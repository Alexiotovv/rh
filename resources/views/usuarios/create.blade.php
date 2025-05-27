@extends('bases.base')
@section('content')

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


<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <h5>Crear Usuario</h5>
                <form action="{{route('register')}}" method="POST">@csrf
                    <label for="">Nombre</label>
                    <input type="text" class="form-control" name="name">
                    <label for="">Correo</label>
                    <input type="email" class="form-control" name="email">
                    <label for="">Rol</label>
                    <select name="role" id="" class="form-select">
                        <option value="0">Admin</option>
                        <option value="1">Asistente</option>
                        <option value="2">Visor</option>
                    </select>
                    <label for="">Contraseña</label>
                    <input type="password" name="password"  placeholder="******" class="form-control" autocomplete="new-password">
                    <br>
                    <button class="btn btn-primary bt-sm">Guardar</button>
                </form>
              

            </div>
        </div>
    </div>
</div>

@endsection

