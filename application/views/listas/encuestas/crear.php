<?php
// Si es edición de un registro
if ($id != 0) {
    // Se consultan los datos
    // $encuesta = $this->listas_model->cargar_encuesta($id);

    // Input oculto
    echo '<input id="id_encuesta" type="hidden" value="'.$id.'">';
} // if
?>

<!-- Modal para el registro nuevo o el que se editará -->
<div id="modal_encuesta" class="modal fade">
	<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 id="modal_mensaje_titulo" class="modal-title">Gestión de encuestas</h4>
            </div>
            <div class="modal-body">
                <div class="row ">
                    <!-- Producto -->
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="select_producto_encuesta" class="control-label">Producto *</label>
                            <select id="select_producto_encuesta" class="form-control input-sm" autofocus>
                                <option value="">Seleccione...</option>
                                
                                <!-- Se recorren los registros -->
                                <?php foreach ($this->listas_model->cargar_productos() as $producto) { ?>
                                    <option value="<?php echo $producto->intCodigo; ?>"><?php echo $producto->strNombre; ?></option>
                                <?php } // foreach ?>
                            </select>
                        </div>
                    </div>

					<!-- Preguna -->
                	<div class="col-lg-12">
		            	<div class="form-group">
							<label for="select_pregunta_encuesta" class="control-label">Pregunta *</label>
				            <select id="select_pregunta_encuesta" class="form-control input-sm" autofocus>
    							<option value="">Seleccione...</option>
								
								<!-- Se recorren los registros -->
							    <?php foreach ($this->listas_model->cargar_preguntas() as $pregunta) { ?>
							        <option value="<?php echo $pregunta->intCodigo; ?>"><?php echo $pregunta->descripcion; ?></option>
							    <?php } // foreach ?>
							</select>
	            		</div>
		            </div>

					<!-- Periodicidad -->
                	<div class="col-lg-4">
		            	<div class="form-group">
							<label for="select_periodicidad" class="control-label">Periodicidad *</label>
				            <select id="select_periodicidad" class="form-control input-sm" autofocus>
    							<option value="">Seleccione...</option>
								
								<!-- Se recorren los registros -->
							    <?php foreach ($this->listas_model->cargar_periodicidades() as $periodicidad) { ?>
							        <option value="<?php echo $periodicidad->intCodigo; ?>"><?php echo $periodicidad->strNombre; ?></option>
							    <?php } // foreach ?>
							</select>
		            	</div>
		            </div>

					<!-- Día de inicio -->
                	<div class="col-lg-4">
                        <div class="form-group">
                            <label for="select_dia_inicio" class="control-label">Día de la evaluación *</label>
                            <select id="select_dia_inicio" class="form-control input-sm" autofocus>
                                <option value="">Seleccione...</option>

                                <?php foreach ($this->listas_model->listar_dias() as $dia) { ?>
                                    <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                                <?php } ?>
                            </select>
		            	</div>
		            </div>

					<!-- Hora de inicio -->
                	<div class="col-lg-4">
		            	<label for="select_hora_inicio" class="control-label">Hora de la evaluación *</label>
                        <select id="select_hora_inicio" class="form-control input-sm" autofocus>
                            <option value="">Seleccione...</option>

                            <?php foreach ($this->listas_model->listar_horas() as $hora) { ?>
                                <option value="<?php echo $hora; ?>"><?php echo $hora; ?></option>
                            <?php } ?>
                        </select>
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
        $('#modal_encuesta').modal('show');

        // Si hay un producto seleccionado en el módulo de encuestas
        if ($("#select_producto").val() != "0") {
            // Se pone por defecto ese producto
            select_por_defecto("select_producto_encuesta", $("#select_producto").val());
        } // if

        // Si hay una pregunta seleccionada en el módulo de encuestas
        if ($("#select_pregunta").val() != "0") {
        	// Se pone por defecto ese producto
        	select_por_defecto("select_pregunta_encuesta", $("#select_pregunta").val());
        } // if
    }); // document.ready
</script>