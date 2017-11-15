<!-- Este modal crea las diferentes tipos de estructuras -->
<div id="modal_pesos" class="modal fade" >
    <!-- modal-content -->
    <div class="modal-dialog" style="width: 1020px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 id="titulo_mensaje" class="modal-title">Configuración de estructura</h4>
            </div>
            <div class="modal-body">
                <?php
                // Se reciben las variables por post
                $tipo = $this->input->post('tipo');
                $id_balance = $this->input->post('id_balance');
                $id_conector = $this->input->post('id_conector');

                // Se consultan las estructuras
                $estructuras = $this->balance_model->cargar_pesos($tipo, $id_balance, $id_conector);
                ?>
                <div class="container">
                    <?php
                    // Contador de pesos
                    $cont = 1;
                    $suma = 0;

                    // Se recorren las estructuras
                    foreach ($estructuras as $estructura) { ?>
                        <!-- Nombre -->
                        <div class="col-lg-5">
                            <input type="text" id="<?php echo $estructura->intCodigo; ?>" name="nombre<?php echo $cont; ?>" class="form-control input-sm" value="<?php echo $estructura->strNombre; ?>">
                        </div><!-- Nombre -->

                        <!-- Descripción -->
                        <div class="col-lg-6">
                            <input type="text" id="<?php echo $estructura->intCodigo; ?>" name="descripcion<?php echo $cont; ?>" class="form-control input-sm" value="<?php echo $estructura->descripcion; ?>">
                        </div><!-- Descripción -->
                        
                        <!-- Peso -->
                        <div class="col-lg-1">
                            <input id="<?php echo $estructura->intCodigo; ?>" name="peso<?php echo $cont; ?>" class="form-control input-sm" type="text" value="<?php echo $estructura->peso; ?>" >
                        </div><!-- Peso -->
                    <?php
                        $suma += $estructura->peso;
                        $cont ++;
                    }
                    $cont--;
                    ?>

                    <div class="col-lg-10"></div>

                    <div class="col-lg-2">
                        <center>
                            <a href="javascript:recalcular_pesos('<?php echo $cont; ?>')"  class="icono_balance" title="Recalcular">
                                <span class="glyphicon glyphicon-refresh"></span>    
                            </a>
                            <strong id="calculo"><?php echo $suma; ?></strong>
                        </center>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button id="btn_actualizar_pesos" type="button" class="btn btn-success" data-dismiss="modal">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    // Cuando el DOM esté listo
    $(document).ready(function(){
        // Se abre la ventana
        $('#modal_pesos').modal('show');

        // Actualizar pesos
        $("#btn_actualizar_pesos").on('click', function(){
            // Variables
            cont = "<?php echo $cont; ?>";
            tipo = "<?php echo $tipo; ?>";
            id_conector = "<?php echo $id_conector; ?>";
            id_balance = "<?php echo $id_balance; ?>";
            suma = 0;

            //Recorrido para sumar cada registro
            for (var i = 1; i <= cont; i++){
                // Variables
                var peso = $("input[name='peso"+i+"']");

                // Se realiza la suma con los nuevos valores
                suma = parseInt(suma) + parseInt(peso.val());
            };

            //Recorrido para guardar cada registro
            for (var i = 1; i <= cont; i++){
                // Variables
                var peso = $("input[name='peso"+i+"']");
                var nombre = $("input[name='nombre"+i+"']");
                var descripcion = $("input[name='descripcion"+i+"']");

                // Si el peso supera 100
                if(suma > 100){
                    //Se muestra el mensaje de error
                    mostrar_mensaje('No se puede actualizar', 'El peso total es de ' + suma + '. Recuerde que no debe superar 100.');

                    // Se detiene el formulario
                    return false;
                }

                datos_formulario = {
                    'peso': peso.val(),
                    'strNombre': nombre.val(),
                    'descripcion': descripcion.val()
                }
                // imprimir(datos_formulario);

                // Se actualiza el peso vía ajax
                actualizar = ajax("<?php echo site_url('balance/actualizar_peso'); ?>", {'id_estructura': peso.attr('id'), 'datos': datos_formulario}, "html");

                //Se cierra la ventana
                $('#modal_pesos').modal('hide');

                //Cuando se termine de cerrar
                $('#modal_pesos').on('hidden.bs.modal', function (e) {
                    //Dependiendo del tipo, se recargará la interfaz
                    if(tipo == 'C'){
                        //Cargamos las categorías del año seleccionado
                        $("#cont_categorias").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: "balance_categorias", anio: $("#select_anio").val(), id_oficina: $("#select_oficina").val()});
                    } else if(tipo == 'D'){
                        //Cargamos la interfaz
                        $("#cont_dimension" + id_conector).load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'balance_dimensiones', id_categoria: id_conector, anio: $("#select_anio").val(), id_oficina: $("#select_oficina").val(), id_balance: id_balance});
                    } else if(tipo == 'V'){
                        //Cargamos la interfaz
                        $("#cont_variable" + id_conector).load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'balance_variables', id_dimension: id_conector, anio: $("#select_anio").val(), id_oficina: $("#select_oficina").val(), id_balance: id_balance});
                    }
                });

                //Falta ir sumando los pesos
                // imprimir(actualizar)
                
            };
            return false;
        });
    }); // document.ready
</script>