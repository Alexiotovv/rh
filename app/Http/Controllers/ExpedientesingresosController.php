<?php

namespace App\Http\Controllers;

use App\Models\expediente_ingresos;
use Illuminate\Http\Request;
use Validator;
use DB;

class ExpedientesingresosController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'expediente_id_ing' => 'required|exists:expedientes,id',
            'ingreso' => 'required|exists:ingresos,id',
            'monto_ingreso' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validación fallida',
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            $registro = new expediente_ingresos();
            $registro->expediente_id = $request->expediente_id_ing;
            $registro->ingreso_id = $request->ingreso;
            $registro->monto = $request->monto_ingreso;
            $registro->save();

            return response()->json([
                'message' => 'Ingreso guardado correctamente',
                'data' => $registro
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al guardar el ingreso',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index($expediente_id)
    {
        try {
            
            
            $ingresos = DB::table('expediente_ingresos')
                ->leftJoin('ingresos', 'ingresos.id', '=', 'expediente_ingresos.ingreso_id')
                ->where('expediente_ingresos.expediente_id', $expediente_id)
                ->select(
                    'expediente_ingresos.id',
                    'ingresos.nombre',
                    'expediente_ingresos.monto'
                )
                ->get();

            return response()->json([
                'message' => 'Ingresos del expediente',
                'data' => $ingresos
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los ingresos del expediente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $ingreso = DB::table('expediente_ingresos')->where('id', $id)->first();

            if (!$ingreso) {
                return response()->json([
                    'message' => 'Ingreso no encontrado'
                ], 404);
            }

            DB::table('expediente_ingresos')->where('id', $id)->delete();

            return response()->json([
                'message' => 'Ingreso eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el ingreso',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}