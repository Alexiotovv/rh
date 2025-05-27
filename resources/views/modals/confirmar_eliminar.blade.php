

<div class="modal fade modalEliminar" id="modalEliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirma por favor para Eliminar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <h5>Aceptar para Eliminar...</h5>
                <input type="text" id="nombre_modelo" hidden>
                <input type="text" id="id_registro_eliminar" hidden readonly>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn-sm" onclick="btnSiEliminar()">Aceptar, Eliminar</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
            </div>
            
        </div>
    </div>
</div>