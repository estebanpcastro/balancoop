<p>
	<!-- Botón agregar pregunta -->
	<button onClick="javascript:crear()" type="button" class="btn btn-info btn-block">Agregar pregunta</button>
</p>

<!-- Contenedor donde se cargará la información -->
<p><div id="cont_tabla"></div></p>

<!-- Contenedor de modal -->
<p><div id="cont_modal"></div></p>

<script type="text/javascript">
	/**
	 * Función que se activa al presionar el botón crear del menú
	 * @return void 
	 */
	function crear()
	{
		// Se carga la interfaz
	    $("#cont_modal").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {"tipo": "preguntas_crear", "id": 0});
	} // crear

	/**
	 * Función de edición de registros
	 * @return void 
	 */
	function editar(id)
	{
		// Se carga la interfaz
	    $("#cont_modal").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {"tipo": "preguntas_crear", "id": id});
	} // editar

	/**
	 * Guardar en base de datos 
	 */
	function guardar(){
    	// Recolección de datos
    	var id_pregunta = $("#id_pregunta").val();
		var descripcion = $("#input_descripcion");

		// Arreglo de datos a validar
	    datos_obligatorios = new Array(
	    	descripcion.val()
    	);
    	// imprimir(datos_obligatorios);

    	//Se ejecuta la validación del nombre
        validacion = validar_campos_vacios(datos_obligatorios);

        // Si no supera la validacíón del nombre
        if (!validacion) {
            //Se muestra el mensaje de error
            mostrar_mensaje('Aun no se puede continuar', 'Por favor digite la pregunta.');

            return false;
        } // if

		// arreglo con los datos
	    datos = {
	    	"descripcion": descripcion.val(),
	    	"id_empresa": "<?php echo $this->session->userdata('id_empresa'); ?>"
	    }
	    // imprimir(datos);

	    // Si trae un id
	    if(id_pregunta){
	        // Se actualiza el registro
            id = ajax("<?php echo site_url('listas/actualizar'); ?>", {"tabla": "preguntas", "datos": datos, "campo": "intCodigo", 'id_campo':id_pregunta}, "JSON");
	    } else {
	    	id = ajax("<?php echo site_url('listas/guardar'); ?>", {"tabla": "preguntas", "datos": datos}, "JSON");
	    } // if
	    // imprimir(id);

	    //Se cierra la ventana
        $('#modal_pregunta').modal('hide');

        //Cuando se termine de cerrar
        $('#modal_pregunta').on('hidden.bs.modal', function (e) {
            //Se muestra el mensaje de exito
	        mostrar_mensaje('Registro exitoso', 'La pregunta se guardó exitosamente.');

	        // Se recarga la interfaz
	        listar();
        });
	} // guardar

	/**
	 * Listado de los registros
	 */
	function listar()
	{
		//Se muestra la barra de carga
		cargando($("#cont_tabla"));

		// Carga de interfaz
        $("#cont_tabla").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'preguntas_lista'});
	} // listar

	$(document).ready(function(){
        // De entrada, se listan los registros
        listar();
    }); 
</script>
