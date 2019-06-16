<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;

use App\Models\Marca;
use App\Models\Producto;

class MarcaController extends Controller
{   
    public function listar(Request $requets) {
       $marca = Marca::paginate(5);
        return response()->json([
            'status' => true,
            'data' => $marca
        ]);
    }

    public function index(Request $requets) {
       $marca = Marca::get();
        return response()->json([
            'status' => true,
            'data' => $marca
        ]);
    }

    public function show($id) {
       $marca = Marca::find($id);
        return response()->json([
            'status' => true,
            'data' => $marca
        ]);
    }

   public function store(Request $request){
        $datos_recibidos = $request->all();
        $respuesta = [];
        $respuesta["status"] = false;

        $validator = Validator::make($datos_recibidos ,[
            'nombre'=>'required|max:100',
            'referencia'=>'required|max:15|unique:marcas,referencia'
        ],[
            'nombre.required' => 'El nombre es requerido',
            'nombre.max' => 'El nombre no puede sobrepasar los 100 caracteres',
            'referencia.unique' => 'La referencia ya esta registrada',
            'referencia.required' => 'La referencia es requerida',
            'referencia.max' => 'La referencia no puede sobrepasar los 15 caracteres',
        ]);

        if ($validator->fails()) {
            $respuesta["msg"] = 'Verificar los campos de información';
            $respuesta["validator"] = $validator->errors();
        } else {
            $marca = new Marca();
            $marca->fill($datos_recibidos );
    
            if ($marca->save()) {
                $respuesta["status"] = true;
                $respuesta["msg"] = 'Registrado correctamente';
                $respuesta["data"] = $marca;
            }else{                
                $respuesta["msg"] = 'Registrado correctamente';
                $respuesta["data"] = $marca;
            }
        }
        return response()->json($respuesta);
    }

   public function update(Request $request, $id){
        $datos_recibidos = $request->all();
        $respuesta = [];
        $respuesta["status"] = false;

        $validator = Validator::make($datos_recibidos ,[
            'nombre'=>'required|max:100',
            'referencia'=>'required|max:15|unique:marcas,referencia,' . $id,
        ],[
            'nombre.required' => 'El nombre es requerido',
            'nombre.max' => 'El nombre no puede sobrepasar los 100 caracteres',
            'referencia.required' => 'La referencia es requerida',
            'referencia.unique' => 'La referencia ya esta registrada',
            'referencia.max' => 'La referencia no puede sobrepasar los 15 caracteres',
        ]);

        if ($validator->fails()) {
            $respuesta["msg"] = 'Verificar los campos de informacion';
            $respuesta["validator"] = $validator->errors();
        } else {
            $marca = Marca::find($id);
            $marca->fill($datos_recibidos);
    
            if($marca->save()){
                $respuesta["status"] = true;
                $respuesta["msg"] = 'Actualizado correctamente.';
                $respuesta["data"] = $marca;
            }else{                
                $respuesta["msg"] = 'No se puedo actualizar.';
                $respuesta["data"] = $marca;
            }
        }
        return response()->json($respuesta);
    }

    public function destroy($id){
        $respuesta = [];
        $respuesta["status"] = false;

        $marca = Marca::find($id);

        if ($marca) {

            $productos_relacionados = Producto::where('marca_id', $id)->get();

            if (count($productos_relacionados) > 0) {
                $respuesta["status"] = true;
                $respuesta["msg"] = "La marca esta siendo usada por varios productos.";
                $respuesta["productos_relacionados"] = $productos_relacionados;
            } else {            
                if ($marca->delete()) {
                    $respuesta["status"] = true;
                    $respuesta["msg"] = "Registro eliminado correctamente.";
                    $respuesta["data"] = $marca;
                } else {
                    $respuesta["msg"] = "No se puede eliminar el registro.";
                    $respuesta["data"] = $marca;
                }  
            }      
        } else {
            $respuesta["msg"] = 'No se encontro el registro que intenta eliminar.';
        }                 
        return response()->json($respuesta);
    }
}
