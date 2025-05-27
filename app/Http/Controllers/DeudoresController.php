<?php

namespace App\Http\Controllers;

use App\Models\deudores;
use App\Models\expedientes;
use App\Models\cronogramas;
use App\Models\pagos;
use App\Models\tipo_personas;
use App\Models\provincias;
use App\Models\distritos;
use App\Models\vregistrals;
use App\Models\condicion_laborals;
use Illuminate\Http\Request;
use Validator;
use DB;

class DeudoresController extends Controller
{

    public function index(Request $request)
    {
        $deudores = DB::table('deudores')
        ->leftjoin('tipo_personas','tipo_personas.id','=','deudores.id_tipopersonas')
        ->leftjoin('distritos','distritos.id','=','deudores.id_distritos')
        ->leftjoin('provincias','provincias.id','=','distritos.id_provincias')
        ->select(
            'deudores.id as id_deudor',
            'tipo_personas.nombre as tipo_persona',
            'provincias.id as id_provincia',
            'provincias.nombre_provincia as provincia',
            'distritos.id as id_distrito',
            'distritos.nombre_distrito as distrito',
            'deudores.dni',
            'deudores.nombre',
            'deudores.apellidos',
            'deudores.cargo',
            'deudores.ruc',
            'deudores.razon',
            'deudores.nombre_rep',
            'deudores.apellidos_rep',
            'deudores.dni_rep',
            'deudores.domicilio',
            'deudores.created_at as fecha_registro',
        )
        ->orderBy('deudores.id', 'desc')
        ->paginate(1500);        
        
        return view('ejecutados.index',['deudores'=>$deudores]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $tipopersonas = tipo_personas::all();
        $provincias = provincias::all();
        $condicion_laboral = condicion_laborals::all();
        return view('ejecutados.create',
        compact('tipopersonas','provincias','condicion_laboral'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $obj=new deudores();
        $obj->id_tipopersonas=request('tipopersona');
        $obj->id_distritos=request('distrito');
        $obj->condicion_laboral_id=request('condicion_laboral');
        if (request('tipopersona')=='1') {
            

            $rules=[
                'dni'=>'required_if:tipopersona,1|string|size:8|',
                'nombre'=>'required_if:tipopersona,1||string|max:250',
                'apellidos'=>'required_if:tipopersona,1|string|max:250',
                'domicilio'=>'required|string|max:250',
            ];
    
            $messages = [
                'dni.required_if' => 'El DNI es obligatorio cuando el tipo de persona es Natural.',
                'dni.string' => 'El DNI debe ser una cadena de texto.',
                'dni.size' => 'El DNI debe tener exactamente 8 caracteres.',
                
                'nombre.required_if' => 'El nombre es obligatorio cuando el tipo de persona es Natural.',
                'nombre.string' => 'El nombre debe ser una cadena de texto.',
                'nombre.max' => 'El nombre no debe exceder los 250 caracteres.',
                
                'apellidos.required_if' => 'Los apellidos son obligatorios cuando el tipo de persona es Natural.',
                'apellidos.string' => 'Los apellidos deben ser una cadena de texto.',
                'apellidos.max' => 'Los apellidos no deben exceder los 250 caracteres.',
                
                'domicilio.required' => 'El domicilio es obligatorio.',
                'domicilio.string' => 'El domicilio debe ser una cadena de texto.',
                'domicilio.max' => 'El domicilio no debe exceder los 250 caracteres.',
            ];
    
            $this->validate($request, $rules, $messages);   


            $obj->dni=request('dni');
            $obj->nombre=request('nombre');
            $obj->apellidos=request('apellidos');
            $obj->cargo=request('cargo');
            $obj->domicilio=request('domicilio');
            $obj->ruc='';
            $obj->razon='';
            $obj->nombre_rep='';
            $obj->apellidos_rep='';
            $obj->dni_rep='';

        }else{
            

            $rules = [
                'ruc' => 'required|string|size:11',
                'razon' => 'required_if:tipopersona,2|string|max:250',
                'nombre_rep' => 'required_if:tipopersona,2|string|max:250',
                'apellidos_rep' => 'required_if:tipopersona,2|string|max:250',
                'dni_rep' => 'required_if:tipopersona,2|string|size:8',
            ];
            
            $messages = [
                'ruc.required' => 'El RUC es obligatorio.',
                'ruc.string' => 'El RUC debe ser una cadena de texto.',
                'ruc.size' => 'El RUC debe tener exactamente 11 caracteres.',
            
                'razon.required_if' => 'La razón social es obligatoria cuando el tipo de persona es Jurídica.',
                'razon.string' => 'La razón social debe ser una cadena de texto.',
                'razon.max' => 'La razón social no debe exceder los 250 caracteres.',
            
                'nombre_rep.required_if' => 'El nombre del representante es obligatorio cuando el tipo de persona es Jurídica.',
                'nombre_rep.string' => 'El nombre del representante debe ser una cadena de texto.',
                'nombre_rep.max' => 'El nombre del representante no debe exceder los 250 caracteres.',
            
                'apellidos_rep.required_if' => 'Los apellidos del representante son obligatorios cuando el tipo de persona es Jurídica.',
                'apellidos_rep.string' => 'Los apellidos del representante deben ser una cadena de texto.',
                'apellidos_rep.max' => 'Los apellidos del representante no deben exceder los 250 caracteres.',
            
                'dni_rep.required_if' => 'El DNI del representante es obligatorio cuando el tipo de persona es Jurídica.',
                'dni_rep.string' => 'El DNI del representante debe ser una cadena de texto.',
                'dni_rep.size' => 'El DNI del representante debe tener exactamente 8 caracteres.',
            ];
            
            $this->validate($request, $rules, $messages);
            

            $obj->dni='';
            $obj->nombre='';
            $obj->apellidos='';
            $obj->cargo=request('cargo');
            $obj->domicilio=request('domicilio');
            $obj->ruc=request('ruc');
            $obj->razon=request('razon');
            $obj->nombre_rep=request('nombre_rep');
            $obj->apellidos_rep=request('apellidos_rep');
            $obj->dni_rep=request('dni_rep');
        }
        $obj->save();

        return redirect()->route('index.ejecutado')->with('mensaje','Registro Creado!');
        #return response()->json(['status'=>'success','message'=>'Registro Creado'],200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,$doc)
    {
        
        $deudor = deudores::where('dni', $doc)
        ->leftjoin('tipo_personas','tipo_personas.id','=','deudores.id_tipopersonas')
        ->select(
            'deudores.razon',
            'deudores.id',
            'deudores.nombre',
            'deudores.apellidos',
            'deudores.cargo',
            'deudores.domicilio',
            'tipo_personas.id as id_tipopersona')
        ->first();
    
        if (!$deudor) {
            $deudor = deudores::where('ruc', $doc)
            ->leftjoin('tipo_personas','tipo_personas.id','=','deudores.id_tipopersonas')
            ->select(
                'deudores.razon',
                'deudores.id', 
                'deudores.nombre', 
                'deudores.apellidos', 
                'deudores.cargo', 
                'deudores.domicilio',
                'tipo_personas.id as id_tipopersona')
                ->first();
        }
        
        if ($deudor) {
            return response()->json(['status' => 'success', 'data' => $deudor], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'No se encontró el DNI o RUC en la base de datos'], 202);
        }
            
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tipopersonas = tipo_personas::all();
        $provincias = provincias::all();
        $distritos = distritos::all();
        $condicion_laboral = condicion_laborals::all();
        $deudores = DB::table('deudores')
        ->leftjoin('tipo_personas','tipo_personas.id','=','deudores.id_tipopersonas')
        ->leftjoin('distritos','distritos.id','=','deudores.id_distritos')
        ->leftjoin('provincias','provincias.id','=','distritos.id_provincias')
        ->select(
            'deudores.id as id_deudor',
            'deudores.id_tipopersonas as id_tipopersonas',
            'tipo_personas.nombre as tipo_persona',
            'provincias.id as id_provincia',
            'provincias.nombre_provincia as provincia',
            'distritos.id as id_distrito',
            'distritos.nombre_distrito as distrito',
            'deudores.dni',
            'deudores.nombre',
            'deudores.apellidos',
            'deudores.cargo',
            'deudores.ruc',
            'deudores.razon',
            'deudores.nombre_rep',
            'deudores.apellidos_rep',
            'deudores.dni_rep',
            'deudores.domicilio',
            'deudores.condicion_laboral_id',
            'deudores.created_at as fecha_registro',
        )
        ->where('deudores.id','=',$id)
        ->first();
        
        return view('ejecutados.edit',compact(
            'deudores',
            'tipopersonas',
            'provincias',
            'distritos',
            'condicion_laboral'
            ));

        #return response()->json(['status'=>'success','message'=>'Registro Actualizado'],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {   $id=request('id_deudor');

        $obj=deudores::findOrFail($id);
        $obj->id_tipopersonas=request('tipopersona');
        $obj->id_distritos=request('distrito');
        $obj->condicion_laboral_id=request('condicion_laboral');

        if (request('tipopersona')=='1') {
            
            $rules=[
                'dni'=>'required_if:tipopersona,1|string|size:8|',
                'nombre'=>'required_if:tipopersona,1||string|max:250',
                'apellidos'=>'required_if:tipopersona,1|string|max:250',
                'domicilio'=>'required|string|max:250',
            ];
    
            $messages = [
                'dni.required_if' => 'El DNI es obligatorio cuando el tipo de persona es Natural.',
                'dni.string' => 'El DNI debe ser una cadena de texto.',
                'dni.size' => 'El DNI debe tener exactamente 8 caracteres.',
                
                'nombre.required_if' => 'El nombre es obligatorio cuando el tipo de persona es Natural.',
                'nombre.string' => 'El nombre debe ser una cadena de texto.',
                'nombre.max' => 'El nombre no debe exceder los 250 caracteres.',
                
                'apellidos.required_if' => 'Los apellidos son obligatorios cuando el tipo de persona es Natural.',
                'apellidos.string' => 'Los apellidos deben ser una cadena de texto.',
                'apellidos.max' => 'Los apellidos no deben exceder los 250 caracteres.',
                
                'domicilio.required' => 'El domicilio es obligatorio.',
                'domicilio.string' => 'El domicilio debe ser una cadena de texto.',
                'domicilio.max' => 'El domicilio no debe exceder los 250 caracteres.',
            ];
    
            $this->validate($request, $rules, $messages);

            $obj->dni=request('dni');
            $obj->nombre=request('nombre');
            $obj->apellidos=request('apellidos');
            $obj->cargo=request('cargo');
            $obj->domicilio=request('domicilio');
            $obj->ruc='';
            $obj->razon='';
            $obj->nombre_rep='';
            $obj->apellidos_rep='';
            $obj->dni_rep='';

        }else{

            $rules = [
                'ruc' => 'required|string|size:11',
                'razon' => 'required_if:tipopersona,2|string|max:250',
                'nombre_rep' => 'required_if:tipopersona,2|string|max:250',
                'apellidos_rep' => 'required_if:tipopersona,2|string|max:250',
                'dni_rep' => 'required_if:tipopersona,2|string|size:8',
            ];
            
            $messages = [
                'ruc.required' => 'El RUC es obligatorio.',
                'ruc.string' => 'El RUC debe ser una cadena de texto.',
                'ruc.size' => 'El RUC debe tener exactamente 11 caracteres.',
            
                'razon.required_if' => 'La razón social es obligatoria cuando el tipo de persona es Jurídica.',
                'razon.string' => 'La razón social debe ser una cadena de texto.',
                'razon.max' => 'La razón social no debe exceder los 250 caracteres.',
            
                'nombre_rep.required_if' => 'El nombre del representante es obligatorio cuando el tipo de persona es Jurídica.',
                'nombre_rep.string' => 'El nombre del representante debe ser una cadena de texto.',
                'nombre_rep.max' => 'El nombre del representante no debe exceder los 250 caracteres.',
            
                'apellidos_rep.required_if' => 'Los apellidos del representante son obligatorios cuando el tipo de persona es Jurídica.',
                'apellidos_rep.string' => 'Los apellidos del representante deben ser una cadena de texto.',
                'apellidos_rep.max' => 'Los apellidos del representante no deben exceder los 250 caracteres.',
            
                'dni_rep.required_if' => 'El DNI del representante es obligatorio cuando el tipo de persona es Jurídica.',
                'dni_rep.string' => 'El DNI del representante debe ser una cadena de texto.',
                'dni_rep.size' => 'El DNI del representante debe tener exactamente 8 caracteres.',
            ];
            
            $this->validate($request, $rules, $messages);

            $obj->dni='';
            $obj->nombre='';
            $obj->apellidos='';
            $obj->cargo=request('cargo');
            $obj->domicilio=request('domicilio');
            $obj->ruc=request('ruc');
            $obj->razon=request('razon');
            $obj->nombre_rep=request('nombre_rep');
            $obj->apellidos_rep=request('apellidos_rep');
            $obj->dni_rep=request('dni_rep');
        }
        $obj->save();
        return redirect()->route('index.ejecutado')->with('mensaje','Registro Actualizado!');
        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id=request('id_deudor');

        $datos_en_expedientes=expedientes::where('id_deudores',$id)->first();

        if ($datos_en_expedientes){
            return redirect()->route('index.ejecutado')->with('mensaje','El registro no se puede eliminar, contiene datos!')->with('color','danger');
        }


        $deudor = deudores::findOrFail($id);
        $deudor->delete();
        
        return redirect()->route('index.ejecutado')->with('mensaje','Registro Eliminado!')->with('color','success');

    }

    public function ficha($id){
        $deudor= DB::table("deudores")
        ->leftjoin("condicion_laborals","condicion_laborals.id","=","deudores.condicion_laboral_id")
        ->where("deudores.id","=",$id)
        ->select("deudores.*","condicion_laborals.nombre as condicion_laboral")
        ->first();

        $expediente=DB::table('expedientes')
        ->leftjoin('direcciones','direcciones.id','=','expedientes.id_direcciones')
        ->leftjoin('entidades','entidades.id','=','expedientes.entidad_id')
        ->leftjoin('tipo_creditos','tipo_creditos.id','=','expedientes.tipo_credito_id')
        ->where('expedientes.id_deudores','=',$id)
        ->select('expedientes.*',
            'entidades.nombre as nombre_entidad',
            'tipo_creditos.nombre as tipo_credito',
            'direcciones.nombre')
        ->get();

        $ingresos=DB::table('expedientes')
        ->leftjoin("expediente_ingresos","expediente_ingresos.expediente_id","=","expedientes.id")
        ->leftjoin("ingresos","ingresos.id","=","expediente_ingresos.ingreso_id")
        ->where('expedientes.id_deudores','=',$id)
        ->select(
            "expediente_ingresos.expediente_id",
            "ingresos.nombre as nombre_ingreso",
            "expediente_ingresos.monto as monto_ingreso")
        ->get();
        $egresos=DB::table('expedientes')
        ->leftjoin("expediente_egresos","expediente_egresos.expediente_id","=","expedientes.id")
        ->leftjoin("egresos","egresos.id","=","expediente_egresos.egreso_id")
        ->where('expedientes.id_deudores','=',$id)
        ->select(
            "expediente_egresos.expediente_id",
            "egresos.nombre as nombre_egreso",
            "expediente_egresos.monto as monto_egreso")
        ->get();

        $cronogramas = cronogramas::whereIn('id_expedientes', $expediente->pluck('id'))->get();
        $pagos = pagos::whereIn('id_cronograma',$cronogramas->pluck('id'))->get();
        $vregistral=vregistrals::whereIn('id_expedientes',$expediente->pluck('id'))->get();

        return view('ejecutados.ficha',compact(
            'deudor',
            'expediente',
            'cronogramas',
            'pagos',
            'vregistral',
            'ingresos',
            'egresos',
        ));
    }



}
