<?php

namespace App\Http\Controllers;

use App\Models\constanciasdatos;
use App\Models\numerocartas;
use Illuminate\Http\Request;

class ConstanciasdatosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function datos_index()
    {
        
        $constanciasdatos= constanciasdatos::all();
        $numerocorrelativo = numerocartas::first();
        if (!$numerocorrelativo) {
            $numerocorrelativo=0;
        }
        $numerocorrelativo=$numerocorrelativo->numero_carta;
        return view('constancias.datos',compact('constanciasdatos','numerocorrelativo'));
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
    public function datos_store(Request $request)
    {
        //primero actualizará estados a todos a false
        constanciasdatos::where('estado', true)->update(['estado' => false]);

        $datos=new constanciasdatos();
        $datos->contenido=request('contenido');
        $datos->descripcion_correlativo=request('descripcion_correlativo');
        $datos->estado=request('estado');

        if ($request->hasFile('archivo_encabezado')){
            $file = request('archivo_encabezado')->getClientOriginalName();//archivo recibido
            $filename = pathinfo($file, PATHINFO_FILENAME);//nombre archivo sin extension
            $extension = request('archivo_encabezado')->getClientOriginalExtension();//extensión
            $archivo= $filename.'_'.time().'.'.$extension;//
            request('archivo_encabezado')->storeAs('encabezados/',$archivo,'public');//refiere carpeta publica es el nombre de disco
            $datos->archivo_encabezado = $archivo;
        }

        if ($request->hasFile('archivo_firma')){
            $file = request('archivo_firma')->getClientOriginalName();//archivo recibido
            $filename = pathinfo($file, PATHINFO_FILENAME);//nombre archivo sin extension
            $extension = request('archivo_firma')->getClientOriginalExtension();//extensión
            $archivo= $filename.'_'.time().'.'.$extension;//
            request('archivo_firma')->storeAs('firmas/',$archivo,'public');//refiere carpeta publica es el nombre de disco
            $datos->archivo_firma = $archivo;
        }
        $datos->save();

        return redirect()->route('datos.constancias.index')->with('mensaje','Nuevo Datos de Constancia Creado!');
    }

    public function datos_edit($id)
    {
        $constanciasdatos = constanciasdatos::find($id);
        return view('constancias.editardatos',compact('constanciasdatos'));
    }

    public function show(constanciasdatos $constanciasdatos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(constanciasdatos $constanciasdatos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function datos_update(Request $request)
    {
        
        constanciasdatos::where('estado', true)->update(['estado' => false]);

        $id=request('id_datos_constancias');
        $datos=constanciasdatos::findOrFail($id);
        $datos->contenido=request('contenido');
        $datos->descripcion_correlativo=request('descripcion_correlativo');
        $datos->estado=request('estado');

        if ($request->hasFile('archivo_encabezado')){
            $file = request('archivo_encabezado')->getClientOriginalName();//archivo recibido
            $filename = pathinfo($file, PATHINFO_FILENAME);//nombre archivo sin extension
            $extension = request('archivo_encabezado')->getClientOriginalExtension();//extensión
            $archivo= $filename.'_'.time().'.'.$extension;//
            request('archivo_encabezado')->storeAs('encabezados/',$archivo,'public');//refiere carpeta publica es el nombre de disco
            $datos->archivo_encabezado = $archivo;
        }

        if ($request->hasFile('archivo_firma')){
            $file = request('archivo_firma')->getClientOriginalName();//archivo recibido
            $filename = pathinfo($file, PATHINFO_FILENAME);//nombre archivo sin extension
            $extension = request('archivo_firma')->getClientOriginalExtension();//extensión
            $archivo= $filename.'_'.time().'.'.$extension;//
            request('archivo_firma')->storeAs('firmas/',$archivo,'public');//refiere carpeta publica es el nombre de disco
            $datos->archivo_firma = $archivo;
        }
        
        $datos->save();

        return redirect()->route('datos.constancias.index')->with('mensaje','Datos de Constancia Actualizado!');
    }


    public function correlativo_update(constanciasdatos $constanciasdatos)
    {
        $numero = request('numero');
        $registro = numerocartas::first();
        if ($registro) {
            $obj = numerocartas::findOrFail($registro->id);
            $obj->numero_carta=$numero;
            $obj->save();
        } else {
            $obj = new numerocartas();
            $obj->numero_carta = $numero;
            $obj->save();
        }
        return redirect()->route('datos.constancias.index')->with('mensaje', 'Correlativo Actualizado!');
    }

    public function destroy(constanciasdatos $constanciasdatos)
    {
        //
    }


}
