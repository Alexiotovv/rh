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

        <h5>Lista de Oficinas</h5>
        <a class="btn btn-primary btn-sm" id="btnNuevo" >Nuevo</a>
        <div class="table-responsive">
            <br>
            <table id="dtOficinas" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Acción</th>
                        <th>Nombre de Oficina</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($oficinas as $o)
                        <tr>
                            <td>{{$o->id}}</td>
                            <td>
                                <a class="btn btn-light btn-sm btnEditarOficina"> <i class="fas fa-edit"></i> </a>
                                <a class="btn btn-light btn-sm btnEliminarOficina"> <i class="fas fa-trash-alt"></i> </a>
                            </td>
                            <td>{{$o->nombre}}</td>
                            
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarOficina" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Oficina</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('update.oficinas')}}" method="POST">@csrf
                <div class="modal-body">
                    <input type="text" name="idoficina" id="idoficina" hidden>
                    <label for="direccion">Oficina(Dirección)</label>
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

<div class="modal fade" id="modalNuevaOficina" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nueva Oficina</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('store.oficinas')}}" method="POST">@csrf
                <div class="modal-body">
                    <label for="direccion">Nueva Oficina(Dirección)</label>
                    <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" maxlength="250" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                    <button type="submit" onclick="guardarOficina()" class="btn btn-primary btn-sm">Guardar</button>
                </div>

            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="modalEliminarOficina" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Oficina</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('destroy.oficinas')}}" method="POST">@csrf
                <div class="modal-body">
                    <label for="oficina">Confirma para eliminar </label>
                    <input type="text" name="idoficina_eliminar" id="idoficina_eliminar" hidden>
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
        $(document).on("click",".btnEditarOficina",function () { 
            fila = $(this).closest("tr");
            let id = (fila).find('td:eq(0)').text();
            let oficina = (fila).find('td:eq(2)').text();
            $("#idoficina").val(id);
            $("#nombre").val(oficina);
            $("#modalEditarOficina").modal('show');
        })
        
        $("#btnNuevo").on("click",function () { 
            $("#modalNuevaOficina").modal('show');
        })

        $(document).on("click",".btnEliminarOficina",function (e) { 
            fila = $(this).closest("tr");
            let id = (fila).find('td:eq(0)').text();
            $("#idoficina_eliminar").val(id);
            $("#modalEliminarOficina").modal('show');
        })

        
    </script>
    
@endsection