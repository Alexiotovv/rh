<?php

namespace App\Http\Controllers;

use App\Models\agrarios_desembolsos;
use Illuminate\Http\Request;

class AgrariosDesembolsosController extends Controller
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
        try {

            $request->validate([
                'agrarios_creditos_id' => 'required|exists:trabajadores,id',
                'fecha_desembolso' => 'required|date',
                'monto_desembolsado' => 'required|numeric|min:0',
                'fecha_carga' => 'required|date',
                'fecha_pago' => 'required|date',
                'archivo_oficio' => 'required|string|max:250',
            ]);

            Desembolso::create($request->all());

            return response()->json(['message'=>'Registro Correcto'], 200);
            
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Errores de validación',
                'errores' => $e->errors()
            ], 422); // 422 Unprocessable Entity
        }



    }

    /**
     * Display the specified resource.
     */
    public function show(agrarios_desembolsos $agrarios_desembolsos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(agrarios_desembolsos $agrarios_desembolsos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, agrarios_desembolsos $agrarios_desembolsos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(agrarios_desembolsos $agrarios_desembolsos)
    {
        //
    }
}
