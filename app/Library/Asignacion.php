<?PHP
namespace App\Library;

use DVDoug\BoxPacker\Packer;
use DVDoug\BoxPacker\Test\TestBox;
use DVDoug\BoxPacker\Test\TestItem; 
use DVDoug\BoxPacker\ItemList; 
use DVDoug\BoxPacker\VolumePacker; 

/**
* 
*/
class Asignacion
{
	private $products;
	private $trucks;
	private $orders;
	private $travel;
	private $invalidOrders;
	private $Asignacion;
	private $cantTruck;
	//$description, $width, $length, $depth, $weight, $keepFlat)
	public function __construct($products, $trucks, $orders)
	{

    	$this->products = $products;
		$this->trucks	= $trucks;
		$this->orders   = $orders;

        $this->cantTruck = count($this->trucks);
	}

	public function GetAsignation(){
		//Asignacion de prioridades
		foreach ($this->orders as $key => $value) {
			if($value['priority']){
				if($this->OrderValidate($key)){
					$this->AsigPrior([], $key,0);
				}
			}
		}
		
		//Asignacion Normal
		foreach ($this->orders as $key => $value) {
			if($value['priority'] == false){
				if($this->OrderValidate($key)){
					$this->AsigRegular([], $key);
				}
			}
		}
	    return $this->travel;

	}

	//Asginacion de paquetes regulares
	private function AsigRegular($testTruck, $id_order, $round_travel = 0){
		foreach ($this->trucks as $key => $value) {
			if(!isset($this->travel[$round_travel][$key])){
				$this->travel[$round_travel][$key]['itemsObject'] = new ItemList();
	      		$this->travel[$round_travel][$key]['asigCount'] = 0;
	      		$this->travel[$round_travel][$key]['itemCount'] = 0;
			}
			$items 		= clone $this->travel[$round_travel][$key]['itemsObject'];
		    $result     = $this->OrderBreackDown($id_order, $items);
			$items 	    = $result[1];
			$countItems = $result[0];

			$box = new TestBox(
				$key, 
				$this->trucks[$key]['outerWidth'], 
				$this->trucks[$key]['outerLength'], 
				$this->trucks[$key]['outerDepth'], 
				$this->trucks[$key]['emptyWeight'], 
				$this->trucks[$key]['innerWidth'], 
				$this->trucks[$key]['innerLength'], 
				$this->trucks[$key]['innerDepth'], 
				$this->trucks[$key]['maxWeight']
			);

		    $volumePacker  = new VolumePacker($box, $items);
		    $packedBox 	   = $volumePacker->pack();
		    $packitem 	   = $packedBox->getItems();
		    $packitemCount = $packitem->count();
		    
		    //valido si estan todos los items adentro
		    if($packitemCount == ($this->travel[$round_travel][$key]['itemCount'] + $countItems)){
		    	$this->travel[$round_travel][$key]['itemsObject'] = $packitem;
		    	$this->travel[$round_travel][$key]['itemCount']   = $this->travel[$round_travel][$key]['itemCount'] + $countItems;
		    	$this->travel[$round_travel][$key]['asig'][]	  =  $id_order;
		    	$this->orders[$id_order]['isAsig'] = true;

		    	return 'next';
		    }
		    else{
		    	//Verifico si existe el id del truck en los probados
		    	if (!in_array($key, $testTruck)) {
		        	array_push($testTruck, $key);//incorporo 
		    	}
		    	//compruebo si ya trato con todos los camiones para lanzarlo a una segunda vuelta
		    	if(count($testTruck) == $this->cantTruck){
		    		$round_travel++;
		        	return $this->AsigRegular([], $id_order, $round_travel);
		      	}
		    }
		}

	}
	//seleciona un camion para una factura
	private function SelectTruck($testTruck, $round_travel, $cant_asig = 0){
	    foreach ($this->trucks as $key => $value) {
	    	if (in_array($key, $testTruck)) {
	    		continue;
	    	}
	    	if(isset($this->travel[$round_travel][$key])){
	       		if(count($this->travel[$round_travel][$key]['asigCount'])==$cant_asig){
	        		if($cant_asig == 0){
	            		$this->travel[$round_travel][$key]['itemsObject'] = new ItemList();
	          		}
	        		return  $key;
	        	}
	      	}else{
	      		$this->travel[$round_travel][$key]['itemsObject'] = new ItemList();
	      		$this->travel[$round_travel][$key]['asigCount'] = 0;
	      		$this->travel[$round_travel][$key]['itemCount'] = 0;
	      		return  $key;
	      	}
	    }
	    $cant_asig++;
	    return $this->SelectTruck($testTruck, $round_travel, $cant_asig);
	}

	/**
	* Asigna las ordenes con prioridad
	* @param $testTruck - trucks ya probados para una orden
	* @param $id_oder - id del orden (factura)
	* @param $round_travel - id o index del travel (se entiende como las vueltas que da un truck) 
	*/
  	private function AsigPrior($testTruck = [], $id_order, $round_travel = 0){

	    $trucKey = $this->SelectTruck($testTruck,$round_travel);
	    $truck   = $this->travel[$round_travel][$trucKey];
	    //Proceso de validacion de entrada de items en camion
	    $items 		= clone $truck['itemsObject'];
	    $result     = $this->OrderBreackDown($id_order, $items);
		$items 	    = $result[1];
		$countItems = $result[0];

		$box = new TestBox(
			$trucKey, 
			$this->trucks[$trucKey]['outerWidth'], 
			$this->trucks[$trucKey]['outerLength'], 
			$this->trucks[$trucKey]['outerDepth'], 
			$this->trucks[$trucKey]['emptyWeight'], 
			$this->trucks[$trucKey]['innerWidth'], 
			$this->trucks[$trucKey]['innerLength'], 
			$this->trucks[$trucKey]['innerDepth'], 
			$this->trucks[$trucKey]['maxWeight']
		);

	    $volumePacker  = new VolumePacker($box, $items);
	    $packedBox 	   = $volumePacker->pack();
	    $packitem 	   = $packedBox->getItems();
	    $packitemCount = $packitem->count();
	    
	    //valido si estan todos los items adentro
	    if($packitemCount == ($truck['itemCount'] + $countItems)){
	    	$this->travel[$round_travel][$trucKey]['itemsObject'] = $packitem;
	    	$this->travel[$round_travel][$trucKey]['itemCount']   = $truck['itemCount'] + $countItems;
	    	$this->travel[$round_travel][$trucKey]['asig'][]	  =  $id_order;
	    	$this->orders[$id_order]['isAsig'] = true;

	    	return 'next';
	    }
	    else{
	     	//Verifico si existe el id del truck en los probados
	    	if (!in_array($trucKey, $testTruck)) {
	        	array_push($testTruck, $trucKey);//incorporo 
	    	}
	    	//compruebo si ya trato con todos los camiones para lanzarlo a una segunda vuelta
	    	if(count($testTruck) == $this->cantTruck){
	    		$round_travel++;
	        	return $this->AsigPrior([], $id_order, $round_travel);
	      	}
	    	
 			return $this->AsigPrior($testTruck, $id_order, $round_travel);  
		}
	}

	/**
	* Valida que la orden quepa en algun camion sola.
	* @param $id_order - id de la orden a validar 
	*/
	private function OrderValidate($id_order){
		foreach ($this->trucks as $key => $value) {
			$box = new TestBox(
				$key, 
				$value['outerWidth'], 
				$value['outerLength'], 
				$value['outerDepth'], 
				$value['emptyWeight'], 
				$value['innerWidth'], 
				$value['innerLength'], 
				$value['innerDepth'], 
				$value['maxWeight']
			);

			$items     = new ItemList();
			$result    = $this->OrderBreackDown($id_order, $items);
			$items 	   = $result[1];
			$countItems = $result[0];

			//empaquetado
			$volumePacker  = new VolumePacker($box, $items);
		    $packedBox	   = $volumePacker->pack();
		    $packitem 	   = $packedBox->getItems();
		    $packitemCount = $packitem->count();

		    if($packitemCount == $countItems) {
		    	$this->orders[$id_order]['valid'] = true;
	    		return true;
	    	}
	    }
	    $this->invalidOrders[] = $id_order;
	    $this->orders[$id_order]['valid'] = false;
	    return false;
	}

	/**
	* Descompone una factura.
	* @param $id_order - id de la orden a descomponer.
	* @param $items - Objeto ItemList().
	*/
	private function OrderBreackDown($id_order, $items){
		$orders   = $this->orders;
		$products = $this->products;
		$countItems = 0;
		foreach ($orders[$id_order]['items'] as $key => $value) {
			for ($i=0; $i < $value['cant']; $i++) { //Desconpongo la factura
	    		$items->insert(
	    			new TestItem(
	    				$products[$value['product']]['description'], 
	    				$products[$value['product']]['width'], 
	    				$products[$value['product']]['length'], 
	    				$products[$value['product']]['depth'],
	    				$products[$value['product']]['weight'], 
	    				false //KeepFlat
	    			)
	    		);
	    		$countItems ++;
	    	}
		}
		return [$countItems, $items];
	}
}