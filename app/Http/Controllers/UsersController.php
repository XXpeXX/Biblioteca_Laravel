<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    public function crear(Request $request){
        $response = array('error_code' => 400, 'error_msg' => 'Error inserting info');
        $usuario = new User;

        if (!$request->nombre) {
            $response['error_msg'] = 'Name is requiered';

        }elseif (!$request->email) {
            $response['error_msg'] = 'Email is requiered';

        }elseif (!$request->password) {
            $response['error_msg'] = 'Password is requiered';

        }else{
            try {
                $usuario->nombre = $request->nombre;
                $usuario->email = $request->email;
                $usuario->password = $request->password;
                $api_token = Str::random(8);
                $usuario->api_token =  hash('sha256',$api_token);
                $usuario->save();
                $response = array('error_code' => 200, 'error_msg' => 'OK: '.$api_token);

            } catch (\Exception $e) {
                $response = array('error_code' => 500, 'error_msg' =>$e->getMessage());
            }
        }
        return response()->json($response);
    }

    public function mostrarTodos(){
        $usuarios = User::all(['id', 'nombre', 'email']);

        return response()->json($usuarios);
    }
}
