<!-- Nombre -->
<div class="col-lg-6">
    <input id="input_nombre" class="form-control input-sm" type="text" placeholder="Nombre del documento (obligatorio)"  autofocus/><!-- Nombre -->
</div><!-- Nombre -->

<!-- Subir -->
<div class="col-lg-6">
	<input type="button" id="subir_documento" class="btn btn-info btn-block" value="Seleccionar archivo y subir" disabled />
</div><!-- Subir -->
<div class="clear"></div>
<br>

<!-- Botón de subida -->
<div id="documentos_subidos"></div>

<script type="text/javascript">
	$(document).ready(function(){
		//Se carga la lista con documentos subidos
    	$("#documentos_subidos").load("<?php echo site_url('cliente/listar_documentos') ?>", {'id_asociado': "<?php echo $id_asociado; ?>"});

    	/**
    	 * Cuando digiten nombre
    	 */
    	$("#input_nombre").on("keyup", function(){
    		// Si ha escrito algo
    		if ($.trim($(this).val()).length > 0) {
    			// Se activa el botón
    			$('#subir_documento').removeAttr("disabled")
    		}else{
    			// Se desactiva el botón
    			$('#subir_documento').attr("disabled", true)
    		}// if
    	}); // fin keyup

		//Se prepara la subida del archivo
		new AjaxUpload('#subir_documento', {
			action: '<?php echo site_url("cliente/subir_documento"); ?>',
			type: 'POST',
			data: {id_asociado: "<?php echo $id_asociado; ?>", nombre: $("#input_nombre").val()},
			onSubmit : function(file , ext){
				//Se valida la extension del archivo
				if (!(ext && /^(pdf|PDF|jpg|jpeg|png)$/.test(ext))){
					//Se muestra el error
                    mostrar_mensaje('Archivo no válido', 'El archivo que está tratando de subir no es permitido. Por favor suba un documento PDF o una imagen en formato JPG o PNG.');
			      	return false;
				} else {
					//Se muestra la barra de carga
            		cargando($("#documentos_subidos"));
				}// if
			}, // onsubmit
			onComplete: function(file, respuesta){
				//Si se subió
				if(respuesta == "true"){
					//Se carga la lista con documentos subidos
	    			$("#documentos_subidos").load("<?php echo site_url('cliente/listar_documentos') ?>", {'id_asociado': "<?php echo $id_asociado; ?>"});
				} else {
					//Se muestra el error
                    mostrar_mensaje('Documento no subido', 'No se pudo subir el documento.');
			      	return false;
			      } // if
			} // oncomplete
		}); // AjaxUpload

		
	});
</script>