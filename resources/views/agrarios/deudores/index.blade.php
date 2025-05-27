@extends('bases.base')
@section('content')

<div class="card">
    <div class="card-body">
        @if(session()->has('mensaje'))
            <div class="col-sm-4">
                <div class="alert border-0 border-start border-5 border-{{Session::get('color')}} alert-dismissible fade show py-2">
                    <div class="d-flex align-items-center">
                        <div class="font-35 text-{{Session::get('color')}}"><i class='bx bxs-check-circle'></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 text-{{Session::get('color')}}">Mensaje</h6>
                            <div>{{Session::get('mensaje')}}</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        
            <h5 class="mb-4">Lista de Personas</h5>
            <a onclick="btnNuevoPersona()" class="btn btn-primary btn-sm">Nuevo Persona</a>

            <div class="table-responsive">
                <br>
                <table id="deudoresTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Acciones</th>
                            <th>Provincia</th>
                            <th>Distrito</th>
                            <th>NombreCompleto</th>
                            <th>Dirección DNI</th>
                            <th>Dirección Actual</th>
                            <th>DNI</th>
                            <th>Teléfono</th>
                            <th>Mercado</th>
                            <th>Actividad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deudores as $deudor)
                        <tr>
                            <td>{{ $deudor->id }}</td>
                            <td>
                                {{-- <a href="{{route('ficha.ejecutado',$deudor->id_deudor)}}" class="btn btn-light btn-sm"><i class="fas fa-eye"></i></a> --}}
                                <a onclick="btnEditarPersona('{{$deudor->id}}')" class="btn btn-light btn-sm" data-bs-toggle="tooltip" title="editar persona"><i class="fas fa-edit"></i></a>
                                <a onclick="btnAsignarCredito(this,{{$deudor->id}})" class="btn btn-light btn-sm" data-bs-toggle="tooltip" title="generar crédito"><i class="fas fa-file-invoice-dollar"></i></a>
                                
                                
                            </td>
                            <td>{{ $deudor->nombre_provincia }}</td>
                            <td>{{ $deudor->nombre_distrito }}</td>
                            <td>{{ $deudor->nombres }} {{ $deudor->apellidos }}</td>
                            <td>{{ $deudor->direccion_dni }}</td>
                            <td>{{ $deudor->direccion_actual }}</td>
                            <td>{{ $deudor->dni_ruc }}</td>
                            <td>{{ $deudor->telefono }}</td>
                            <td>{{ $deudor->mercado }}</td>
                            <td>{{ $deudor->actividad }}</td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- <div class="d-flex justify-content-center mt-4">
                {{ $deudores->links('pagination::bootstrap-5') }}
            </div> --}}
        

    </div>
</div>


<div class="modal fade" id="modalEliminarDeudor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Persona</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('agrario.deudor.destroy')}}" method="POST">@csrf
                <div class="modal-body">
                    <input type="text" id="id_deudor" name="id_deudor" hidden>
                    <p>Confirme por favor para poder eliminar</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-danger btn-sm">Sí Eliminar</a>
                </div>

            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="modalNuevoPersona" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Persona</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('agrario.deudor.store')}}" method="POST">@csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="provincia">Provincia</label>
                            <select class="form-control form-control-sm" id="provincia" name="provincia_id" required>
                                <option value="">----Seleccione una Provincia----</option>
                                @foreach ($provincias as $provincia)
                                    <option value="{{$provincia->id}}">{{$provincia->nombre_provincia}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="distrito">Distrito</label>
                            <select class="form-control form-control-sm" id="distrito" name="distritos_id" disabled required>
                                <option value="">Seleccione un distrito</option>
                                <!-- Opciones de distritos -->
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="nombres">Nombres</label>
                            <input type="text" class="form-control form-control-sm" id="nombres" name="nombres" maxlength="250" required>
                        </div>
                        <div class="col-md-4">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" class="form-control form-control-sm" id="apellidos" name="apellidos" maxlength="250" required>
                        </div>
                        <div class="col-md-4">
                            <label for="direccion_dni">Dirección DNI</label>
                            <input type="text" class="form-control form-control-sm" id="direccion_dni" name="direccion_dni" maxlength="250">
                        </div>
                        <div class="col-md-4">
                            <label for="direccion_actual">Dirección Actual</label>
                            <input type="text" class="form-control form-control-sm" id="direccion_actual" name="direccion_actual" maxlength="250">
                        </div>
                        <div class="col-md-4">
                            <label for="dni_ruc">DNI/RUC</label>
                            <input type="text" class="form-control form-control-sm" id="dni_ruc" name="dni_ruc" maxlength="15" required>
                        </div>
                        <div class="col-md-4">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control form-control-sm" id="telefono" name="telefono" maxlength="250">
                        </div>
                        <div class="col-md-4">
                            <label for="mercado">Mercado</label>
                            <input type="text" class="form-control form-control-sm" id="mercado" name="mercado" maxlength="250">
                        </div>
                        <div class="col-md-4">
                            <label for="actividad">Actividad</label>
                            <input type="text" class="form-control form-control-sm" id="actividad" name="actividad" maxlength="250">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-primary btn-sm">Guardar</a>
                </div>

            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarPersona" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Persona</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('agrario.deudor.update')}}" method="POST">@csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" id="id_persona" name="id_persona" readonly hidden>
                            <label for="provincia">Provincia</label>
                            <select class="form-control form-control-sm" id="edit_provincia" name="provincia_id" required>
                                <option value="">----Seleccione una Provincia----</option>
                                @foreach ($provincias as $provincia)
                                    <option value="{{$provincia->id}}">{{$provincia->nombre_provincia}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="distrito">Distrito</label>
                            <select class="form-control form-control-sm" id="edit_distrito" name="distritos_id" required>
                                <option value="">Seleccione un distrito</option>
                                <!-- Opciones de distritos -->
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="nombres">Nombres</label>
                            <input type="text" class="form-control form-control-sm" id="edit_nombres" name="nombres" maxlength="250" required>
                        </div>
                        <div class="col-md-4">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" class="form-control form-control-sm" id="edit_apellidos" name="apellidos" maxlength="250" required>
                        </div>
                        <div class="col-md-4">
                            <label for="direccion_dni">Dirección DNI</label>
                            <input type="text" class="form-control form-control-sm" id="edit_direccion_dni" name="direccion_dni" maxlength="250">
                        </div>
                        <div class="col-md-4">
                            <label for="direccion_actual">Dirección Actual</label>
                            <input type="text" class="form-control form-control-sm" id="edit_direccion_actual" name="direccion_actual" maxlength="250">
                        </div>
                        <div class="col-md-4">
                            <label for="dni_ruc">DNI/RUC</label>
                            <input type="text" class="form-control form-control-sm" id="edit_dni_ruc" name="dni_ruc" maxlength="15" required>
                        </div>
                        <div class="col-md-4">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control form-control-sm" id="edit_telefono" name="telefono" maxlength="250">
                        </div>
                        <div class="col-md-4">
                            <label for="mercado">Mercado</label>
                            <input type="text" class="form-control form-control-sm" id="edit_mercado" name="mercado" maxlength="250">
                        </div>
                        <div class="col-md-4">
                            <label for="actividad">Actividad</label>
                            <input type="text" class="form-control form-control-sm" id="edit_actividad" name="actividad" maxlength="250">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-primary btn-sm">Guardar</a>
                </div>

            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAsignarCredito" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generar Crédito</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formCreditoAgrario" method="POST">@csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nombre_deudor">Deudor</label>
                            <input type="text" class="form-control form-control-sm" id="nombre_deudor" readonly>
                            <input type="text" class="form-control form-control-sm" id="deudor_id" name="deudor_id" readonly hidden>
                        </div>
                        <div class="col-md-3">
                            <label for="tipocredito">Tipo Cŕedito</label>
                            <select class="form-control form-control-sm" id="tipocredito" name="tipocredito" required>
                                <option value="">----Seleccione un tipo Crédito----</option>
                                @foreach ($tipocreditos as $tipocred)
                                    <option value="{{$tipocred->id}}">{{$tipocred->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="nombres">Monto Solicitado</label>
                            <input type="text" class="form-control form-control-sm" id="monto_solicitado" name="monto_solicitado" required>
                        </div>
                        <div class="col-md-3">
                            <label for="apellidos">Monto Aprobado</label>
                            <input type="text" class="form-control form-control-sm" id="monto_aprobado" name="monto_aprobado"  required>
                            <br>
                        </div>

                            <h5>Anulación</h5>
                            <div class="col-md-3">
                                <label for="">Monto Anul.</label>
                                <input type="text" class="form-control form-control-sm" id="anulacion_monto" name="anulacion_monto" value="0" required>
                            </div>
                            <div class="col-md-3">
                                <label for="">N°Resol.</label>
                                <input type="text" class="form-control form-control-sm" id="anulacion_resolucion" name="anulacion_resolucion" value="0" required>
                            </div>
                            <div class="col-md-3">
                                <label for="">Fecha</label>
                                <input type="date" class="form-control form-control-sm" id="anulacion_fecha" name="anulacion_fecha">
                                <br>
                            </div>
                        <h5>Condiciones del Crédito</h5>
                        <div class="col-md-4">
                            <label for="direccion_dni">Tasa Interés%</label>
                            <input type="text" class="form-control form-control-sm" id="tasa_interes" name="tasa_interes" required>
                        </div>
                        <div class="col-md-4">
                            <label for="direccion_actual">Monto Cuota Pagar</label>
                            <input type="text" class="form-control form-control-sm" id="monto_cuota_pagar" name="monto_cuota_pagar" required>
                        </div>
                        <div class="col-md-4">
                            <label for="dni_ruc">Periodo Gracia</label>
                            <div class="input-group">
                                <input type="number" class="form-control form-control-sm" id="periodo_gracia" name="periodo_gracia" value="0" required>
                                <select name="letra_gracia" id="letra_gracia" class="form-control form-control-sm">
                                    <option value="SEMANAS">SEMANAS</option>
                                    <option value="MESES">MESES</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="telefono">Periodo Devolución</label>
                            <div class="input-group">
                                <input type="number" class="form-control form-control-sm" id="periodo_devolucion" name="periodo_devolucion" value="0" maxlength="250">
                                <select name="letra_devolucion" id="letra_devolucion" class="form-control form-control-sm">
                                    <option value="SEMANAS">SEMANAS</option>
                                    <option value="MESES">MESES</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                    <br>

                    <div class="row" style="justify-content: center">
                        <button onclick="btnRegistrarCredito(event)" class="btn btn-light btn-sm" style="width: 20%"><i class="fas fa-plus-circle"></i> Agregar Crédito</button>
                    </div>
                    
                    <br>
                    <div class="table-responsive">
                        <table id="dtCreditosGenerados" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>M.Solic.</th>
                                    <th>M.Aprob.</th>
                                    <th>Mont.Anul</th>
                                    <th>N°Res.Anul.</th>
                                    <th>Fech.Anul.</th>
                                    <th>TasaInt.%</th>
                                    <th>M.CuotaPagar.%</th>
                                    <th>P.Gracia</th>
                                    <th>P.Devol.</th>
                                    <th>Acc.</th>
                                </tr>
                            </thead>
                            <tbody>
    
                            </tbody>
                        </table>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                    {{-- <button type="submit" class="btn btn-primary btn-sm">Guardar</a> --}}
                </div>

            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDesembolsarCredito" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Desembolso Crédito</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formDesembolso" method="POST">@csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" id="agrarios_creditos_id" name="agrarios_creditos_id" readonly hidden>
                            <label for="apellidos">Oficio Remitido</label>
                            <input type="text" class="form-control form-control-sm" id="oficio_remitido" name="oficio_remitido"  required>
                        </div>
                        <div class="col-md-3">
                            <label for="fecha_desembolso">Fecha Desembolso</label>
                            <input type="date" class="form-control form-control-sm" id="fecha_desembolso" name="fecha_desembolso" required>
                        </div>
                        <div class="col-md-3">
                            <label for="fecha_carga">Fecha de Cargaasdasd</label>
                            <input type="date" class="form-control form-control-sm" id="fecha_carga" name="fecha_carga" required>
                        </div>
                        <div class="col-md-3">
                            <label for="fecha_pago">Fecha de Pago</label>
                            <input type="date" class="form-control form-control-sm" id="fecha_pago" name="fecha_pago" required>
                        </div>
                        <div class="col-md-3">
                            <label for="monto_revertido">Monto Revertido</label>
                            <input type="text" class="form-control form-control-sm" id="monto_revertido" name="monto_revertido" required>
                        </div>
                        <div class="col-md-3">
                            <label for="monto_desembolsado">M.Desembolsado </label>
                            <input type="text" class="form-control form-control-sm" id="monto_desembolsado" name="monto_desembolsado" required>
                        </div>
                        
                    </div>
                    <br>

                    <div class="row" style="justify-content: center">
                        <button onclick="btnRegistrarDesembolso(event)" class="btn btn-light btn-sm" style="width: 20%"><i class="fas fa-plus-circle"></i> Registrar Desembolso</button>
                    </div>
                    
                    <br>
                    <div class="table-responsive">
                        <table id="dtDesembolso" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>N°Oficio</th>
                                    <th>Fecha Desem.</th>
                                    <th>Monto Desem.</th>
                                    <th>F.Carga</th>
                                    <th>F.Pago</th>
                                    <th>Monto Revertido</th>
                                    <th>Monto Anul.</th>
                                    <th>F.Anul</th>
                                    <th>Archivo</th>
                                    <th>Accicones</th>
                                </tr>
                            </thead>
                            <tbody>
    
                            </tbody>
                        </table>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                    {{-- <button type="submit" class="btn btn-primary btn-sm">Guardar</a> --}}
                </div>

            </form>
        </div>
    </div>
</div>

@include('messages.confirmacion_eliminar_asin')

@endsection
@section('js')
    <script>
        function eliminarDeudor(id) { 
            $("#id_deudor").val(id);
            $("#modalEliminarDeudor").modal('show');
        }
    </script>


<script src="../../../assets/js/plugins/jquery.dataTables.min.js"></script>
<script src="../../../assets/js/plugins/dataTables.bootstrap4.min.js"></script>
<script>

    function btnRegistrarDesembolso(e) {
        let ds=$("#formDesembolso").serialize();
        e.preventDefault();
        const form = $('#formDesembolso')[0];
        
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        

        $.ajax({
            type: "POST",
            url: "/agrario/desembolso/store",
            data: ds,
            dataType: "json",
            success: function (response) {
                console.log(response.message);
            }
        });

        $("#modalDesembolsarCredito").modal("show");

    }

    function btnDesembolsarCredito(button,id) {
        // var fila = $(button).closest("tr");
        // var nombre_completo = fila.find('td:eq(4)').text();
        $("#agrarios_creditos_id").val(id);
        $("#modalDesembolsarCredito").modal("show");
    }

    function modalConfirmarEliminar(id) {
        $("#id_registro_eliminar").val(id);
        $("#modalConfirmarEliminar").modal("show");
    }

    function btnEliminarCredito() {
        id=$("#id_registro_eliminar").val();
        $.ajax({
            type: "GET",
            url: "/agrario/credito/destroy/"+id,
            dataType: "json",
            success: function (response) {
                $("#modalConfirmarEliminar").modal("hide");
                obtenerDatosCreditos($("#deudor_id").val())
                alert(response.message)
                
            }
        });
    }

    function btnRegistrarCredito(e) {
        e.preventDefault()
        const form = $('#formCreditoAgrario')[0];
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        ds = $("#formCreditoAgrario").serialize()
        $.ajax({
            type: "POST",
            url: "/agrario/credito/store",
            data: ds,
            dataType: "json",
            success: function (response) {                
                obtenerDatosCreditos($("#deudor_id").val())
                alert(response.message)
                limpiarFormCreditos()
            }
        });
    }

    function btnNuevoPersona() {
        $("#modalNuevoPersona").modal("show");
    }
    function btnEditarPersona(id) {
        $("#modalEditarPersona").modal("show");
        $("#id_persona").val(id);
        obtenerDatosPersona(id);
    }

    function btnAsignarCredito(button,id) {
        $("#deudor_id").val(id)
        var fila = $(button).closest("tr");
        var nombre_completo = fila.find('td:eq(4)').text();
        $("#nombre_deudor").val(nombre_completo)

        obtenerDatosCreditos(id);
        $("#modalAsignarCredito").modal("show");

    }

    function obtenerDatosCreditos(id_deudor) {
        $.ajax({
            type: "GET",
            url: "/agrario/credito/show/"+id_deudor,
            dataType: "json",
            success: function (response) {
                $("#dtCreditosGenerados tbody").html("");
                response.forEach(element => {
                    $("#dtCreditosGenerados tbody").append("<tr>"+
                        "<td>"+ element.id  +"</td>"+
                        "<td>"+ element.monto_solicitado  +"</td>"+
                        "<td>"+ element.monto_aprobado  +"</td>"+
                        "<td>"+ element.anulacion_monto  +"</td>"+
                        "<td>"+ element.anulacion_resolucion  +"</td>"+
                        "<td>"+ element.anulacion_fecha  +"</td>"+
                        "<td>"+ element.tasa_interes  +"</td>"+
                        "<td>"+ element.monto_cuota_pagar  +"</td>"+
                        "<td>"+ element.periodo_gracia+" "+ element.letra_gracia +"</td>"+
                        "<td>"+ element.periodo_devolucion + " "+element.letra_devolucion +"</td>"+
                        "<td>"+
                            "<a onclick='modalConfirmarEliminar("+ element.id +")' class='btn btn-light btn-sm' data-bs-toggle='tooltip' title='eliminar crédito'><i class='fas fa-trash'></i></a>"+
                            "<a onclick='btnDesembolsarCredito(this,"+element.id+")' class='btn btn-light btn-sm' data-bs-toggle='tooltip' title='desembolsar crédito'><i class='fas fa-hand-holding-usd'></i></a>"+
                        "</td>"+
                    +"<tr>")
                });
            }
        });
    }

    function obtenerDatosPersona(id) {
        $.ajax({
            type: "GET",
            url: "/agrario/deudor/edit/"+id,
            dataType: "json",
            success: function (response) {
                $("#edit_provincia").val(response.data.provincia_id).change();
                setTimeout(function() {
                    $("#edit_distrito").val(response.data.distrito_id).change();
                }, 1000); // 1000 milisegundos = 1 segundo
                $("#edit_nombres").val(response.data.nombres);
                $("#edit_apellidos").val(response.data.apellidos);
                $("#edit_direccion_dni").val(response.data.direccion_dni);
                $("#edit_direccion_actual").val(response.data.direccion_actual);
                $("#edit_dni_ruc").val(response.data.dni_ruc);
                $("#edit_telefono").val(response.data.telefono);
                $("#edit_mercado").val(response.data.mercado);
                $("#edit_actividad").val(response.data.actividad);

            }
        });
    }

    $(document).ready(function() {
        $('#deudoresTable').DataTable({
            columnDefs: [
                { width: '200px', targets: 1 }
            ],
            fixedColumns: true
        });
    });

    $("#provincia").change(function (e) { 
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: "/distritos",
            dataType: "json",
            success: function (response) {
                var select = $('#distrito');
                var id_provincia = $("#provincia").val();
                select.empty(); // Vaciar el select antes de llenarlo
                select.append('<option value="">-- Seleccione ---</option>'); // Añadir una opción por defecto
                response.data.forEach(element => {
                    if (id_provincia==element.id_provincias) {
                        select.append('<option value="' + element.id + '">' + element.nombre_distrito + '</option>');
                    }
                });
                select.removeAttr('disabled'); // Habilitar el select después de llenarlo
            }
        });
    });

    $("#edit_provincia").change(function (e) { 
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: "/distritos",
            dataType: "json",
            success: function (response) {
                var select = $('#edit_distrito');
                var id_provincia = $("#edit_provincia").val();
                select.empty(); // Vaciar el select antes de llenarlo
                select.append('<option value="">-- Seleccione ---</option>'); // Añadir una opción por defecto
                response.data.forEach(element => {
                    if (id_provincia==element.id_provincias) {
                        select.append('<option value="' + element.id + '">' + element.nombre_distrito + '</option>');
                    }
                });
                select.removeAttr('disabled'); // Habilitar el select después de llenarlo
            }
        });
    });


    function limpiarFormCreditos() {
        $("#tipocredito").val("").change();
        $("#monto_solicitado").val("0");
        $("#monto_aprobado").val("0");
        $("#anulacion_monto").val("0");
        $("#anulacion_resolucion").val("0");
        // $("#anulacion_fecha").val("");
        $("#tasa_interes").val("0");
        $("#monto_cuota_pagar").val("0");
        $("#periodo_gracia").val("0");
        $("#periodo_devolucion").val("0");
        

    }
</script>
@endsection