<?php

namespace App\Http\Controllers;

use App\Models\agrarios_deudores;
use Illuminate\Http\Request;
use DB;
use Validator;
class AgrariosDeudoresController extends Controller
{

    public function index()
    {
        $deudores=DB::table('agrarios_deudores')
        ->leftjoin('distritos','distritos.id','=','agrarios_deudores.distritos_id')
        ->leftjoin('provincias','provincias.id','=','distritos.id_provincias')
        ->select('agrarios_deudores.*','distritos.nombre_distrito','provincias.nombre_provincia')
        ->get();
        $provincias=DB::table('provincias')
        ->select('provincias.id','provincias.nombre_provincia')
        ->get();
        $tipocreditos=DB::table('agrarios_tipocreditos')
        ->select('id','nombre')
        ->get();
        return view('agrarios/deudores/index',compact('deudores','provincias','tipocreditos'));

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
        
        // Validar los datos del formulario
        $validator=Validator::make($request->all(),[
            'distritos_id' => 'required',
            'nombres' => 'required|string|max:250',
            'apellidos' => 'required|string|max:250',
            'direccion_dni' => 'required|string|max:250',
            'direccion_actual' => 'string|max:250',
            'dni_ruc' => 'required|string|max:15',
            'telefono' => 'string|max:250',
            'mercado' => 'string|max:250',
            'actividad' => 'string|max:250',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with(['mensaje'=>$validator->errors(),'color'=>'warning']); 
        }

        // Obtener los datos validados
        $validatedData = $validator->validated();

        // Crear un nuevo registro en la base de datos
        agrarios_deudores::create($validatedData);

        // Redireccionar con un mensaje de éxito
        return redirect()->back()->with(['mensaje'=>'Datos guardados correctamente.','color'=>'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(agrarios_deudores $agrarios_deudores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $personas=DB::table('agrarios_deudores')
        ->leftjoin('distritos','distritos.id','=','agrarios_deudores.distritos_id')
        ->leftjoin('provincias','provincias.id','=','distritos.id_provincias')
        ->select('agrarios_deudores.*','distritos.id as distrito_id','provincias.id as provincia_id')
        ->where('agrarios_deudores.id','=',$id)
        ->first();
        return response()->json(['data'=>$personas,'status'=>'success'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, agrarios_deudores $agrarios_deudores)
    {
         // Validar los datos del formulario
         $validator=Validator::make($request->all(),[
            'id_persona' => 'required',
            'distritos_id' => 'required',
            'nombres' => 'required|string|max:250',
            'apellidos' => 'required|string|max:250',
            'direccion_dni' => 'required|string|max:250',
            'direccion_actual' => 'string|max:250',
            'dni_ruc' => 'required|string|max:15',
            'telefono' => 'string|max:250',
            'mercado' => 'string|max:250',
            'actividad' => 'string|max:250',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with(['mensaje'=>$validator->errors(),'color'=>'warning']); 
        }

        // Obtener los datos validados
        $validatedData = $validator->validated();

        $persona = agrarios_deudores::findOrFail($request->id_persona);
        $persona->distritos_id=$request->distritos_id;
        $persona->nombres=$request->nombres;
        $persona->apellidos=$request->apellidos;
        $persona->direccion_dni=$request->direccion_dni;
        $persona->direccion_actual=$request->direccion_actual;
        $persona->dni_ruc=$request->dni_ruc;
        $persona->telefono=$request->telefono;
        $persona->mercado=$request->mercado;
        $persona->actividad=$request->actividad;
        $persona->save();

        // Redireccionar con un mensaje de éxito
        return redirect()->back()->with(['mensaje'=>'Datos guardados correctamente.','color'=>'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(agrarios_deudores $agrarios_deudores)
    {
        //
    }
}
