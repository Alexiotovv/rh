<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DeudoresController;
use App\Http\Controllers\ExpedientesController;
use App\Http\Controllers\DireccionesController;
use App\Http\Controllers\TipoPersonasController;
use App\Http\Controllers\RegionesController;
use App\Http\Controllers\GenerateTokensController;
use App\Http\Controllers\CronogramasController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\VregistralsController;
use App\Http\Controllers\ConstanciasdatosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConstanciasemitidosController;
use App\Http\Controllers\AgrariosDeudoresController;
use App\Http\Controllers\AgrariosCreditosController;
use App\Http\Controllers\ExpedientesingresosController;
use App\Http\Controllers\ExpedientesegresosController;
use App\Http\Controllers\IngresosController;
use App\Http\Controllers\EgresosController;
use App\Http\Controllers\EntidadesController;
use App\Http\Controllers\CondicionlaboralsController;

Route::get('/',function(){
    return view('auth.login');
})->name('credentials');

Route::middleware('auth:api')->get('/check-auth', [App\Http\Controllers\AuthController::class, 'checkAuth']);

//Home y Graficos
Route::get('/home', [HomeController::class, 'index'])->middleware(['auth'])->name('home');
Route::get('/graficos/datos', [HomeController::class,'datos'])->name('graficos.datos');

//expedientes_ingresos
Route::post('/ingresos/store', [ExpedientesingresosController::class, 'store']);
Route::get('/ingresos/index/{expediente_id}', [ExpedientesingresosController::class, 'index']);
Route::get('/ingresos/destroy/{ingreso_id}', [ExpedientesingresosController::class, 'destroy']);

//expediente_egresos
Route::post('/egresos/store', [ExpedientesegresosController::class, 'store']);
Route::get('/egresos/index/{expediente_id}', [ExpedientesegresosController::class, 'index']);
Route::get('/egresos/destroy/{egreso_id}', [ExpedientesegresosController::class, 'destroy']);


//ingresos
Route::get('/ingresos/index', [IngresosController::class,'index'])->name('index.ingresos');
Route::post('/ingresos/update', [IngresosController::class,'update'])->name('update.ingresos');
Route::post('/ingresos/store', [IngresosController::class,'store'])->name('store.ingresos');
Route::post('/ingresos/destroy', [IngresosController::class,'destroy'])->name('destroy.ingresos');

//egresos
Route::get('/egresos/index', [EgresosController::class,'index'])->name('index.egresos');
Route::post('/egresos/update', [EgresosController::class,'update'])->name('update.egresos');
Route::post('/egresos/store', [EgresosController::class,'store'])->name('store.egresos');
Route::post('/egresos/destroy', [EgresosController::class,'destroy'])->name('destroy.egresos');

//condicion laboral
Route::get('/condicionlaborals/index', [CondicionlaboralsController::class,'index'])->name('index.condicion_laborals');
Route::post('/condicionlaborals/update', [CondicionlaboralsController::class,'update'])->name('update.condicion_laborals');
Route::post('/condicionlaborals/store', [CondicionlaboralsController::class,'store'])->name('store.condicion_laborals');
Route::post('/condicionlaborals/destroy', [CondicionlaboralsController::class,'destroy'])->name('destroy.condicion_laborals');
Route::get('/condicionlaborals/show', [CondicionlaboralsController::class,'show'])->name('show.condicion_laborals');
Route::post('/condicionlaborals/asinc/store', [CondicionlaboralsController::class, 'store_asinc'])->name('store.asinc_condicion_laborals');


//entidades
Route::get('/entidades/index', [EntidadesController::class,'index'])->name('index.entidades');
Route::post('/entidades/update', [EntidadesController::class,'update'])->name('update.entidades');
Route::post('/entidades/store', [EntidadesController::class,'store'])->name('store.entidades');
Route::post('/entidades/destroy', [EntidadesController::class,'destroy'])->name('destroy.entidades');


//Register and Login user
Route::post('/login', [AuthController::class, 'login'])->name('login_post');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//Usuarios
Route::get('/users', [UserController::class,'users'])->middleware(['auth'])->name('users');
Route::get('/users/edit/{id}', [UserController::class,'edit'])->middleware(['auth'])->name('usuario.edit');
Route::get('/users/create', [UserController::class,'create'])->middleware(['auth'])->name('usuario.create');
Route::post('/users/update', [UserController::class,'update'])->middleware(['auth'])->name('usuario.update');
Route::post('/users/changepassword', [UserController::class,'changepassword'])->middleware(['auth'])->name('change.password');

Route::post('/profile', function () { return auth()->user(); });
Route::patch('/change_status/user/{id_user}', [UserController::class,'change_status']);
Route::post('/register', [UserController::class,'register'])->name('register');

//Ejecutados
Route::get('/ejecutado/create', [DeudoresController::class,'create'])->middleware(['auth'])->name('create.ejecutado');
Route::get('/ejecutado/index', [DeudoresController::class,'index'])->middleware(['auth'])->name('index.ejecutado');
Route::post('/ejecutado/store', [DeudoresController::class,'store'])->middleware(['auth'])->name('store.ejecutado');
Route::get('/ejecutado/edit/{id}', [DeudoresController::class,'edit'])->middleware(['auth'])->name('edit.ejecutado');
Route::post('/ejecutado/update', [DeudoresController::class,'update'])->middleware(['auth'])->name('update.ejecutado');
Route::post('/ejecutado/destroy', [DeudoresController::class,'destroy'])->middleware(['auth'])->name('destroy.ejecutado');
Route::get('/ejecutado/show/{doc}', [DeudoresController::class,'show'])->middleware(['auth'])->name('show.ejecutado');
Route::get('/ejecutado/ficha/{id}', [DeudoresController::class,'ficha'])->middleware(['auth'])->name('ficha.ejecutado');

//Expedientes
Route::get('/expedientes/index/', [ExpedientesController::class,'index'])->middleware(['auth'])->name('index.expedientes');
Route::get('/expedientes/create/', [ExpedientesController::class,'create'])->middleware(['auth'])->name('create.expediente');
Route::get('/expedientes/edit/{id}', [ExpedientesController::class,'edit'])->middleware(['auth'])->name('edit.expediente');
Route::post('/expedientes/store/', [ExpedientesController::class,'store'])->middleware(['auth'])->name('store.expediente');
Route::get('/expedientes/buscar/{numero}', [ExpedientesController::class,'show'])->middleware(['auth'])->name('buscar.expediente');;
Route::post('/expedientes/update', [ExpedientesController::class,'update'])->middleware(['auth'])->name('update.expediente');;
Route::get('/expedientes/buscar/doc/{dniruc}', [ExpedientesController::class,'buscar_doc'])->middleware(['auth'])->name('buscar.expediente.dniruc');;
Route::get('/expedientes/destroy/{id}', [ExpedientesController::class,'destroy'])->middleware(['auth'])->name('destroy.expediente');
Route::get('/expedientes/destroy/registro/{id}', [ExpedientesController::class,'destroy_registro'])->middleware(['auth'])->name('destroy.registro');
Route::get('/expedientes/show/correlativo', [ExpedientesController::class,'show_correlativo'])->middleware(['auth'])->name('show.correlativo');
Route::post('/expedientes/update/correlativo', [ExpedientesController::class,'update_correlativo'])->middleware(['auth'])->name('update.correlativo');

//Cronogramas
Route::get('/cronogramas/index/{expediente_id}', [CronogramasController::class,'index'])->middleware(['auth'])->name('index.cronograma');
Route::post('/cronogramas/store/', [CronogramasController::class,'store'])->name('store.cronograma');
Route::put('/cronogramas/update/{cronograma_id}', [CronogramasController::class,'update'])->middleware(['auth'])->name('update.cronograma');
Route::get('/cronogramas/show/{expediente_id}', [CronogramasController::class,'show'])->middleware(['auth'])->name('show.cronograma');
Route::get('/cronogramas/destroy/{id}', [CronogramasController::class,'destroy'])->middleware(['auth'])->name('destroy.cronograma');

//Pagos
Route::post('/pagos/store/', [PagosController::class,'store'])->middleware(['auth'])->name('store.pagos');
Route::post('/pagos/update/{id}', [PagosController::class,'update'])->middleware(['auth'])->name('update.pagos');
Route::get('/pagos/index/{cronograma_id}', [PagosController::class,'index'])->middleware(['auth'])->name('index.pagos');
Route::get('/pagos/destroy/{id}', [PagosController::class,'destroy'])->middleware(['auth'])->name('destroy.pagos');

//contancias
Route::get('/constancias/index', [ConstanciasemitidosController::class,'index'])->middleware(['auth'])->name('index.constancias');
Route::post('/constancias/store', [ConstanciasemitidosController::class,'store'])->middleware(['auth'])->name('store.constancias');
Route::get('/constancias/imprimir/{id_constancia}', [ConstanciasemitidosController::class,'imprimir'])->middleware(['auth'])->name('imprimir.constancias');

//constancias datos
Route::get('/datos/constancias/index', [ConstanciasdatosController::class,'datos_index'])->middleware(['auth'])->name('datos.constancias.index');
Route::post('/datos/constancias/store', [ConstanciasdatosController::class,'datos_store'])->middleware(['auth'])->name('datos.constancias.store');
Route::get('/datos/constancias/edit/{id}', [ConstanciasdatosController::class,'datos_edit'])->middleware(['auth'])->name('datos.constancias.edit');
Route::post('/datos/constancias/update', [ConstanciasdatosController::class,'datos_update'])->middleware(['auth'])->name('datos.constancias.update');

//CorrelativoCartas de No Adeudo
Route::post('/numero/correlativo/update', [ConstanciasdatosController::class,'correlativo_update'])->middleware(['auth'])->name('correlativo.update');

//Verificacion Registral
Route::post('/vregistral/store/', [VregistralsController::class,'store']);
Route::middleware('jwt.auth')->put('/vregistral/update/{vregistral_id}', [VregistralsController::class,'update']);
Route::get('/vregistral/index/{expediente_id}', [VregistralsController::class,'index']);
Route::get('/vregistral/destroy/{id}', [VregistralsController::class,'destroy']);

//Oficinas
Route::get('/oficinas/index', [DireccionesController::class,'index'])->name('index.oficinas');
Route::post('/oficinas/update', [DireccionesController::class,'update'])->name('update.oficinas');
Route::post('/oficinas/store', [DireccionesController::class,'store'])->name('store.oficinas');
Route::post('/oficinas/destroy', [DireccionesController::class,'destroy'])->name('destroy.oficinas');



//--------------------START AGRARIOS-----------------------------------
//Desembolso
Route::post('/agrario/desembolso/store', [AgrariosDeudoresController::class,'store'])->name('agrario.desembolso.store');

//Deudores
Route::get('/agrario/deudor/index', [AgrariosDeudoresController::class,'index'])->name('agrario.deudor.index');
Route::get('/agrario/deudor/edit/{id}', [AgrariosDeudoresController::class,'edit'])->name('agrario.deudor.edit');
Route::post('/agrario/deudor/store', [AgrariosDeudoresController::class,'store'])->name('agrario.deudor.store');
Route::post('/agrario/deudor/update', [AgrariosDeudoresController::class,'update'])->name('agrario.deudor.update');
Route::post('/agrario/deudor/destroy', [AgrariosDeudoresController::class,'destroy'])->name('agrario.deudor.destroy');

//Generar Creditos
Route::post('/agrario/credito/store', [AgrariosCreditosController::class,'store'])->name('agrario.credito.store');
Route::get('/agrario/credito/destroy/{id_credito}', [AgrariosCreditosController::class,'destroy'])->name('agrario.credito.destroy');
Route::get('/agrario/credito/show/{id_deudor}', [AgrariosCreditosController::class,'show'])->name('agrario.credito.show');



//---------------------------END AGRARIOS------------------------------




//Provincia,Distritos, Regiones
Route::get('/distritos', [RegionesController::class,'index_distritos']);
Route::get('/provincias', [RegionesController::class,'index_provincias']);
Route::get('/regiones', [RegionesController::class,'index_regiones']);
