@extends('bases.base')


@section('content')
    <div class="card">
        <div class="card-body">
            @if(session()->has('mensaje'))
                <div class="col-sm-4">
                    <div class="alert border-0 border-start border-5 border-success alert-dismissible fade show py-2">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-success"><i class='bx bxs-check-circle'></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-success">Mensaje</h6>
                                <div>{{Session::get('mensaje')}}</div>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if ($datos_constancias==null)
                <div class="col-sm-4">
                    <div class="alert border-0 border-start border-5 border-success alert-dismissible fade show py-2">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-success"><i class='bx bxs-check-circle'></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-success">Mensaje</h6>
                                <div>Para emitir una constancia debe registrar los datos de la carta.. <a href="/datos/constancias/index">Ir a registrar datos</a></div>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-4">
                    <button class="btn btn-primary btn-sm" onclick="btnModalBuscarExpediente()"><i class="fas fa-search"></i> Buscar Expediente</button>
                    <hr>

                </div>
                    <div class="row" id="divDatosExpedientes" hidden>
                        <h5>Datos del Expediente <i class="fas fa-file-invoice"></i></h5>
                        <form action="{{route('store.constancias')}}" method="POST">@csrf
                            <input type="text" id="id_expediente" name="id_expediente" hidden readonly>
                       

                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <br>
                                    <table  class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>N° Expediente</th>
                                                <th>Monto</th>
                                                <th>Concepto</th>
                                                <th>Fecha</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong><p id="numero_expediente"></p></strong></td>
                                                <td><strong><p id="monto"></p></strong></td>
                                                <td><strong><p id="concepto"></p></strong></td>
                                                <td><strong><p id="fecha"></p></strong></td>
                                                <td><strong><p id="estado"></p></strong></td>
                                                <td><button class="btn btn-light btn-sm" onclick="btnGenerarConstancia()">Generar Constancia</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5>Lista de Constancias Generadas</h5>
            <div class="col-md-12">
                <div class="table-responsive">
                    <br>
                    <table id="tablaConstanciasEmitidas" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Accion</th>
                                <th>DNI/RUC</th>
                                <th>N° Carta</th>
                                <th>N° Expediente</th>
                                <th>Monto</th>
                                <th>Concepto</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($constancias_emitidos as $ce)
                                <tr>
                                    <td>{{$ce->id}}</td>
                                    <td><a href="{{route('imprimir.constancias',$ce->id)}}" class="btn btn-light btn-sm"><i class="fas fa-print"></i></a></td>
                                    <td>{{$ce->dni}}/{{$ce->ruc}}</td>
                                    <td>{{$ce->numero_carta}}</td>
                                    <td>{{$ce->numero_expediente}}</td>
                                    <td>{{$ce->monto}}</td>
                                    <td>{{$ce->concepto}}</td>
                                    <td>{{$ce->fecha}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            
        </div>
    </div>



    <div class="modal fade" id="modalBuscarExpediente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Búsqueda Expediente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Ingrese un DNI/RUC</label>
                            <div class="input-group">
                                <input type="text" id="doc" class="form-control form-control-sm">
                                <button class="btn btn-primary btn-sm" onclick="btnBuscarExpediente()">Buscar</button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <br>
                        <table id="dtExpedientes" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Agregar</th>
                                    <th>Nro_Expediente</th>
                                    <th>Monto</th>
                                    <th>Concepto</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
           
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')

<script>
    function btnModalBuscarExpediente() {
        $("#modalBuscarExpediente").modal('show');
    }

    function btnBuscarExpediente() {
        var doc = $("#doc").val()
        $.ajax({
            type: "GET",
            url: "/expedientes/buscar/doc/"+doc,
            dataType: "json",
            success: function (response) {
                $("#dtExpedientes tbody").html("");
                var btnagregar=""
                if (response.data) {
                    response.data.forEach(element => {
                        if (element.estado==1) {
                            estado = 'PAGADO'
                            btnagregar='<a class="btn btn-light btn-sm btnAgregarExpediente"><i class="fas fa-plus"></i></a>' 
                        }else if(element.estado==0){
                            estado = 'PENDIENTE'
                        }else if(element.estado==null){
                            estado = 'SIN CRONOGRAMA'
                        }
    
                        $("#dtExpedientes tbody").append('<tr>'+
                                '<td>'+ element.id +'</td>'+
                                '<td>'+ btnagregar +'</td>'+
                                '<td>'+ element.numero_expediente +'</td>'+
                                '<td>'+ element.monto +'</td>'+
                                '<td>'+ element.concepto +'</td>'+
                                '<td>'+ element.fecha +'</td>'+
                                '<td>'+ estado +'</td>'+
                            '</tr>')
                    });
                }else{
                    alert("No se encontró datos");
                }
            }
        });
    }

    function btnGenerarConstancia() {
        ds=$("#formConstancia").serialize();
        $.ajax({
            type: "POST",
            url: "/constancias/store",
            data: ds,
            dataType: "json",
            success: function (response) {
                console.log(response)
            }
        });
    }
</script>
<script>
    $(document).on("click",".btnAgregarExpediente",function (e) {
        fila = $(this).closest("tr");
        $("#id_expediente").val((fila).find('td:eq(0)').text());
        $("#numero_expediente").text((fila).find('td:eq(2)').text());
        $("#monto").text((fila).find('td:eq(3)').text());
        $("#concepto").text((fila).find('td:eq(4)').text());
        $("#fecha").text((fila).find('td:eq(5)').text());
        $("#estado").text((fila).find('td:eq(6)').text());
        
        $("#divDatosExpedientes").prop('hidden',false);
        $("#modalBuscarExpediente").modal('hide');
    })

    
</script>
<script src="../../../assets/js/plugins/jquery.dataTables.min.js"></script>
<script src="../../../assets/js/plugins/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tablaConstanciasEmitidas').DataTable({
            columnDefs: [
                { width: '200px', targets: 1 }
            ],
            fixedColumns: true
        });
    });
</script>
@endsection