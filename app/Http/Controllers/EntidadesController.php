<?php

namespace App\Http\Controllers;

use App\Models\entidades;
use App\Models\expedientes;
use Illuminate\Http\Request;

class EntidadesController extends Controller
{

    public function index()
    {
        $entidades= entidades::all();
        return view('entidades.index',compact('entidades'));
    }


    public function store(Request $request)
    {
        $obj = new entidades();
        $obj->nombre=request('nombre');
        $obj->save();
        return redirect()->route('index.entidades')->with('mensaje','Entidad Registrado');
    }

    public function show(regiones $regiones)
    {
        
    }

    public function edit(regiones $regiones)
    {
    
    }

    public function update(Request $request)
    {  
        $id = request('identidad');
        $obj = entidades::findOrFail($id);
        $obj->nombre=request('nombre');
        $obj->save();
        return redirect()->route('index.entidades')->with('mensaje','Entidad Actualizada');
        
    }

    public function destroy(Request $request)
    {
        $id = request('identidad_eliminar');
        $datos=expedientes::where('entidad_id',$id)->first();
        if ($datos){
            return redirect()->route('index.entidades')->with('mensaje','El registro no se puede eliminar, contiene datos!')->with('color','danger');
        }
        $entidades = entidades::findOrFail($id);
        $entidades->delete();
        
        return redirect()->route('index.entidades')->with('mensaje','Registro Eliminado!')->with('color','success');

    }
}
