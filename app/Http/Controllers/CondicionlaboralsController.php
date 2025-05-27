<?php

namespace App\Http\Controllers;

use App\Models\condicion_laborals;
use App\Models\deudores;
use Illuminate\Http\Request;

class CondicionlaboralsController extends Controller
{

    public function index()
    {
        $condicion_laborals= condicion_laborals::all();
        return view('condicion_laborals.index',compact('condicion_laborals'));
    }


    public function store(Request $request)
    {
        $obj = new condicion_laborals();
        $obj->nombre=request('nombre');
        $obj->save();
        return redirect()->route('index.condicion_laborals')->with('mensaje','Condición Laboral Registrado');
    }
    public function store_asinc(Request $request)
    {
        //Validación
        $request->validate([
            'nombre' => 'required|string|max:255|unique:condicion_laborals,nombre',
        ]);
        

        // Guardar
        $obj = new condicion_laborals();
        $obj->nombre = $request->input('nombre');
        $obj->save();

        // Retornar respuesta JSON
        return response()->json([
            'message' => 'Condición Laboral registrada correctamente',
            'data' => $obj
        ], 201); // 201: creado
    }

    public function edit(regiones $regiones)
    {
    
    }

    public function update(Request $request)
    {  
        $id = request('idcondicion_laborals');
        $obj = condicion_laborals::findOrFail($id);
        $obj->nombre=request('nombre');
        $obj->save();
        return redirect()->route('index.condicion_laborals')->with('mensaje','Condición laboral Actualizada');
        
    }

    public function destroy(Request $request)
    {
        $id = request('idcondicion_laborals_eliminar');
        $datos=deudores::where('condicion_laboral_id',$id)->first();
        if ($datos){
            return redirect()->route('index.condicion_laborals')->with('mensaje','El registro no se puede eliminar, contiene datos!')->with('color','danger');
        }
        $condicion_laborals = condicion_laborals::findOrFail($id);
        $condicion_laborals->delete();
        
        return redirect()->route('index.condicion_laborals')->with('mensaje','Registro Eliminado!')->with('color','success');

    }

    public function show(Request $request)
    {
        $condicion_laborals = condicion_laborals::select('id', 'nombre')
            ->orderBy('nombre')
            ->get();

        return response()->json(['data' => $condicion_laborals], 200);
    }

}
