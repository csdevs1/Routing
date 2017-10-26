<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clientes;
use App\Oficinas;
use App\Vehiculos;
use App\Documentos;
use Auth;
use DB;

class ClientController extends Controller
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
    public function create()
    {
        //
    }

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

    public function getClients(){
        $user = Auth::user();
        $clients = Clientes::has('documentos')->where('id_oficina',$user->id_oficina)->orderBy('prioridad','DESC')->get();
        $json=array();
        $arr=array();
        $data=array();
        $waypoints=array();
        if (!empty($clients)) {
            foreach($clients as $k=>$val){
                $documents=Documentos::select(['codigo','id_vehiculo'])->where('id_cliente',$val['id'])->orderBy('prioridad','DESC')->get();
                $oficina=Oficinas::where('id',$val['id_oficina'])->first();
                $data_vehicle=array();
                foreach($documents as $key=>$v){
                    $vehicle=Vehiculos::where('id',$v['id_vehiculo'])->first();
                    if (!empty($vehicle)) {
                        $data_vehicle[]=[
                            'id'          => $vehicle->id,
                            'nombre'      => $vehicle->nombre,
                            'patente'     => $vehicle->patente
                        ];
                        //$tmp_arr=Clientes::select(['lat','lng'])->join('documentos', 'clientes.id', '=', 'documentos.id_cliente')->where('documentos.id_vehiculo',$vehicle->id)->get();
                        //array_push($waypoints,['lat'=>(float)$tmp_arr[0]['lat'],'lng'=>(float)$tmp_arr[0]['lng']]);
                    }
                }

                $data[]=[
                    'id'          => $val['id'],
                    'nombre'      => $val['nombre'],
                    'lat'         => (float)$val['lat'],
                    'lng'         => (float)$val['lng'],
                    'direccion'   => $val['direccion'],
                    'vehicle'=>$data_vehicle,
                    'origen'=>['nombre'=>$oficina->nombre,'direccion'=>$oficina->direccion,'ltLng'=>array('lat'=>(float)$oficina->lat,'lng'=>(float)$oficina->lng)],
                    'documents'=>$documents
                ];
            }
        }
        $vehicles=Vehiculos::has('documentos')->where('id_oficina',$user->id_oficina)->get();
        if (!empty($vehicles)) {
            foreach($vehicles as $k=>$v){
                $tmp_arr=Clientes::select(['lat','lng'])->join('documentos', 'clientes.id', '=', 'documentos.id_cliente')->where('documentos.id_vehiculo',$vehicles[$k]["id"])->groupBy('clientes.id')->orderBy('clientes.prioridad','DESC')->get();
                //array_push($waypoints,['lat'=>(float)$tmp_arr[0]['lat'],'lng'=>(float)$tmp_arr[0]['lng']]);
                array_push($waypoints,[$vehicles[$k]["nombre"]=>[$tmp_arr]]);
            }
        }
        $data[]['route']=$waypoints;
        return response()->json($data);
       /* PRIORITY BY DOCUMENT
        $documents=Documentos::get();
        $json=array();
        $arr=array();
        foreach($documents as $k=>$v){
            $id_vehicle=$v["id_vehiculo"];
            $id_cliente=$v["id_cliente"];
            $vehicle = Vehiculos::where('id',$id_vehicle)->get();
            $oficina=Oficinas::where('id',$vehicle[0]->id_oficina)->first();
            $client=Clientes::where('id',$id_cliente)->first();
            if (!empty($client)) {
                $data=[
                    'id'          => $client->id,
                    'nombre'      => $client->nombre,
                    'lat'         => (float)$client->lat,
                    'lng'         => (float)$client->lng,
                    'direccion'   => $client->direccion
                ];
                $v['client']=$data;
                $v['vehicle']=$vehicle[0]->nombre;
                $v['origen']=['nombre'=>$oficina->nombre,'direccion'=>$oficina->direccion,'ltLng'=>array('lat'=>(float)$oficina->lat,'lng'=>(float)$oficina->lng)];
                $arr[]['factura']=$v;
                array_push($json,$arr);
            }
        }*/

        /*$vehicles = Vehiculos::has('documentos')->get();
        $json=array();
        $arr=array();
        foreach($vehicles as $k=>$v){
            $id_vehicle=$vehicles[$k]["id"];
            $vehicle_name=$vehicles[$k]["nombre"];
            $id_oficina=$vehicles[$k]["id_oficina"];
            $oficina=Oficinas::where('id',$id_oficina)->first();
            $documents=Documentos::where('id_vehiculo',$id_vehicle)->orderBy('prioridad','DESC')->get();
            foreach($documents as $key=>$val){
                $client=Clientes::where('id',$val['id_cliente'])->first();
                if (!empty($client)) {
                    $data=[
                        'id'          => $client->id,
                        'nombre'      => $client->nombre,
                        'lat'         => (float)$client->lat,
                        'lng'         => (float)$client->lng,
                        'direccion'   => $client->direccion
                    ];
                    $val['client']=$data;
                    $val['vehicle']=$vehicle_name;
                    $val['origen']=['nombre'=>$oficina->nombre,'direccion'=>$oficina->direccion,'ltLng'=>array('lat'=>(float)$oficina->lat,'lng'=>(float)$oficina->lng)];
                    $arr[]['factura']=$val;
                    array_push($json,$arr);
                }
            }
        }*/
    }
}
