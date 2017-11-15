<!-- Modal -->
<div id="modal_pass_crear" class="modal fade" >
	<form id="form_campana">
        <div class="modal-dialog">
            <div class="modal-content">
				<!-- Cabecera -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Contraseña del usuario</h4>
                </div><!-- Cabecera -->

                <!-- Cuerpo -->
                <div class="modal-body">
                	<!-- Container -->
                    <div class="container">
                    	<!-- Contraseña -->
	                    <div class="col-lg-6">
	                        <label for="input_password1" class="control-label">Digite la contraseña de inicio de sesión para ver su transferencia</label>
	                        <input id="input_password1" class="form-control input-sm" type="password">
	                    </div><!-- Contraseña -->

                    	<!-- Contraseña -->
	                    <div class="col-lg-6">
	                        <label for="input_password2" class="control-label">Digite la contraseña de inicio de sesión para ver su transferencia</label>
	                        <input id="input_password2" class="form-control input-sm" type="password">
	                    </div><!-- Contraseña -->
                    </div><!-- Container -->
                </div><!-- Cuerpo -->

                <!-- Pie -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" id="btn_crear">Guardar</button>
                </div><!-- Pie -->
        	</div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal -->

<script type="text/javascript">
	$(document).ready(function(){
        //Se abre la ventana
        $('#modal_pass_crear').modal('show');

        //Se cierra la ventana anterior
        $('#modal_mensaje').modal('hide');

        // Crear contraseña
        $("#btn_crear").on("click", function(){
	        // Recolección de datos
	        var password1 = $("#input_password1");
	        var password2 = $("#input_password2");

	  		//Datos a validar
	        datos_obligatorios = new Array(
	            password1.val(),
	            password2.val()
	        );
	        // imprimir(datos_obligatorios);

	        //Se ejecuta la validación de los campos obligatorios
	        validacion = validar_campos_vacios(datos_obligatorios);

	        //Si no supera la validacíón
	        if (!validacion) {
	            //Se muestra el mensaje de error
	            mostrar_mensaje('No se puede renovar la clave todavía', 'Por favor digite ambas contraseñas.');

	            return false;
	        } // if

	        



	  		return false;
        }); // clic
    });//document.ready
</script>