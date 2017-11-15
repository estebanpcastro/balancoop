<!-- Se cargan los datos necesarios -->
<?php
$estados = $this->listas_model->cargar('oportunidad_estados');
$fases = $this->listas_model->cargar('oportunidad_fases');
$oportunidades_cliente = $this->cliente_model->cargar_oportunidades_cliente($id_asociado);
$campanas = $this->listas_model->cargar_campanas_activas();
?>

<!-- Agregar oportunidad -->
<button id="btn_agregar_oportunidad" type="button" class="btn btn-info btn-block">Agregar oportunidad</button>
<br>

<input type="hidden" id="id_oportunidad">

<!-- Tabla responsiva -->
<div id="tabla" class="table-responsive">
    <!-- Tabla -->
    <table id="tabla_oportunidades" class="table">
        <!-- Cabecera -->
        <thead>
            <tr>
				<th class="alinear_centro">Opc.</th>
                <th class="alinear_centro">Nro.</th>
                <th class="alinear_centro">Estado</th>
                <th class="alinear_centro">Producto</th>
                <th class="alinear_centro">Fase</th>
                <th class="alinear_centro">Fecha inicial</th>
                <th class="alinear_centro">Fecha final</th>
                <th class="alinear_centro">Oficina</th>
                <th class="alinear_centro">Campaña</th>
                <th class="alinear_centro">Valor estimado</th>
                <th class="alinear_centro">Usuario creador</th>
        	</tr>
        </thead><!-- Cabecera -->

        <!-- Cuerpo -->
        <tbody>
        	<?php
            $cont = 1;
            // Recorrido de las oportunidades
            foreach ($oportunidades_cliente as $oportunidad) {
            ?>
            <tr>
				<td>
                    <!-- Editar oportunidad -->
                    <a href="javascript:editar_oportunidad(<?php echo $oportunidad->intCodigo; ?>)">
                        <span class="glyphicon glyphicon-edit icono"></span>            
                    </a>

                    <!-- Eliminar oportunidad -->
                    <a href="javascript:eliminar(<?php echo $oportunidad->intCodigo; ?>)" title="Eliminar oportunidad" class="icono">
                        <span class="glyphicon glyphicon-remove"></span>
                    </a>             
                </td>
				<td><?php echo $cont; ?></td>
                <td><?php echo $oportunidad->Estado; ?></td>
                <td><?php echo $oportunidad->Producto; ?></td>
                <td><?php echo $oportunidad->Fase; ?></td>
                <td><?php echo $oportunidad->fecha_inicial; ?></td>
                <td><?php echo $oportunidad->fecha_final; ?></td>
                <td><?php echo $oportunidad->Oficina; ?></td>
                <td><?php echo $oportunidad->Campana; ?></td>
                <td><?php echo $oportunidad->valor_estimado; ?></td>
				<td><?php echo $oportunidad->Usuario; ?></td>
        	</tr>
            <?php
            $cont++;
            } //Foreach
            ?>
        </tbody><!-- Cuerpo -->
    </table><!-- Tabla -->
</div><!-- Tabla responsiva -->

<!-- Modal nueva oportunidad -->
<div id="modal_nueva_oportunidad" class="modal fade">
    <form id="form_oportunidad">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Cabecera -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Gestion de oportunidades del asociado</h4>
                </div><!-- Cabecera -->

                <!-- Cuerpo -->
                <div class="modal-body">
                    <!-- Container -->
                    <div class="container">
                        <!-- Estado -->
                        <div class="col-lg-4">
                            <label for="select_estado" class="control-label">Estado *</label>
                            <select id="select_estado" class="form-control input-sm-4" autofocus>
                                <option value="">Seleccione...</option>
                                <?php foreach ($estados as $estado) { ?>
                                    <option value="<?php echo $estado->intCodigo; ?>"><?php echo $estado->strNombre; ?></option>
                                <?php } ?>
                            </select>
                        </div><!-- Estado -->

                        <!-- Producto -->
                        <div class="col-lg-4">
                            <label for="select_producto" class="control-label">Producto *</label>
                            <select id="select_producto" class="form-control input-sm-4">
                                <option value="">Seleccione...</option>
                                <?php foreach ($this->listas_model->cargar_productos() as $producto) { ?>
                                    <option value="<?php echo $producto->intCodigo; ?>"><?php echo $producto->strNombre; ?></option>
                                <?php } ?>
                            </select>
                        </div><!-- Producto -->

                        <!-- Fase -->
                        <div class="col-lg-4">
                            <label for="select_fase" class="control-label">Fase *</label>
                            <select id="select_fase" class="form-control input-sm-4">
                                <option value="">Seleccione...</option>
                                <?php foreach ($fases as $fase) { ?>
                                    <option value="<?php echo $fase->intCodigo; ?>"><?php echo $fase->strNombre; ?></option>
                                <?php } ?>
                            </select>
                        </div><!-- Fase -->
                    </div><!-- Container -->
                    <br>

                    <!-- Container -->
                    <div class="container well">
                        <!-- Fecha de inicio -->
                        <label for="dia_inicio" class="control-label col-lg-12">Fecha de inicio</label>
                        <div class="col-lg-4">
                            <select id="dia_inicio" class="form-control">
                                <option value="00">Día</option>
                                <?php foreach ($dias as $dia) { ?>
                                    <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <select id="mes_inicio" class="form-control">
                                <option value="00">Mes</option>
                                <?php foreach ($meses as $mes) { ?>
                                    <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-lg-4">
                            <select id="anio_inicio" class="form-control" >
                                <option value="0000">Año</option>
                                <?php foreach ($anios as $anio) { ?>
                                    <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                                <?php } ?>
                            </select>
                        </div><!-- Fecha de inicio -->

                        <!-- Fecha final -->
                        <label for="dia_inicio" class="control-label col-lg-12">Fecha final</label>
                        <div class="col-lg-4">
                            <select id="dia_fin" class="form-control">
                                <option value="00">Día</option>
                                <?php foreach ($dias as $dia) { ?>
                                    <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <select id="mes_fin" class="form-control">
                                <option value="00">Mes</option>
                                <?php foreach ($meses as $mes) { ?>
                                    <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-lg-4">
                            <select id="anio_fin" class="form-control" >
                                <option value="0000">Año</option>
                                <?php foreach ($anios as $anio) { ?>
                                    <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                                <?php } ?>
                            </select>
                        </div><!-- Fecha final -->
                    </div><!-- Container -->
                </div><!-- Cuerpo -->
                
                <!-- Container -->
                <div class="container">
                    <!-- Valor estimado -->
                    <div class="col-lg-4">
                        <label for="input_valor" class="control-label">Valor estimado</label>
                        <input id="input_valor" class="form-control input-sm" type="text" placeholde="Obligatorio"><!-- Valor estimado -->
                    </div><!-- Valor estimado -->

                    <!-- Campaña -->
                        <div class="col-lg-4">
                            <label for="select_campana" class="control-label">Campaña</label>
                            <select id="select_campana" class="form-control input-sm-4" autofocus>
                                <option value="">Seleccione...</option>
                                <?php foreach ($campanas as $campana) { ?>
                                    <option value="<?php echo $campana->intCodigo; ?>"><?php echo $campana->strNombre; ?></option>
                                <?php } ?>
                            </select>
                        </div><!-- Campaña -->

                        <!-- Oficina -->
                        <div class="col-lg-4">
                            <label for="select_oficina" class="control-label">Oficina *</label>
                            <select id="select_oficina" class="form-control input-sm">
                                <option value="">Seleccione...</option>
                                <?php foreach ($oficinas as $oficina) { ?>
                                    <option value="<?php echo $oficina->intCodigo; ?>"><?php echo $oficina->strNombre; ?></option>
                                <?php } ?>
                            </select>
                        </div><!-- Oficina -->
                </div><!-- Container -->

                <!-- Pie -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div><!-- Pie -->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal nueva oportunidad -->

<!-- Modal eliminar oportunidad -->
<div id="modal_eliminar_oportunidad" class="modal fade">
    <form id="form_eliminar_oportunidad">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Cabecera -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Eliminar oportunidades</h4>
                </div><!-- Cabecera -->

                <!-- Cuerpo -->
                <div class="modal-body">
                    <!-- Container -->
                    <div class="container">
                        <p>¿Está seguro de eliminar la oportunidad?</p>
                    </div><!-- Container -->
                </div><!-- Cuerpo -->

                <!-- Pie -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-success">Si, eliminar</button>
                </div><!-- Pie -->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal eliminar oportunidad -->

<script type="text/javascript">
    function editar_oportunidad(id_oportunidad){
        // Se pone el id de la oportunidad
        $("#id_oportunidad").val(id_oportunidad);
        imprimir(id_oportunidad);

        // Consultamos los datos de la oportunidad específica
        oportunidad = ajax("<?php echo site_url('listas/cargar_oportunidad_cliente'); ?>", {'tipo': 'oportunidad', 'id_oportunidad_cliente': id_oportunidad}, "JSON");
        // imprimir(oportunidad);
        
        // Se ponen los datos 
        $('#select_estado > option[value="' + oportunidad.id_estado_oportunidad + '"]').attr('selected', 'selected');
        $('#select_producto > option[value="' + oportunidad.id_producto + '"]').attr('selected', 'selected');
        $('#select_fase > option[value="' + oportunidad.id_fase + '"]').attr('selected', 'selected');
        $('#select_fase > option[value="' + oportunidad.id_fase + '"]').attr('selected', 'selected');
        $('#dia_inicio > option[value="' + oportunidad.fecha_inicial.substring(8,10) + '"]').attr('selected', 'selected');
        $('#mes_inicio > option[value="' + oportunidad.fecha_inicial.substring(5,7) + '"]').attr('selected', 'selected');
        $('#anio_inicio > option[value="' + oportunidad.fecha_inicial.substring(0,4) + '"]').attr('selected', 'selected');
        $('#dia_fin > option[value="' + oportunidad.fecha_final.substring(8,10) + '"]').attr('selected', 'selected');
        $('#mes_fin > option[value="' + oportunidad.fecha_final.substring(5,7) + '"]').attr('selected', 'selected');
        $('#anio_fin > option[value="' + oportunidad.fecha_final.substring(0,4) + '"]').attr('selected', 'selected');
        $('#input_valor').val(oportunidad.valor_estimado);
        $('#select_campana > option[value="' + oportunidad.id_campana + '"]').attr('selected', 'selected');
        $('#select_oficina > option[value="' + oportunidad.id_oficina + '"]').attr('selected', 'selected');

        //Se abre la ventana
        $('#modal_nueva_oportunidad').modal('show');
    }

    function eliminar(id){
        // Se pone el id en un input oculto
        $("#id_oportunidad").val(id);
        
        //Se abre la ventana
        $('#modal_eliminar_oportunidad').modal('show');
    }

	$(document).ready(function(){
        //Agregar oportunidad
        $("#btn_agregar_oportunidad").on("click", function(){
            // Se pone el id en un input oculto
            $("#id_oportunidad").val(0);

            // Se limpian los datos 
            $('#select_estado > option[value=""]').attr('selected', 'selected');
            $('#select_producto > option[value=""]').attr('selected', 'selected');
            $('#select_fase > option[value=""]').attr('selected', 'selected');
            $('#select_fase > option[value=""]').attr('selected', 'selected');
            $('#dia_inicio > option[value="00"]').attr('selected', 'selected');
            $('#mes_inicio > option[value="00"]').attr('selected', 'selected');
            $('#anio_inicio > option[value="0000"]').attr('selected', 'selected');
            $('#dia_fin > option[value="00"]').attr('selected', 'selected');
            $('#mes_fin > option[value="00"]').attr('selected', 'selected');
            $('#anio_fin > option[value="0000"]').attr('selected', 'selected');
            $('#input_valor').val("");
            $('#select_campana > option[value=""]').attr('selected', 'selected');
            $('#select_oficina > option[value=""]').attr('selected', 'selected');

            //Se abre la ventana
            $('#modal_nueva_oportunidad').modal('show');
        });//Agregar oportunidad

		// Inicialización de la tabla
        $('#tabla_oportunidades').dataTable({
            "bProcessing": true,
        }); // Tabla

        //Recolección de datos
        var estado = $("#select_estado");
        var producto = $("#select_producto");
        var campana = $("#select_campana");
        var fase = $("#select_fase");
        var fase = $("#select_fase");
        var dia_inicio = $("#dia_inicio");
        var mes_inicio = $("#mes_inicio");
        var anio_inicio = $("#anio_inicio");
        var dia_fin = $("#dia_fin");
        var mes_fin = $("#mes_fin");
        var anio_fin = $("#anio_fin");
        var valor = $("#input_valor");
        var oficina = $("#select_oficina");

        //Guardar oportunidad
        $("#form_oportunidad").on("submit", function(){
            //Datos a validar
            datos_obligatorios = new Array(
                estado.val(),
                producto.val(),
                fase.val()
            );

            //Se ejecuta la validación de los campos obligatorios
            validacion = validar_campos_vacios(datos_obligatorios);

            //Si no supera la validacíón
            if (!validacion) {
                //Se muestra el mensaje de error
                mostrar_mensaje('Faltan datos', 'Por favor complete la información para guardar el producto.');
            } else {
                // Arreglo de datos
                datos_formulario = {
                    "id_cliente": "<?php echo $id_asociado; ?>",
                    "id_producto": producto.val(),
                    "id_estado_oportunidad": estado.val(),
                    "id_fase": fase.val(),
                    "fecha_inicial": anio_inicio.val() + "-" + mes_inicio.val() + "-" + dia_inicio.val(),
                    "fecha_final": anio_fin.val() + "-" + mes_fin.val() + "-" + dia_fin.val(),
                    "valor_estimado": valor.val(),
                    "id_campana": campana.val(),
                    "id_oficina": oficina.val(),
                    "id_usuario_creador": "<?php echo $this->session->userdata('id_usuario'); ?>",
                    "id_empresa": "<?php echo $this->session->userdata('id_empresa'); ?>"
                };
                // imprimir(datos_formulario);
                
                //  Si es para actualizar, o sea, tiene id de campaña
                if ($("#id_oportunidad").val() > 0) {
                    imprimir("Actualizando...");

                    //Se invoca la petición ajax que actualizará la oportunidad
                    ajax("<?php echo site_url('cliente/actualizar'); ?>", {"tipo": "oportunidad", "id_asociado": $("#id_oportunidad").val(), "datos": datos_formulario}, "html");
                } else{
                    imprimir("Guardando...");

                    //Se invoca la petición ajax que guardará la oportunidad
                    ajax("<?php echo site_url('cliente/guardar'); ?>", {"tipo": "oportunidad", "datos": datos_formulario}, "html");
                }
                
                //Se cierra la ventana
                $('#modal_nueva_oportunidad').modal('hide');
            } // if validacion

            //Cuando se termine de cerrar
            $('#modal_nueva_oportunidad').on('hidden.bs.modal', function (e) {
                //Se recarga la tabla para que muestre los datos
                $("#cont_detalle").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'cliente_oportunidad', "id_asociado": "<?php echo $id_asociado; ?>"});
            });

            //Se detiene el formulario
            return false;
        });//Guardar oportunidad

        //Eliminar oportunidad
        $("#form_eliminar_oportunidad").on("submit", function(){
            //Se invoca la petición ajax que eliminará la oportunidad
            eliminar = ajax("<?php echo site_url('cliente/eliminar'); ?>", {"tipo": "oportunidad", "id": $("#id_oportunidad").val()}, "html");
            
            //Se cierra la ventana
            $('#modal_eliminar_oportunidad').modal('hide');
            
            //Cuando se termine de cerrar
            $('#modal_eliminar_oportunidad').on('hidden.bs.modal', function (e) {
                //Se recarga la tabla para que muestre los datos
                $("#cont_detalle").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'cliente_oportunidad', "id_asociado": "<?php echo $id_asociado; ?>"});
            });

            //Se detiene el formulario
            return false;
        });//Eliminar oportunidad
	});//document.ready
</script>