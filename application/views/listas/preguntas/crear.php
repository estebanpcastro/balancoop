<?php
// Si es edición de un registro
if ($id != 0) {
    // Se consultan los datos
    $pregunta = $this->listas_model->cargar_pregunta($id);

    // Input oculto
    echo '<input id="id_pregunta" type="hidden" value="'.$id.'">';
} // if
?>

<!-- Modal para el registro nuevo o el que se editará -->
<div id="modal_pregunta" class="modal fade">
	<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 id="modal_mensaje_titulo" class="modal-title">Gestión de preguntas</h4>
            </div>
            <div class="modal-body">
                <div class="row ">
					<!-- Descripción -->
                	<div class="col-lg-12">
	                    <div class="form-group">
        					<input id="input_descripcion" class="form-control input-sm" type="text" value="<?php echo $valor = (isset($pregunta->descripcion)) ? $pregunta->descripcion : "" ; ?>" autofocus>
			            </div>
		            </div>
        		</div>
        	</div>
            <div class="modal-footer">
                <button type="button" onclick="javascript:guardar()" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-outline btn-info" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    // Cuando el DOM esté listo
    $(document).ready(function() {
        // Se muestra el modal
        $('#modal_pregunta').modal('show');
    }); // document.ready
</script>