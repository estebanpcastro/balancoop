<?php
// Se cargan los datos necesarios
$campanas = $this->listas_model->cargar_campanas_activas();
$productos = $this->listas_model->cargar_productos();
$productos_cliente = $this->cliente_model->cargar_productos_cliente($id_asociado);
?>

<!-- Agregar producto -->
<button id="btn_agregar_producto" type="button" class="btn btn-info btn-block">Agregar producto</button>
<br>

<input type="hidden" id="input_id_producto">

<!-- Tabla responsiva -->
<div id="tabla" class="table-responsive">
    <!-- Tabla -->
    <table id="tabla_productos" class="table">
        <!-- Cabecera -->
        <thead>
            <tr>
                <th class="alinear_centro">Opc.</th>
                <th class="alinear_centro">Nro.</th>
                <th class="alinear_centro">Producto</th>
                <th class="alinear_centro">Cantidad</th>
                <th class="alinear_centro">Valor</th>
                <th class="alinear_centro">Transferencia</th>
                <th class="alinear_centro">Fecha inicial</th>
                <th class="alinear_centro">Fecha final</th>
                <th class="alinear_centro">Campaña</th>
                <th class="alinear_centro">Oficina</th>
                <th class="alinear_centro">Usuario</th>
            </tr>
        </thead><!-- Cabecera -->

        <!-- Cuerpo -->
        <tbody>
            <?php
            $cont = 1;
            // Recorrido de los productos
            foreach ($productos_cliente as $producto_cliente) {
            ?>
            <tr>
                <td>
                    <a href="javascript:eliminar(<?php echo $producto_cliente->intCodigo; ?>)" title="Eliminar producto" class="icono">
                        <span class="glyphicon glyphicon-remove"></span>
                    </a>
                    <a href="<?php echo site_url('reporte/producto').'/'.$producto_cliente->intCodigo; ?>" target="_blank" title="Imprimir recibo producto" class="icono">
                        <span class="glyphicon glyphicon-print"></span>
                    </a>
                </td>
                <td><?php echo $cont; ?></td>
                <td><?php echo $producto_cliente->Producto; ?></td>
                <td><?php echo $producto_cliente->cantidad; ?></td>
                <td><?php echo number_format($producto_cliente->valor, 0, '', '.'); ?></td>
                <td><?php echo number_format($producto_cliente->transferencia, 0, '', '.'); ?></td>
                <td><?php echo $producto_cliente->fecha_inicial; ?></td>
                <td><?php echo $producto_cliente->fecha_final; ?></td>
                <td><?php echo $producto_cliente->Campana; ?></td>
                <td><?php echo $producto_cliente->Oficina; ?></td>
                <td><?php echo $producto_cliente->Usuario; ?></td>
            </tr>
            <?php
            $cont++;
            } //Foreach
            ?>
        </tbody><!-- Cuerpo -->
    </table><!-- Tabla -->
</div><!-- Tabla responsiva -->

<!-- Modal nuevo producto -->
<div id="modal_nuevo_producto" class="modal fade">
	<form id="form_producto">
        <div class="modal-dialog">
            <div class="modal-content">
				<!-- Cabecera -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Gestion de productos del asociado</h4>
                </div><!-- Cabecera -->

                <!-- Cuerpo -->
                <div class="modal-body">
                    <!-- Container -->
                    <div class="container">
                		<!-- Producto -->
                        <div class="col-lg-12">
	                        <label for="select_producto" class="control-label">Producto *</label>
	                        <select id="select_producto" class="form-control input-sm-4" autofocus>
	                            <option value="">Seleccione...</option>
	                            <?php foreach ($productos as $producto) { ?>
		                            <option value="<?php echo $producto->intCodigo; ?>"><?php echo $producto->strNombre; ?></option>
		                        <?php } ?>
	                        </select>
                    	</div><!-- Producto -->

                        <!-- Oficina -->
                        <div class="col-lg-6">
                            <label for="select_oficina" class="control-label">Oficina *</label>
                            <select id="select_oficina" class="form-control input-sm">
                                <option value="">Seleccione...</option>
                                <?php foreach ($oficinas as $oficina) { ?>
                                    <option value="<?php echo $oficina->intCodigo; ?>"><?php echo $oficina->strNombre; ?></option>
                                <?php } ?>
                            </select>
                        </div><!-- Oficina -->

                        <!-- Campaña -->
                        <div class="col-lg-6">
                            <label for="select_campana" class="control-label">Campaña</label>
                            <select id="select_campana" class="form-control input-sm-4" autofocus>
                                <option value="">Seleccione...</option>
                                <?php foreach ($campanas as $campana) { ?>
                                    <option value="<?php echo $campana->intCodigo; ?>"><?php echo $campana->strNombre; ?></option>
                                <?php } ?>
                            </select>
                        </div><!-- Campaña -->

                        <div class="clear"></div>

                        <!-- Cantidad -->
                        <div class="col-lg-4">
	                        <label for="input_cantidad" class="control-label">Cantidad *</label>
				            <input id="input_cantidad" class="form-control input-sm" type="text" placeholder="Obligatorio"><!-- Cantidad -->
                    	</div><!-- Cantidad -->
                        
                        <!-- Valor -->
                        <div class="col-lg-4">
                            <label for="input_valor" class="control-label">Valor</label>
                            <input id="input_valor" class="form-control input-sm" type="text">
                        </div><!-- Valor -->
                        
                        <!-- Transferencia -->
                    	<div class="col-lg-4">
	                        <label for="input_transferencia" class="control-label">Transferencia</label>
				            <input id="input_transferencia" class="form-control input-sm" type="text">
                    	</div><!-- Transferencia -->
                    </div><!-- Container -->
                    <br>

                    <!-- Container -->
                    <div class="container well">
                        <!-- Fecha de inicio -->
                        <label for="dia_inicio" class="control-label col-lg-12">Fecha de inicio (obligatoria)</label>
                        <div class="col-lg-4">
                            <select id="dia_inicio" class="form-control">
                                <option value="00">Día</option>
                                <?php foreach ($dias as $dia) { ?>
                                    <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <select id="mes_inicio" class="form-control">
                                <option value="00">Mes</option>
                                <?php foreach ($meses as $mes) { ?>
                                    <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-lg-4">
                            <select id="anio_inicio" class="form-control" >
                                <option value="0000">Año</option>
                                <?php foreach ($anios as $anio) { ?>
                                    <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                                <?php } ?>
                            </select>
                        </div><!-- Fecha de inicio -->

                        <!-- Fecha final -->
                        <label for="dia_inicio" class="control-label col-lg-12">Fecha final</label>
                        <div class="col-lg-4">
                            <select id="dia_fin" class="form-control">
                                <option value="00">Día</option>
                                <?php foreach ($dias as $dia) { ?>
                                    <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <select id="mes_fin" class="form-control">
                                <option value="00">Mes</option>
                                <?php foreach ($meses as $mes) { ?>
                                    <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-lg-4">
                            <select id="anio_fin" class="form-control" >
                                <option value="0000">Año</option>
                                <?php foreach ($anios as $anio) { ?>
                                    <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                                <?php } ?>
                            </select>
                        </div><!-- Fecha final -->
                    </div><!-- Container -->

                    <!-- Container -->
                    <center><b>Condiciones de habilidad</b></center>
                    <div class="container">
                        <!-- Contenedor de las habilidades -->
                        <div id="cont_habilidades well">
                            <!-- Container -->
                            <div class="container">
                                <!-- Habilidad 1 -->
                                <div class="col-lg-6 well">
                                    <label>Asociado de enero 1 a diciembre 31 de <?php echo date("Y")-1; ?></label>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <label for="habilidad1_requerido" class="control-label">Requerido:</label>
                                            <input type="text" id="habilidad1_requerido" class="form-control" disabled>
                                
                                            <label for="habilidad1_real" class="control-label">Real:</label>
                                            <input type="text" id="habilidad1_real" class="form-control" disabled>
                                
                                            <b id="habilidad1_estado"></b>
                                        </div>
                                    </div>                                    
                                </div>
                                <!-- Habilidad 1 -->

                                <!-- Habilidad 2 -->
                                <!-- <div class="col-lg-6 well">
                                    <div class="row">
                                        <label>Asociado de antiguedad 1 año fecha de inicio producto</label>
                                        <div class="col-xs-12">
                                            <label for="habilidad2_requerido" class="control-label">Requerido:</label>
                                            <input type="text" id="habilidad2_requerido" class="form-control" disabled>
                                
                                            <label for="habilidad2_real" class="control-label">Real:</label>
                                            <input type="text" id="habilidad2_real" class="form-control" disabled>
                                
                                            <b id="habilidad2_estado"></b>
                                        </div>
                                    </div>                                    
                                </div> --><!-- Habilidad 2 -->

                                <!-- Habilidad 3 -->
                                <div class="col-lg-6 well">
                                    <div class="row">
                                        <label>Compras desde enero 1 hasta diciembre 31 de <?php echo date("Y")-1; ?></label>
                                        <div class="col-xs-12">
                                            <label for="habilidad3_requerido" class="control-label">Requerido:</label>
                                            <input type="text" id="habilidad3_requerido" class="form-control" disabled>
                                        
                                            <label for="habilidad3_real" class="control-label">Real:</label>
                                            <input type="text" id="habilidad3_real" class="form-control" disabled>
                                        
                                            <b id="habilidad3_estado"></b>
                                        </div>
                                    </div>                                    
                                </div><!-- Habilidad 3 -->
                                <div class="clear"></div>

                                <!-- Habilidad 4 -->
                                <div class="col-lg-6 well">
                                    <div class="row">
                                        <label>Compras en el último trimestre</label><br><br>
                                        <div class="col-xs-12">
                                            <label for="habilidad4_requerido" class="control-label">Requerido:</label>
                                            <input type="text" id="habilidad4_requerido" class="form-control" disabled>
                                        
                                            <label for="habilidad4_real" class="control-label">Real:</label>
                                            <input type="text" id="habilidad4_real" class="form-control" disabled>
                                        
                                            <b id="habilidad4_estado"></b>
                                        </div>
                                    </div>                                    
                                </div><!-- Habilidad 4 -->

                                <!-- Habilidad 5 -->
                                <div class="col-lg-6 well">
                                    <div class="row">
                                        <label>Compras de fecha de inicio del producto un año atrás</label><br><br>
                                        <div class="col-xs-12">
                                            <label for="habilidad5_requerido" class="control-label">Requerido:</label>
                                            <input type="text" id="habilidad5_requerido" class="form-control" disabled>
                                        
                                            <label for="habilidad5_real" class="control-label">Real:</label>
                                            <input type="text" id="habilidad5_real" class="form-control" disabled>
                                        
                                            <b id="habilidad5_estado"></b>
                                        </div>
                                    </div>                                    
                                </div><!-- Habilidad 5 -->
                                <div class="clear"></div>
                                
                                <!-- Habilidad 6 -->
                                <div class="col-lg-6 well">
                                    <div class="row">
                                        <label>¿Es asociado?</label><br><br>
                                        <div class="col-xs-12">
                                            <label for="habilidad6_requerido" class="control-label">Requerido:</label>
                                            <input type="text" id="habilidad6_requerido" class="form-control" disabled>
                                        
                                            <label for="habilidad6_real" class="control-label">Real:</label>
                                            <input type="text" id="habilidad6_real" class="form-control" disabled>
                                        
                                            <b id="habilidad6_estado"></b>
                                        </div>
                                    </div>                                    
                                </div><!-- Habilidad 6 -->
                            </div><!-- Container -->
                        </div><!-- Contenedor de las habilidades -->
                    </div><!-- Container -->
                </div><!-- Cuerpo -->

                <!-- Pie -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div><!-- Pie -->
        	</div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal nuevo producto -->

<!-- Modal eliminar producto -->
<div id="modal_eliminar_producto" class="modal fade">
    <form id="form_eliminar_producto">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Cabecera -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Eliminar productos</h4>
                </div><!-- Cabecera -->

                <!-- Cuerpo -->
                <div class="modal-body">
                    <!-- Container -->
                    <div class="container">
                        <p>¿Está seguro de eliminar el producto?</p>
                    </div><!-- Container -->
                </div><!-- Cuerpo -->

                <!-- Pie -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-success">Si, eliminar</button>
                </div><!-- Pie -->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal eliminar producto -->

<script type="text/javascript">
    function eliminar(id){
        // Se pone el id en un input oculto
        $("#input_id_producto").val(id);
        
        //Se abre la ventana
        $('#modal_eliminar_producto').modal('show');
    }

    function calcular_habilidad(numero, id_asociado){
        // Suiche para cada habilidad
        switch(numero) {
             
            case '1':
                imprimir("Calculando la habilidad 1 del asociado " + id_asociado + "...");

                // Se consulta la habilidad 1
                habil1 = ajax("<?php echo site_url('cliente/consultar_habilidad'); ?>", {'numero': '1', 'id_asociado': id_asociado, 'fecha_inicio': '0'}, "JSON");
                imprimir(habil1);

                // Se ponen los valores en pantalla
                $("#habilidad1_requerido").val("Año anterior");
                $("#habilidad1_real").val(habil1.Fecha_Ingreso);

                //Si no es hábil
                if(habil1.aplica == "0"){
                    // Se aumenta la habilidad
                    habil++;

                    // Se pone el mensaje
                    $("#habilidad1_estado").addClass('error').text("Inhabilitado");
                }else{
                    // Se pone el mensaje
                    $("#habilidad1_estado").addClass('exito').text("Hábil");
                } // if

                break;
                
            /*case '2':
                imprimir("Calculando la habilidad 2 del asociado " + id_asociado + "...");

                // Se consulta la habilidad 2
                habil2 = ajax("<?php echo site_url('cliente/consultar_habilidad'); ?>", {'numero': '2', 'id_asociado': id_asociado, 'fecha_inicio': $("#anio_inicio").val() + "-" + $("#mes_inicio").val() + "-" + $("#dia_inicio").val()}, "JSON");
                
                // Se ponen los valores en pantalla
                $("#habilidad2_requerido").val("Antes de " + habil2.Fecha_Requerida);
                $("#habilidad2_real").val(habil2.Fecha_Ingreso);

                //Si no es hábil
                if(habil2.aplica == "0"){
                    // Se aumenta la habilidad
                    habil++;

                    // Se pone el mensaje
                    $("#habilidad2_estado").addClass('error').text("Inhabilitado");
                }else{
                    // Se pone el mensaje
                    $("#habilidad2_estado").addClass('exito').text("Hábil");
                } // if

                break;*/

            case '3':
                imprimir("Calculando la habilidad 3 del asociado " + id_asociado + "...");

                // Se consulta la habilidad 3
                habil3 = ajax("<?php echo site_url('cliente/consultar_habilidad'); ?>", {'numero': '3', 'id_asociado': id_asociado, 'fecha_inicio': $("#anio_inicio").val() + "-" + $("#mes_inicio").val() + "-" + $("#dia_inicio").val(), 'id_producto': $("#select_producto").val()}, "JSON");

                // Se ponen los valores en pantalla
                $("#habilidad3_requerido").val("Compras por $" + habil3.Salario_Requerido);
                $("#habilidad3_real").val("$" + habil3.Compras);

                //Si no es hábil
                if(habil3.aplica == "0"){
                    // Se aumenta la habilidad
                    habil++;

                    // Se pone el mensaje
                    $("#habilidad3_estado").addClass('error').text("Inhabilitado");
                }else{
                    // Se pone el mensaje
                    $("#habilidad3_estado").addClass('exito').text("Hábil");
                } // if

                break;
            
            case '4':
                imprimir("Calculando la habilidad 4 del asociado " + id_asociado + "...");

                // Se consulta la habilidad 4
                habil4 = ajax("<?php echo site_url('cliente/consultar_habilidad'); ?>", {'numero': '4', 'id_asociado': id_asociado, 'fecha_inicio': $("#anio_inicio").val() + "-" + $("#mes_inicio").val() + "-" + $("#dia_inicio").val(), 'id_producto': $("#select_producto").val()}, "JSON");
                imprimir($("#anio_inicio").val() + "-" + $("#mes_inicio").val() + "-" + $("#dia_inicio").val())


                // Se ponen los valores en pantalla
                $("#habilidad4_requerido").val("Compras: $" + habil4.Salario_Requerido/*+ " (desde " + habil4.Fecha_Requerida + ")"*/);
                $("#habilidad4_real").val("$" + habil4.Compras);

                //Si no es hábil
                if(habil4.aplica == "0"){
                    // Se aumenta la habilidad
                    habil++;

                    // Se pone el mensaje
                    $("#habilidad4_estado").addClass('error').text("Inhabilitado");
                }else{
                    // Se pone el mensaje
                    $("#habilidad4_estado").addClass('exito').text("Hábil");
                } // if

                break;

            case '5':
                imprimir("Calculando la habilidad 5 del asociado " + id_asociado + "...");

                // Se consulta la habilidad 5
                habil5 = ajax("<?php echo site_url('cliente/consultar_habilidad'); ?>", {'numero': '5', 'id_asociado': id_asociado, 'fecha_inicio': $("#anio_inicio").val() + "-" + $("#mes_inicio").val() + "-" + $("#dia_inicio").val(), 'id_producto': $("#select_producto").val()}, "JSON");

                // Se ponen los valores en pantalla
                $("#habilidad5_requerido").val("Compras: $" + habil5.Salario_Requerido/* + " (desde " + habil5.Fecha_Requerida + ")"*/);
                $("#habilidad5_real").val("$" + habil5.Compras);

                //Si no es hábil
                if(habil5.aplica == "0"){
                    // Se aumenta la habilidad
                    habil++;

                    // Se pone el mensaje
                    $("#habilidad5_estado").addClass('error').text("Inhabilitado");
                }else{
                    // Se pone el mensaje
                    $("#habilidad5_estado").addClass('exito').text("Hábil");
                } // if

                break;

            case '6':
                imprimir("Calculando la habilidad 6 del asociado " + id_asociado + "...");

                // Se consulta la habilidad 6
                habil6 = ajax("<?php echo site_url('cliente/consultar_habilidad'); ?>", {'numero': '6', 'id_asociado': id_asociado}, "JSON");

                // Se ponen los valores en pantalla
                $("#habilidad6_requerido").val("Si");
                $("#habilidad6_real").val(habil6.Tipo);

                //Si no es hábil
                if(habil6.aplica == "0"){
                    // Se aumenta la habilidad
                    habil++;

                    // Se pone el mensaje
                    $("#habilidad6_estado").addClass('error').text("Inhabilitado");
                }else{
                    // Se pone el mensaje
                    $("#habilidad6_estado").addClass('exito').text("Hábil");
                } // if

                break;
        }
    }// calcular_habilidad


    $(document).ready(function(){
    	//Agregar producto
        $("#btn_agregar_producto").on("click", function(){
            //Se abre la ventana
            $('#modal_nuevo_producto').modal('show');
        });//Agregar producto
        

        // Inicialización de la tabla
        $('#tabla_productos').dataTable({
            "bProcessing": true,
        }); // Tabla

        //Recolección de datos
        var id_asociado = "<?php echo $id_asociado; ?>";
        var producto = $("#select_producto");
        var campana = $("#select_campana");
        var cantidad = $("#input_cantidad");
        var valor = $("#input_valor");
        var oficina = $("#select_oficina");
        var dia_inicio = $("#dia_inicio");
        var mes_inicio = $("#mes_inicio");
        var anio_inicio = $("#anio_inicio");
        var dia_fin = $("#dia_fin");
        var mes_fin = $("#mes_fin");
        var anio_fin = $("#anio_fin");
        var transferencia = $("#input_transferencia");

        /**
         * Al cambiar la fecha  de inicio o el producto
         */
        $("#select_producto, #dia_inicio, #mes_inicio, #anio_inicio").on("change", function(){
            imprimir("Cambia producto o fecha de inicio");

            // Se consultan las habilidades que el producto requiere cumplir
            consultar = ajax("<?php echo site_url('cliente/consultar_habilidad_producto'); ?>", {'id_producto': $("#select_producto").val()}, "JSON");

            // Se limpian todos los campos de habilidad
            $("#habilidad1_requerido, #habilidad1_real, #habilidad2_requerido, #habilidad2_real, #habilidad3_requerido, #habilidad3_real, #habilidad3_requerido, #habilidad3_real, #habilidad4_requerido, #habilidad4_real, #habilidad5_requerido, #habilidad5_real, #habilidad6_requerido, #habilidad6_real").val("");
            $("#habilidad1_estado, #habilidad2_estado, #habilidad3_estado, #habilidad4_estado, #habilidad5_estado, #habilidad6_estado").text("");

            // Se pone valor y transferencia en el modal
            valor.val(consultar.valor);
            transferencia.val(consultar.transferencia);

            // variable de habilidades
            habil = 0;
            
            /**
             * Si la habilidad 1 es requerida
             */
            if(consultar.habilidad1_es == "1"){
                // Se llama la función para la habilidad 1
                calcular_habilidad('1', id_asociado);
            } // Consulta habilidad 1
            
            /**
             * Si la habilidad 2 es requerida
             */
            /*if(consultar.habilidad2_es == "1"){
                // Se llama la función para la habilidad 2
                calcular_habilidad('2', id_asociado);
            } // Consulta habilidad 2*/

            // Si la habilidad 3 es requerida
            if(consultar.habilidad3_es == "1"){
                // Se llama la función para la habilidad 3
                calcular_habilidad('3', id_asociado);
            } // Consulta habilidad 3

            // Si la habilidad 4 es requerida
            if(consultar.habilidad4_es == "1"){
                // Se llama la función para la habilidad 4
                calcular_habilidad('4', id_asociado);
            } // Consulta habilidad 4

            // Si la habilidad 5 es requerida
            if(consultar.habilidad5_es == "1"){
                // Se llama la función para la habilidad 5
                calcular_habilidad('5', id_asociado);
            } // Consulta habilidad 5

            // Si la habilidad 6 es requerida
            if(consultar.habilidad6_es == "1"){
                // Se llama la función para la habilidad 6
                calcular_habilidad('6', id_asociado);
            } // Consulta habilidad 6
        }); // fecha de inicio y producto change
        

        //Guardar producto
        $("#form_producto").on("submit", function(){
            //Datos a validar
            datos_obligatorios = new Array(
                producto.val(),
                cantidad.val(),
                dia_inicio.val(),
                mes_inicio.val(),
                anio_inicio.val()
            );

            //Se ejecuta la validación de los campos obligatorios
            validacion = validar_campos_vacios(datos_obligatorios);

            //Si no supera la validacíón
            if (!validacion) {
                //Se muestra el mensaje de error
                mostrar_mensaje('Faltan datos', 'Por favor complete la información para guardar el producto.');
            } else {
                // Arreglo de datos
                datos_formulario = {
                    "cantidad": cantidad.val(),
                    "id_producto": producto.val(),
                    "transferencia": transferencia.val(),
                    "valor": valor.val(),
                    "id_cliente": "<?php echo $id_asociado; ?>",
                    "fecha_inicial": anio_inicio.val() + "-" + mes_inicio.val() + "-" + dia_inicio.val(),
                    "fecha_final": anio_fin.val() + "-" + mes_fin.val() + "-" + dia_fin.val(),
                    "id_agencia": oficina.val(),
                    "ano": "<?php echo date('Y') ?>",
                    "mes": "<?php echo date('m') ?>",
                    "dia": "<?php echo date('d') ?>",
                    "id_usuario_creador": "<?php echo $this->session->userdata('id_usuario'); ?>",
                    "id_empresa": "<?php echo $this->session->userdata('id_empresa'); ?>",
                    "id_campana": campana.val()
                };
                imprimir(datos_formulario);
                
                // Si la ahbilidad no es igual  a cero
                if (habil > 0) {
                    //Se muestra el mensaje de error
                    mostrar_mensaje('Inhabilidades', 'No puede registrarse el producto al asociado porque presenta inhabilidades');

                    // Se detiene el formulario
                    return false;
                };
                
                //Se invoca la petición ajax que guardará el registro
                producto_nuevo = ajax("<?php echo site_url('cliente/guardar'); ?>", {"tipo": "producto", "datos": datos_formulario}, "html");
                // imprimir(producto_nuevo);
                
                //Se cierra la ventana
                $('#modal_nuevo_producto').modal('hide');

                //Cuando se termine de cerrar
                $('#modal_nuevo_producto').on('hidden.bs.modal', function (e) {
                    //Se recarga la tabla para que muestre los datos
                    $("#cont_detalle").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'cliente_producto', "id_asociado": "<?php echo $id_asociado; ?>"});

                    // Se actualizan los datos personales del cliente
                    datos_cliente = ajax("<?php echo site_url('cliente/actualizar_datos_cliente_producto'); ?>", {"id_cliente": "<?php echo $id_asociado; ?>"}, "html");
                });
            } // if validacion

            //Se detiene el formulario
            return false;
        });//Guardar producto

        //Eliminar producto
        $("#form_eliminar_producto").on("submit", function(){
            //Se invoca la petición ajax que eliminará el producto
            eliminar = ajax("<?php echo site_url('cliente/eliminar'); ?>", {"tipo": "producto", "id": $("#input_id_producto").val()}, "html");
            
            //Se cierra la ventana
            $('#modal_eliminar_producto').modal('hide');
            
            //Cuando se termine de cerrar
            $('#modal_eliminar_producto').on('hidden.bs.modal', function (e) {
                //Se recarga la tabla para que muestre los datos
                $("#cont_detalle").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'cliente_producto', "id_asociado": "<?php echo $id_asociado; ?>"});
            });

            //Se detiene el formulario
            return false;
        });//Eliminar producto
    });//document.ready
</script>