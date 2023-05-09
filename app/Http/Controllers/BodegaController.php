<?php

namespace App\Http\Controllers;

use App\Helpers\Http;
use App\Models\Bodega;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BodegaController extends Controller
{
    public function guardarProductosEnBodega(Request $request){
       $validator = Validator::make($request->all(), [
            'productos_id' => 'array',
            'nombre_bo' => 'string|unique:bodegas,nombre_bo'
       ]);

       if ($validator->fails()) {
            return http::respuesta(http::retError, $validator->errors());
       }

       DB::beginTransaction();
       try {
            foreach ($request->productos_id as $pro) {
               $idProductos = Producto::find($pro);
               if (!$idProductos) {
                    return http::respuesta(http::retNotFound, "algun producto no fue encontrado");
               }
                $bodega = new Bodega();
                $bodega->nombre_bo = $request->nombre_bo;
                $bodega->productos_id = $pro;
                $bodega->save();
            }
       } catch (\Throwable $th) {
          DB::rollBack();
          return http::respuesta(http::retError, ['error en cacth'=> $th->getMessage()]);
       }
       DB::commit();
       return http::respuesta(http::retOK, "productos en bodega guardados");
    }

    public function obtenerProductosPorNombreBodega(Request $request){
        $nombreBo = $request->nombre_bo;
        $productosEnBodega = DB::table('bodegas AS b')
                             ->join('productos AS p', 'b.productos_id', '=', 'p.id_productos')
                             ->select('p.nombre_pro')
                             ->where('b.nombre_bo', '=', $nombreBo)
                             ->get();
         if ($productosEnBodega == null) {
             return http::respuesta(http::retNotFound, "no se encontraron productos en la bodega");
         }
         return http::respuesta(http::retOK, [
               'bodega' => $nombreBo,
               'productos' => $productosEnBodega
         ]);
    }
}