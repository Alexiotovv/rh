<?php

namespace App\Http\Controllers;

use App\Models\constanciasemitidos;
use App\Models\constanciasdatos;
use App\Models\expedientes;
use App\Models\numerocartas;
use Illuminate\Http\Request;
use DB;
class ConstanciasemitidosController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(){
        $datos_constancias=constanciasdatos::all()->first();
        $constancias_emitidos=DB::table('constanciasemitidos')
        ->leftjoin('expedientes','expedientes.id','=','constanciasemitidos.idExpediente')
        ->leftjoin('deudores','deudores.id','=','expedientes.id_deudores')
        ->select(
            'constanciasemitidos.id',
            'deudores.ruc',
            'deudores.dni',
            'constanciasemitidos.numero_carta',
            'expedientes.expediente as numero_expediente',
            'expedientes.monto',
            'expedientes.concepto',
            'expedientes.fecha',
        )
        ->get();
        
        return view('constancias.index',compact('constancias_emitidos','datos_constancias'));
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

        $id_expediente = request('id_expediente');
        $ce = constanciasemitidos::where('idExpediente', $id_expediente)->exists();
        
        if ($ce) {
            return redirect()->route('index.constancias')->with('mensaje', 'Ya existe una constancia de este expediente, busque en la parte inferior');
        }
        
        $id_datos_constancias = constanciasdatos::where('estado', 1)->value('id');
        $descripcion_correlativo = constanciasdatos::where('estado', 1)->value('descripcion_correlativo');
        $numero_carta = numerocartas::value('numero_carta');
        $numero_carta = $numero_carta + 1;
        $numero_formateado = str_pad($numero_carta, 3, '0', STR_PAD_LEFT);
        $numero_carta_guardar = $numero_formateado."-".$descripcion_correlativo;

        $obj= new constanciasemitidos();
        $obj->numero_carta=$numero_carta_guardar;
        $obj->idConstanciasDatos=$id_datos_constancias;
        $obj->idExpediente=$id_expediente;
        $obj->save();

        //actualiza el número de carta generado
        numerocartas::query()->update(['numero_carta' => $numero_carta]);

        return redirect()->route('index.constancias')->with('mensaje','Constancia Registrada!');
        #return response()->json(['message'=>'Constancia Registrada']);

    }


    public function imprimir($id_constancia)
    {
        $constancia=constanciasemitidos::find($id_constancia);
        $numero_carta=$constancia->numero_carta;
        
        $deudor=DB::table('expedientes')
        ->leftjoin('deudores','deudores.id','=','expedientes.id_deudores')
        ->leftjoin('distritos','distritos.id','=','deudores.id_distritos')
        ->leftjoin('provincias','provincias.id','=','distritos.id_provincias')
        ->where('expedientes.id','=',$constancia->idExpediente)
        ->select(
            'deudores.ruc',
            'deudores.dni',
            'deudores.razon',
            'deudores.nombre',
            'deudores.apellidos',
            'deudores.domicilio',
            'distritos.nombre_distrito',
            'provincias.nombre_provincia',
        )
        ->first();

        $constanciadatos=constanciasdatos::find($constancia->idConstanciasDatos);
        $contenido=$constanciadatos->contenido;
        $firma=$constanciadatos->archivo_firma;
        
        return view('constancias.imprimir',compact('numero_carta','deudor','contenido','firma'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(constanciasemitidos $constanciasemitidos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, constanciasemitidos $constanciasemitidos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(constanciasemitidos $constanciasemitidos)
    {
        //
    }
}
