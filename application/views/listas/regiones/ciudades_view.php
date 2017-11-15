<!-- Se cargan los datos necesarios -->
<?php $ciudades = $this->listas_model->cargar_ciudades($codigo_departamento); ?>

<!-- Sólo los super usuarios pueden crear datos a listas -->
<?php if ($this->session->userdata('tipo') != "2") { ?>
    <!-- Agregar ciudad -->
    <button id="btn_agregar_ciudad" type="button" class="btn btn-info btn-block">Agregar Ciudad</button>
<?php } ?>
<p></p>
	
<!-- Tabla responsiva -->
<div id="tabla_ciudades" class="table-responsive">
	<!-- Tabla -->
    <table id="ciudades" class="table">
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
            // Recorrido de las ciudades
            foreach ($ciudades as $ciudad) {
            ?>
            <tr>
				<td class="alinear_derecha">
                    <a href="javascript:cargar_barrios('<?php echo $ciudad->strCodigo; ?>')" alt="Ver barrios"><span class="glyphicon glyphicon-search icono"></span></a>
                    <!-- Sólo los super usuarios pueden modificar -->
                    <?php if ($this->session->userdata('tipo') == "3") { ?>
                    <a href="javascript:editar_ciudad(<?php echo $cont; ?>)">
                        <span class="glyphicon glyphicon-edit icono"></span>
                    </a>
                    <?php } ?>
                </td>
                <td class="alinear_derecha"><?php echo $cont; ?></td>
                <td id="nombrec<?php echo $cont; ?>"><?php echo $ciudad->strNombre; ?></td>
                <td id="estadoc<?php echo $cont; ?>" class="oculto"><?php echo $ciudad->Estado; ?></td>
                <td><?php if($ciudad->Estado == "1"){echo "Activo";}else{echo "Inactivo";} ?></td>
                <td id="codigoc<?php echo $cont; ?>" class="oculto"><?php echo $ciudad->strCodigo; ?></td>
			</tr>
			<?php
            //Aumento de contador
            $cont++;
            } //Foreach
            ?>
    	</tbody><!-- Cuerpo -->
    </table><!-- Tabla -->
</div><!-- Tabla responsiva -->

<!-- Modal nuevo ciudad -->
<div id="modal_nuevo_ciudad" class="modal fade">
    <form id="form_ciudad">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Cabecera -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Gestión de ciudades</h4>

                    <!-- Cuerpo -->
                    <div class="modal-body">
                        <!-- Container -->
                        <div class="container">
                            <div class="col-lg-4">
                                <!-- Código del ciudad -->
                                <input type="hidden" id="input_id_dato" value="">
                                <label for="input_codigo_ciudad" class="control-label">Código</label>
                                <input id="input_codigo_ciudad" class="form-control input-sm" type="text" autofocus><!-- Código del ciudad -->
                            </div>

                            <div class="col-lg-4">
                                <!-- Nombre del ciudad -->
                                <label for="input_nombre_ciudad" class="control-label">Nombre</label>
                                <input id="input_nombre_ciudad" class="form-control input-sm" type="text"><!-- Nombre del ciudad -->
                            </div>

                            <div class="col-lg-4">
                                <!-- Estado de la ciudad -->
                                <label for="select_estado_ciudad" class="control-label">Estado</label>
                                <select id="select_estado_ciudad" class="form-control input-sm">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select><!-- Estado de la ciudad -->
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
</div><!-- /.modal nuevo ciudad -->

<script type="text/javascript">
	// Borrar formulario    
    function borrar_formulario(){        
        $('#input_id_dato').val('');            
        $('#input_nombre_ciudad').val('');            
        $("#input_codigo_ciudad").val('');
        $("#select_estado_ciudad").val('');
    }

    // Cuando den clic sobre editar     
    function editar_ciudad(elemento){     
        borrar_formulario();
        //alert('nombre'+elemento);
        //mostrar_elemento($("#" + elemento));     
        var input_nombre_ciudad = document.getElementById('nombrec'+elemento).innerHTML
        var input_codigo_ciudad = document.getElementById('codigoc'+elemento).innerHTML
        var estado_ciudad = document.getElementById('estadoc'+elemento).innerHTML
        
        //alert("id_variable"+elemento); 
        $('#modal_nuevo_ciudad').modal('show');        
        $("#input_id_dato").val(input_codigo_ciudad);        
        $("#input_nombre_ciudad").val(input_nombre_ciudad);        
        $("#input_codigo_ciudad").val(input_codigo_ciudad);
        $('#select_estado_ciudad > option[value="' + estado_ciudad +'"]').attr('selected', 'selected');
    }

    $(document).ready(function(){
        // Inicialización de la tabla
        $('#ciudades').dataTable( {
            "bProcessing": true,
        }); // Tabla

        //Agregar ciudad
        $("#btn_agregar_ciudad").on("click", function(){
            //Se abre la ventana
            $('#modal_nuevo_ciudad').modal('show');
        });//Agregar ciudad

        //Recolección de datos
        var id_dato = $("#input_id_dato");
        var codigo = $("#input_codigo_ciudad").numericInput();
        var nombre = $("#input_nombre_ciudad");
        var estado = $("#select_estado_ciudad");

        //Guardar pais
        $("#form_ciudad").on("submit", function(){
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
                mostrar_mensaje('Faltan datos', 'Por favor ingrese toda la información para guardar el ciudad.');
            } else {
                //Arreglo JSON de datos a enviar posteriormente
                datos_formulario = {
                    'Estado': estado.val(),
                    'strNombre': nombre.val(),
                    'strCodigo': codigo.val(),
                    'strTipo': 'C'
                };
                // imprimir(datos_formulario)
                
                if(id_dato.val()!=''){
                    //Se invoca la petición ajax que guardará el registro
                    ciudad = ajax("<?php echo site_url('listas/actualizar'); ?>", {"datos": datos_formulario, "tabla": "regiones", "campo": "strCodigo", "id_campo": id_dato.val() }, "html"); 

                    // Si se guardó correctamente
                    if(ciudad){
                        //Se cierra la ventana
                        $('#modal_nuevo_ciudad').modal('hide');

                        //Cuando se termine de cerrar
                        $('#modal_nuevo_ciudad').on('hidden.bs.modal', function (e) {
                            //Se recarga la tabla para que muestre los datos
                            $("#cont_ciudades").load("listas/cargar_interfaz", {tipo: 'ciudad'});
                        });
                    };//if
                }else{  
                    //Se invoca la petición ajax que guardará el registro
                    ciudad = ajax("<?php echo site_url('listas/guardar'); ?>", {"datos": datos_formulario, "tabla": "regiones"}, "html");

                    // Si se guardó correctamente
                    if(ciudad){
                        //Se cierra la ventana
                        $('#modal_nuevo_ciudad').modal('hide');

                        //Cuando se termine de cerrar
                        $('#modal_nuevo_ciudad').on('hidden.bs.modal', function (e) {
                            //Se recarga la tabla para que muestre los datos
                            $("#cont_ciudades").load("listas/cargar_interfaz", {tipo: 'ciudad'});
                        });
                    };//if
                }
            }//if validacion

            //Se detiene el formulario
            return false;
        });//Guardar pais
    });//document.rady
</script>