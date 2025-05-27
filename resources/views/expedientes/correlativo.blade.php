<div class="modal fade" id="modalCorrelativo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Correlativo de Expediente </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formCorrelativo" action="" method="POST">@csrf
                <div class="modal-body">
                    <p>Formulario de Correlativo</p>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">N° Exp.</label>
                            <input type="number" class="form-control form-control-sm" id="numero_expediente" name="numero_expediente" >
                        </div>
                        <div class="col-md-4">
                            <label for="">Año Exp.</label>
                            <input type="text" class="form-control form-control-sm" id="ano_expediente" name="ano_expediente" >
                        </div>
                        <div class="col-md-4">
                            <label for="">Descripción Exp.</label>
                            <input type="text" class="form-control form-control-sm" id="desc_expediente" name="desc_expediente" >
                        </div>
                    </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                    <button type="button" class="btn btn-primary btn-sm" id="btnGuardarCorrelativo">Guardar</a>
                </div>
            </form>
        </div>
    </div>
</div>