<?php

namespace App\Http\Controllers;

use App\Models\direcciones;
use App\Models\expedientes;
use Illuminate\Http\Request;

class DireccionesController extends Controller
{

    public function index()
    {
        $oficinas= direcciones::all();
        return view('oficinas.index',compact('oficinas'));
    }


    public function store(Request $request)
    {
        $obj = new direcciones();
        $obj->nombre=request('nombre');
        $obj->save();
        return redirect()->route('index.oficinas')->with('mensaje','Oficina Registrada');
    }

    public function show(regiones $regiones)
    {
        
    }

    public function edit(regiones $regiones)
    {
    
    }

    public function update(Request $request)
    {  
        $id = request('idoficina');
        $obj = direcciones::findOrFail($id);
        $obj->nombre=request('nombre');
        $obj->save();
        return redirect()->route('index.oficinas')->with('mensaje','Oficina Actualizada');
        
    }

    public function destroy(Request $request)
    {
        $id = request('idoficina_eliminar');
        $datos_en_direccion=expedientes::where('id_direcciones',$id)->first();
        if ($datos_en_direccion){
            return redirect()->route('index.oficinas')->with('mensaje','El registro no se puede eliminar, contiene datos!')->with('color','danger');
        }
        $oficinas = direcciones::findOrFail($id);
        $oficinas->delete();
        
        return redirect()->route('index.oficinas')->with('mensaje','Registro Eliminado!')->with('color','success');

    }
}
