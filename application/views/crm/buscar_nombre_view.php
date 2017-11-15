<form id="form_busqueda" role="search">
    <div class="form-group">
        <div class="col-sm-10">
            <input value="" id="input_busqueda" type="text" class="form-control" placeholder="Digite el nombre completo o parcial" autofocus>
        </div>
        <div class="col-sm-2s">
            <button type="submit" class="btn btn-default">Buscar</button>
        </div>
    </div>
</form>

<!-- Contenedor -->
<div id="cont_tabla"></div>

<script type="text/javascript">
    $(document).ready(function(){
        // Declaración de variables
        var busqueda = $("#input_busqueda");

        /**
         * Cuando se busque la cédula
         */
        $("#form_busqueda").on("submit", function(){
        	//Validar que se haya escrito algo
            if($.trim(busqueda.val()) == ""){
            	//Se muestra el mensaje de error
                mostrar_mensaje('Escriba alguna palabra', 'Por favor escriba un nombre parcial o completo para realizar la búsqueda.');

                return false;
            }// if

            /**
	         * Cargamos la vista
	         */
	        $("#cont_tabla").load("listas/cargar_interfaz", {tipo: 'crm_tabla_nombres', nombre: busqueda.val()});

	        //Se muestra la barra de carga
            cargando($("#cont_tabla"));

            // Petición para buscar el nombre
            // asociado = ajax("<?php echo site_url('crm/buscar_asociado_nombre'); ?>", {'nombre': busqueda.val()}, 'json');
            // imprimir(asociado);


        	// Se detiene el formulario
            return false;
        });// form busqueda
    });//Document.ready
</script>