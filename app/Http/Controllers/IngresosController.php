<?php

namespace App\Http\Controllers;

use App\Models\ingresos;
use App\Models\expediente_ingresos;
use Illuminate\Http\Request;

class IngresosController extends Controller
{

    public function index()
    {
        $ingresos= ingresos::all();
        return view('ingresos.index',compact('ingresos'));
    }


    public function store(Request $request)
    {
        $obj = new ingresos();
        $obj->nombre=request('nombre');
        $obj->save();
        return redirect()->route('index.ingresos')->with('mensaje','Ingreso Registrado');
    }

    public function show(regiones $regiones)
    {
        
    }

    public function edit(regiones $regiones)
    {
    
    }

    public function update(Request $request)
    {  
        $id = request('idingreso');
        $obj = ingresos::findOrFail($id);
        $obj->nombre=request('nombre');
        $obj->save();
        return redirect()->route('index.ingresos')->with('mensaje','Ingreso Actualizada');
        
    }

    public function destroy(Request $request)
    {
        $id = request('idingreso_eliminar');
        $datos=expediente_ingresos::where('ingreso_id',$id)->first();
        if ($datos){
            return redirect()->route('index.ingresos')->with('mensaje','El registro no se puede eliminar, contiene datos!')->with('color','danger');
        }
        $ingresos = ingresos::findOrFail($id);
        $ingresos->delete();
        
        return redirect()->route('index.ingresos')->with('mensaje','Registro Eliminado!')->with('color','success');

    }
}
