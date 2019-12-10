<?php

namespace App\Http\Controllers;

use App\Libro;
use App\Prestamo;
use App\User;
use Illuminate\Http\Request;

class PrestamosController extends Controller
{
    public function prestar(Request $request){
        $response = array('error_code' => 400, 'error_msg' => 'Error inserting info');

        if (isset($request->usuario_id) && !empty($request->usuario_id) && isset($request->libro_id) && !empty($request->libro_id)) {
            $usuario = User::find($request->usuario_id);
            $libro= Libro::find($request->libro_id);

            if (!empty($usuario) && !empty($libro)) {
                $prestamo = new Prestamo;
                $prestamo->usuario_id = $request->usuario_id;
                $prestamo->libro_id = $request->libro_id;
                $prestamo->fecha_prestamo = date('Y-m-d H:i:s');

                try {
                    $prestamo->save();
                    $response = array('error_code' => 200, 'error_msg' => 'OK');
                } catch (\Exception $e) {
                    $response = array('error_code' => 500, 'error_msg' =>$e->getMessage());
                }
            }

        }
        return response()->json($response);
    }

    public function devolver(Request $request){
        $response = array('error_code' => 400, 'error_msg' => 'Error inserting info');

        if (isset($request->id) && !empty($request->id) && !is_null($request->id)) {
            $prestamo = Prestamo::find($request->id);

            if (is_null($prestamo->fecha_devolucion)) {
                try {
                    $prestamo->fecha_devolucion = date('Y-m-d H:i:s');
                    $prestamo->save();
                    $response = array('error_code' => 200, 'error_msg' => 'OK');

                } catch (\Exception $e) {
                    $response = array('error_code' => 500, 'error_msg' =>$e->getMessage());
                }
            }else{
                $response = array('error_code' => 400, 'error_msg' => 'The book is alredy returned');
            }
        }
        return response()->json($response);
    }
}
