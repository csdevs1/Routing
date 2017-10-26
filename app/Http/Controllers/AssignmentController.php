<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Library\Asignacion;
use App\Usuarios;
use App\Clientes;
use App\Vehiculos;
use App\Oficinas;
use App\Documentos;
use App\Documentositems;
use App\Productos;
use Auth;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
   /* protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }*/

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */

    public function vehicles_page(){
        $vehicles = Vehiculos::has('documentos')->get();
        return view('documents.export_vehicle')
            ->with('vehicles', $vehicles);
    }

    protected function save_documents(array $documento){
        try{
            return Documentos::insertGetId([
                'codigo' => $documento['codigo'],
                'id_cliente' => $documento['id_cliente'],
                'fecha_pactada' => $documento['fecha_pactada'],
                'fecha_despacho' => $documento['fecha_despacho'],
            ]);
        }catch(\Exception $e){
            return false;
        }
    }
    protected function save_documentsItems(array $documento){
        try{
            return Documentositems::create($documento);
        }catch(\Exception $e){
            return false;
        }
    }

    protected function insert_vehicle(array $vehicle){
        try{
            return Vehiculos::create($vehicle);
        }catch(\Exception $e){
            return false;
        }
    }
    protected function insert_product(array $product){
        try{
            return Productos::create($product);
        }catch(\Exception $e){
            return false;
        }
    }

    public function save_vehicles(Request $request){
        $user = Auth::user();
        $file=$request->file('input_file');
        $csv = array_map('str_getcsv', file($file->getRealPath()));
        $vehicles[] = $csv;
        $vehicles = array_slice($vehicles[0], 1);
        foreach ($vehicles as $k=>$val) {
            $nombre=$vehicles[$k][0];
            $patente=$vehicles[$k][1];
            $ancho=(int)$vehicles[$k][2];
            $largo=(int)$vehicles[$k][3];
            $profundidad=(int)$vehicles[$k][4];
            $peso=(int)$vehicles[$k][5];
            $ancho_interno=(int)$vehicles[$k][6];
            $largo_interno=(int)$vehicles[$k][7];
            $profundidad_interno=(int)$vehicles[$k][8];
            $peso_max=(int)$vehicles[$k][9];
            $vehiculos=array('nombre'=>$nombre,'patente'=>$patente,'outerwidth'=>$ancho,'outerlength'=>$largo,'outerdepth'=>$profundidad,'emptyweight'=>$peso,'innerwidth'=>$ancho_interno,'innerlength'=>$largo_interno,'innerdepth'=>$profundidad_interno,'maxweight'=>$peso_max,'id_oficina'=>$user->id_oficina);

            if(!$this->insert_vehicle($vehiculos)){
                $errors[]=$nombre.' ya existe';
            }
        }
        if(empty($errors))
            return response()->json([true]);
        else
            return response()->json([$errors]);
    }

    public function save_products(Request $request){
        $file=$request->file('input_file');
        $csv = array_map('str_getcsv', file($file->getRealPath()));
        $products[] = $csv;
        $products = array_slice($products[0], 1);
        foreach ($products as $k=>$val) {
            $codigo_producto=$products[$k][0];
            $description=$products[$k][1];
            $width=(int)$products[$k][2];
            $length=(int)$products[$k][3];
            $depth=(int)$products[$k][4];
            $weight=(int)$products[$k][5];
            $product=array('codigo'=>$codigo_producto,'description'=>$description,'tipo'=>'Tipo','width'=>$width,'length'=>$length,'depth'=>$depth,'weight'=>$weight);
            if(!$this->insert_product($product)){
                $errors[]=$codigo_producto.' ya existe';
            }
        }
        if(empty($errors))
            return response()->json([true]);
        else
            return response()->json([$errors]);
    }

    public function update_document($vehicle_id,$doc_code){
        Documentos::where('codigo', $doc_code)->update([
            'id_vehiculo' => $vehicle_id,
        ]);
    }

    public function getFile(Request $request){
        $user = Auth::user();
        $vehicles = Vehiculos::has('documentos', '<', 1)->where('id_oficina',$user->id_oficina)->get(); // SELECT VEHICLES THAT HAVEN'T BEEN ASSIGNED
        $files=$request->file('input-iconic');
        $errors;
        $vehiculos=array();
        $boxArr=array();
        $oders=array();
        $errors=array();
        $fila=1;
        foreach ($files as $file) {
            $csv = array_map('utf8_encode', file($file->getRealPath()));
            $oders_a[] = $csv;
        }
        //$oders = array_slice($oders_a[0], 1);
        foreach ($csv as $key => $value) {
            $value=explode(';', $value);
            array_push($oders,$value);
        }
        $products=array();
        $saved_docs_id=array();
        foreach ($oders as $k=>$val) {
            if(empty($val[1])) array_push($errors,'Valor en la columna '.$oders[0][1].', fila: '.$fila.' esta vacio');
            if(empty($val[2])) array_push($errors,'Valor en la columna '.$oders[0][2].', fila: '.$fila.' esta vacio');
            if(empty($val[3])) array_push($errors,'Valor en la columna '.$oders[0][3].', fila: '.$fila.' esta vacio');
            if(empty($val[4])) array_push($errors,'Valor en la columna '.$oders[0][4].', fila: '.$fila.' esta vacio');
            if(empty($val[5])) array_push($errors,'Valor en la columna '.$oders[0][5].', fila: '.$fila.' esta vacio');
            if(empty($val[6])) array_push($errors,'Valor en la columna '.$oders[0][6].', fila: '.$fila.' esta vacio');
            if(empty($val[7])) array_push($errors,'Valor en la columna '.$oders[0][7].', fila: '.$fila.' esta vacio');
            if(empty($val[8])) array_push($errors,'Valor en la columna '.$oders[0][8].', fila: '.$fila.' esta vacio');
            $fila++;
        }
        if(count($oders[0]) < 10) array_push($errors,'Numero de columnas menor de lo esperado');
        if(empty($errors)){
            foreach ($oders as $k=>$val) {
                if($k!=0){
                    $array_item=array();
                    $num_order=$oders[$k][6];
                    $id_cliente=$oders[$k][0];
                    $priority_order=false;
                    $item = $oders[$k][7];
                    $cant=$oders[$k][9];
                    $document=array('codigo'=>$num_order,'id_cliente'=>$id_cliente,'prioridad'=>$priority_order,'fecha_pactada'=>date('Y-m-d G:m:s'),'fecha_despacho'=>date('Y-m-d G:m:s'));

                    //Create array of products and their quantities
                    array_push($array_item,array('product'=>$item,'cant'=>$cant));

                    //Save Documents
                    $save_doc=$this->save_documents($document);

                    $product_id=Productos::select(['id'])->where('codigo',$item)->first();
                    $document_items=array('id_producto'=>$product_id['id'],'id_documento'=>$save_doc,'cantidad'=>$cant);

                    //Save Docuents - Products relationship
                    $doc_item=$this->save_documentsItems($document_items);

                    $products[]=array('producto'=>Productos::where('codigo',$item)->first());

                    $ordenes[$num_order]=array('items'=>$array_item,'priority'=>$priority_order);
                }
            }


        foreach ($vehicles as $k=>$val) {
            $nombre=$vehicles[$k]['nombre'];
            $outerWidth=(int)$vehicles[$k]['outerwidth'];
            $outerLength=(int)$vehicles[$k]['outerlength'];
            $outerDepth=(int)$vehicles[$k]['outerdepth'];
            $emptyWeight=(int)$vehicles[$k]['emptyweight'];
            $innerDepth=(int)$vehicles[$k]['innerdepth'];
            $innerLength=(int)$vehicles[$k]['innerlength'];
            $innerWidth=(int)$vehicles[$k]['innerwidth'];
            $maxWeight=(int)$vehicles[$k]['maxweight']; $vehiculos[$nombre]=array('outerWidth'=>$outerWidth,'outerLength'=>$outerLength,'outerDepth'=>$outerDepth,'emptyWeight'=>$emptyWeight,'innerWidth'=>$innerWidth,'innerLength'=>$innerLength,'innerDepth'=>$innerDepth,'maxWeight'=>$maxWeight);
        }

        foreach ($products as $k=>$val) {
            $array_item=array();
            $num_factura=$products[$k]['producto']['codigo'];
            $description=$products[$k]['producto']['description'];
            $width=(int)$products[$k]['producto']['width'];
            $length=(int)$products[$k]['producto']['length'];
            $depth=(int)$products[$k]['producto']['depth'];
            $weight=(int)$products[$k]['producto']['weight'];
            $productos[$num_factura]=array('description'=>$description,'width'=>$width,'length'=>$length,'depth'=>$depth,'weight'=>$weight);
        }

        $products=$productos;
        $trucks=$vehiculos;
        $orders=$ordenes;
        $Asignacion = new Asignacion($products, $trucks, $ordenes);

            $response=$Asignacion->GetAsignation();
            foreach($response[0] as $k=>$v){
                $vehicle_id=Vehiculos::select(['id'])->where('nombre',$k)->first();
                if(isset($vehicle_id->id) && !empty($vehicle_id->id)){
                    $nu_arr=$response[0][$k]['asig'];
                    foreach($nu_arr as $key=>$val){
                        $this->update_document($vehicle_id->id,$val);
                    }
                } else{
                    $response['error_vehiculo']='Vehiculo '.$k.' no existe!';
                }
            }
        }else{
            $response['errors']=$errors;
        }
        \Log::info($response);
        return response()->json([$response]);
    }

    public function export_xls($param){
        $documents=Documentos::where('id_vehiculo',$param)->get();
        $vehicle=Vehiculos::where('id',$param)->get();
        $formatted=array();
        foreach($documents as $k=>$v){
            $json=[
                'Id Documento'=>$documents[$k]['id'],
                'Codigo'=>$documents[$k]['codigo'],
                'Vehiculo Asignado'=>$vehicle[0]->nombre
            ];
            $formatted[]=$json;
        }
		return \Excel::create($vehicle[0]->nombre, function($excel) use ($formatted) {
			$excel->sheet('mySheet', function($sheet) use ($formatted)
	        {
				$sheet->fromArray($formatted);
	        });
		})->download('xls');
        echo json_encode($formatted);
    }
    
    public function export_all(){
        $user = Auth::user();
        $vehicles = Vehiculos::has('documentos')->select(['id','nombre','patente','id_oficina'])->where('id_oficina',$user->id_oficina)->get();
        $json=array();
        $arr=array();
        foreach($vehicles as $k=>$v){
            $id_vehicle=$vehicles[$k]["id"];
            $vehicle_name=$vehicles[$k]["nombre"];
            $id_oficina=$vehicles[$k]["id_oficina"];
            $oficina=Oficinas::where('id',$id_oficina)->first();
            $documents=Documentos::select(['id','codigo','id_vehiculo','id_cliente'])->where('id_vehiculo',$id_vehicle)->orderBy('prioridad','DESC')->get();
            $orden_cliente=array();
            $orden_cliente[$vehicle_name]=1;
            $last_client="";
            foreach($documents as $key=>$val){
                $client=Clientes::where('id',$val['id_cliente'])->orderBy('clientes.prioridad','DESC')->first();
                $documentItem=Documentositems::select(['id_producto','cantidad'])->where('id_documento',$val['id'])->get();

                if (!empty($client)) {
                    $nombre_cliente=$client->nombre;
                    $orden_cliente[$nombre_cliente]=$nombre_cliente;
                    if($last_client!=$nombre_cliente && !empty($last_client))
                            $orden_cliente[$vehicle_name]+=1;
                    $last_client=$nombre_cliente;
                    foreach($documentItem as $k2=>$v2){
                        $item=Productos::select(['codigo','description'])->where('id',$v2['id_producto'])->first();
                        $data=[
                            'Orden de entrega'      => $orden_cliente[$vehicle_name],
                            'Vehiculo Asignado' => $vehicle_name,
                            'Nombre Cliente'      => $client->nombre,
                            'Latitud'         => (float)$client->lat,
                            'Longitud'         => (float)$client->lng,
                            'Direccion'   => $client->direccion,
                            'Origen'   => $oficina->direccion,
                            'Codigo Factura' => $val['codigo'],
                            'Codigo Producto' => $item['codigo'],
                            'Producto' => $item['description'],
                            'Cantidad' => $v2['cantidad']
                        ];
                       /* $val['Cliente']=$data;
                        $val['Vehicle']=$vehicle_name;
                        $val['Origen']=['nombre'=>$oficina->nombre,'direccion'=>$oficina->direccion,'ltLng'=>array('lat'=>(float)$oficina->lat,'lng'=>(float)$oficina->lng)];*/
                        //$arr[]['Factura_'.$val['codigo']]=$val;
                        array_push($json,$data);
                    }
                }
            }
        }

		return \Excel::create('Facturas', function($excel) use ($json) {
			$excel->sheet('mySheet', function($sheet) use ($json)
	        {
				$sheet->fromArray($json);
	        });
		})->download('csv');
        echo json_encode($json);
    }
}
