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


        {{-- <div class="col-sm-12" style="text-align: -webkit-right">
            
        </div> --}}
        <br>

        <h5>Lista de condicion_laborals</h5>
        <a class="btn btn-primary btn-sm" id="btnNuevo" >Nuevo</a>
        <div class="table-responsive">
            <br>
            <table id="dtcondicion_laborals" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Acción</th>
                        <th>Nombre de Condicion Laboral</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($condicion_laborals as $i)
                        <tr>
                            <td>{{$i->id}}</td>
                            <td>
                                <a class="btn btn-light btn-sm btnEditarCondicionLaboral"> <i class="fas fa-edit"></i> </a>
                                <a class="btn btn-light btn-sm btnEliminarCondicionLaboral"> <i class="fas fa-trash-alt"></i> </a>
                            </td>
                            <td>{{$i->nombre}}</td>
                            
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarCondicionLaboral" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Condicion Laboral</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('update.condicion_laborals')}}" method="POST">@csrf
                <div class="modal-body">
                    <input type="text" name="idcondicion_laborals" id="idcondicion_laborals" hidden>
                    <label for="condicion_laborals">Condicion Laboral</label>
                    <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" maxlength="250" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                </div>

            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNuevoCondicionLaboral" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Condicion Laboral</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('store.condicion_laborals')}}" method="POST">@csrf
                <div class="modal-body">
                    <label for="direccion">Nuevo Condicion Laboral</label>
                    <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" maxlength="250" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                    <button type="submit" onclick="guardarCondicionLaboral()" class="btn btn-primary btn-sm">Guardar</button>
                </div>

            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="modalEliminarCondicionLaboral" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Condicion Laboral</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('destroy.condicion_laborals')}}" method="POST">@csrf
                <div class="modal-body">
                    <label for="condicion_laboral">Confirma para eliminar </label>
                    <input type="text" name="idcondicion_laborals_eliminar" id="idcondicion_laborals_eliminar" hidden>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-danger btn-sm">Sí, eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $(document).on("click",".btnEditarCondicionLaboral",function () { 
            fila = $(this).closest("tr");
            let id = (fila).find('td:eq(0)').text();
            let condicion_laborals = (fila).find('td:eq(2)').text();
            $("#idcondicion_laborals").val(id);
            $("#nombre").val(condicion_laborals);
            $("#modalEditarCondicionLaboral").modal('show');
        })
        
        $("#btnNuevo").on("click",function () { 
            $("#modalNuevoCondicionLaboral").modal('show');
        })

        $(document).on("click",".btnEliminarCondicionLaboral",function (e) { 
            fila = $(this).closest("tr");
            let id = (fila).find('td:eq(0)').text();
            $("#idcondicion_laborals_eliminar").val(id);
            $("#modalEliminarCondicionLaboral").modal('show');
        })

        
    </script>
    
@endsection