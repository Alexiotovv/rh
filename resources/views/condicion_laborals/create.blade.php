<div class="modal fade" id="modalNuevoCondicionLaboral" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Condicion Laboral</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form  method="POST">@csrf
                <div class="modal-body">
                    <label for="direccion">Nuevo Condicion Laboral</label>
                    <input type="text" class="form-control form-control-sm" id="nueva_condicion" name="nueva_condicion" maxlength="250" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                    <button type="button" onclick="guardarCondicionLaboral()" class="btn btn-primary btn-sm">Guardar</button>
                </div>

            </form>
        </div>
    </div>
</div>