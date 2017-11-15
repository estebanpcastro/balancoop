<?php
//Se cargan los elementos de base de datos
$categorias = $this->listas_model->cargar('productos_categorias');
$lineas = $this->listas_model->cargar('productos_lineas');
$productos = $this->listas_model->cargar_productos();
$proveedores = $this->listas_model->cargar_proveedores();
?>

<!-- Si el usuario no es responsable -->
<?php if ($this->session->userdata('tipo') != "2") { ?>
    <!-- Botón agregar producto -->
    <button id="btn_agregar_producto" type="button" class="btn btn-info btn-block">Agregar producto</button>
<?php } ?>
<br>

<input type="hidden" id="input_id_producto">

<!-- Tabla responsiva -->
<div class="table-responsive">
    <!-- Tabla -->
    <table id="productos" class="table">
        <!-- Cabecera -->
        <thead>
            <tr>
                <th class="alinear_centro" width="10%">Opc.</th>
                <th class="alinear_centro" width="5%">Id</th>
                <th class="alinear_centro">Nombre</th>
                <th class="alinear_centro">Proveedor</th>
                <th class="alinear_centro">Línea</th>
                <th class="alinear_centro">Categoría</th>
                <th class="alinear_centro">Estado</th>
            </tr>
        </thead><!-- Cabecera -->
        <!-- Cuerpo -->
        <tbody>
            <?php
            //Contador
            $cont = 1;

            // Recorrido de los productos
            foreach ($productos as $producto) {
            ?>
                <tr>
                    <td>
                        <a href="javascript:editar(<?php echo $producto->intCodigo; ?>)" title="Editar producto" class="icono">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a> 
                    </td>
                    <td class="text-right"><?php echo $producto->intCodigo; ?></td>
                    <td><?php echo $producto->strNombre; ?></td>
                    <td><?php echo $producto->Proveedor; ?></td>
                    <td><?php echo $producto->Linea; ?></td>
                    <td><?php echo $producto->Categoria; ?></td>
                    <td><?php if($producto->Estado == '1'){echo "Activo";}else{echo "Inactivo";} ?></td>
                </tr>
            <?php
            //Aumento de contador
            $cont++;
            } //Foreach
            ?>
        </tbody><!-- Cuerpo -->
    </table><!-- Tabla -->
</div><!-- Tabla responsiva -->

<!-- Modal nuevo producto -->
<div id="modal_nuevo_producto" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <!-- Cabecera -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Agregar nuevo producto</h4>
                </div><!-- Cabecera -->

                <!-- Cuerpo -->
                <div class="modal-body">
                    <!-- Container -->
                    <div class="container">
                        <div class="col-lg-12">
                            <!-- Nombre del producto -->
                            <label for="input_nombre" class="control-label">Nombre del producto *</label>
                            <input id="input_nombre" class="form-control input-sm" type="text" placeholder="Obligatorio" autofocus ><!-- Nombre del producto -->
                        </div>

                        <div class="col-lg-6">
                            <!-- Estado del producto -->
                            <label for="select_estado" class="control-label">Estado</label>
                            <select id="select_estado" class="form-control input-sm">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                            <!-- Estado del producto -->
                        </div>


                        <div class="col-lg-6">
                            <!-- Proveedor del producto -->
                            <label for="select_proveedor" class="control-label">Proveedor</label>
                            <select id="select_proveedor" class="form-control input-sm">
                                <option value="0">Seleccione...</option>
                                <?php foreach ($proveedores as $proveedor) { ?>
                                    <option value="<?php echo $proveedor->intCodigo; ?>"><?php echo $proveedor->strNombre; ?></option>
                                <?php } ?>
                            </select><!-- Proveedor del producto -->
                        </div>
                            
                        <div class="col-lg-6">
                            <!-- Valor del producto -->
                            <label for="input_valor" class="control-label">Valor</label>
                            <input id="input_valor" class="form-control input-sm" type="text" ><!-- Valor del producto -->
                        </div>

                        <div class="col-lg-6">
                            <!-- Transferencia del producto -->
                            <label for="input_transferencia" class="control-label">Transferencia</label>
                            <input id="input_transferencia" class="form-control input-sm" type="text" ><!-- Transferencia del producto -->
                        </div>

                        <div class="col-lg-6">
                            <!-- Línea del producto -->
                            <label for="select_linea" class="control-label">Línea</label>
                            <select id="select_linea" class="form-control input-sm">
                                <option value="">Seleccione...</option>
                                <?php foreach ($lineas as $linea) { ?>
                                    <option value="<?php echo $linea->intCodigo; ?>"><?php echo $linea->strNombre; ?></option>
                                <?php } ?>
                            </select><!-- Línea del producto -->
                        </div>

                        <div class="col-lg-6">
                            <!-- Categoría del producto -->
                            <label for="select_categoria" class="control-label">Categoría</label>
                            <select id="select_categoria" class="form-control input-sm">
                                <option value="">Seleccione...</option>
                                <?php foreach ($categorias as $categoria) { ?>
                                    <option value="<?php echo $categoria->intCodigo; ?>"><?php echo $categoria->strNombre; ?></option>
                                <?php } ?>
                            </select><!-- Categoría del producto --> 
                        </div>
                    </div><!-- Container -->
                    <br>

                    <!-- Container -->
                    <div class="container">
                        <div class="col-lg-6 well">
                            <label for="select_habilidad1" class="control-label">Asociado de enero 1 a diciembre 31 de <?php echo date("Y")-1; ?></label>
                            <select id="select_habilidad1" class="form-control input-sm">
                                <option value="0">Inactivo</option>
                                <option value="1">Activo</option>
                            </select>
                        </div>

                        <!-- <div class="col-lg-6 well">
                            <label for="select_habilidad2" class="control-label">Asociado de antiguedad 1 año fecha de inicio producto</label>
                            <select id="select_habilidad2" class="form-control input-sm">
                                <option value="0">Inactivo</option>
                                <option value="1">Activo</option>
                            </select>
                        </div> -->

                        <div class="col-lg-6 well">
                            <label for="input_habilidad3" class="control-label">Compras desde enero 1 hasta diciembre 31 de <?php echo date("Y")-1; ?></label>
                            <input id="input_habilidad3" class="form-control input-sm" type="text" placeholder="En salarios mínimos" >
                        </div>
                        
                        <div class="col-lg-6 well">
                            <label for="input_habilidad4" class="control-label">Compras en el último trimestre</label><br><br>
                            <input id="input_habilidad4" class="form-control input-sm" type="text" placeholder="En salarios mínimos" >
                        </div>
                        
                        <div class="col-lg-6 well">
                            <label for="input_habilidad5" class="control-label">Compras de fecha de inicio del producto un año atrás</label>
                            <input id="input_habilidad5" class="form-control input-sm" type="text" placeholder="En salarios mínimos" >
                        </div>
                        
                        <div class="col-lg-6 well">
                            <label for="select_habilidad6" class="control-label">Que sea asociado</label><br><br>
                            <select id="select_habilidad6" class="form-control input-sm">
                                <option value="0">No</option>
                                <option value="1">Si</option>
                            </select>
                        </div>
                    </div><!-- Container -->
                </div><!-- Cuerpo -->

                <!-- Pie -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btn_guardar_producto" class="btn btn-success">Guardar</button>
                </div><!-- Pie -->
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- Modal nuevo producto -->

<script type="text/javascript">
    function editar(id){
        // Se pone el id del producto
        $("#input_id_producto").val(id);

        // Consultamos los datos del producto específico
        dato_producto = ajax("<?php echo site_url('listas/cargar_producto'); ?>", {id_producto: id}, "JSON");

        // Se ponen los datos 
        $("#input_nombre").val(dato_producto.strNombre);
        $('#select_proveedor > option[value="' + dato_producto.id_proveedor + '"]').attr('selected', 'selected');
        $('#select_estado > option[value="' + dato_producto.Estado + '"]').attr('selected', 'selected');
        $("#input_valor").val(dato_producto.valor);
        $("#input_transferencia").val(dato_producto.transferencia);
        $('#select_linea > option[value="' + dato_producto.id_linea + '"]').attr('selected', 'selected');
        $('#select_categoria > option[value="' + dato_producto.id_categoria + '"]').attr('selected', 'selected');

        //Habilidades
        $('#select_habilidad1 > option[value="' + dato_producto.habilidad1_es + '"]').attr('selected', 'selected');
        $('#select_habilidad2 > option[value="' + dato_producto.habilidad2_es + '"]').attr('selected', 'selected');
        $("#input_habilidad3").val(dato_producto.habilidad3);
        $("#input_habilidad4").val(dato_producto.habilidad4);
        $("#input_habilidad5").val(dato_producto.habilidad5);
        $('#select_habilidad6 > option[value="' + dato_producto.habilidad6_es + '"]').attr('selected', 'selected');

        //Se abre la ventana
        $('#modal_nuevo_producto').modal('show');
    }

    $(document).ready(function(){
        // Inicialización de la tabla
        $('#productos').dataTable( {
            "bProcessing": true,
        }); // Tabla

        //Agregar producto
        $("#btn_agregar_producto").on("click", function(){
            // Se quita el id del usuario
            $("#input_id_producto").val(0);

            //Se abre la ventana
            $('#modal_nuevo_producto').modal('show');
        });//Agregar producto

        //Recolección de datos
        var id_proveedor = $("#select_proveedor");
        var estado = $("#select_estado");
        var id_categoria = $("#select_categoria");
        var id_linea = $("#select_linea");
        var nombre = $("#input_nombre");
        var transferencia = $("#input_transferencia");
        var valor = $("#input_valor");

        // Habilidades
        var habilidad1 = $("#select_habilidad1");
        var habilidad2 = $("#select_habilidad2");
        var habilidad3 = $("#input_habilidad3");
        var habilidad4 = $("#input_habilidad4");
        var habilidad5 = $("#input_habilidad5");
        var habilidad6 = $("#select_habilidad6");

        //Guardar producto
        $("#btn_guardar_producto").on("click", function(){
            //Datos a validar
            datos_obligatorios = new Array(
                nombre.val()
            );

            //Se ejecuta la validación de los campos obligatorios
            validacion = validar_campos_vacios(datos_obligatorios);

            //Si no supera la validacíón
            if (!validacion) {
                //Se muestra el mensaje de error
                mostrar_mensaje('Aun no se ha completado el registro del producto', 'Por favor complete toda la información para guardar los productos.');
            } else {
                //Se valida si las habilidades 3, 4 y 5 son mayores a 0
                if (habilidad3.val() > 0) {habilidad3_es = '1';}else{habilidad3_es = '0';}
                if (habilidad4.val() > 0) {habilidad4_es = '1';}else{habilidad4_es = '0';}
                if (habilidad5.val() > 0) {habilidad5_es = '1';}else{habilidad5_es = '0';}

                //Arreglo JSON de datos a enviar posteriormente
                datos_formulario = {
                    'strNombre': nombre.val(),
                    'valor': valor.val(),
                    'id_proveedor': id_proveedor.val(),
                    'Estado': estado.val(),
                    'id_linea': id_linea.val(),
                    'id_categoria': id_categoria.val(),
                    'id_empresa': "<?php echo $this->session->userdata('id_empresa'); ?>",
                    'transferencia': transferencia.val(),
                    'habilidad1_es': habilidad1.val(),
                    'habilidad2_es': habilidad2.val(),
                    'habilidad3_es': habilidad3_es,
                    'habilidad3': habilidad3.val(),
                    'habilidad4_es': habilidad4_es,
                    'habilidad4': habilidad4.val(),
                    'habilidad5_es': habilidad5_es,
                    'habilidad5': habilidad5.val(),
                    'habilidad6_es': habilidad6.val()
                };
                imprimir(datos_formulario);
                
                //  Si es para actualizar, o sea, tiene id de producto
                if ($("#input_id_producto").val() > 0) {
                    // Se actualiza
                    ajax("<?php echo site_url('listas/actualizar'); ?>", {"datos": datos_formulario, "tabla": "productos", "campo": "intCodigo", "id_campo": $("#input_id_producto").val() }, "html");

                    //Se cierra la ventana
					$('#modal_nuevo_producto').modal('hide');

					//Cuando se termine de cerrar
					$('#modal_nuevo_producto').on('hidden.bs.modal', function (e) {
						//Se recarga la tabla para que muestre los datos
						$("#cont_listas").load("<?php echo 'listas/cargar_interfaz' ?>", {tipo: 'producto'});
					});
                }else{
                    //Se invoca la petición ajax que guardará el registro
                    ajax("<?php echo site_url('listas/guardar'); ?>", {"datos": datos_formulario, "tabla": "productos"}, "html");

                    //Se cierra la ventana
                    $('#modal_nuevo_producto').modal('hide');

                    //Cuando se termine de cerrar
                    $('#modal_nuevo_producto').on('hidden.bs.modal', function (e) {
                        //Se recarga la tabla para que muestre los datos
                        $("#cont_listas").load("<?php echo 'listas/cargar_interfaz' ?>", {tipo: 'producto'});
                    });
                } //if
            }//if validacion

            //Se detiene el formulario
            return false;
        });//Guardar producto
    });//document.rady
</script>