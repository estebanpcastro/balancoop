<?php
// Carga de datos necesarios
$productos = $this->listas_model->cargar_productos();
$generos = $this->listas_model->cargar('generos');

// Si es edición de un registro
if ($id != 0) {
    // Se consultan los datos
    $filtro = $this->filtro_model->cargar_filtro_producto($id);

    // Input oculto
    echo '<input id="id_filtro" type="hidden" value="'.$id.'">';
} // if
?>

<!-- Modal para el registro nuevo o el que se editará -->
<div id="modal_filtro" class="modal fade">
	<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 id="modal_mensaje_titulo" class="modal-title">Gestión de filtros de producto</h4>
            </div>
            <div class="modal-body">
            	<!-- Contenedor de datos básicos -->
            	<div id="cont_datos_basicos"></div>

            	<div class="row well">
					<!-- Condición -->
            		<div class="col-lg-3">
	                    <div class="form-group">
	                    	<label for="select_filtro_condicion" class="control-label">Condición</label>
				            <select id="select_filtro_condicion" class="form-control input-sm" autofocus>
				                <option value="">Seleccione</option>
				                <option value="1">Contiene</option>
				                <option value="0">No contiene</option>
				            </select>
	                    </div>
                	</div>

					<!-- Producto -->
            		<div class="col-lg-6">
	                    <div class="form-group">
	                    	<label for="select_filtro_producto" class="control-label">Producto</label>
				            <select id="select_filtro_producto" class="form-control input-sm" autofocus>
				                <option value="">Seleccione...</option>
				                <?php foreach ($productos as $producto) { ?>
				                    <option value="<?php echo $producto->intCodigo; ?>"><?php echo $producto->strNombre; ?></option>
				                <?php } ?>
				            </select>
	                    </div>
                	</div>

					<!-- Género -->
            		<div class="col-lg-3">
	                    <div class="form-group">
	                    	<label for="select_filtro_genero" class="control-label">Género</label>
				            <select id="select_filtro_genero" class="form-control input-sm" autofocus>
				                <option value="">Seleccione...</option>
				                <?php foreach ($generos as $genero) { ?>
				                    <option value="<?php echo $genero->intCodigo; ?>"><?php echo $genero->strNombre; ?></option>
				                <?php } ?>
				            </select>
	                    </div>
                	</div>
        		</div>
        	</div>
            <div class="modal-footer">
                <button type="button" onclick="javascript:guardar('productos')" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-outline btn-info" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    // Cuando el DOM esté listo
    $(document).ready(function() {
        // Se muestra el modal
        $('#modal_filtro').modal('show');

        // Se cargan los datos básicos
        cargar_datos_basicos();        
    }); // document.ready
</script>

<!-- Si es edición -->
<?php if ($id) { ?>
	<script type="text/javascript">
		// Listas por defecto
		select_por_defecto("select_filtro_condicion", "<?php echo $filtro->contiene; ?>");
		select_por_defecto("select_filtro_producto", "<?php echo $filtro->id_producto; ?>");
		select_por_defecto("select_filtro_genero", "<?php echo $filtro->id_genero; ?>");
	</script>
<?php } ?>