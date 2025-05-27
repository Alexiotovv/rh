<?php

namespace App\Http\Controllers;

use App\Models\egresos;
use App\Models\expediente_egresos;
use Illuminate\Http\Request;

class EgresosController extends Controller
{

    public function index()
    {
        $egresos= egresos::all();
        return view('egresos.index',compact('egresos'));
    }


    public function store(Request $request)
    {
        $obj = new egresos();
        $obj->nombre=request('nombre');
        $obj->save();
        return redirect()->route('index.egresos')->with('mensaje','Egreso Registrado');
    }

    public function show(regiones $regiones)
    {
        
    }

    public function edit(regiones $regiones)
    {
    
    }

    public function update(Request $request)
    {  
        $id = request('idegreso');
        $obj = egresos::findOrFail($id);
        $obj->nombre=request('nombre');
        $obj->save();
        return redirect()->route('index.egresos')->with('mensaje','Egreso Actualizada');
        
    }

    public function destroy(Request $request)
    {
        $id = request('idegreso_eliminar');
        $datos=expediente_egresos::where('egreso_id',$id)->first();
        if ($datos){
            return redirect()->route('index.egresos')->with('mensaje','El registro no se puede eliminar, contiene datos!')->with('color','danger');
        }
        $egresos = egresos::findOrFail($id);
        $egresos->delete();
        
        return redirect()->route('index.egresos')->with('mensaje','Registro Eliminado!')->with('color','success');

    }
}
