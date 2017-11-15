<!-- Se cargan los datos necesarios -->
<?php $departamentos = $this->listas_model->cargar_departamentos($codigo_pais); ?>

<!-- Sólo los super usuarios pueden crear datos a listas -->
<?php if ($this->session->userdata('tipo') != "2") { ?>
    <!-- Agregar departamento -->
    <button id="btn_agregar_departamento" type="button" class="btn btn-info btn-block">Agregar Departamento</button>
<?php } ?>
<p></p>

<!-- Tabla responsiva -->
<div id="tabla_departamentos" class="table-responsive">
	<!-- Tabla -->
    <table id="departamentos" class="table">
        <!-- Cabecera -->
        <thead>
            <tr>
            	<th class="alinear_centro" width="10%">Opc.</th>
                <th class="alinear_centro" width="5%">Nro.</th>
                <th class="alinear_centro">Nombre</th>
                <th class="oculto">Estado</th>
                <th class="alinear_centro">Estado</th>
                <th class="oculto">Codigo</th>
        	</tr>
        </thead><!-- Cabecera -->
        <!-- Cuerpo -->
        <tbody>
        	<?php
            //Contador
            $cont = 1;
            // Recorrido de los departamentos
            foreach ($departamentos as $departamento) {
            ?>
            <tr>
				<td class="alinear_derecha">
                    <a href="javascript:cargar_ciudades('<?php echo $departamento->strCodigo; ?>')" alt="Ver departamentos"><span class="glyphicon glyphicon-search icono"></span></a>
                    <!-- Sólo los super usuarios pueden modificar -->
                    <?php if ($this->session->userdata('tipo') == "3") { ?>
                        <a href="javascript:editar_departamento(<?php echo $cont; ?>)">
                            <span class="glyphicon glyphicon-edit icono"></span>
                        </a>
                    <?php } ?>
                </td>
                <td class="alinear_derecha"><?php echo $cont; ?></td>
                <td id="nombred<?php echo $cont; ?>"><?php echo $departamento->strNombre; ?></td>
                <td id="estadod<?php echo $cont; ?>" class="oculto"><?php echo $departamento->Estado; ?></td>
                <td><?php if($departamento->Estado == "1"){echo "Activo";}else{echo "Inactivo";} ?></td>
                <td id="codigod<?php echo $cont; ?>" class="oculto"><?php echo $departamento->strCodigo; ?></td>
			</tr>
			<?php
            //Aumento de contador
            $cont++;
            } //Foreach
            ?>
    	</tbody><!-- Cuerpo -->
    </table><!-- Tabla -->
</div><!-- Tabla responsiva -->

<!-- Modal nuevo departamento -->
<div id="modal_nuevo_departamento" class="modal fade">
	<form id="form_departamento">
        <div class="modal-dialog">
			<div class="modal-content">
				<!-- Cabecera -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Gestión de departamentos</h4>

                    <!-- Cuerpo -->
                	<div class="modal-body">
						<!-- Container -->
	                    <div class="container">
	                        <div class="col-lg-4">
	                        	<!-- Código del departamento -->
                                <input type="hidden" id="input_id_dato" value="">
	                            <label for="input_codigo_departamento" class="control-label">Código</label>
	                            <input id="input_codigo_departamento" class="form-control input-sm" type="text" autofocus><!-- Código del departamento -->
	                    	</div>

	                    	<div class="col-lg-4">
	                        	<!-- Nombre del departamento -->
	                            <label for="input_nombre_departamento" class="control-label">Nombre</label>
	                            <input id="input_nombre_departamento" class="form-control input-sm" type="text"><!-- Nombre del departamento -->
	                    	</div>

                            <div class="col-lg-4">
                                <!-- Estado del departamento -->
                                <label for="select_estado_departamento" class="control-label">Estado</label>
                                <select id="select_estado_departamento" class="form-control input-sm">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select><!-- Estado del departamento -->
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
</div><!-- /.modal nuevo departamento -->

<script type="text/javascript">

    // Borrar formulario    
    function borrar_formulario(){        
        $('#input_id_dato').val('');            
        $('#input_nombre_departamento').val('');            
        $("#input_codigo_departamento").val('');
        $("#select_estado_departamento").val('');
    }

    // Cuando den clic sobre editar     
    function editar_departamento(elemento){     
        borrar_formulario();
        //alert('nombre'+elemento);
        //mostrar_elemento($("#" + elemento));     
        var input_nombre_departamento = document.getElementById('nombred'+elemento).innerHTML
        var input_codigo_departamento = document.getElementById('codigod'+elemento).innerHTML
        var estado_departamento = document.getElementById('estadod'+elemento).innerHTML
        
        //alert("id_variable"+elemento); 
        $('#modal_nuevo_departamento').modal('show');        
        $("#input_id_dato").val(input_codigo_departamento);        
        $("#input_nombre_departamento").val(input_nombre_departamento);        
        $("#input_codigo_departamento").val(input_codigo_departamento);
        $('#select_estado_departamento > option[value="' + estado_departamento +'"]').attr('selected', 'selected');
    }

	$(document).ready(function(){
        // Inicialización de la tabla
        $('#departamentos').dataTable( {
            "bProcessing": true,
        }); // Tabla

        //Agregar departamento
        $("#btn_agregar_departamento").on("click", function(){
            //Se abre la ventana
            $('#modal_nuevo_departamento').modal('show');
        });//Agregar departamento

        //Recolección de datos
        var id_dato = $("#input_id_dato");
        var codigo = $("#input_codigo_departamento").numericInput();
        var nombre = $("#input_nombre_departamento");
        var estado = $("#select_estado_departamento");

        //Guardar pais
        $("#form_departamento").on("submit", function(){
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
                mostrar_mensaje('Faltan datos', 'Por favor ingrese toda la información para guardar el departamento.');
            } else {
            	//Arreglo JSON de datos a enviar posteriormente
                datos_formulario = {
                    'Estado': estado.val(),
                    'strNombre': nombre.val(),
                    'strCodigo': codigo.val(),
                    'strTipo': 'D'
                };
                // imprimir(datos_formulario)
                
                if(id_dato.val()!=''){
                    //Se invoca la petición ajax que guardará el registro
                    departamento = ajax("<?php echo site_url('listas/actualizar'); ?>", {"datos": datos_formulario, "tabla": "regiones", "campo": "strCodigo", "id_campo": id_dato.val() }, "html"); 

                    // Si se guardó correctamente
                    if(departamento){
                        //Se cierra la ventana
                        $('#modal_nuevo_departamento').modal('hide');

                        //Cuando se termine de cerrar
                        $('#modal_nuevo_departamento').on('hidden.bs.modal', function (e) {
                            //Se recarga la tabla para que muestre los datos
                            $("#cont_departamentos").load("listas/cargar_interfaz", {tipo: 'departamento'});
                        });
                    };//if
                }else{  
                    //Se invoca la petición ajax que guardará el registro
                    departamento = ajax("<?php echo site_url('listas/guardar'); ?>", {"datos": datos_formulario, "tabla": "regiones"}, "html");

                    // Si se guardó correctamente
                    if(departamento){
                    	//Se cierra la ventana
                        $('#modal_nuevo_departamento').modal('hide');

                        //Cuando se termine de cerrar
                        $('#modal_nuevo_departamento').on('hidden.bs.modal', function (e) {
                            //Se recarga la tabla para que muestre los datos
                            $("#cont_departamentos").load("listas/cargar_interfaz", {tipo: 'departamento'});
                        });
                    };//if
                }
            }//if validacion

        	//Se detiene el formulario
            return false;
        });//Guardar pais
	});//document.rady
</script>