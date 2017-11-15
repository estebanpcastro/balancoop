<!-- Campaña -->
<div class="col-lg-12">
    <!-- <label for="select_campana" class="control-label">Campaña</label> -->
    <select id="select_campana" class="form-control input-sm-4" autofocus>
        <option value="">Seleccione una campaña...</option>
        <?php foreach ($this->listas_model->cargar_campana_empresa() as $campana) { ?>
            <option value="<?php echo $campana->intCodigo; ?>"><?php echo $campana->strNombre; ?></option>
        <?php } ?>
    </select>
</div><!-- Campaña -->
<br>

<div id="cont_informes"></div>

<script type="text/javascript">
    $(document).ready(function(){
        /**
         * Cuando se seleccione una campaña
         */
        $("#select_campana").on("change", function(){
            // Si se selecciona una campaña
            if ($(this).val() != "") {
                //Se carga la interfaz
                $("#cont_informes").load("<?php echo site_url('listas/cargar_interfaz') ?>", {tipo: "reporte_campana_listado", id_campana: $(this).val()});

                //Se muestra la barra de carga
                cargando($("#cont_informes"));
            };
        }); // Change campaña
    });//document.ready
</script>