<?php

namespace App\Http\Controllers;

use App\Libro;
use Illuminate\Http\Request;

class LibrosController extends Controller
{
    public function crear(Request $request){
        $response = array('error_code' => 400, 'error_msg' => 'Error inserting info');
        $libro = new Libro;

        if (!$request->titulo) {
            $response['error_msg'] = 'Title is requiered';

        }elseif (!$request->sinopsis) {
            $response['error_msg'] = 'Synopsis is requiered';

        }elseif (!$request->genero) {
            $response['error_msg'] = 'Gender is requiered';

            if ($request->genero->count_chars > 30) {
                $response['error_msg'] = 'Gender must be shorter';
            }
        }elseif (!$request->autor) {
            $response['error_msg'] = 'Author is requiered';

        } else {
            try {
                $libro->titulo = ucfirst(strtolower($request->titulo));
                $libro->sinopsis = ucfirst(strtolower($request->sinopsis));
                $libro->genero = ucfirst(strtolower($request->genero));
                $libro->autor = ucfirst(strtolower($request->autor));
                $libro->save();
                $response = array('error_code' => 200, 'error_msg' => 'OK');

            } catch (\Exception $e) {
                $response = array('error_code' => 500, 'error_msg' =>$e->getMessage());

            }
        }
        return response()->json($response);
    }

    public function eliminar($id){
        $response = array('error_code' => 404, 'error_msg' => 'Libro '.$id.' not found');
        $libro = Libro::find($id);

        if (!empty($libro)) {
            try {
                $libro->delete();
                $response = array('error_code' => 200, 'error_msg' => 'OK');

            } catch (\Exception $e) {
                $response = array('error_code' => 500, 'error_msg' => $e->getMessage());

            }
        }

        return response()->json($response);
    }

    public function modificar(Request $request, $id){
        $response = array('error_code' => 400, 'error_msg' => 'Libro '.$id.' not found');
        $libro = Libro::find($id);

        if (!empty($libro)) {
            $ok = true;

            if (isset($request->titulo)) {
                if (empty($request->titulo)) {
                    $ok = false;
                    $response['error_msg'] = 'Title is empty';
                }else {
                    $libro->titulo = ucfirst(strtolower($request->titulo));
                }
            }elseif (isset($request->sinopsis)) {
                if (empty($request->sinopsis)) {
                    $ok = false;
                    $response['error_msg'] = 'Synopsis is empty';
                }else {
                    $libro->sinopsis = ucfirst(strtolower($request->sinopsis));
                }
            }elseif (isset($request->genero)) {
                if (empty($request->genero)) {
                    $ok = false;
                    $response['error_msg'] = 'Gender is empty';
                }else {
                    $libro->genero = ucfirst(strtolower($request->genero));
                }
            }elseif (isset($request->autor)) {
                if (empty($request->autor)) {
                    $ok = false;
                    $response['error_msg'] = 'Author is empty';
                }else {
                    $libro->autor = ucfirst(strtolower($request->autor));
                }
            }else {
                $ok = false;
                $response['error_msg'] = 'No change made';
            }

            if ($ok) {
                try {
                    $libro->save();
                    $response = array('error_code' => 200, 'error_msg' => 'OK');

                } catch (\Exception $e) {
                    $response = array('error_code' => 500, 'error_msg' => $e->getMessage());

                }
            }
        }

        return response()->json($response);
    }

    public function mostrarTodos(){
        $libros = Libro::all(['id', 'titulo', 'sinopsis', 'genero', 'autor']);

        return response()->json($libros);
    }

    public function filtarPorAutor($autor){
        $response = array('error_code' => 400, 'error_msg' => 'Error searching info');
        $libros = Libro::all()->where('autor',ucfirst(strtolower($autor)));

        if (!empty($libros)) {
            $response = $libros;
        }

        return response()->json($response);
    }

    public function filtarPorGenero($genero){
        $response = array('error_code' => 400, 'error_msg' => 'Error searching info');
        $libros = Libro::all()->where('genero',ucfirst(strtolower($genero)));

        if (!empty($libros)) {
            $response = $libros;
        }

        return response()->json($response);
    }
}
