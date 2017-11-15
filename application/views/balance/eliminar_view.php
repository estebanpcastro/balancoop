<!-- Este modal elimina las diferentes tipos de estructuras -->
<div id="modal_eliminar_estrcturas" class="modal fade" >
    <!-- modal-content -->
    <div class="modal-dialog" style="width: 1020px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 id="titulo_mensaje" class="modal-title">Eliminación de estructura</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="tipo_eliminar">
                <input type="hidden" id="id_estructura_eliminar">

                <?php
                // Se reciben las variables por post
                $tipo = $this->input->post('tipo');
                $id_balance = $this->input->post('id_balance');
                $id_conector = $this->input->post('id_conector');

                // Se consultan las estructuras
                $estructuras = $this->balance_model->cargar_pesos($tipo, $id_balance, $id_conector);
                ?>
                <p>Seleccione la estructura que desea eliminar:</p>
                <!-- Listado de estructuras -->
                <ul>
                    <?php foreach ($estructuras as $estructura) { ?>
                        <li id="estructura<?php echo $estructura->intCodigo; ?>" onclick="javascript:eliminar_estructura('<?php echo $tipo ?>', '<?php echo $estructura->intCodigo; ?>', '<?php echo $estructura->strNombre; ?>')" style="cursor:pointer" ><?php echo $estructura->strNombre; ?></li>
                    <?php } ?>
                </ul><!-- Listado de estructuras -->
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Este modal elimina las diferentes tipos de estructuras -->
<div id="modal_eliminar" class="modal fade" >
    <!-- modal-content -->
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 id="titulo_mensaje" class="modal-title">¿Eliminar?</h4>
            </div>
            <div class="modal-body">
                <p>¿Está seguro que desea eliminar <strong id="estructura_eliminar"></strong> y todo lo que se asocie a este?</p>
            </div>

            <div class="modal-footer">
                <button id="btn_eliminar" type="button" class="btn btn-success" data-dismiss="modal">Si</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No, cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    function eliminar_estructura(tipo, id_estructura, nombre){
        // Se pone el nombre y los demás datos
        $("#estructura_eliminar").text(nombre);
        $("#tipo_eliminar").val(tipo);
        $("#id_estructura_eliminar").val(id_estructura);

        // Se abre el modal con el mensaje
        $('#modal_eliminar').modal('show');
    } //eliminar_estructura

    // Cuando el DOM esté listo
    $(document).ready(function(){
        // Se abre la ventana
        $('#modal_eliminar_estrcturas').modal('show');

        // Al dar clic 
        $("#btn_eliminar").on("click", function(){
            // Dependiento del tipo
            if ($("#tipo_eliminar").val() == 'C') {
                // Eliminaremos vía ajax las categorías, dimensiones y variables que se asocien
                eliminar = ajax("<?php echo site_url('balance/eliminar'); ?>", {tipo: 'C', id_estructura: $("#id_estructura_eliminar").val()}, "html");

                // Si lo eliminó
                if(eliminar == 'true'){
                    // Se oculta la categoría
                    $("#estructura" + $("#id_estructura_eliminar").val()).hide('slow');

                    //Cargamos las categorías del año seleccionado
                    $("#cont_categorias").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: "balance_categorias", anio: $("#select_anio").val(), id_oficina: $("#select_oficina").val()});
                }
            };

            if ($("#tipo_eliminar").val() == 'D') {
                // Eliminaremos la dimensión y variables asociadas
                eliminar = ajax("<?php echo site_url('balance/eliminar'); ?>", {tipo: 'D', id_estructura: $("#id_estructura_eliminar").val()}, "html");

                // Si lo eliminó
                if(eliminar == 'true'){
                    // Se oculta la categoría
                    $("#estructura" + $("#id_estructura_eliminar").val()).hide('slow');

                    $("#cont_dimension" + "<?php echo $id_conector; ?>").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'balance_dimensiones', id_categoria: $("#id_estructura_eliminar").val(), anio: $("#select_anio").val(), id_oficina: $("#select_oficina").val(), id_balance: "<?php echo $id_balance; ?>"});
                }
            };

            if ($("#tipo_eliminar").val() == 'V') {
                // Eliminaremos la variable
                eliminar = ajax("<?php echo site_url('balance/eliminar'); ?>", {tipo: 'V', id_estructura: $("#id_estructura_eliminar").val()}, "html");

                // Si lo eliminó
                if(eliminar == 'true'){
                    // Se oculta la categoría
                    $("#estructura" + $("#id_estructura_eliminar").val()).hide('slow');

                    $("#cont_variable" + "<?php echo $id_conector; ?>").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'balance_variables', id_dimension: "<?php echo $id_conector; ?>", anio: $("#select_anio").val(), id_oficina: $("#select_oficina").val(), id_balance: "<?php echo $id_balance; ?>"});
                }

            }


        });
    }); // document.ready
</script>