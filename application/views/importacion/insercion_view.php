<!-- Modal mensaje -->
<div id="modal_alerta" class="modal fade">
    <form>
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Cabecera -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Mensaje</h4>
                </div><!-- Cabecera -->

                <!-- Cuerpo -->
                <div class="modal-body">
                    <!-- Container -->
                    <div class="container">
                        <p id="mensaje"></p>
                    </div><!-- Container -->
                </div><!-- Cuerpo -->

                <!-- Pie -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                    <!-- <button type="submit" id="btn_borrar" class="btn btn-success">OK</button> -->
                </div><!-- Pie -->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal mensaje -->

<div class="col-lg-4">
    <fieldset>
        <legend><h2>2. Tabla</h2></legend>
        
        <label class="radio-inline">
            <input type="radio" name="tabla" id="tabla" value="asociados" checked> Asociados
        </label><br>

        <label class="radio-inline">
            <input type="radio" name="tabla" id="tabla" value="asociados_beneficiarios"> Beneficiarios
        </label><br>

        <label class="radio-inline">
            <input type="radio" name="tabla" id="tabla" value="clientes_campanas"> Campañas de asociados
        </label><br>

        <label class="radio-inline">
            <input type="radio" name="tabla" id="tabla" value="asociados_conocidos"> Conocidos
        </label><br>

        <label class="radio-inline">
            <input type="radio" name="tabla" id="tabla" value="asociados_hijos"> Hijos
        </label><br>

        <label class="radio-inline">
            <input type="radio" name="tabla" id="tabla" value="productos"> Productos
        </label><br>

        <label class="radio-inline">
            <input type="radio" name="tabla" id="tabla" value="clientes_productos"> Productos del asociado
        </label>
    </fieldset>
</div>

<div class="col-lg-4">
    <fieldset>
        <legend><h2>3. Formato</h2></legend>
        
        <p>Descargue la plantilla con los campos actualizados de la base de datos, para que la importación no genere errores</p>

        <button id="btn_plantilla_asociados" type="button" class="btn btn-success btn-sm btn-block">Descargar &raquo;</button>
    </fieldset>
</div>

<div class="col-lg-4">
    <fieldset>
        <legend><h2>4. Subir</h2></legend>
        
        <p>Suba el archivo de excel. Si la tabla es de asociados y el id ya existe, lo reemplazará. Para las demás tablas, siempre creará registros nuevos.</p>
       
        <form method="post"  enctype="multipart/form-data">
           <input type="file" id="archivo" name="archivo">
           <input type="submit" value="Importar" class="btn btn-info btn-sm">
       </form>
    </fieldset>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        // Generar plantilla
        $("#btn_plantilla_asociados").on("click", function(){
            location.href = "<?php echo site_url('reporte/formato_importacion'); ?>" + "/" + $("#tabla:checked").val();
        }); // exportar excel

        // Clic en el formulario
        $("form").on("submit", function(){
            // Se almacena el action del formulario dependiendo a la tabla que vaya
            $("form").attr("action", "importacion/subir/" + $("#tabla:checked").val());

            // Si no tiene archivo seleccionado
            if($("#archivo").val() == ""){
                // Se adiciona el mensaje
                $("#mensaje").text("Ningún archivo seleccionado.")

                // Se abre el modal
                $('#modal_alerta').modal('show');

                return false;
            }else {
                var archivo = $('#archivo')[0].files[0];
                var nombre_archivo = archivo.name;
                var extension_archivo = '.' + nombre_archivo.split('.').pop();

                // Si la extensión no es de excel
                if (extension_archivo != ".xlsx") {
                    // Se adiciona el mensaje
                    $("#mensaje").text("El archivo subido no es un archivo de Excel.")

                    // Se abre el modal
                    $('#modal_alerta').modal('show');

                    return false;
                }
            }
        });
    });//document.ready
</script>