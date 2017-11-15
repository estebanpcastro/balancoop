<!-- Opciones de filtros -->
<center>
    <div class="btn-group btn-group-sm">
        <button type="button" class="btn btn-default" onClick="javascript:cargar('asociados')">Asociados</button>
        <button type="button" class="btn btn-default" onClick="javascript:cargar('productos')">Productos</button>
    </div>
<center>

<!-- Contenedor de filtro -->
<p><div id="cont_filtro"></div></p>

<!-- Contenedor donde se cargará la información -->
<p><div id="cont_tabla"></div></p>

<!-- Contenedor de modal -->
<p><div id="cont_modal"></div></p>

<script type="text/javascript">
	/**
	 * Función que carga los filtros
	 * @return void 
	 */
	function cargar(tipo)
	{
		//Se muestra la barra de carga
        cargando($("#cont_filtro"));

		// Se carga la interfaz
        $("#cont_filtro").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: "filtro_" + tipo});
	} // cargar
	
	/**
	 * Función que carga los datos básicos
	 * @return void 
	 */
	function cargar_datos_basicos()
	{
		// Se cargan los datos básicos
	    $("#cont_datos_basicos").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {"tipo": "filtro_datos_basicos", "id": $("#id_filtro").val()});
	} // cargar

	/**
	 * Función que se activa al presionar el botón crear del menú
	 * @return void 
	 */
	function crear(tipo)
	{
		// Se carga la interfaz
	    $("#cont_modal").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {"tipo": "filtro_" + tipo + "_crear", "id": 0});

	} // crear

	/**
	 * Función que se activa al presionar el botón editar del menú
	 * @return void 
	 */
	function editar(tipo, id)
	{
		// Se carga la interfaz
	    $("#cont_modal").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {"tipo": "filtro_" + tipo + "_crear", "id": id});
	} // editar

	/**
	 * Guardar en base de datos 
	 */
	function guardar(tipo){
    	// Recolección del id
    	var id_filtro = $("#id_filtro").val();
		var nombre = $("#input_nombre_filtro");
        var filtro_cliente = $("#select_filtro_cliente");
        var filtro_sistema = $("#select_filtro_sistema");
        var busqueda_rapida = $("#select_busqueda_rapida");
		var por_defecto = $("#check_por_defecto");
        var privado = 0;
        var activo = 0;

    	/********************************************************************
        *************************** Datos básicos ***************************
        ********************************************************************/
    	// Arreglo de datos a validar
	    datos_basicos_obligatorios = new Array(
	    	nombre.val()
    	);
    	// imprimir(datos_basicos_obligatorios);

    	//Se ejecuta la validación del nombre
        validacion = validar_campos_vacios(datos_basicos_obligatorios);

        // Si no supera la validacíón del nombre
        if (!validacion) {
            //Se muestra el mensaje de error
            mostrar_mensaje('Aun no se ha guardado el filtro', 'Por favor digite un nombre para este filtro.');

            return false;
        } // if

        // Verificaremos que haya seleccionado algún select
        if(busqueda_rapida.val() == "0" && filtro_cliente.val() == "0" && filtro_sistema.val() == "0"){
            //Se muestra el mensaje de error
            mostrar_mensaje('Advertencia', 'El filtro debe ser de cliente, de sistema o de búsqueda rápida. Seleccione al menos una opción, por favor.');

            return false;
        } // if

        //Se verifica si será privado o público
        if ($("#check_privado").is(':checked')) {
            var privado = 1;
        } // if

	    //Se verifica si está activo o no
        if ($("#check_activo").is(':checked')) {
            var activo = 1;
        } // if

		// Suiche de validaciones
		switch(tipo) {
			// Asociados
		    case "asociados":
		    	/********************************************************************
		        ****************************** Campos *******************************
		        ********************************************************************/
		    	// Arreglo de datos a validar
			    datos_campos_obligatorios = new Array(
			    	$("#select_campo1").val()
		    	);

		    	//Se ejecuta la validación de los campos obligatorios
    			validacion = validar_campos_vacios(datos_campos_obligatorios);

    			//Si no supera la validacíón
			    if (!validacion) {
			        //Se muestra el mensaje de error
                	mostrar_mensaje('Aun no se ha guardado el filtro', 'Por favor, seleccione al menos el primer campo');

			        return false;
			    } // if

    			/********************************************************************
		        *************************** Condicionales ***************************
		        ********************************************************************/
				// Arreglo de datos a validar
			    datos_campos_obligatorios = new Array(
			    	$("#select_campo_condicion1").val(),
			    	$("#select_condicion1").val()
		    	);

		    	//Se ejecuta la validación de los campos obligatorios
    			validacion = validar_campos_vacios(datos_campos_obligatorios);

    			//Si no supera la validacíón
			    if (!validacion) {
			        //Se muestra el mensaje de error
                	mostrar_mensaje('Aun no se ha guardado el filtro', 'Por favor, configure al menos una condición (campo, condición y detalle).');

			        return false;
			    } // if

	            // Se recorren las condiciones para verificar que estén llenas
    			for (var i = 1; i <= $("#total_condiciones").val(); i++) {
    				// Si el campo tiene información
    				if ($("#select_campo_condicion" + i).val() != "") {
    					// Si no ha elegido una condición
    					if ($("#select_condicion" + i).val() == "") {
    						//Se muestra el mensaje de error
        					mostrar_mensaje('No se ha podido continuar', "La condición para el campo " + i + " (" + $("#select_campo_condicion" + i + " option:selected").text() + ") no se ha configurado todavía.");

        					return false;
    					};
    				} // if
    			} // for
        	break; // Asociados

        	// Productos
		    case "productos":
		    	// Recolección de datos
			    var id_condicion = $("#select_filtro_condicion");
			    var id_producto = $("#select_filtro_producto");
			    var id_genero = $("#select_filtro_genero");

			    // Arreglo de datos a validar
			    datos_obligatorios = new Array(
					id_condicion.val(),
					id_producto.val(),
					id_genero.val()
		    	);
		    	// imprimir(datos_obligatorios);
		    	
		    	//Se ejecuta la validación de los campos obligatorios
    			validacion = validar_campos_vacios(datos_obligatorios);

    			//Si no supera la validacíón
			    if (!validacion) {
			        //Se muestra el mensaje de error
                	mostrar_mensaje('Aun no se ha guardado el filtro', 'Por favor, seleccione condición, producto y género');

			        return false;
			    } // if
        	break; // Productos
		} // suiche

		// arreglo con los datos
	    datos = {
	        "strNombre": nombre.val(),
			// "es_reporte": ,
			"es_sistema": filtro_sistema.val(),
			"es_cliente": filtro_cliente.val(),
			"busqueda_rapida": busqueda_rapida.val(),
			"id_asociado": "<?php echo $this->session->userdata('id_usuario'); ?>",
			"privado": privado,
			"Estado": activo,
			"id_usuario": "<?php echo $this->session->userdata('id_usuario'); ?>",
			// "id_Filtro_balance": ,
			// "id_campo_balance": 
	    }
	    // imprimir(datos);

	    // Si trae un id
	    if(id_filtro){
	        // Se actualiza el filtro
            ajax("<?php echo site_url('filtros/actualizar'); ?>", {"tipo": "filtro", "datos": datos, 'id':id_filtro}, "JSON");
            
            // Arreglo con el id del filtro
            id = {"id_filtro": id_filtro}

            // Se borran los campos y condiciones del filtro creado
            ajax("<?php echo site_url('filtros/actualizar'); ?>", {"tipo": "borrar", 'id': id_filtro}, "html");
	    } else {
	    	//Se invoca la petición ajax que guardará el filtro
        	id = ajax("<?php echo site_url('filtros/guardar'); ?>", {"tipo": "filtro", "datos": datos}, "JSON");
	    } // if
	    // imprimir(id.id_filtro);

    	// Si por defecto está chequeado
        if (por_defecto.is(':checked')) {
            //Actualizamos el filtro del usuario por defecto vía ajax
            ajax("<?php echo site_url('filtros/cambiar_filtro_por_defecto'); ?>", {'id_filtro': id.id_filtro}, 'html');
        } // if

		// Después de validados, si es filtro de asociados
    	if (tipo == "asociados") {
    		// Se recorren los campos
			for (var i = 1; i <= $("#total_campos").val(); i++) {
				// Si el campo tiene información
				if ($("#select_campo" + i).val() != "") {
					// Datos a guardar
					datos_campo = {
                        'id_filtro': id.id_filtro,
                        'id_filtro_campo': $("#select_campo" + i).val()
					}

					// Se guarda en base de datos
                    ajax("<?php echo site_url('filtros/guardar') ?>", {'datos': datos_campo, "tipo": "campo"}, 'html');
				} // if
			} // for

			// Se recorren las condiciones para guardar
			for (var i = 1; i <= $("#total_condiciones").val(); i++) {
				// Si el campo tiene información
				if ($("#select_campo_condicion" + i).val() != "") {
					// Datos a guardar
					datos_condicional = {
                        'id_filtro': id.id_filtro,
                        'id_filtro_campo': $("#select_campo_condicion" + i).val(),
                        'id_filtro_condicion': $("#select_condicion" + i).val(),
                        'detalle': $("#input_detalle" + i).val(),
					}
					// imprimir(datos_condicional);
					
					// Se inserta cada condicional
                    ajax("<?php echo site_url('filtros/actualizar') ?>", {"tipo": "condicional", 'datos': datos_condicional, 'id':id.id_filtro}, 'html');
				} // if
			} // for
    	} // if

		// Después de validados, si es filtro de asociados

    	if (tipo == "productos") {
			// arreglo con los datos
		    datos_producto = {
	            'id_filtro': id.id_filtro,
	            'contiene': id_condicion.val(),
	            'id_producto': id_producto.val(),
	            'id_genero': id_genero.val()
		    }
    		// imprimir(datos_producto);

		    // Si trae un id
		    if(id_filtro){
	        	// Se elimina el el detalle del filtro producto
	        	ajax("<?php echo site_url('filtros/borrar_datos_filtro_producto') ?>", {'id':id.id_filtro}, 'html')
		    } // if

		    // Se guarda el filtro de producto
        	ajax("<?php echo site_url('filtros/guardar'); ?>", {"tipo": "producto", "datos": datos_producto}, "JSON");
    	} // if

		//Se cierra la ventana
        $('#modal_filtro').modal('hide');

        //Cuando se termine de cerrar
        $('#modal_filtro').on('hidden.bs.modal', function (e) {
            //Se muestra el mensaje de exito
	        mostrar_mensaje('Registro exitoso', 'El filtro se guardó exitosamente.');

	        // Se recarga la interfaz
	        cargar(tipo);
        });
	} // guardar

	/**
	 * Listado de los registros
	 */
	function listar(tipo)
	{
		//Se muestra la barra de carga
		cargando($("#cont_tabla"));

		// Carga de interfaz
        $("#cont_tabla").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'filtros_' + tipo + '_lista'});
	} // listar

    // Cuando el DOM esté listo
    $(document).ready(function(){
    	//De entrada. cargamos la interfaz de filtros de asociado
        cargar("asociados");
    });//document.ready
</script>