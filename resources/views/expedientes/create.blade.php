@extends('bases.base')
@section('content')
<div class="card">
    <div class="card-body">
        @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="col-sm-4">
                <div class="alert border-0 border-start border-5 border-success alert-dismissible fade show py-2">
                    <div class="d-flex align-items-center">
                        <div class="font-35 text-success"><i class='bx bxs-check-circle'></i>
                        </div>
                    <div class="ms-3">
                            <h6 class="mb-0 text-success">Mensaje</h6>
                            <div>{{ $error }}</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endforeach
    @endif
    <form action="{{ route('store.expediente') }}" method="POST" class="p-4"  enctype="multipart/form-data">@csrf
        <h1 class="text-2xl font-bold mb-6 text-center md:text-left">Registro de Expedientes</h1>

        <div class="row">
            <h5>Buscar Trabajador</h5>
            <input type="text" name="id_deudor" id="id_deudor" hidden>
            <label for="doc" class="form-label">DNI/RUC</label>
            <p hidden id="MensajeBusqueda" style="color: red"></p>
            <div class="col-md-4 d-flex align-items-end">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" id="doc" name="doc" placeholder="dni/ruc" required>
                    <button onclick="btnBuscarEjecutado()" class="btn btn-primary btn-sm" type="button">Buscar</button>
                </div>
            </div>
            
            {{-- <div class="col-md-4">
                <label for="nombre" class="form-label">Ejecutado</label>
                <input type="text" class="form-control form-control-sm" id="ejecutado" name="ejecutado" readonly>
            </div> --}}

            <div class="col-md-4">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" placeholder="Nombre del deudor" readonly>
            </div>
    
            <div class="col-md-4">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control form-control-sm" id="apellidos" name="apellidos" placeholder="Apellidos del deudor" readonly>
            </div>
    
            <div class="col-md-4">
                <label for="" class="form-label">Dirección</label>
                <input type="text" class="form-control form-control-sm" id="direccion" placeholder="Dirección del deudor" readonly>
            </div>
            <div class="col-md-4">
                <label for="" class="form-label">Oficina </label>
                <select name="oficina" id="oficina" class="form-select form-select-sm" required>
                    <option value="">--Seleccion Oficina--</option>
                    @foreach ($oficinas as $o)
                        <option value="{{$o->id}}">{{$o->nombre}}</option>
                    @endforeach
                </select>
                
            </div>
            <br>
            <hr>
            <br>
            <div class="row">
                <h5>Datos del Expediente</h5>
            </div>
            <div class="col-md-6">
                <label for="concepto" class="form-label">Concepto</label>
                <input type="text" class="form-control form-control-sm" id="concepto" name="concepto" placeholder="Concepto del expediente" required>
            </div>
    
            <div class="col-md-3">
                <label for="monto" class="form-label">Monto</label>
                <input type="number" class="form-control form-control-sm" id="monto" name="monto" placeholder="Monto del expediente" required>
            </div>
            <div class="col-md-3">
                <label for="monto_dscto" class="form-label">Cuota</label>
                <input type="number" class="form-control form-control-sm" id="monto_dscto" name="monto_dscto" placeholder="Monto descuento" required>
            </div>
            <div class="col-md-3">
                <label for="plazo_meses" class="form-label">Meses</label>
                <input type="number" class="form-control form-control-sm" id="plazo_meses" name="plazo_meses" placeholder="N° Meses" required>
            </div>
            <div class="col-md-3">
                <label for="entidad" class="form-label">Entidad Bancaria</label>
                <select name="entidad" id="entidad" class="form-select form-select-sm" required>
                    <option value="">--Seleccion Entidad--</option>
                    @foreach ($entidades as $e)
                        <option value="{{$e->id}}">{{$e->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="tipo_credito" class="form-label">Tipo Crédito</label>
                <select name="tipo_credito" id="tipo_credito" class="form-select form-select-sm" required>
                    <option value="">--Seleccion Tipo Crédito--</option>
                    @foreach ($tipo_creditos as $tc)
                        <option value="{{$tc->id}}">{{$tc->nombre}}</option>
                    @endforeach
                </select>
            </div>
    
            <div class="col-md-3">
                <label for="expediente" class="form-label">Número de Expediente</label>
                <input type="text" class="form-control form-control-sm" id="expediente" name="expediente" placeholder="Se genera automáticamente" readonly>
            </div>
    
            <div class="col-md-3">
                <label for="fecha" class="form-label">Fecha del Expediente</label>
                <input type="date" class="form-control form-control-sm" id="fecha" name="fecha" required>
            </div>
    
            <div class="col-md-3" hidden>
                <label for="uit" class="form-label">UIT</label>
                <input type="number" step="0.01" class="form-control form-control-sm" id="uit" name="uit" placeholder="UIT del expediente" value="0" required>
            </div>
    
            <div class="col-md-3" hidden>
                <label for="resolucion_admin" class="form-label">Resolución Administrativa</label>
                <input type="text" class="form-control form-control-sm" id="resolucion_admin" value="0" name="resolucion_admin" placeholder="Resolución administrativa" maxlength="250">
            </div>
    
            <div class="col-md-3" hidden>
                <label for="fecha_resolucion_admin" class="form-label">Fecha de Resolución Administrativa</label>
                <input type="date" class="form-control form-control-sm" id="fecha_resolucion_admin" name="fecha_resolucion_admin">
            </div>
    
            <div class="col-md-3" hidden>
                <br>
                <input type="checkbox" class="form-check-input" id="noaperturado" name="noaperturado">
                <label class="form-check-label" for="noaperturado" >Aperturado</label>
            </div>
    
            <div class="col-md-6">
                <label for="archivo" class="form-label">Expediente Escaneado</label>
                <input type="file" class="form-control form-control-sm" id="archivo" name="archivo">
                <p>Max. 20MB </p>
            </div>
    
            <div class="mb-3">
                <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
            </div>
        </div>
    </form>

    </div>
</div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            const hoy = new Date();
            const fechaFormateada = hoy.toISOString().split('T')[0]; // Formato YYYY-MM-DD
            $('#fecha_resolucion_admin').val(fechaFormateada);
        });
    </script>
    <script>
        function btnBuscarEjecutado() { 
            var doc=$("#doc").val();
            $.ajax({
                type: "GET",
                url: "/ejecutado/show/"+doc,
                dataType: "json",
                success: function (response) {
                    
                    if (response.message) {
                        
                        $("#MensajeBusqueda").text("No se encontró el documento, intente nuevamente");
                        $("#MensajeBusqueda").prop('hidden',false);
                        $("#nombre").val("");
                        $("#apellidos").val("");
                        $("#direccion").val("");
                    }else{
                        $("#MensajeBusqueda").text("");
                        $("#MensajeBusqueda").prop('hidden',true);
                        $("#id_deudor").val(response.data.id);
                        
                        if (response.data.id_tipopersona===1) {
                            $("#ejecutado").val(response.data.razon);
                            $("#nombre").val(response.data.nombre);
                            $("#apellidos").val(response.data.apellidos);
                            $("#direccion").val(response.data.domicilio);
                            
                        }else{
                            $("#ejecutado").val(response.data.razon);
                            $("#direccion").val(response.data.domicilio);
                        }

                    }

                
                }
            });
         }
    </script>
@endsection