<?php

namespace App\Http\Controllers;

use App\Models\agrarios_creditos;
use App\Models\agrarios_desembolsos;
use Illuminate\Http\Request;

class AgrariosCreditosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $credito = new agrarios_creditos();
        $credito->agrariosdeudores_id=request('deudor_id');
        $credito->agrarios_tipocreditos_id=request('tipocredito');
        $credito->anulacion_monto=request('anulacion_monto');
        $credito->anulacion_resolucion=request('anulacion_resolucion');
        $credito->anulacion_fecha=request('anulacion_fecha');
        $credito->monto_solicitado=request('monto_solicitado');
        $credito->monto_aprobado=request('monto_aprobado');
        $credito->tasa_interes=request('tasa_interes');
        $credito->monto_cuota_pagar=request('monto_cuota_pagar');
        $credito->periodo_gracia=request('periodo_gracia');
        $credito->letra_gracia=request('letra_gracia');
        $credito->periodo_devolucion=request('periodo_devolucion');
        $credito->letra_devolucion=request('letra_devolucion');

        $credito->save();
        return response()->json(['message'=>'Datos guardados correctamente'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id_deudor)
    {
        $creditos=agrarios_creditos::where('agrariosdeudores_id',$id_deudor)
        ->orderBy('id','desc')
        ->get();
        return response()->json($creditos, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(agrarios_creditos $agrarios_creditos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, agrarios_creditos $agrarios_creditos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $datos=agrarios_desembolsos::where('agrarios_creditos_id',$id)->exists();
        if($datos){
            return response()->json(['message'=>'No se puede eliminar, contiene datos'], 200);
        }
        $credito = agrarios_creditos::find($id);
        $credito->delete();
        return response()->json(['message'=>'Registro Eliminado'], 200);
    }
}
