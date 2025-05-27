<?php

namespace App\Http\Controllers;

use App\Models\expediente_egresos;
use Illuminate\Http\Request;
use Validator;
use DB;

class ExpedientesegresosController extends Controller
{
    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'expediente_id_egr' => 'required|exists:expedientes,id',
        //     'egreso' => 'required|exists:egresos,id',
        //     'monto_egreso' => 'required|numeric|min:0',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'message' => 'Validación fallida',
        //         'errors' => $validator->errors()
        //     ], 422);
        // }

        // try {

            $registro = new expediente_egresos();
            $registro->expediente_id = $request->expediente_id_egr;
            $registro->egreso_id = $request->egreso;
            $registro->monto = $request->monto_egreso;
            $registro->save();

            return response()->json([
                'message' => 'Egreso guardado correctamente',
                'data' => $registro
            ]);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'message' => 'Error al guardar el egreso',
        //         'error' => $e->getMessage()
        //     ], 500);
        // }
    }

    public function index($expediente_id)
    {
        try {
            
            
            $egresos = DB::table('expediente_egresos')
                ->leftJoin('egresos', 'egresos.id', '=', 'expediente_egresos.egreso_id')
                ->where('expediente_egresos.expediente_id', $expediente_id)
                ->select(
                    'expediente_egresos.id',
                    'egresos.nombre',
                    'expediente_egresos.monto'
                )
                ->get();

            return response()->json([
                'message' => 'Egresos del expediente',
                'data' => $egresos
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los egresos del expediente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $egreso = DB::table('expediente_egresos')->where('id', $id)->first();

            if (!$egreso) {
                return response()->json([
                    'message' => 'Egreso no encontrado'
                ], 404);
            }

            DB::table('expediente_egresos')->where('id', $id)->delete();

            return response()->json([
                'message' => 'Egreso eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el egreso',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}