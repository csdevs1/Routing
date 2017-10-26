<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DVDoug\BoxPacker\Packer;
use DVDoug\BoxPacker\Test\TestBox;// use your own implementation
use DVDoug\BoxPacker\Test\TestItem; // use your own implementation
use DVDoug\BoxPacker\ItemList; // use your own implementation
use DVDoug\BoxPacker\VolumePacker; // use your own implementation
use App\Library\Asignacion;
use App\Usuarios;
use JWTAuth;
use Auth;

class AsignacionController extends Controller
{
    public function pack(Request $request){        
        try{
            $tokenFetch = JWTAuth::parseToken()->authenticate(); //Authenticate user
            if ($tokenFetch) { // If true then get the token send via headers
                $token=JWTAuth::getToken();
            } else {
                $token = '';
            }
            $input=$request->all();
            \Log::info($token);
            return response()->json(['response'=>$input]);
        } catch(\Tymon\JWTAuth\Exceptions\JWTException $e){
            return response()->json(['error'=>'Not logged in.']);
        }
    }
    public function GetAsignacion(Request $request){
        $input = $request->all();
        if(isset($input['token']) && $this->verify_user($input['token'] )){
            $this->validate($request, [
                'products' => 'required',
                'trucks' => 'required',
                'orders' => 'required',
            ]);

            $products = $input['products'];
            $trucks   = $input['trucks'];
            $orders   = $input['orders'];
            $Asignacion = new Asignacion($products, $trucks, $orders);
            return response()->json([$Asignacion->GetAsignation()]);
        } else{
            return response()->json(['error' =>['code'=>'001', 'description'=>'Not logged in']]);
        }
    }
}