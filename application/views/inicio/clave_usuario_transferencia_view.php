<!-- Modal -->
<div id="modal_pass" class="modal fade">
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
	                    <div class="col-lg-12">
	                        <label for="input_clave" class="control-label">Digite la contraseña de inicio de sesión para ver su transferencia</label>
	                        <input id="input_clave" class="form-control input-sm" type="password">
	                    </div><!-- Contraseña -->
                    </div><!-- Container -->
                </div><!-- Cuerpo -->

                <!-- Pie -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" id="btn_pass">Guardar</button>
                </div><!-- Pie -->
        	</div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal -->

<script type="text/javascript">
	$(document).ready(function(){
        //Se abre la ventana
        $('#modal_pass').modal('show');

        //Guardar oportunidad
        $("#btn_pass").on("click", function(){
	        //Recolección de datos
	        var clave = $("#input_clave");

	        //Datos a validar
            datos_obligatorios = new Array(
                clave.val()
            );
            // imprimir(datos_obligatorios);

            //Se ejecuta la validación de los campos obligatorios
            validacion = validar_campos_vacios(datos_obligatorios);

	        // Si no supera la validacíón
            if (!validacion) {
                //Se muestra el mensaje de error
                mostrar_mensaje('No ha digitado la contraseña', 'Por favor digite la contraseña para poder generar la transferencia.');

                return false;
            } // if

			validacion_clave = ajax("<?php echo site_url('inicio/validar_clave_transferencia'); ?>", {"documento": "<?php echo $documento; ?>", "id_empresa": "<?php echo $id_empresa; ?>", "clave": clave.val()}, "HTML");
            // imprimir(validacion_clave);
			
			// Si no coinciden los datos de la clave con el usuario y la empresa
			if (!validacion_clave) {
                $("#id_asociado_transferencia").val("<?php echo $id_asociado; ?>");

				//Se muestra el mensaje de error
                mostrar_mensaje('No se puede generar la transferencia','La contraseña no coincide. Si no la recuerda o desea crearla, por favor <a onClick="javascript:crear_clave()" style="cursor: pointer">haga clic aquí</a>.');

                return false;
			} // if

			// //Se redirecciona
            redireccionar("<?php echo site_url('transferencia/index'); ?>" + "/" + "<?php echo $id_empresa; ?>" + "/" + "<?php echo $id_oficina; ?>" + "/" + "<?php echo $documento; ?>" + "/get/");
			
			return false;
        }); // clic
    });//document.ready
</script>
