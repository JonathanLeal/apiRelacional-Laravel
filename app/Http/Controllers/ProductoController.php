<?php

namespace App\Http\Controllers;

use App\Helpers\Http;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    public function obtenerProductos(){
        $productos = Producto::all();
        if (count($productos) == 0) {
            return Http::respuesta(http::retNotFound, "No hay productos en la base de datos");
        }
        return http::respuesta(http::retOK, $productos);
    }

    public function obtenerProductosId(Request $request){
        $idProducto = Producto::find($request->id_productos);
        if (!$idProducto) {
            return http::respuesta(http::retNotFound, "no se encontro el producto");
        }
        return http::respuesta(http::retOK, $idProducto);
    }

    public function guardarProducto(Request $request){
        $validator = Validator::make($request->all(), [
            'nombre_pro' => 'required|string|unique:productos,nombre_pro',
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/'
        ]);

        if ($validator->fails()) {
            return http::respuesta(http::retError, $validator->errors());
        }

        DB::beginTransaction();
        try {
            $producto = new Producto();
            $producto->nombre_pro = $request->nombre_pro;
            $producto->cantidad = $request->cantidad;
            $producto->precio = $request->precio;
            $producto->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            return http::respuesta(http::retError, ['error en el cacth' => $th->getMessage()]);
        }
        DB::commit();
        return http::respuesta(http::retOK, "producto guardado con exito");
    }

    public function editarProducto(Request $request){
        $idProducto = Producto::find($request->id_productos);
        if (!$idProducto) {
            return http::respuesta(http::retNotFound, "no se encontro el producto");
        }

        $validator = Validator::make($request->all(), [
            'nombre_pro' => 'required|string',
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/'
        ]);

        if ($validator->fails()) {
            return http::respuesta(http::retError, $validator->errors());
        }

        DB::beginTransaction();
        try {
            $idProducto->nombre_pro = $request->nombre_pro;
            $idProducto->cantidad = $request->cantidad;
            $idProducto->precio = $request->precio;
            $idProducto->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            return http::respuesta(http::retError, ['error en el cacth' => $th->getMessage()]);
        }
        DB::commit();
        return http::respuesta(http::retOK, "producto editado con exito");
    }

    public function eliminarProducto(Request $request){
        $idProducto = Producto::find($request->id_productos);
        if (!$idProducto) {
            return http::respuesta(http::retNotFound, "no se encontro el producto");
        }

        DB::beginTransaction();
        try {
            $idProducto->delete();
        } catch (\Throwable $th) {
            DB::rollBack();
            return http::respuesta(http::retError, ['error en el catch' => $th->getMessage()]);
        }
        DB::commit();
        return http::respuesta(http::retOK, "Producto eliminado con exito");
    }
}
