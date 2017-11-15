<!-- Modal eliminar -->
<div id="modal_eliminar" class="modal fade">
    <form id="form_eliminar">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Cabecera -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Eliminar</h4>
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="submit" id="btn_borrar" class="btn btn-success">Si, eliminar</button>
                </div><!-- Pie -->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal eliminar -->

<!-- Modal Vacíos -->
<div id="modal_vacios" class="modal fade">
    <form id="form_eliminar">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Cabecera -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">No hay nada que eliminar</h4>
                </div><!-- Cabecera -->

                <!-- Cuerpo -->
                <div class="modal-body">
                    <!-- Container -->
                    <div class="container">
                        <p>No hay registros por eliminar en el rango de fechas seleccionado</p>
                    </div><!-- Container -->
                </div><!-- Cuerpo -->

                <!-- Pie -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                </div><!-- Pie -->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal Vacíos -->

<!-- Modal Exito -->
<div id="modal_exito" class="modal fade">
    <form id="form_eliminar">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Cabecera -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Correcto</h4>
                </div><!-- Cabecera -->

                <!-- Cuerpo -->
                <div class="modal-body">
                    <!-- Container -->
                    <div class="container">
                        <p>Los registros se han borrado correctamente.</p>
                    </div><!-- Container -->
                </div><!-- Cuerpo -->

                <!-- Pie -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div><!-- Pie -->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal Exito -->

<div class="col-lg-4">
    <fieldset>
        <legend><h2>2. Tabla</h2></legend>
        
        <label class="radio-inline">
            <input type="radio" name="tabla" id="tabla" value="clientes_campanas" checked> Campañas de asociados
        </label><br>

        <label class="radio-inline">
            <input type="radio" name="tabla" id="tabla" value="clientes_productos"> Productos de asociados
        </label>
    </fieldset>
</div>

<div class="col-lg-8">
    <fieldset>
        <legend><h2>3. Rango de fecha</h2></legend>
        <p>Seleccione el rango de fechas de registros que desea eliminar</p>
        
        <!-- Desde -->
        <p class="row">
            <div class="col-lg-4">
                <label for="select_dia_inicio" class="control-label">Desde</label>
                <select id="select_dia_inicio" class="form-control input-sm">
                    <option value="">Día ...</option>
                    <?php foreach ($this->listas_model->listar_dias() as $dia) { ?>
                        <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-lg-4">
                <label for="select_mes_inicio" class="control-label"></label>
                <select id="select_mes_inicio" class="form-control input-sm">
                    <option value="">Mes ...</option>
                    <?php foreach ($this->listas_model->listar_meses() as $mes) { ?>
                        <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-lg-4">
                <label for="select_anio_inicio" class="control-label"></label>
                <select id="select_anio_inicio" class="form-control input-sm">
                    <option value="">Año ...</option>
                    <?php foreach ($this->listas_model->listar_anios() as $anio) { ?>
                        <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                    <?php } ?>
                </select>
            </div>
        </p>
            
        <!-- Hasta -->
        <p class="row">
            <div class="col-lg-4">
                <label for="select_dia_fin" class="control-label">Hasta</label>
                <select id="select_dia_fin" class="form-control input-sm">
                    <option value="">Día ...</option>
                    <?php foreach ($this->listas_model->listar_dias() as $dia) { ?>
                        <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-lg-4">
                <label for="select_mes_fin" class="control-label"></label>
                <select id="select_mes_fin" class="form-control input-sm">
                    <option value="">Mes ...</option>
                    <?php foreach ($this->listas_model->listar_meses() as $mes) { ?>
                        <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-lg-4">
                <label for="select_anio_fin" class="control-label"></label>
                <select id="select_anio_fin" class="form-control input-sm">
                    <option value="">Año ...</option>
                    <?php foreach ($this->listas_model->listar_anios() as $anio) { ?>
                        <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                    <?php } ?>
                </select>
            </div>
        </p>
    </fieldset><br>
    
    <button id="btn_eliminar" type="button" class="btn btn-danger btn-sm btn-block">Eliminar rango &raquo;</button>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        // Generar plantilla
        $("#btn_plantilla_asociados").on("click", function(){
            location.href = "<?php echo site_url('reporte/formato_importacion'); ?>" + "/" + $("#tabla:checked").val();
        }); // exportar excel

        // Modal eliminar
        $("#btn_eliminar").on("click", function(){
            // Se recogen las variables
            var dia_inicio = $("#select_dia_inicio");
            var dia_fin = $("#select_dia_fin");
            var mes_inicio = $("#select_mes_inicio");
            var mes_fin = $("#select_mes_fin");
            var anio_inicio = $("#select_anio_inicio");
            var anio_fin = $("#select_anio_fin");

            //Datos a validar
            datos_obligatorios = new Array(
                dia_inicio.val(),
                dia_fin.val(),
                mes_inicio.val(),
                mes_fin.val(),
                anio_inicio.val(),
                anio_fin.val()
            );
            // imprimir(datos_obligatorios);

            //Se ejecuta la validación de los campos obligatorios
            validacion = validar_campos_vacios(datos_obligatorios);

            //Si no supera la validacíón
            if (!validacion) {
                //Se muestra el mensaje de error
                mostrar_mensaje('Faltan datos', 'Por favor complete la información para proceder a la eliminación.');

                return false;
            } else {
                // Datos a enviar
                datos = {
                    "Fecha_Inicio": anio_inicio.val() + "-" + mes_inicio.val() + "-" + dia_inicio.val(),
                    "Fecha_Final": anio_fin.val() + "-" + mes_fin.val() + "-" + dia_fin.val()
                }
                // imprimir(datos);

                // Se consulta la cantidad de registros a eliminar
                registros = ajax("<?php echo site_url('importacion/contar') ?>", {"tipo": $("#tabla:checked").val(), "datos": datos}, "html");
                imprimir(registros);

                // Si hay registros
                if (registros > 0) {
                    // Se manda el mensaje
                    $("#mensaje").text("Hay " + registros + " registros en el rango seleccionado. ¿Está seguro que desea eliminarlos?")

                    // Se abre el modal preguntando si desea eliminar los registos
                    $('#modal_eliminar').modal('show');
                } else {
                    // Se abre el modal de registros vacíos
                    $('#modal_vacios').modal('show');
                }
            }
        });// Eliminar registros
        

        $("#btn_borrar").on("click", function(){
            // Se eliminan los registros mediante ajax
            eliminar = ajax("<?php echo site_url('importacion/eliminar') ?>", {"tipo": $("#tabla:checked").val(), "datos": datos}, "html");
    
            // Se abre el modal de exito
            $('#modal_exito').modal('show');

            //Cuando se termine de cerrar
            $('#modal_exito').on('hidden.bs.modal', function (e) {
                // Se abre el modal de exito
                $('#modal_eliminar').modal('hide');
            });

            return false;
        });
    });//document.ready
</script>