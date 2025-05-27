<?php

namespace App\Http\Controllers;

use App\Models\cronogramas;
use App\Models\expedientes;
use App\Models\pagos;
use Illuminate\Http\Request;
use Validator;
use DB;

class CronogramasController extends Controller
{

    public function index($expediente_id)
    {
        
        $cronogramas = DB::table('cronogramas')
        ->where('cronogramas.id_expedientes','=',$expediente_id)
        ->select('cronogramas.*')
        ->get();
        
        return response()->json($cronogramas);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        // try {
            
            $request->merge([
                'monto_cuota' => str_replace(',', '', $request->monto_cuota),
            ]);
            
            $descuento=request('chkDescuento');
            if ($descuento=='on') {
                $validator=Validator::make($request->all(),[
                    'id_expediente'=>'required',
                    'numero_cuotas'=>'required|integer',
                    'fecha_inicial_pago'=>'required|date',
                    'monto_cuota'=>'required|numeric',
                    'interes_aplicado'=>'required|numeric',
                    'monto_deuda_dscto'=>'required'
                ]);    
            }else{
                $validator=Validator::make($request->all(),[
                    'id_expediente'=>'required',
                    'numero_cuotas'=>'required|integer',
                    'fecha_inicial_pago'=>'required|date',
                    'monto_cuota'=>'required|numeric',
                    'interes_aplicado'=>'required|numeric',
                ]);
            }

            $validator=Validator::make($request->all(),[
                'id_expediente'=>'required',
                'numero_cuotas'=>'required|integer',
                'fecha_inicial_pago'=>'required|date',
                'monto_cuota'=>'required|numeric',
                'interes_aplicado'=>'required|numeric',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['message'=>'error','data'=>$validator->errors()],422);
            }
            
            $estado_cronograma=cronogramas::where('id_expedientes',request('id_expediente'))->value('estado');

            // if ($estado_cronograma==0 || $estado_cronograma==1) {
            //     return response()->json(['message'=>'Accion previa','data'=>'No se puede registrar un cronograma si existre un PENDIENTE o CANCELADO,
            //     cierre primero el cronograma anterior','status'=>'required'], 409);
            // }


            // if (!$existe_cronograma) {
                $cronograma = new cronogramas();
                $cronograma->id_user=auth()->user()->id;
                $cronograma->id_expedientes=request('id_expediente');
                $cronograma->numero_cuotas=request('numero_cuotas');
                $cronograma->fecha_inicial_pago=request('fecha_inicial_pago');
                $cronograma->monto_pagar=request('monto_cuota');
                $cronograma->interes_aplicado=request('interes_aplicado');
                $cronograma->save();
                
                if ($descuento=='on'){
                    $exp_update=expedientes::findOrFail(request('id_expediente'));
                    $exp_update->monto_dscto=request('monto_deuda_dscto');
                    if ($request->hasFile('ordenanzadscto')){
                        $file = request('ordenanzadscto')->getClientOriginalName();//archivo recibido
                        $filename = pathinfo($file, PATHINFO_FILENAME);//nombre archivo sin extension
                        $extension = request('ordenanzadscto')->getClientOriginalExtension();//extensión
                        $archivo= $filename.'_'.time().'.'.$extension;//
                        request('ordenanzadscto')->storeAs('ordenanzadscto/',$archivo,'public');//refiere carpeta publica es el nombre de disco
                        $exp_update->ordenanzadscto = $archivo;
                    }
                    $exp_update->save();
                }

                return response()->json(['message'=>'success','data'=>'Cronograma Agregado'], 200);
            // }else{
            //     return response()->json(['status'=>'error','message'=>'No se puede registrar otro cronograma para un expediente'], 200);
            // }
        // } catch (\Throwable $th) {
        //     return response()->json(['status'=>'error','data'=>$th], 500);
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show($expediente_id)
    {
        $cronograma=DB::table('expedientes')
        ->leftjoin('deudores','deudores.id','=','expedientes.id_deudores')
        ->leftjoin('direcciones','direcciones.id','=','expedientes.id_direcciones')
        ->select('deudores.nombre',
        'deudores.apellidos',
        'deudores.nombre_rep',
        'deudores.apellidos_rep',
        'expedientes.concepto',
        'expedientes.expediente',
        'expedientes.monto',
        'direcciones.nombre as entidad_sancionadora',
        )
        ->where('expedientes.id','=',$expediente_id)
        ->first();
        if ($cronograma) {
            return response()->json(['status'=>'success','data'=>$cronograma], 200);
        }else{
            return response()->json(['message'=>'No Se encontraron los datos'], 201);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cronogramas $cronogramas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $cronograma_id)
    {
        try {
            
            $validator=Validator::make($request->all(),[
                'numero_cuotas'=>'required|integer',
                'fecha_inicial_pago'=>'required|date',
                'monto_cuota'=>'required|numeric',
                'interes_aplicado'=>'required|numeric',
            ]);
            if ($validator->fails()) {
                return response()->json(['status'=>'required','message'=>$validator->errors()],422);
            }

            $cronograma = cronogramas::findOrFail($cronograma_id);

            $cronograma->id_user=auth()->user()->id; 
            $cronograma->numero_cuotas=request('numero_cuotas');
            $cronograma->fecha_inicial_pago=request('fecha_inicial_pago');
            $cronograma->monto_pagar=request('monto_cuota');
            $cronograma->interes_aplicado=request('interes_aplicado');
            $cronograma->save();
            return response()->json(['status'=>'success','message'=>'Registro Actualizado'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status'=>'error','message'=>'No se pudo encontrar el id del cronograma'], 500);
        } catch (\Throwable $th) {
            return response()->json(['status'=>'error','message'=>'no se pudo procesar la transacción'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_cronograma)
    {
        $pagos=pagos::where('id_cronograma',$id_cronograma)->first();

        if ($pagos) {
            return response()->json(['status'=>'error','data'=>'No es posible eliminar el cronograma, contiene pagos'], 422);
        }else{
            $cronograma=cronogramas::findOrFail($id_cronograma);
            $cronograma->delete();
            return response()->json(['status'=>'success','data'=>'Registro Eliminado'], 200);
        }


    }
}
