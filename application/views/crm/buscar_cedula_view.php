<form id="form_busqueda" role="search">
    <div class="form-group">
        <div class="col-sm-10">
            <input value="" id="input_busqueda" type="text" class="form-control" placeholder="Digite el número de cédula del cliente" autofocus>
        </div>
        <div class="col-sm-2s">
            <button type="submit" class="btn btn-default">Buscar cédula</button>
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
                mostrar_mensaje('Digite un número de cédula', 'Por favor digite un número de cédula.');

                // Retorna falso
                return false;
            }// if

            // Petición para buscar el documento
            asociado = ajax("<?php echo site_url('crm/buscar_asociado'); ?>", {'documento': busqueda.val(), 'id_empresa': "<?php echo $this->session->userdata('id_empresa'); ?>"}, 'json');
            // imprimir(asociado);

            // Si no se encontró
            if(asociado.id_asociado == 0){
                // Variable de no encontrado
                encontrado = "0";
            } else {
                // Variable de encontrado
                encontrado = "1";
            } // if

            /**
             * Cargamos la vista
             */
            $("#cont_tabla").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'crm_tabla_productos', encontrado: encontrado, asociado: asociado, documento: busqueda.val()});

            //Se muestra la barra de carga
            cargando($("#cont_tabla"));

            // Se detiene el formulario
            return false;
        });// form busqueda
    });//Document.ready
</script>