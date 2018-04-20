<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Confirmar</h4>
            </div>
            <div class="modal-body">
                <h3 class="text-center">¿Esta seguro que desea eliminar el {{ $name }}?</h3>
            </div>
            <div class="modal-footer">
                <a href="#" id="deleteButton" class="btn btn-primary primary">Aceptar</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#deleteButton').click(function(){
        $('#form-delete').submit();
    });
</script>