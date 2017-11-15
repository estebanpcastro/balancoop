<?php
// Se cargan los elementos de base de datos
$filtros_productos = $this->filtro_model->cargar_filtros_productos();
$oficinas = $this->listas_model->cargar_empresa('din_agencias', $this->session->userdata('id_empresa'));
$anios = $this->listas_model->listar_anios();
?>

<!-- Usuario -->
<div class="form-group col-lg-5">
    <label for="select_busqueda_filtro" class="control-label">Filtro</label>
    <select id="select_busqueda_filtro" class="form-control input-sm" autofocus>
        <option value="0">Seleccione...</option>
        <?php foreach ($filtros_productos as $filtro) { ?>
            <option value="<?php echo $filtro->intCodigo; ?>"><?php echo $filtro->strNombre; ?></option>
        <?php } ?>
    </select>
</div><!-- Usuario -->

<!-- Oficina -->
<div class="form-group col-lg-4">
    <label for="select_busqueda_oficina" class="control-label">Oficina</label>
    <select id="select_busqueda_oficina" class="form-control input-sm" >
        <option value="0">Todas...</option>
        <?php foreach ($oficinas as $oficina) { ?>
            <option value="<?php echo $oficina->intCodigo; ?>"><?php echo $oficina->strNombre; ?></option>
        <?php } ?>
    </select>
</div><!-- Oficina -->

<!-- Año -->
<div class="form-group col-lg-3">
    <label for="select_busqueda_anio" class="control-label">Año</label>
    <select id="select_busqueda_anio" class="form-control input-sm" >
        <option value="0">Todos...</option>
        <?php foreach ($anios as $anio) { ?>
            <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
        <?php } ?>
    </select>
</div><!-- Año -->

<div class="clear"></div>

<!-- Contenedor -->
<div id="cont_tabla"></div>

<script type="text/javascript">
    $(document).ready(function(){
        // Declaración de variables
        var filtro = $("#select_busqueda_filtro");
        var oficina = $("#select_busqueda_oficina");
        var anio = $("#select_busqueda_anio");

        /**
         * Cuando se busque la cédula
         */
        $("#select_busqueda_filtro, #select_busqueda_oficina, #select_busqueda_anio").on("change", function(){
            // Si selecciona un producto
            if(filtro != ""){
                // Cargamos la vista
                $("#cont_tabla").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'crm_tabla_asociados_productos', id_filtro: filtro.val(), id_oficina: oficina.val(), anio: anio.val()});

                //Se muestra la barra de carga
                cargando($("#cont_tabla"));
            }

            // Se detiene el formulario
            return false;
        });// form busqueda
    });//Document.ready
</script>