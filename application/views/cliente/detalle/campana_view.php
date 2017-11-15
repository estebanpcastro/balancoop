<!-- Se cargan los datos necesarios -->
<?php
$campanas_cliente = $this->cliente_model->cargar_campanas_cliente($id_asociado);
$campanas_activas = $this->listas_model->cargar_campanas_activas();
// exit();
?>

<!-- Agregar campana -->
<button id="btn_agregar_campana" type="button" class="btn btn-info btn-block">Agregar campaña</button>
<br>

<input type="hidden" id="id_campana">

<!-- Tabla responsiva -->
<div id="tabla" class="table-responsive">
    <!-- Tabla -->
    <table id="tabla_campanas" class="table">
        <!-- Cabecera -->
        <thead>
            <tr>
                <th class="alinear_centro">Opc.</th>
                <th class="alinear_centro">Nro.</th>
                <th class="alinear_centro">Campaña</th>
                <th class="alinear_centro">Fecha inicial</th>
                <th class="alinear_centro">Fecha final</th>
                <th class="alinear_centro">Usuario</th>
            </tr>
        </thead><!-- Cabecera -->

        <!-- Cuerpo -->
        <tbody>
            <?php
            $cont = 1;
            // Recorrido de las campañas
            foreach ($campanas_cliente as $campana_cliente) {
            ?>
            <tr>
                <td>
                    <!-- Editar campaña -->
                    <a href="javascript:editar_campana(<?php echo $campana_cliente->intCodigo; ?>)">
                        <span class="glyphicon glyphicon-edit icono"></span>            
                    </a>

                    <!-- Eliminar campaña -->
                    <a href="javascript:eliminar(<?php echo $campana_cliente->intCodigo; ?>)" title="Eliminar campaña" class="icono">
                        <span class="glyphicon glyphicon-remove"></span>
                    </a>  
                </td>
                <td><?php echo $cont; ?></td>
                <td><?php echo $campana_cliente->Campana; ?></td>
                <td><?php echo $campana_cliente->fecha_inicial; ?></td>
                <td><?php echo $campana_cliente->fecha_final; ?></td>
                <td><?php echo $campana_cliente->Usuario; ?></td>
            </tr>
            <?php
            $cont++;
            } //Foreach
            ?>
        </tbody><!-- Cuerpo -->
    </table><!-- Tabla -->
</div><!-- Tabla responsiva -->

<!-- Modal nueva campaña -->
<div id="modal_nueva_campana" class="modal fade">
	<form id="form_campana">
        <div class="modal-dialog">
            <div class="modal-content">
				<!-- Cabecera -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Gestion de campañas del asociado</h4>
                </div><!-- Cabecera -->

                <!-- Cuerpo -->
                <div class="modal-body">
                	<!-- Container -->
                    <div class="container">
                    	<!-- Campaña -->
                        <div class="col-lg-12">
	                        <label for="select_campana" class="control-label">Campaña *</label>
	                        <select id="select_campana" class="form-control input-sm-4" autofocus>
	                            <option value="">Seleccione...</option>
	                            <?php foreach ($campanas_activas as $campana) { ?>
		                            <option value="<?php echo $campana->intCodigo; ?>"><?php echo $campana->strNombre; ?></option>
		                        <?php } ?>
	                        </select>
                    	</div><!-- Campaña -->
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

                <!-- Pie -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div><!-- Pie -->
        	</div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal nueva campaña -->

<!-- Modal eliminar campana -->
<div id="modal_eliminar_campana" class="modal fade">
    <form id="form_eliminar_producto">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Cabecera -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Eliminar campañas</h4>
                </div><!-- Cabecera -->

                <!-- Cuerpo -->
                <div class="modal-body">
                    <!-- Container -->
                    <div class="container">
                        <p>¿Está seguro de eliminar la campaña?</p>
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
</div><!-- /.modal eliminar campana -->

<script type="text/javascript">
    function editar_campana(id_campana){
        // Se pone el id de la campaña
        $("#id_campana").val(id_campana);

        // Consultamos los datos de la campaña específica
        dato_campana = ajax("<?php echo site_url('listas/cargar_campana_cliente'); ?>", {'tipo': 'campana', 'id_campana_cliente': id_campana}, "JSON");
        // imprimir(dato_campana);
        
        // Se ponen los datos 
        $('#select_campana > option[value="' + dato_campana.id_campana + '"]').attr('selected', 'selected');
        $('#dia_inicio > option[value="' + dato_campana.fecha_inicial.substring(8,10) + '"]').attr('selected', 'selected');
        $('#mes_inicio > option[value="' + dato_campana.fecha_inicial.substring(5,7) + '"]').attr('selected', 'selected');
        $('#anio_inicio > option[value="' + dato_campana.fecha_inicial.substring(0,4) + '"]').attr('selected', 'selected');
        $('#dia_fin > option[value="' + dato_campana.fecha_final.substring(8,10) + '"]').attr('selected', 'selected');
        $('#mes_fin > option[value="' + dato_campana.fecha_final.substring(5,7) + '"]').attr('selected', 'selected');
        $('#anio_fin > option[value="' + dato_campana.fecha_final.substring(0,4) + '"]').attr('selected', 'selected');

        //Se abre la ventana
        $('#modal_nueva_campana').modal('show');
    }

	function eliminar(id){
        // Se pone el id en un input oculto
        $("#id_campana").val(id);
        
        //Se abre la ventana
        $('#modal_eliminar_campana').modal('show');
    }

	$(document).ready(function(){
    	//Agregar campaña
        $("#btn_agregar_campana").on("click", function(){
            // Se quita el id de la campaña
            $("#id_campana").val(0);

            //Se limpian todos los selects
            $('#select_campana > option[value=""]').attr('selected', 'selected');
            $('#dia_inicio > option[value="00"]').attr('selected', 'selected');
            $('#mes_inicio > option[value="00"]').attr('selected', 'selected');
            $('#anio_inicio > option[value="0000"]').attr('selected', 'selected');
            $('#dia_fin > option[value="00"]').attr('selected', 'selected');
            $('#mes_fin > option[value="00"]').attr('selected', 'selected');
            $('#anio_fin > option[value="0000"]').attr('selected', 'selected');

            //Se abre la ventana
            $('#modal_nueva_campana').modal('show');
        });//Agregar campaña

        // Inicialización de la tabla
        $('#tabla_campanas').dataTable({
            "bProcessing": true,
        }); // Tabla

        //Recolección de datos
        var campana = $("#select_campana");
        var dia_inicio = $("#dia_inicio");
        var mes_inicio = $("#mes_inicio");
        var anio_inicio = $("#anio_inicio");
        var dia_fin = $("#dia_fin");
        var mes_fin = $("#mes_fin");
        var anio_fin = $("#anio_fin");

        //Guardar campaña
        $("#form_campana").on("submit", function(){//Datos a validar
            datos_obligatorios = new Array(
                campana.val()
            );

        	//Se ejecuta la validación de los campos obligatorios
            validacion = validar_campos_vacios(datos_obligatorios);

            //Si no supera la validacíón
            if (!validacion) {
                //Se muestra el mensaje de error
                mostrar_mensaje('Faltan datos', 'Por favor complete la información para guardar la campaña.');
            } else {
            	// Arreglo de datos
                datos_formulario = {
                    "id_campana": campana.val(),
                    "id_cliente": "<?php echo $id_asociado; ?>",
                    "id_usuario_creador": "<?php echo $this->session->userdata('id_usuario'); ?>",
                    "id_empresa": "<?php echo $this->session->userdata('id_empresa'); ?>",
                    "fecha_inicial": anio_inicio.val() + "-" + mes_inicio.val() + "-" + dia_inicio.val(),
                    "fecha_final": anio_fin.val() + "-" + mes_fin.val() + "-" + dia_fin.val()
                };
                // imprimir(datos_formulario);
                
                //  Si es para actualizar, o sea, tiene id de campaña
                if ($("#id_campana").val() > 0) {
                    imprimir("Actualizando...");

                    //Se invoca la petición ajax que guardará el registro
                    ajax("<?php echo site_url('cliente/actualizar'); ?>", {"tipo": "campana", "id_asociado": $("#id_campana").val(), "datos": datos_formulario}, "html");
                } else {
                    imprimir("Guardando...");

                    //Se invoca la petición ajax que actualizará el registro
                    ajax("<?php echo site_url('cliente/guardar'); ?>", {"tipo": "campana", "datos": datos_formulario}, "html");
                } 

                //Se cierra la ventana
                $('#modal_nueva_campana').modal('hide');

                //Cuando se termine de cerrar
                $('#modal_nueva_campana').on('hidden.bs.modal', function (e) {
                    //Se recarga la tabla para que muestre los datos
                    $("#cont_detalle").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'cliente_campana', "id_asociado": "<?php echo $id_asociado; ?>"});
                });
            } // if validacion

        	//Se detiene el formulario
            return false;
        });//Guardar campaña

		//Eliminar campaña
        $("#form_eliminar_producto").on("submit", function(){
            //Se invoca la petición ajax que eliminará la campaña
            eliminar = ajax("<?php echo site_url('cliente/eliminar'); ?>", {"tipo": "campana", "id": $("#id_campana").val()}, "html");
            
            //Se cierra la ventana
            $('#modal_eliminar_campana').modal('hide');
            
            //Cuando se termine de cerrar
            $('#modal_eliminar_campana').on('hidden.bs.modal', function (e) {
                //Se recarga la tabla para que muestre los datos
                $("#cont_detalle").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'cliente_campana', "id_asociado": "<?php echo $id_asociado; ?>"});
            });

            //Se detiene el formulario
            return false;
        });//Eliminar campaña
    });//document.ready
</script>