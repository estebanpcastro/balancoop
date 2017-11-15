<!-- Se cargan los datos necesarios -->
<?php
$comentarios = $this->cliente_model->cargar_comentarios($id_asociado);
$campanas = $this->listas_model->cargar_campanas_activas();
?>

<!-- Agregar comentario -->
<button id="btn_agregar_comentario" type="button" class="btn btn-info btn-block">Agregar Comentario</button>
<br>

<input type="hidden" id="id_comentario">

<!-- Tabla responsiva -->
<div id="tabla" class="table-responsive">
	<!-- Tabla -->
	<table id="tabla_comentarios" class="table">
		<!-- Cabecera -->
        <thead>
            <tr>
                <th class="alinear_centro">Opc.</th>
            	<th class="alinear_centro">Nro.</th>
            	<th class="alinear_centro">Campaña</th>
                <th class="alinear_centro">Comentario</th>
                <th class="alinear_centro">Fecha</th>
            	<th class="alinear_centro">Usuario</th>
            </tr>
        </thead><!-- Cabecera -->
        <!-- Cuerpo -->
        <tbody>
        	<?php
            $cont = 1;
            // Recorrido de los comentarios
            foreach ($comentarios as $comentario) {
            ?>
            <tr>
        		<td>
                    <!-- Editar comentario -->
                    <a href="javascript:editar_comentario(<?php echo $comentario->intCodigo; ?>)">
                        <span class="glyphicon glyphicon-edit icono"></span>            
                    </a>

                    <!-- Eliminar comentario -->
                    <a href="javascript:eliminar(<?php echo $comentario->intCodigo; ?>)" title="Eliminar comentario" class="icono">
                        <span class="glyphicon glyphicon-remove"></span>
                    </a>    
                </td>
        		<td><?php echo $cont; ?></td>
                <td><?php echo $comentario->Campana; ?></td>
                <td><?php echo $comentario->Comentario; ?></td>
                <td><?php echo $comentario->fecha; ?></td>
                <td><?php echo $comentario->Usuario; ?></td>
        	</tr>
        	<?php
            $cont++;
            } //Foreach
            ?>
        </tbody><!-- Cuerpo -->
	</table><!-- Tabla -->
</div><!-- Tabla responsiva -->

<!-- Modal nuevo comentario -->
<div id="modal_nuevo_comentario" class="modal fade">
	<form id="form_comentario">
        <div class="modal-dialog">
            <div class="modal-content">
				<!-- Cabecera -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Gestion de comentarios</h4>
                </div><!-- Cabecera -->

                <!-- Cuerpo -->
                <div class="modal-body">
                    <!-- Container -->
                    <div class="container">
                    	<!-- Comentario -->
                        <textarea id="input_comentario" class="form-control" rows="5" autofocus></textarea>
						
						<!-- Campaña -->
                        <label for="select_campana" class="control-label">Campaña</label>
                        <select id="select_campana" class="form-control input-sm">
                            <option value="">Seleccione...</option>
                            <?php foreach ($campanas as $campana) { ?>
	                            <option value="<?php echo $campana->intCodigo; ?>"><?php echo $campana->strNombre; ?></option>
	                        <?php } ?>
                        </select><!-- Campaña -->
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
</div><!-- /.modal nuevo comentario -->

<!-- Modal eliminar comentario -->
<div id="modal_eliminar_comentario" class="modal fade">
    <form id="form_eliminar_comentario">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Cabecera -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Eliminar comentarios</h4>
                </div><!-- Cabecera -->

                <!-- Cuerpo -->
                <div class="modal-body">
                    <!-- Container -->
                    <div class="container">
                        <p>¿Está seguro de eliminar el comentario?</p>
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
</div><!-- /.modal eliminar comentario -->

<script type="text/javascript">
    function editar_comentario(id_comentario){
        // Se pone el id del comentario
        $("#id_comentario").val(id_comentario);
        // imprimir(id_comentario);

        // Consultamos los datos del comentario específico
        comentario = ajax("<?php echo site_url('listas/cargar_comentario_cliente'); ?>", {'tipo': 'comentario', 'id_comentario_cliente': id_comentario}, "JSON");
        // imprimir(comentario);
        
        // Se ponen los datos 
        $('#select_campana > option[value="' + comentario.id_campana + '"]').attr('selected', 'selected');
        $('#input_comentario').val(comentario.comentario);

        // //Se abre la ventana
        $('#modal_nuevo_comentario').modal('show');
    }

    function eliminar(id){
        // Se pone el id en un input oculto
        $("#id_comentario").val(id);
        
        //Se abre la ventana
        $('#modal_eliminar_comentario').modal('show');
    }

	$(document).ready(function(){
		// Inicialización de la tabla
        $('#tabla_comentarios').dataTable({
            "bProcessing": true,
        }); // Tabla

        //Agregar comentario
        $("#btn_agregar_comentario").on("click", function(){
            // Se quita el id del comentario
            $("#id_comentario").val(0);

            // Se limpian los campos
            $('#select_campana > option[value=""]').attr('selected', 'selected');
            $('#input_comentario').val("");

            //Se abre la ventana
            $('#modal_nuevo_comentario').modal('show');
        });//Agregar comentario

        //Recolección de datos
        var comentario = $("#input_comentario");
        var campana = $("#select_campana");

        //Guardar comentario
        $("#form_comentario").on("submit", function(){
        	//Datos a validar
            datos_obligatorios = new Array(
                comentario.val(),
                campana.val()
            );

            //Se ejecuta la validación de los campos obligatorios
            validacion = validar_campos_vacios(datos_obligatorios);

            //Si no supera la validacíón
            if (!validacion) {
                //Se muestra el mensaje de error
                mostrar_mensaje('Faltan datos', 'Por favor complete la información para guardar el comentario.');
            } else {
            	//Arreglo JSON de datos a enviar posteriormente
                datos_formulario = {
                    'id_cliente': "<?php echo $id_asociado; ?>",
                    'comentario': comentario.val(),
                    'id_campana': campana.val(),
                    'id_usuario_creador': "<?php echo $this->session->userdata('id_usuario'); ?>",
                    'id_empresa': "<?php echo $this->session->userdata('id_empresa'); ?>"
                };
                // imprimir(datos_formulario);
                
                //  Si es para actualizar, o sea, tiene id de comentario
                if ($("#id_comentario").val() > 0) {
                    imprimir("Actualizando...");

                    //Se invoca la petición ajax que guardará el registro
                    ajax("<?php echo site_url('cliente/actualizar'); ?>", {"tipo": "comentario", "id_asociado": $("#id_comentario").val(), "datos": datos_formulario}, "html");
                } else {
                    imprimir("Guardando...");
                
                    //Se invoca la petición ajax que guardará el registro
                    ajax("<?php echo site_url('cliente/guardar'); ?>", {"tipo": "comentario", "datos": datos_formulario}, "html");
                }
                
            	//Se cierra la ventana
            	$('#modal_nuevo_comentario').modal('hide');
            	
            	//Cuando se termine de cerrar
                $('#modal_nuevo_comentario').on('hidden.bs.modal', function (e) {
                    //Se recarga la tabla para que muestre los datos
                    $("#cont_detalle").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'cliente_comentario', "id_asociado": "<?php echo $id_asociado; ?>"});
                });
            } // if validacion

        	//Se detiene el formulario
        	return false;
        });//Guardar comentario

        //Eliminar comentario
        $("#form_eliminar_comentario").on("submit", function(){
            //Se invoca la petición ajax que eliminará el registro
            eliminar = ajax("<?php echo site_url('cliente/eliminar'); ?>", {"tipo": "comentario", "id": $("#id_comentario").val()}, "html");
            
            //Se cierra la ventana
            $('#modal_eliminar_comentario').modal('hide');
            
            //Cuando se termine de cerrar
            $('#modal_eliminar_comentario').on('hidden.bs.modal', function (e) {
                //Se recarga la tabla para que muestre los datos
                $("#cont_detalle").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'cliente_comentario', "id_asociado": "<?php echo $id_asociado; ?>"});
            });

            //Se detiene el formulario
            return false;
        });//Eliminar comentario
	});//document.ready
</script>