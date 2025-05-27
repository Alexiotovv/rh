<?php

namespace App\Http\Controllers;

use App\Models\expedientes;
use App\Models\numeroexpediente;
use App\Models\direcciones;
use App\Models\deudores;
use App\Models\vregistrals;
use App\Models\cronogramas;
use App\Models\entidades;
use App\Models\tipo_creditos;
use App\Models\ingresos;
use App\Models\egresos;
use Illuminate\Http\Request;
use Validator;
use DB;
use Illuminate\Support\Facades\Storage;

class ExpedientesController extends Controller
{
    
    public function carta_expedientes($doc_identidad){
        
        $deudor_natural=DB::table('deudores')
        ->leftjoin('expedientes','expedientes.id_deudores','=','deudores.id')
        ->leftjoin('cronogramas','cronogramas.id_expedientes','=','expedientes.id')
        ->where('deudores.dni','=',$doc_identidad)
        ->select('deudores.*','expedientes.*','cronogramas.estado')
        ->get();
        if ($deudor_natural->isNotEmpty()) {
            return response()->json(['data'=>$deudor_natural,'status'=>'success'], 200);
        }

        $deudor_juridico=DB::table('deudores')
        ->leftjoin('expedientes','expedientes.id_deudores','=','deudores.id')
        ->leftjoin('cronogramas','cronogramas.id_expedientes','=','expedientes.id')
        ->where('deudores.ruc','=',$doc_identidad)
        ->select('deudores.*','expedientes.*','cronogramas.estado')
        ->get();

        if ($deudor_juridico->isNotEmpty()) {
            return response()->json(['data'=>$deudor_juridico,'status'=>'success'], 200);
        }
        return response()->json(['message'=>'No existe registros con documento proporcionado','status'=>'success'], 200);

    }

    public function carta($id_expediente){
        $data= DB::table('expedientes')
        ->leftjoin('deudores','expedientes.id_deudores','=','deudores.id')
        ->leftjoin('distritos','distritos.id','=','deudores.id_distritos')
        ->leftjoin('provincias','provincias.id','=','distritos.id_provincias')
        ->leftjoin('cronogramas','expedientes.id','=','cronogramas.id_expedientes')
        ->leftjoin('tipo_personas','tipo_personas.id','=','deudores.id_tipopersonas')
        ->where('expedientes.id','=',$id_expediente)
        ->select(
        'deudores.dni',
        'deudores.ruc',
        'deudores.nombre',
        'deudores.apellidos',
        'deudores.domicilio',
        'deudores.nombre',
        'distritos.nombre_distrito',
        'provincias.nombre_provincia',
        'cronogramas.estado')
        ->get();

        return response()->json(['data'=>$data,'status'=>'success'], 200);

    }


    public function index()
    {

        $expedientes=DB::table('expedientes')
        ->leftjoin('deudores','deudores.id','=','expedientes.id_deudores')
        ->leftjoin('direcciones','direcciones.id','=','expedientes.id_direcciones')
        ->select(
            'expedientes.id',
            'deudores.nombre',
            'deudores.apellidos',
            'deudores.nombre_rep',
            'deudores.apellidos_rep',
            'deudores.dni',
            'deudores.ruc',
            'direcciones.id as id_direccion',
            'direcciones.nombre as direccion',
            'expedientes.concepto',
            'expedientes.monto',
            'expedientes.monto_dscto',
            'expedientes.expediente',
            'expedientes.fecha',
            'expedientes.uit',
            'expedientes.importe',
            'expedientes.resolucion_admin',
            'expedientes.fecha_resolucion_admin',
            'expedientes.noaperturado',
            'expedientes.archivo',
            'expedientes.created_at')
        ->orderBy('expedientes.id','desc')
        ->paginate(1500);
        
        $ingresos=ingresos::all();
        $egresos=egresos::all();

        return view('expedientes.index',compact(
            'expedientes',
            'ingresos',
            'egresos',
        ));
        

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $oficinas=direcciones::all();
        $entidades=entidades::all();
        $tipo_creditos=tipo_creditos::all();

        return view('expedientes.create',compact(
            'oficinas',
            'entidades',
            'tipo_creditos',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        
        $rules = [
            'id_deudor' => 'required|integer',
            'concepto' => 'required|string|max:250',
            'monto' => 'required|numeric',
            // 'expediente' => 'required|string|max:250',
            'fecha' => 'required|date',
            'uit' => 'required|numeric',
            // 'importe' => 'required|numeric',
            'fecha_resolucion_admin' => 'required|date',
            'entidad' => 'required|integer',
            'tipo_credito' => 'required|integer',
        ];

        $messages = [
            'entidad.required' => 'El campo entidad es obligatorio.',
            'tipo_credito.required' => 'El campo tipo de crédito es obligatorio.',
            'id_deudor.required' => 'El campo deudor es obligatorio.',
            'concepto.required' => 'El campo concepto es obligatorio.',
            'monto.required' => 'El campo monto es obligatorio.',
            // 'expediente.required' => 'El campo expediente es obligatorio.',
            'expediente.max' => 'El campo expediente no debe exceder los 250 caracteres.',
            'fecha.date' => 'El campo fecha debe ser una fecha válida.',
            // 'importe.required' => 'El campo importe es obligatorio.',
            // 'importe.numeric' => 'El campo importe debe ser un número.',
            'fecha_resolucion_admin.required' => 'El campo fecha de resolución administrativa es obligatorio.',
            'fecha_resolucion_admin.date' => 'El campo fecha de resolución administrativa debe ser una fecha válida.',
            
        ];
        $this->validate($request, $rules, $messages);
        // return response()->json(['status'=>'success','data'=>'Registro Creado'],200);
        
        if (request('noaperturado')=='on'){
            $administrado=true;
        }else{
            $administrado=false;
        }
        $obj = new expedientes();
        $obj->id_deudores=request('id_deudor');
        $obj->entidad_id=request('entidad');
        $obj->tipo_credito_id=request('tipo_credito');
        $obj->plazo_meses=request('plazo_meses');
        $obj->id_direcciones=request('oficina');
        $obj->concepto=request('concepto');
        $obj->monto=request('monto');
        $obj->monto_dscto=request('monto_dscto');
        // $obj->expediente=request('expediente');
        $obj->fecha=request('fecha');
        $obj->uit=request('uit');
        $obj->importe=0.00;
        $obj->resolucion_admin=request('resolucion_admin');
        $obj->fecha_resolucion_admin=request('fecha_resolucion_admin');
        $obj->noaperturado=$administrado;


        if ($request->hasFile('archivo')){
            $file = request('archivo')->getClientOriginalName();//archivo recibido
            $filename = pathinfo($file, PATHINFO_FILENAME);//nombre archivo sin extension
            $extension = request('archivo')->getClientOriginalExtension();//extensión
            $archivo= $filename.'_'.time().'.'.$extension;//
            request('archivo')->storeAs('expedientes/',$archivo,'public');//refiere carpeta publica es el nombre de disco
            $obj->archivo = $archivo;
        }

        
        $numero = numeroexpediente::value('numero_expediente');
        $ano = numeroexpediente::value('ano_expediente');
        $desc = numeroexpediente::value('desc_expediente');
        $numero= $numero + 1;
        $numero_formateado = str_pad($numero, 3, '0', STR_PAD_LEFT);
        $numero_exp_guardar = $numero_formateado."-".$ano."-".$desc;
        
        $obj->expediente=$numero_exp_guardar;
        $obj->save();

        numeroexpediente::query()->update(['numero_expediente' => $numero]);


        return redirect()->route('index.expedientes')->with('mensaje','Expediente Creado!');
    }

    /**
     * Display the specified resource.
     */
    public function show($numero)
    {
        
        $expediente=DB::table('expedientes')
        ->leftjoin('deudores','deudores.id','=','expedientes.id_deudores')
        ->leftjoin('direcciones','direcciones.id','=','expedientes.id_direcciones')
        ->leftjoin('cronogramas','cronogramas.id_expedientes','=','expedientes.id')
        ->select(
            'expedientes.id',
            'deudores.nombre',
            'deudores.apellidos',
            'direcciones.nombre as direccion',
            'expedientes.concepto',
            'expedientes.monto',
            'expedientes.monto_dscto',
            'expedientes.expediente',
            'expedientes.fecha',
            'expedientes.uit',
            'expedientes.importe',
            'expedientes.resolucion_admin',
            'expedientes.fecha_resolucion_admin',
            'expedientes.noaperturado',
            'expedientes.archivo',
            
            DB::raw('(IF(cronogramas.id > 0, true, false)) AS tiene_cronograma')
            )
        ->whereRaw('LEFT(expedientes.expediente, 8) = ?', [$numero])
        ->first();
        if (!$expediente) {
            return response()->json(['status'=>'error','message'=>'No existe expediente con el numero proporcionado'], 401);
        }else{
            return response()->json(['status'=>'success','data'=>$expediente], 200);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $oficinas=direcciones::all();
        $entidades=entidades::all();
        $tipo_creditos=tipo_creditos::all();
        $expediente=DB::table('expedientes')
        ->leftjoin('deudores','deudores.id','=','expedientes.id_deudores')
        ->leftjoin('direcciones','direcciones.id','=','expedientes.id_direcciones')
        ->leftjoin('cronogramas','cronogramas.id_expedientes','=','expedientes.id')
        ->select(
            'expedientes.id',
            'deudores.dni',
            'deudores.ruc',
            'deudores.nombre',
            'deudores.razon',
            'deudores.apellidos',
            'deudores.domicilio',
            'direcciones.id as id_direccion',
            'direcciones.nombre as direccion',
            'expedientes.concepto',
            'expedientes.monto',
            'expedientes.monto_dscto',
            'expedientes.expediente',
            'expedientes.fecha',
            'expedientes.uit',
            'expedientes.importe',
            'expedientes.resolucion_admin',
            'expedientes.fecha_resolucion_admin',
            'expedientes.noaperturado',
            'expedientes.archivo',
            'expedientes.plazo_meses',
            'expedientes.entidad_id',
            'expedientes.tipo_credito_id',
            DB::raw('(IF(cronogramas.id > 0, true, false)) AS tiene_cronograma')
            )
        ->where('expedientes.id','=',$id)
        ->first();

        return view('expedientes.edit',compact(
            'oficinas',
            'expediente',
            'entidades',
            'tipo_creditos',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $expediente_id=request('id_expediente');
        
        
        $rules = [
            'concepto' => 'required|string|max:250',
            'monto' => 'required|numeric',
            // 'expediente' => 'required|string|max:250',
            'fecha' => 'required|date',
            'uit' => 'required|numeric',
            // 'importe' => 'required|numeric',
            'fecha_resolucion_admin' => 'required|date',
        ];

        $messages = [
            
            'concepto.required' => 'El campo concepto es obligatorio.',
            'monto.required' => 'El campo monto es obligatorio.',
            'expediente.required' => 'El campo expediente es obligatorio.',
            // 'expediente.max' => 'El campo expediente no debe exceder los 250 caracteres.',
            'fecha.date' => 'El campo fecha debe ser una fecha válida.',
            // 'importe.required' => 'El campo importe es obligatorio.',
            // 'importe.numeric' => 'El campo importe debe ser un número.',
            'fecha_resolucion_admin.required' => 'El campo fecha de resolución administrativa es obligatorio.',
            'fecha_resolucion_admin.date' => 'El campo fecha de resolución administrativa debe ser una fecha válida.',
        ];
        $this->validate($request, $rules, $messages);

        if (request('noaperturado')=='on'){
            $administrado=true;
        }else{
            $administrado=false;
        }

        $obj = expedientes::findOrFail($expediente_id);
        $obj->id_direcciones=request('oficina');
        $obj->entidad_id=request('entidad');
        $obj->tipo_credito_id=request('tipo_credito');
        $obj->plazo_meses=request('plazo_meses');
        $obj->concepto=request('concepto');
        $obj->monto=request('monto');
        $obj->monto_dscto=request('monto_dscto');
        // $obj->expediente=request('expediente');
        $obj->fecha=request('fecha');
        $obj->uit=request('uit');
        $obj->importe=0.00;
        $obj->resolucion_admin=request('resolucion_admin');
        $obj->fecha_resolucion_admin=request('fecha_resolucion_admin');
        $obj->noaperturado=$administrado;


        if ($request->hasFile('archivo')){
            $file = request('archivo')->getClientOriginalName();//archivo recibido
            $filename = pathinfo($file, PATHINFO_FILENAME);//nombre archivo sin extension
            $extension = request('archivo')->getClientOriginalExtension();//extensión
            $archivo= $filename.'_'.time().'.'.$extension;//
            request('archivo')->storeAs('expedientes/',$archivo,'public');//refiere carpeta publica es el nombre de disco
            $obj->archivo = $archivo;
        }

        $obj->save();
                
        return redirect()->route('index.expedientes')->with('mensaje','Expediente Actualizado!');
    }

    public function buscar_doc($dniruc)
    {
        $deudor= deudores::where('dni',$dniruc)->first();
        if (!$deudor) {
            $deudor=deudores::where('ruc',$dniruc)->first();   
        }

        if ($deudor) {
            $datos=DB::table('expedientes')
            ->leftjoin('cronogramas','cronogramas.id_expedientes','=','expedientes.id')
            ->select(
                'expedientes.id',
                'expedientes.expediente as numero_expediente',
                'expedientes.monto',
                'expedientes.concepto',
                'expedientes.fecha',
                'cronogramas.estado'
            )
            ->where('expedientes.id_deudores','=',$deudor->id)
            ->get();
            
            return response()->json(['data'=>$datos]);
        }else {
            
            return response()->json(['status'=>'No se encontró datos']);
        }


    }

    public function destroy_registro($id){

        $cronogramas = cronogramas::where('id_expedientes',$id)->exists();
        $vregistrals = vregistrals::where('id_expedientes',$id)->exists();
        if ($cronogramas) {
            return response()->json(['message'=>'No se puede eliminar, contiene cronogramas','status'=>'conflict'], 409);
        }
        if ($vregistrals) {
            return response()->json(['message'=>'No se puede eliminar, contiene verificacion registral','status'=>'conflict'], 409);
        }

        $expediente=expedientes::findOrFail($id);
        $nombre_archivo=$expediente->archivo;
        $expediente->delete();

        if ($nombre_archivo!=='') {
            $ruta = 'expedientes/'.$nombre_archivo;
            Storage::disk('public')->delete($ruta);
        }

        return response()->json(['message'=>'Expediente eliminado','status'=>'success'], 200,);
    }

    public function destroy($id)
    {
        try {
            $expediente=expedientes::find($id);
            $nombre_archivo=$expediente->archivo;
            $ruta = 'expedientes/'.$nombre_archivo;

            // if (Storage::exists($ruta)) {
            Storage::disk('public')->delete($ruta);


            $expediente->archivo='';
            $expediente->save();
            return response()->json(['message'=>'Expediente escaneado eliminado','status'=>'success'], 200,);
            // }else{
            //     return response()->json(['message'=>'Ruta o archivo no existe','status'=>'success'], 200,);
            // }

        } catch (\Throwable $th) {
            return response()->json(['message'=>$th,'status'=>'error'], 200,);
        }
    }

    public function show_correlativo(Request $request){
        $numeroexpediente= numeroexpediente::first();
        
        if (!$numeroexpediente) {
            $numero=0;
            $ano=0;
            $descripcion='';
        }else{
            $numero=$numeroexpediente->numero_expediente;
            $ano=$numeroexpediente->ano_expediente;
            $descripcion=$numeroexpediente->desc_expediente;;
        }

        return response()->json(['status'=>'success','data'=>['numero'=>$numero,'ano'=>$ano,'descripcion'=>$descripcion]], 200);
    }

    public function update_correlativo(Request $request){
        $numero = request('numero_expediente');
        $ano = request('ano_expediente');
        $desc = request('desc_expediente');
        $registro = numeroexpediente::first();
        if ($registro) {
            $obj = numeroexpediente::findOrFail($registro->id);
            $obj->numero_expediente=$numero;
            $obj->ano_expediente=$ano;
            $obj->desc_expediente=$desc;
            $obj->save();
        } else {
            $obj = new numeroexpediente();
            $obj->numero_expediente=$numero;
            $obj->ano_expediente=$ano;
            $obj->desc_expediente=$desc;
            $obj->save();
        }
        return response()->json(['status'=>'success','message'=>'Correlativo Guardado'], 200);
    }


}
