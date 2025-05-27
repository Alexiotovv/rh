@extends('bases.base')
@section('css')
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

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
            
            <button class="btn btn-primary btn-sm" onclick="btnNuevoDatos()">Nuevo</button>
            <button class="btn btn-info btn-sm" onclick="btnNumeroCorrelativo()">Numero Correlativo</button>
            <div class="table-responsive">
                <br>
                <table id="example" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Acciones</th>
                            <th>Descripción Correlativo</th>
                            <th>Archivo Encabezado</th>
                            <th>Archivo Firma</th>
                            <th>Estado</th>
                            <th>Contenido</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($constanciasdatos as $dc)
                            <tr>
                                <td>{{$dc->id}}</td>
                                <td><a href="{{route('datos.constancias.edit',$dc->id)}}" class="btn btn-light btn-sm"><i class="fas fa-pen"></i></a></td>
                                <td>{{$dc->descripcion_correlativo}}</td>
                                <td>
                                    <a target="_blank" href="{{asset('storage/encabezados/'.$dc->archivo_encabezado)}}">{{$dc->archivo_encabezado}}</a>
                                    <br>
                                    <img src="{{asset('storage/encabezados/'.$dc->archivo_encabezado)}}" height="80px" alt="">
                                </td>
                                <td>
                                    <a target="_blank" href="{{asset('storage/firmas/'.$dc->archivo_firma)}}">{{$dc->archivo_firma}}</a>
                                    <br>
                                    <img src="{{asset('storage/firmas/'.$dc->archivo_firma)}}" height="80px" alt="">
                                </td>
                                <td>
                                    @if ($dc->estado)
                                        <p style="color: green">Activo</p>
                                    @else
                                        <p style="color: red">Inactivo</p>
                                    @endif
                                    
                                </td>
                                <td>{!!$dc->contenido!!}</td>
                            </tr>
                        @endforeach
                       
                        
                    </tbody>
                </table>
            </div>


            
        </div>
    </div>



    <div class="modal fade" id="modalNuevoDatos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo Datos de Constancias</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('datos.constancias.store')}}" method="POST" enctype="multipart/form-data">@csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="contenido">Contenido</label>
                                <textarea name="contenido" id="contenido" cols="30" rows="10" class="form-control form-control-sm" required>-</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="descripcion_correlativo">Descripcion Correlativo</label>
                                <input type="text" name="descripcion_correlativo" id="descripcion_correlativo" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-6">
                                <label for="archivo_encabezado">Archivo Encabezado</label>
                                <input type="file" name="archivo_encabezado" id="archivo_encabezado" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-6">
                                <label for="archivo_firma">Archivo Firma</label>
                                <input type="file" name="archivo_firma" id="archivo_firma" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-6">
                                <label for="estado">Estado</label>
                                <select name="estado" id="estado" class="form-select form-select-sm">
                                    <option value="1" selected>Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                            
                        </div>
            
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                        <button type="submit" class="btn btn-danger btn-sm">Guardar</a>
                    </div>
    
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalNumeroCorrelativo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo Correlativo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formNumeroCorrelativo" action="{{route('correlativo.update')}}" method="POST">@csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="contenido">Número Actual</label>
                                <input type="number" name="numero" id="numero" class="form-control form-control-sm" value="{{$numerocorrelativo}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                        <button type="submit" class="btn btn-danger btn-sm">Guardar</a>
                    </div>
    
                </form>
            </div>
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
    

    <script>
        function btnNuevoDatos(){
            $("#modalNuevoDatos").modal('show');
        }
        function btnNumeroCorrelativo(){
            $("#modalNumeroCorrelativo").modal('show');
        }
    </script>
    <script src="../../../assets/js/plugins/jquery.dataTables.min.js"></script>
    <script src="../../../assets/js/plugins/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                columnDefs: [
                    { width: '200px', targets: 1 }
                ],
                fixedColumns: true
            });
        });
    </script>

@endsection