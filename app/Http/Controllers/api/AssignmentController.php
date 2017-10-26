<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Asignacion;
use App\Usuarios;
use JWTAuth;

class AssignmentController extends Controller
{
    private function verify_user($token){
        try {
            $tokenFetch = JWTAuth::parseToken()->authenticate();
            $user = JWTAuth::toUser($token);
            return true;
        }catch(\Tymon\JWTAuth\Exceptions\JWTException $e){//general JWT exception
             return false;
        }
    }

    public function GetAsignacion(Request $request){
        \Log::info('Nueva Asignacion Requeest recibida');
        $input = $request->all();
        $request->query->add([ 'token' => $input['token'] ]); //inserto el token como un get
        if($this->verify_user($input['token'])){
            $this->validate($request, [
                'products' => 'required',
                'trucks' => 'required',
                'orders' => 'required',
            ]);

            $products = $input['products'];
            $trucks   = $input['trucks'];
            $orders   = $input['orders'];

            $Asignacion = new Asignacion($products, $trucks, $orders);
            \Log::info('Procesando Asignacion');
            return response()->json([$Asignacion->GetAsignation()]);
        } else{
             \Log::info('Error Autenticacion');
            return response()->json(['error' =>['code'=>'001', 'description'=>'Not logged in']]);
        }
    }
}

