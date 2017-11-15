<?php
// Se cargan datos necesarios
$anios = $this->listas_model->listar_anios();
$meses = $this->listas_model->listar_meses();
$oficinas = $this->listas_model->cargar_empresa('din_agencias', $this->session->userdata('id_empresa'));
?>

<!-- Título -->
<center><h3>Estado de la actualización de las hojas de vida (Asociados activos)</h3></center>

<!-- Contenedor -->
<div class="well container">
    <div class="col-lg-3">
        <label for="select_oficina" class="control-label">Oficina</label>
        <select id="select_oficina" class="form-control input-sm" autofocus>
            <option value="0">Todas</option>
            <?php foreach ($oficinas as $oficina) { ?>
                <option value="<?php echo $oficina->intCodigo; ?>"><?php echo $oficina->strNombre; ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="col-lg-4">
        <label for="select_mes" class="control-label">Mes</label>
        <select id="select_mes" class="form-control input-sm">
            <option value="0">Seleccione ...</option>
            <?php foreach ($this->listas_model->listar_meses() as $mes) { ?>
                <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="col-lg-4">
        <label for="select_anio" class="control-label">Año</label>
        <select id="select_anio" class="form-control input-sm">
            <option value="0">Seleccione ...</option>
            <?php foreach ($this->listas_model->listar_anios() as $anio) { ?>
                <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
            <?php } ?>
        </select>
    </div>
</div><!-- Contenedor -->

<p>
    <!-- Botón ganador -->
    <input type="button" id="btn_ganador" class="btn btn-success btn-block btn-xs" value="Elegir ganadores">
</p>

<p>
    <center>
        <div id="cont_ganador"></div>
        <div id="cont_hojas_vida"></div>
    </center>    
</p>

<script type="text/javascript">
    $(document).ready(function(){
        // De entrada, se carga la interfaz
        $("#cont_hojas_vida").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'cliente_actualizados', id_oficina: "0", mes: "0", anio: "0"});

        //Se muestra la barra de carga
        cargando($("#cont_hojas_vida"));

        // Cuando se cambie la oficina, mes o año
        $("[id^='select']").on("change", function(){
            // Se carga la interfaz según los parámetros
            $("#cont_hojas_vida").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'cliente_actualizados', id_oficina: $("#select_oficina").val(), anio: $("#select_anio").val(), mes: $("#select_mes").val()});

            //Se muestra la barra de carga
            cargando($("#cont_hojas_vida"));
        }); // change

        // Cuando se seleccione el ganador
        $("#btn_ganador").on("click", function(){
            //se carga el formulario que trae el ganador
            $("#cont_ganador").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'cliente_ganador', id_oficina: $("#select_oficina").val(), anio: $("#select_anio").val(), mes: $("#select_mes").val()});
        }); //clic
    });
</script>