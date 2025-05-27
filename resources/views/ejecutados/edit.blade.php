@extends('bases.base')
@section('content')
<div class="card">
    <div class="card-body">

        <form class="p-4" action="{{route('update.ejecutado')}}" method="POST">@csrf
            <h5>Editar Trabajador</h5>
            <input type="text" name="id_deudor" value="{{$deudores->id_deudor}}" hidden>
            <div class="row">
                <div class="col-md-4">
                    <label for="tipoPersonas" class="form-label">Tipo de persona</label>
                    <select id="tipopersona" name="tipopersona" class="form-select form-select-sm" required>
                        
                        @foreach ($tipopersonas as $tp)
                            @if ($tp->id==$deudores->id_tipopersonas)
                                <option value="{{$tp->id}}" selected>{{$tp->nombre}}</option>
                            @else
                                <option value="{{$tp->id}}">{{$tp->nombre}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="provincia" class="form-label">Provincia</label>
                    <select id="provincia" name="provincia" class="form-select form-select-sm" required>
                        @foreach ($provincias as $p)
                            @if ($p->id==$deudores->id_provincia)
                                <option value="{{$p->id}}" selected>{{$p->nombre_provincia}}</option>
                            @else
                                <option value="{{$p->id}}">{{$p->nombre_provincia}}</option>
                            @endif

                        @endforeach
                        
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="distrito" class="form-label">Distrito</label>
                    <select id="distrito" name="distrito" class="form-select form-select-sm" required>
                        @foreach ($distritos as $d)
                            @if ($d->id_provincias==$deudores->id_provincia)
                                @if ($d->id==$deudores->id_distrito)
                                    <option value="{{$d->id}}" selected>{{$d->nombre_distrito}}</option>
                                @else
                                    <option value="{{$d->id}}" >{{$d->nombre_distrito}}</option>
                                @endif
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label for="dni" class="form-label">N° DNI</label>
                    <div class="input-group">
                        <input id="dni" type="number" name="dni" placeholder="Ejemplo:73011422" class="form-control form-control-sm" value="{{$deudores->dni}}">
                        <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Buscar</button>

                    </div>
                </div>
                
                
                
                <div class="col-md-3" id="classruc" hidden>
                    <label for="ruc" class="form-label">RUC</label>
                    <input id="ruc" type="text" name="ruc" placeholder="Ejemplo: 20425619893" class="form-control form-control-sm" value="{{$deudores->ruc}}">
                </div>
                <div class="col-md-3" id="classrazon" hidden>
                    <label for="ruc" class="form-label">Razón Social</label>
                    <input id="razon" type="text" name="razon" placeholder="Ejemplo: Inversiones Miriam" class="form-control form-control-sm" value="{{$deudores->razon}}">
                </div>
                <div class="col-md-3" id="classdni_rep" hidden>
                    <label for="dni_rep" class="form-label">Dni Representante</label>
                    <input id="dni_rep" type="text" name="dni_rep" placeholder="Ejemplo: 45556569" class="form-control form-control-sm" value="{{$deudores->dni_rep}}">
                </div>
                <div class="col-md-4" id="classnombre_rep" hidden>
                    <label for="nombre_rep" class="form-label">Nombre Representante</label>
                    <input id="nombre_rep" type="text" name="nombre_rep" placeholder="Ejemplo: 20425619893" class="form-control form-control-sm" value="{{$deudores->nombre_rep}}">
                </div>
                <div class="col-md-4" id="classapellidos_rep" hidden>
                    <label for="ruapellidos_repc" class="form-label">Apellidos Representante</label>
                    <input id="apellidos_rep" type="text" name="apellidos_rep" placeholder="Ejemplo: Inversiones Miriam" class="form-control form-control-sm" value="{{$deudores->apellidos_rep}}">
                </div>


                <div class="col-md-4" id="classnombre">
                    <label for="nombre" class="form-label">Nombres</label>
                    <input id="nombre" type="text" name="nombre" placeholder="Ejemplo: Nicolás Arjen" class="form-control form-control-sm"  value="{{$deudores->nombre}}">
                </div>
                <div class="col-md-4" id="classapellidos">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <input id="apellidos" type="text" name="apellidos" placeholder="Ejemplo: Martinez Montoya" class="form-control form-control-sm" value="{{$deudores->apellidos}}">
                </div>
            
                <div class="col-md-4">
                    <label for="domicilio" class="form-label">Domicilio</label>
                    <input id="domicilio" type="text" name="domicilio" placeholder="Ejemplo: Calle los Girasoles Mz. C Lte. 29" class="form-control form-control-sm" required value="{{$deudores->domicilio}}">
                </div>

                <div class="col-md-3 mb-3" id="classcondicion_laboral">
                    <label for="condicion_laboral" class="form-label">Condición Laboral</label>
                    <select id="condicion_laboral" name="condicion_laboral" class="form-select form-select-sm" required>
                        <option value="">--Seleccione--</option>
                        @foreach ($condicion_laboral as $cl)
                            @if ($cl->id==$deudores->condicion_laboral_id)
                                <option value="{{$cl->id}}" selected>{{$cl->nombre}}</option>
                            @else
                                <option value="{{$cl->id}}" >{{$cl->nombre}}</option>
                            @endif
                        @endforeach


                    </select>
                </div>

                <div class="col-md-3 mb-3" id="classcargo">
                    <label for="cargo" class="form-label">Cargo</label>
                    <input id="cargo" type="text" name="cargo" placeholder="Enfermero, Ingeniero, etc" class="form-control form-control-sm" value="{{$deudores->cargo}}" required >
                </div>


            </div>
            <br>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center">
                    Actualizado
                </button>
            </div>
        </form>
    </div>
</div>

    
@endsection

@section('js')
<script>
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
</script>

<script>
    $("#tipopersona").change(function (e) { 
       mostrar_inputs();
    });
</script>

<script>
    $(document).ready(function() {
        mostrar_inputs();
    });
</script>

<script>
    function mostrar_inputs(){
        var selectedValue = $("#tipopersona").val();
       if (selectedValue=="2") {
           $('#classruc').removeAttr('hidden');
           $('#classrazon').removeAttr('hidden');
           $('#classdni_rep').removeAttr('hidden');
           $('#classnombre_rep').removeAttr('hidden');
           $('#classapellidos_rep').removeAttr('hidden');

           $('#classdni').attr('hidden',true);
           $('#classnombre').attr('hidden',true);
           $('#classapellidos').attr('hidden',true);

       }else{
           $('#classruc').attr('hidden', true);
           $('#classrazon').attr('hidden', true);
           $('#classdni_rep').attr('hidden', true);
           $('#classnombre_rep').attr('hidden', true);
           $('#classapellidos_rep').attr('hidden', true);
           
           $('#classdni').removeAttr('hidden');
           $('#classnombre').removeAttr('hidden');
           $('#classapellidos').removeAttr('hidden');           
       }
    }
</script>
@endsection