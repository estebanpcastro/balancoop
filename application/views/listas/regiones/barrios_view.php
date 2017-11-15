<!-- Se cargan los datos necesarios -->
<?php $barrios = $this->listas_model->cargar_barrios(substr($codigo_ciudad, 0, 4)); ?>

<!-- Sólo los super usuarios pueden crear datos a listas -->
<?php if ($this->session->userdata('tipo') != "2") { ?>
    <!-- Agregar barrio -->
    <button id="btn_agregar_barrio" type="button" class="btn btn-info btn-block">Agregar barrio</button>
<?php } ?>
<p></p>

<!-- Tabla responsiva -->
<div id="tabla_barrios" class="table-responsive">
	<!-- Tabla -->
    <table id="barrios" class="table">
        <!-- Cabecera -->
        <thead>
            <tr>
            	<th class="alinear_centro" width="10%">Opc.</th>
                <th class="alinear_centro" width="5%">Nro.</th>
                <th class="alinear_centro">Nombre</th>
                <th class="oculto">Estado</th>
                <th class="alinear_centro">Estado</th>
                <th class="oculto">codigo</th>
        	</tr>
        </thead><!-- Cabecera -->
        <!-- Cuerpo -->
        <tbody>
        	<?php
            //Contador
            $cont = 1;
            // Recorrido de los barrios
            foreach ($barrios as $barrio) {
            ?>
            <tr>
				<td class="alinear_derecha">
                    <!-- Sólo los super usuarios pueden modificar -->
                    <?php if ($this->session->userdata('tipo') == "3") { ?>
                        <a href="javascript:editar_barrio(<?php echo $cont; ?>)">
                            <span class="glyphicon glyphicon-edit icono"></span>
                        </a>
                    <?php } ?>
                </td>
                <td class="alinear_derecha"><?php echo $cont; ?></td>
                <td id="nombreb<?php echo $cont; ?>"><?php echo $barrio->strNombre; ?></td>
                <td id="estadob<?php echo $cont; ?>" class="oculto"><?php echo $barrio->Estado; ?></td>
                <td><?php if($barrio->Estado == "1"){echo "Activo";}else{echo "Inactivo";} ?></td>
                <td id="codigob<?php echo $cont; ?>" class="oculto"><?php echo $barrio->strCodigo; ?></td>
			</tr>
			<?php
            //Aumento de contador
            $cont++;
            } //Foreach
            ?>
    	</tbody><!-- Cuerpo -->
    </table><!-- Tabla -->
</div><!-- Tabla responsiva -->

<!-- Modal nuevo barrio -->
<div id="modal_nuevo_barrio" class="modal fade">
    <form id="form_barrio">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Cabecera -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Gestión de barrios</h4>

                    <!-- Cuerpo -->
                    <div class="modal-body">
                        <!-- Container -->
                        <div class="container">
                            <div class="col-lg-4">
                                <!-- Código del barrio -->
                                <input type="hidden" id="input_id_dato" value="">
                                <label for="input_codigo_barrio" class="control-label">Código</label>
                                <input id="input_codigo_barrio" class="form-control input-sm" type="text" autofocus><!-- Código del barrio -->
                            </div>

                            <div class="col-lg-4">
                                <!-- Nombre del barrio -->
                                <label for="input_nombre_barrio" class="control-label">Nombre</label>
                                <input id="input_nombre_barrio" class="form-control input-sm" type="text"><!-- Nombre del barrio -->
                            </div>

                            <div class="col-lg-4">
                                <!-- Estado del barrio -->
                                <label for="select_estado_barrio" class="control-label">Estado</label>
                                <select id="select_estado_barrio" class="form-control input-sm">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select><!-- Estado del barrio -->
                            </div>
                         </div><!-- Container -->
                    </div><!-- Cuerpo -->

                    <!-- Pie -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                        <!-- <button type="button" class="btn btn-success" data-dismiss="modal">Guardar</button> -->
                    </div><!-- Pie -->
                </div><!-- Cabecera -->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal nuevo barrio -->

<script type="text/javascript">
    // Borrar formulario    
    function borrar_formulario(){        
        $('#input_id_dato').val('');            
        $('#input_nombre_barrio').val('');            
        $("#input_codigo_barrio").val('');
        $("#select_estado_barrio").val('');
    }

    // Cuando den clic sobre editar     
    function editar_barrio(elemento){     
        borrar_formulario();
        //alert('nombre'+elemento);
        //mostrar_elemento($("#" + elemento));     
        var input_nombre_barrio = document.getElementById('nombreb'+elemento).innerHTML
        var input_codigo_barrio = document.getElementById('codigob'+elemento).innerHTML
        var estado_barrio = document.getElementById('estadob'+elemento).innerHTML
        
        //alert("id_variable"+elemento); 
        $('#modal_nuevo_barrio').modal('show');        
        $("#input_id_dato").val(input_codigo_barrio);        
        $("#input_nombre_barrio").val(input_nombre_barrio);        
        $("#input_codigo_barrio").val(input_codigo_barrio);
        $('#select_estado_barrio > option[value="' + estado_barrio +'"]').attr('selected', 'selected');
    }

    $(document).ready(function(){
        // Inicialización de la tabla
        $('#barrios').dataTable( {
            "bProcessing": true,
        }); // Tabla

        //Agregar barrio
        $("#btn_agregar_barrio").on("click", function(){
            //Se abre la ventana
            $('#modal_nuevo_barrio').modal('show');
        });//Agregar barrio

        //Recolección de datos
        var id_dato = $("#input_id_dato");
        var codigo = $("#input_codigo_barrio").numericInput();
        var nombre = $("#input_nombre_barrio");
        var estado = $("#select_estado_barrio");

        //Guardar pais
        $("#form_barrio").on("submit", function(){
            //Datos a validar
            datos_obligatorios = new Array(
                codigo.val(),
                nombre.val()
            );

            //Se ejecuta la validación de los campos obligatorios
            validacion = validar_campos_vacios(datos_obligatorios);

            //Si no supera la validacíón
            if (!validacion) {
                //Se muestra el mensaje de error
                mostrar_mensaje('Faltan datos', 'Por favor ingrese toda la información para guardar el barrio.');
            } else {
                //Arreglo JSON de datos a enviar posteriormente
                datos_formulario = {
                    'Estado': estado.val(),
                    'strNombre': nombre.val(),
                    'strCodigo': codigo.val(),
                    'strTipo': 'B'
                };
                // imprimir(datos_formulario)
                
                if(id_dato.val()!=''){
                    //Se invoca la petición ajax que guardará el registro
                    barrio = ajax("<?php echo site_url('listas/actualizar'); ?>", {"datos": datos_formulario, "tabla": "regiones", "campo": "strCodigo", "id_campo": id_dato.val() }, "html"); 

                    // Si se guardó correctamente
                    if(barrio){
                        //Se cierra la ventana
                        $('#modal_nuevo_barrio').modal('hide');

                        //Cuando se termine de cerrar
                        $('#modal_nuevo_barrio').on('hidden.bs.modal', function (e) {
                            //Se recarga la tabla para que muestre los datos
                            $("#cont_barrios").load("listas/cargar_interfaz", {tipo: 'barrio'});
                        });
                    };//if
                }else{  
                    //Se invoca la petición ajax que guardará el registro
                    barrio = ajax("<?php echo site_url('listas/guardar'); ?>", {"datos": datos_formulario, "tabla": "regiones"}, "html");

                    // Si se guardó correctamente
                    if(barrio){
                        //Se cierra la ventana
                        $('#modal_nuevo_barrio').modal('hide');

                        //Cuando se termine de cerrar
                        $('#modal_nuevo_barrio').on('hidden.bs.modal', function (e) {
                            //Se recarga la tabla para que muestre los datos
                            $("#cont_barrios").load("listas/cargar_interfaz", {tipo: 'barrio'});
                        });
                    };//if
                }
            }//if validacion

            //Se detiene el formulario
            return false;
        });//Guardar pais
    });//document.rady
</script>