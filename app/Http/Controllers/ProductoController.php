<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Models\Producto;

class ProductoController extends Controller
{
    public function index(Request $requets) {
       $producto = Producto::get();
        return response()->json([
            'status' => true,
            'data' => $producto
        ]);
    }

    public function show($id) {
       $producto = Producto::find($id);
        return response()->json([
            'status' => true,
            'data' => $producto
        ]);
    }

   public function store(Request $request){
        $datos_recibidos = $request->all();
        $respuesta = [];
        $respuesta["status"] = false;

        $validator = Validator::make($datos_recibidos ,[
            'nombre'=>'required|max:100',
            'talla'=>'required|in:S,M,L',
            'observaciones'=>'required|max:200',
            'marca_id'=>'required|exists:marcas,id',
            'cantidad_inventario'=>'required|numeric',
            'fecha_embarque'=>'required|date',
        ],[
            'nombre.required' => 'El nombre es requerido',
            'nombre.max' => 'El nombre sobrepaso los 100 caracteres permitidos',
            'talla.required' => 'La talla es requerida',
            'talla.in' => 'Seleccione las tallas S, M o L',
            'observaciones.required' => 'Las observaciones son requeridas',
            'observaciones.max' => 'Las observaciones sobrepasaron los 200 caracteres permitidos',
            'marca_id.required' => 'El marca es requerida',
            'marca_id.exists' => 'La marca seleccionada no existe',
            'cantidad_inventario.required' => 'La cantidad es requerida',
            'cantidad_inventario.numeric' => 'La cantidad no es un valor númerico',
            'cantidad_inventario.max' => 'La cantidad sobrepaso los 11 digitos permitidos',
            'fecha_embarque.required' => 'La fecha de embarque re requerida',
            'fecha_embarque.date' => 'La fecha de embarque no es una fecha',
        ]);

        if ($validator->fails()) {
            $respuesta["msg"] = 'Verificar los campos de información';
            $respuesta["validator"] = $validator->errors();
        } else {
            $producto = new Producto();
            $producto->fill($datos_recibidos );
    
            if ($producto->save()) {
                $respuesta["status"] = true;
                $respuesta["msg"] = 'Registrado correctamente';
                $respuesta["data"] = $producto;
            }else{                
                $respuesta["msg"] = 'Registrado correctamente';
                $respuesta["data"] = $producto;
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
            'talla'=>'required|in:S,M,L',
            'observaciones'=>'required|max:200',
            'marca_id'=>'required|exists:marcas,id',
            'cantidad_inventario'=>'required|numeric',
            'fecha_embarque'=>'required|date',
        ],[
            'nombre.required' => 'El nombre es requerido',
            'nombre.max' => 'El nombre sobrepaso los 100 caracteres permitidos',
            'talla.required' => 'La talla es requerida',
            'tala.in' => 'Seleccione S, M o L',
            'observaciones.required' => 'Las observaciones son requeridas',
            'observaciones.max' => 'Las observaciones sobrepasaron los 200 caracteres permitidos',
            'marca_id.required' => 'El marca es requerida',
            'marca_id.exists' => 'La marca seleccionada no existe',
            'cantidad_inventario.required' => 'La cantidad es requerida',
            'cantidad_inventario.numeric' => 'La cantidad no es un valor númerico',
            'cantidad_inventario.max' => 'La cantidad sobrepaso los 11 digitos permitidos',
            'fecha_embarque.required' => 'La fecha de embarque re requerida',
            'fecha_embarque.date' => 'La fecha de embarque no es una fecha',
        ]);

        if ($validator->fails()) {
            $respuesta["msg"] = 'Verificar los campos de informacion';
            $respuesta["data"] = $validator->errors();
        } else {
            $producto = Producto::find($id);
            $producto->fill($datos_recibidos);
    
            if($producto->save()){
                $respuesta["status"] = true;
                $respuesta["msg"] = 'Actualizado correctamente.';
                $respuesta["data"] = $producto;
            }else{                
                $respuesta["msg"] = 'No se puedo actualizar.';
                $respuesta["data"] = $producto;
            }
        }
        return response()->json($respuesta);
    }

    public function destroy($id){
        $respuesta = [];
        $respuesta["status"] = false;

        $producto = Producto::find($id);

        if ($producto) {           
            if ($producto->delete()) {
                $respuesta["status"] = true;
                $respuesta["msg"] = "Registro eliminado correctamente.";
                $respuesta["data"] = $producto;
            } else {
                $respuesta["msg"] = "No se puede eliminar el registro.";
                $respuesta["data"] = $producto;
            }     
        } else {
            $respuesta["msg"] = 'No se encontro el registro que intenta eliminar.';
        }          
        return response()->json($respuesta);
    }
}
