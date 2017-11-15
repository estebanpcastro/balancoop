<?php
// Se cargan los elementos de base de datos
$productos = $this->listas_model->cargar_productos();
$preguntas = $this->listas_model->cargar_preguntas();
?>

<p>
	<!-- Sólo los super administradores pueden crear-->
	<?php if ($this->session->userdata('tipo') == "3") { ?>
	    <!-- Botón agregar dato -->
	    <button onClick="javascript:crear()" type="button" class="btn btn-info btn-block">Crear encuesta</button>
	<?php } ?>
</p>

<div class="row">
	<div class="col-lg-6">
        <div class="form-group">
			<!-- Producto -->
			<select id="select_producto" class="form-control input-sm" autofocus>
			    <option value="0">Todos los productos...</option>

			    <!-- Se recorren los registros -->
			    <?php foreach ($productos as $producto) { ?>
			        <option value="<?php echo $producto->intCodigo; ?>"><?php echo $producto->strNombre; ?></option>
			    <?php } ?>
			</select><!-- Producto -->
		</div>
	</div>

	<div class="col-lg-6">
        <div class="form-group">
			<!-- Pregunta -->
			<select id="select_pregunta" class="form-control input-sm" autofocus>
			    <option value="0">Todas las preguntas...</option>

			    <!-- Se recorren los registros -->
			    <?php foreach ($preguntas as $pregunta) { ?>
			        <option value="<?php echo $pregunta->intCodigo; ?>"><?php echo $pregunta->descripcion; ?></option>
			    <?php } ?>
			</select><!-- Pregutna -->
		</div>
	</div>
</div>

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
	    $("#cont_modal").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {"tipo": "encuestas_crear", "id": 0});
	} // crear

	/**
	 * Guardar en base de datos 
	 */
	function guardar(){
    	// Recolección de datos
    	var id_encuesta = $("#id_encuesta").val();
    	var id_producto = $("#select_producto_encuesta");
    	var id_periodicidad = $("#select_periodicidad");
    	var id_pregunta = $("#select_pregunta_encuesta");
    	var dia_inicio = $("#select_dia_inicio");
    	var hora_inicio = $("#select_hora_inicio");

    	// Arreglo de datos a validar
	    datos_obligatorios = new Array(
	    	id_producto.val(),
	    	id_periodicidad.val(),
	    	dia_inicio.val(),
	    	hora_inicio.val()
    	);
    	// imprimir(datos_obligatorios);
    	
    	//Se ejecuta la validación del nombre
        validacion = validar_campos_vacios(datos_obligatorios);

        // Si no supera la validacíón del nombre
        if (!validacion) {
            //Se muestra el mensaje de error
            mostrar_mensaje('Aun no se puede continuar', 'Por favor digite los campos obligatorios.');

            return false;
        } // if

		// arreglo con los datos
	    datos = {
	    	"id_producto": id_producto.val(),
	    	"id_periodicidad": id_periodicidad.val(),
	    	"dia_inicio": dia_inicio.val(),
	    	"id_pregunta": id_pregunta.val(),
	    	"id_empresa": "<?php echo $this->session->userdata('id_empresa'); ?>",
	    	"hora_inicio": hora_inicio.val() + ":00:00"
	    }
	    imprimir(datos);

	    // Si trae un id
	    if(id_encuesta){
	        // Se actualiza el registro
            // id = ajax("<?php echo site_url('listas/actualizar'); ?>", {"tabla": "encuestas", "datos": datos, "campo": "intCodigo", 'id_campo':id_encuesta}, "JSON");
	    } else {
	    	// Se crea el registro
	    	id = ajax("<?php echo site_url('listas/guardar'); ?>", {"tabla": "encuestas", "datos": datos}, "JSON");
	    } // if
	    // imprimir(id);

	    //Se cierra la ventana
        $('#modal_encuesta').modal('hide');

        //Cuando se termine de cerrar
        $('#modal_encuesta').on('hidden.bs.modal', function (e) {
            //Se muestra el mensaje de exito
	        mostrar_mensaje('Registro exitoso', 'La encuesta se guardó exitosamente.');

	        // Se recarga la interfaz
	        listar();
        });
	} // guardar

	/**
	 * Listado de los registros
	 */
	function listar(id_producto = null)
	{
		//Se muestra la barra de carga
		cargando($("#cont_tabla"));

		// Carga de interfaz
        $("#cont_tabla").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {"tipo": "encuestas_lista", "id_producto": id_producto});
	} // listar

	$(document).ready(function(){
        // De entrada, se listan los registros
        listar();

        // Cuando se seleccione un producto
        $("#select_producto").on("change", function(){
        	// Si se ha seleccionado un producto
        	if ($(this).val() != "0") {
        		// Se listan las encuestas para el producto seleccionada
        		listar($(this).val());
        	}else{
        		// Se listan todas las encuestas
        		listar();
        	} // if
        }); // change producto
    }); 
</script>