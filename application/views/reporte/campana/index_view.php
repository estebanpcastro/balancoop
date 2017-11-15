<div class="row">
    <!-- Campaña -->
    <div class="col-lg-6">
        <label for="select_campana" class="control-label">Campaña</label>
        <select id="select_campana" class="form-control input-sm-4" autofocus>
            <option value="">Seleccione...</option>
            <?php foreach ($this->listas_model->cargar_campana_empresa() as $campana) { ?>
                <option value="<?php echo $campana->intCodigo; ?>"><?php echo $campana->strNombre; ?></option>
            <?php } ?>
        </select>
    </div><!-- Campaña -->

    <!-- Usuario -->
    <div class="col-lg-6">
        <label for="select_usuario" class="control-label">Usuario</label>
        <select id="select_usuario" class="form-control input-sm-4" autofocus>
            <option value="0">Todos...</option>
            <?php foreach ($this->listas_model->cargar_usuarios_sistema() as $usuario) { ?>
                <option value="<?php echo $usuario->intCodigo; ?>"><?php echo $usuario->strNombre; ?></option>
            <?php } ?>
        </select>
    </div><!-- Usuario -->
</div>
<br>

<div id="cont_informes"></div>

<script type="text/javascript">
    $(document).ready(function(){
    	/**
    	 * Cuando se seleccione una campaña o un usuario
    	 */
    	$("#select_campana, #select_usuario").on("change", function(){
    		// Si se selecciona una campaña
    		if ($(this).val() != "") {
                imprimir("Campaña " + $("#select_campana").val());

    			//Se carga la interfaz
    			$("#cont_informes").load("<?php echo site_url('listas/cargar_interfaz') ?>", {tipo: "reporte_campana_listado", id_campana: $("#select_campana").val(), id_usuario: $("#select_usuario").val() });

                //Se muestra la barra de carga
                cargando($("#cont_informes"));
    		};
    	}); // Change campaña
    });//document.ready
</script>