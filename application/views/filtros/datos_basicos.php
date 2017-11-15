<?php
// Si es edición de un registro
if ($id != 0) {
    // Se consultan los datos
    $filtro = $this->filtro_model->cargar_informacion_filtro($id);
} // if
?>

<!-- Datos básicos -->
<div class="row">
	<!-- Nombre -->
	<div class="col-lg-12">
        <div class="form-group">
        	<input id="input_nombre_filtro" class="form-control input-sm" type="text" placeholder="Nombre del filtro" value="<?php echo $nombre = (isset($filtro->strNombre)) ? $filtro->strNombre : "" ; ?>" autofocus>
        </div>
	</div>
</div>

<!-- Listas -->
<div class="row">
	<!-- Filtro de cliente -->
	<div class="col-lg-4">
        <div class="form-group">
        	<select id="select_filtro_cliente" class="form-control input-sm">
                <option value="1">Es filtro de cliente</option>
                <option value="0">No es filtro de cliente</option>
            </select>
        </div>
	</div>

	<!-- Si es usuario super administrador -->
	<?php if($this->session->userdata('tipo') == "3"){ ?>
		<!-- Filtro del sistema -->
    	<div class="col-lg-4">
            <select id="select_filtro_sistema" class="form-control input-sm">
                <option value="0">No es filtro de sistema</option>
                <option value="1">Es filtro de sistema</option>
            </select>
    	</div>
    <?php }else{ ?>
    	<!-- Input oculto -->
		<input id="select_filtro_sistema" type="hidden" value="0">
    <?php } ?>

	<!-- Filtro de búsqueda rápida -->
	<div class="col-lg-4">
        <div class="form-group">
        	<select id="select_busqueda_rapida" class="form-control input-sm">
                <option value="0">No es filtro de búsqueda rápida</option>
                <option value="1">Es filtro de búsqueda rápida?</option>
            </select>
        </div>
	</div>
</div>

<!-- Checks -->
<div class="row">
	<div class="col-lg-4">
        <!-- Activo -->
        <div class="checkbox">
            <label><input id="check_activo" type="checkbox" checked> Activo</label>
        </div><!-- Activo -->
	</div>

	<div class="col-lg-4">
        <!-- Privado -->
        <div class="checkbox">
            <label><input id="check_privado" type="checkbox"> Privado</label>
        </div><!-- Privado -->
	</div>

	<div class="col-lg-4">
        <!-- Por defecto -->
        <div class="checkbox">
            <label><input id="check_por_defecto" type="checkbox"> Por defecto</label>
        </div><!-- Por defecto -->
	</div>
</div>

<!-- Si es edición -->
<?php if ($id) { ?>
    <script type="text/javascript">
        // Listas por defecto
        select_por_defecto("select_filtro_cliente", "<?php echo $filtro->es_cliente; ?>");
        select_por_defecto("select_filtro_sistema", "<?php echo $filtro->es_sistema; ?>");
        select_por_defecto("select_busqueda_rapida", "<?php echo $filtro->busqueda_rapida; ?>");
        
        // Checks por defecto
        check_por_defecto("check_activo", "<?php echo $filtro->Estado; ?>");
        check_por_defecto("check_privado", "<?php echo $filtro->privado; ?>");
        
        // Si el id por defecto es el mismo seleccionado
        if ("<?php echo $this->session->userdata('id_filtro_por_defecto'); ?>" == "<?php echo $id; ?>") {
            check_por_defecto("check_por_defecto", 1);
        } // if
    </script>
<?php } ?>