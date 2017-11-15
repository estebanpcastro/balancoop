<div class="row">
    <div class="col-lg-3">
        <fieldset>
            <legend><h2>1. Acción</h2></legend>

            <label class="radio-inline">
                <input type="radio" name="accion" id="accion" value="importacion_insercion" checked> Inserción
            </label><br>

            <label class="radio-inline">
                <input type="radio" name="accion" id="accion" value="importacion_actualizacion" > Actualización
            </label><br>

            <label class="radio-inline">
                <input type="radio" name="accion" id="accion" value="importacion_eliminacion" > Eliminación
            </label>
        </fieldset>
    </div>

    <div id="cont_importacion" class="col-lg-9"></div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        // De entrada, se cargan los elementos de inserción
        $("#cont_importacion").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {"tipo": 'importacion_insercion'});

        // Cuando cambie la opción de la acción
        $("input[name=accion]:radio").on("change", function(){
            // Se carga la interfaz correspondiente
            $("#cont_importacion").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {"tipo": $("#accion:checked").val()});
        });
    });//document.ready
</script>
