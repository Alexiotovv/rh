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

        <h5>Lista de egresos</h5>
        <a class="btn btn-primary btn-sm" id="btnNuevo" >Nuevo</a>
        <div class="table-responsive">
            <br>
            <table id="dtegresos" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Acción</th>
                        <th>Nombre de Egreso</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($egresos as $i)
                        <tr>
                            <td>{{$i->id}}</td>
                            <td>
                                <a class="btn btn-light btn-sm btnEditarEgreso"> <i class="fas fa-edit"></i> </a>
                                <a class="btn btn-light btn-sm btnEliminarEgreso"> <i class="fas fa-trash-alt"></i> </a>
                            </td>
                            <td>{{$i->nombre}}</td>
                            
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarEgreso" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Egreso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('update.egresos')}}" method="POST">@csrf
                <div class="modal-body">
                    <input type="text" name="idegreso" id="idegreso" hidden>
                    <label for="direccion">Egreso</label>
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

<div class="modal fade" id="modalNuevoEgreso" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Egreso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('store.egresos')}}" method="POST">@csrf
                <div class="modal-body">
                    <label for="direccion">Nuevo Egreso</label>
                    <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" maxlength="250" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                    <button type="submit" onclick="guardarEgreso()" class="btn btn-primary btn-sm">Guardar</button>
                </div>

            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="modalEliminarEgreso" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Egreso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('destroy.egresos')}}" method="POST">@csrf
                <div class="modal-body">
                    <label for="egreso">Confirma para eliminar </label>
                    <input type="text" name="idegreso_eliminar" id="idegreso_eliminar" hidden>
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
        $(document).on("click",".btnEditarEgreso",function () { 
            fila = $(this).closest("tr");
            let id = (fila).find('td:eq(0)').text();
            let egreso = (fila).find('td:eq(2)').text();
            $("#idegreso").val(id);
            $("#nombre").val(egreso);
            $("#modalEditarEgreso").modal('show');
        })
        
        $("#btnNuevo").on("click",function () { 
            $("#modalNuevoEgreso").modal('show');
        })

        $(document).on("click",".btnEliminarEgreso",function (e) { 
            fila = $(this).closest("tr");
            let id = (fila).find('td:eq(0)').text();
            $("#idegreso_eliminar").val(id);
            $("#modalEliminarEgreso").modal('show');
        })

        
    </script>
    
@endsection