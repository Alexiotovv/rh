@extends('bases.base')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{route('datos.constancias.update')}}" method="POST" enctype="multipart/form-data">@csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" name="id_datos_constancias" id="id_datos_constancias" value="{{$constanciasdatos->id}}" readonly hidden>
                        <label for="contenido">Contenido</label>
                        <textarea name="contenido" id="contenido" cols="30" rows="10" class="form-control form-control-sm" required>{!! $constanciasdatos->contenido!!}</textarea>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="descripcion_correlativo">Descripcion Correlativo</label>
                        <input type="text" value="{{$constanciasdatos->descripcion_correlativo}}" name="descripcion_correlativo" id="descripcion_correlativo" class="form-control form-control-sm" required>
                        
                    </div>
                    <div class="col-md-6">
                        <label for="descripcion_correlativo">Archivo Encabezado</label>
                        <input type="file"  name="archivo_encabezado" id="archivo_encabezado" class="form-control form-control-sm">
                        <strong><p>{{$constanciasdatos->archivo_encabezado}}</p></strong>
                    </div>
                    <div class="col-md-6">
                        <label for="descripcion_correlativo">Archivo Firma</label>
                        <input type="file" name="archivo_firma" id="archivo_firma" class="form-control form-control-sm">
                        <strong><p>{{$constanciasdatos->archivo_firma}}</p></strong>
                    </div>
                    <div class="col-md-6">
                        <label for="descripcion_correlativo">Estado</label>
                        <select name="estado" id="estado" class="form-select form-select-sm" required>
                            @if ($constanciasdatos->estado)
                                <option value="1" selected>Activo</option>
                                <option value="0">Inactivo</option>
                            @else
                                <option value="1">Activo</option>
                                <option value="0" selected>Inactivo</option>
                            @endif
                        </select>
                    
                        <br>
                    </div>
                    
                </div>
        
            </div>
            
                
                <button type="submit" class="btn btn-danger btn-sm">Guardar</a>
            
        
        </form>
    </div>
</div>


@endsection

@section('js')
    <script src="https://cdn.tiny.cloud/1/w88fr3il2xena9o1qe4ar5zy9krw3lljsfce03c2t0i3vtb8/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    {{-- <script src="../../../tinymce/tinymce.min.js"></script> --}}
    <script type="text/javascript">
    tinymce.init({
    selector: '#contenido',
    plugins: 'ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    language:'es',
    mergetags_list: [
        { value: 'First.Name', title: 'First Name' },
        { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant"))
    });
    </script>

@endsection