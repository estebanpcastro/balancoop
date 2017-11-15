<?php
// Se cargan los datos necesarios 
$tipos_usuario = $this->listas_model->cargar('tipo_usuario');
$usuarios_sistema = $this->cliente_model->listar_usuarios_sistema_empresa();
?>

<input type="hidden" id="id_usuario">

<!-- Botón agregar usuario -->
<button id="btn_agregar_usuario" type="button" class="btn btn-info btn-block">Agregar usuario</button>
<br>

<!-- Tabla responsiva -->
<div class="table-responsive">
    <!-- Tabla -->
    <table id="productos" class="table">
        <!-- Cabecera -->
        <thead>
            <tr>
				<th class="alinear_centro" width="10%">Opc.</th>
                <th class="alinear_centro" width="5%">Nro.</th>
                <th class="alinear_centro">Nombre</th>
                <th class="alinear_centro">Identificación</th>
                <th class="alinear_centro">Usuario</th>
                <th class="alinear_centro">Estado</th>
        	</tr>
        </thead><!-- Cabecera -->
        
        <!-- Cuerpo -->
        <tbody>
        	<?php
            //Contador
            $cont = 1;
            // Recorrido de los productos
            foreach ($usuarios_sistema as $usuario) {
            ?>
			<tr>
				<td>
                    <a href="javascript:editar_usuario(<?php echo $usuario->intCodigo; ?>)">
                        <span class="glyphicon glyphicon-edit icono"></span>            
                    </a>
                </td>
                <td class="alinear_derecha"><?php echo $cont; ?></td>
				<td><?php echo $usuario->strNombre; ?></td>
				<td><?php echo $usuario->Identificacion; ?></td>
				<td><?php echo $usuario->login; ?></td>
				<td><?php echo $estado = ($usuario->Estado == "1") ? "Activo" : "Inactivo" ; ?></td>
			</tr>
			<?php
            //Aumento de contador
            $cont++;
            } //Foreach
            ?>
    	</tbody><!-- Cuerpo -->
    </tabla><!-- Tabla -->
</div><!-- Tabla responsiva -->

<!-- Modal nuevo usuario -->
<div id="modal_nuevo_usuario" class="modal fade">
    <form id="form_usuario">
    	<div class="modal-dialog">
    		<div class="modal-content">
	    		<!-- Cabecera -->
	            <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h4 id="titulo_mensaje" class="modal-title">Gestión de usuarios</h4>
	            </div><!-- Cabecera -->

	            <!-- Cuerpo -->
	            <div class="modal-body">
					<!-- Container -->
					<div class="container">
						<div class="col-lg-6">
							<!-- Nombre del usuario -->
           	 				<label for="input_nombre" class="control-label">Nombre *</label>
							<input id="input_nombre" class="form-control input-sm" type="text" placeholder="Nombre completo" autofocus ><!-- Nombre del usuario -->
						</div>

						<div class="col-lg-6">
							<!-- Identificación del usuario -->
           	 				<label for="input_identificacion" class="control-label">Número de identificación *</label>
							<input id="input_identificacion" class="form-control input-sm" type="text" ><!-- Identificación del usuario -->
						</div>

						<div class="col-lg-6">
							<!-- Tipo de usuario -->
           	 				<label for="select_tipo" class="control-label">Tipo *</label>
           	 				<select id="select_tipo" class="form-control input-sm">
								<?php foreach ($tipos_usuario as $tipo) { ?>
                                    <?php
                                    $clase = "";

                                    //La opción tipo de usuario super administrador la debe tener solo el
                                    if($tipo->intCodigo == '3' && $this->session->userdata('tipo') != "3"){$clase = 'oculto';}
                                    ?>
			                        <option value="<?php echo $tipo->intCodigo; ?>" class="<?php echo $clase; ?>"><?php echo $tipo->strNombre; ?></option>
			                    <?php } ?>
	                        </select><!-- Tipo de usuario -->
						</div>

						<div class="col-lg-6">
							<!-- Estado del usuario -->
           	 				<label for="select_estado" class="control-label">Estado *</label>
           	 				<select id="select_estado" class="form-control input-sm">
           	 					<option value="1">Activo</option>
           	 					<option value="0">Inactivo</option>
	                        </select><!-- Estado del usuario -->
						</div>
					</div><!-- Container -->
					<p></p>

					<!-- Container -->
					<div class="container well">
						<div class="col-lg-4">
							<!-- Login del usuario -->
           	 				<label for="input_login" class="control-label">Usuario *</label>
							<input id="input_login" class="form-control input-sm" type="text" placeholder="Sin espacios" ><!-- Login del usuario -->
							<span id="mensaje_login"></span>
						</div>

						<div class="col-lg-4">
                            <!-- Contraseña del usuario -->
           	 				<label for="input_pass1" class="control-label">Contraseña *</label>
							<input id="input_pass1" class="form-control input-sm" type="password" /><!-- Contraseña del usuario -->
							<span id="mensaje_pass1"></span>
						</div>

						<div class="col-lg-4">
                            <!-- Contraseña del usuario -->
           	 				<label for="input_pass2" class="control-label">Repita la contraseña *</label>
							<input id="input_pass2" class="form-control input-sm" type="password" /><!-- Contraseña del usuario -->
							<span id="mensaje_pass2"></span>
						</div>
					</div><!-- Container -->
	        	</div><!-- Cuerpo -->

                <!-- Pie -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btn_guardar" class="btn btn-success">Guardar</button>
                </div><!-- Pie -->
            </div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</form>
</div><!-- Modal nuevo usuario -->

<script type="text/javascript">
    function editar_usuario(id_usuario){
        // Se pone el id del usuario
        $("#id_usuario").val(id_usuario);

        // Consultamos los datos del usuario específico
        dato_usuario = ajax("<?php echo site_url('cliente/cargar'); ?>", {'tipo': 'usuario_sistema', 'id_usuario': id_usuario}, "JSON");

        // Se ponen los datos 
        $("#input_nombre").val(dato_usuario.strNombre);
        $("#input_identificacion").val(dato_usuario.Identificacion);
        $('#select_tipo > option[value="' + dato_usuario.id_tipo_usuario + '"]').attr('selected', 'selected');
        $('#select_estado > option[value="' + dato_usuario.Estado + '"]').attr('selected', 'selected');
        $("#input_login").val(dato_usuario.login);
        // $("#input_pass1").val(dato_usuario.password);
        // $("#input_pass2").val(dato_usuario.password);

        //Se abre la ventana
        $('#modal_nuevo_usuario').modal('show');
    }

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Recolección de datos
		var estado = $("#select_estado");
        var identificacion = $("#input_identificacion").numericInput();
		var login = $("#input_login");
        var nombre = $("#input_nombre");
        var pass1 = $("#input_pass1");
        var pass2 = $("#input_pass2");
        var tipo = $("#select_tipo");

		// Inicialización de la tabla
        $('#productos').dataTable( {
            "bProcessing": true,
        }); // Tabla

		//Agregar usuarios
        $("#btn_agregar_usuario").on("click", function(){
            // Se quita el id del usuario
            $("#id_usuario").val(0);

            //Se limpia el formulario
            limpiar("#form_usuario");

            //Se abre la ventana
            $('#modal_nuevo_usuario').modal('show');
        });//Agregar usuarios

        //Guardar usuario
        $("#btn_guardar").on("click", function(){
            //Variable que me indica si usará paswoird a la hora de actualizar
            usar_password = '0';

            //Datos a validar
            datos_obligatorios = new Array(
            	nombre.val(),
            	identificacion.val(),
            	login.val()
            ); // datos

            //Se ejecuta la validación de los campos obligatorios
            validacion = validar_campos_vacios(datos_obligatorios);

            //Si no supera la validacíón
            if (!validacion) {
                //Se muestra el mensaje de error
                mostrar_mensaje('Aun no se ha completado el registro del usuario', 'Por favor diligencie todos los campos para poder completar el registro.');
            } else {
            	//Consultamos que el usuario no exista en la base de datos
        		usuario_existe = ajax("<?php echo site_url('cliente/consultar_usuario'); ?>", {'login': $.trim(login.val())}, "html");

                // Si no es actualización de usuario o si la contraseña se modifica, debe validar las contraseñas
                if ($("#id_usuario").val() == 0 || $.trim(pass1.val()) != "") {
                    //Si se tendrá en cuenta el password
                    usar_password = '1';

                    // Si la contraseña no es igual
                    if (pass1.val() != pass2.val()) {
                        //Se muestra el mensaje de error
                        mostrar_mensaje('Contraseñas diferentes', 'Las contraseñas no coinciden.');

                        // Se detiene el formulario
                        return false;
                    };
                } // if

            	//Arreglo JSON de datos a enviar posteriormente
	            datos_formulario = {
	            	"Estado": estado.val(),
	            	"id_empresa": "<?php echo $this->session->userdata('id_empresa'); ?>",
	            	"id_tipo_usuario": tipo.val(),
	            	"login": login.val(),
	            	"password": pass1.val(),
	            	"strNombre": nombre.val(),
	            	"Identificacion": identificacion.val()
	            };
	            // imprimir(datos_formulario);
                
                //  Si es para actualizar, o sea, tiene id de usuario
                if ($("#id_usuario").val() > 0) {
                    imprimir('Actualizando...');

                    // Se actualiza el usuario
                    actualizar = ajax("<?php echo site_url('cliente/actualizar_usuario_sistema') ?>", {'id_usuario': $("#id_usuario").val(), 'datos': datos_formulario, "usar_password": usar_password}, 'html');
                } else {
                    imprimir('Guardando...');

                    //Si el usuario existe
                    if(usuario_existe == "true"){
                        //Se muestra el mensaje de error
                        mostrar_mensaje('Usuario no disponible', 'El usuario ' + login.val() + ' ya está siendo usado. Por favor busque un nombre diferente.');

                        // Se detiene el formulario
                        return false;
                    } // if
                    
                    // Se procede a guardar el registro
                    ajax("<?php echo site_url('cliente/guardar') ?>", {'datos': datos_formulario, "tipo": "usuario_sistema"}, 'JSON');
                }
                
            	//Se cierra la ventana
                $('#modal_nuevo_usuario').modal('hide');

                //Cuando se termine de cerrar
                $('#modal_nuevo_usuario').on('hidden.bs.modal', function (e) {
                    //Cargamos la interfaz
		            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'usuario'});
                });
            }//if validacion

        	//Se detiene el formulario
            return false;
        });//Guardar usuario
	});//document.ready
</script>