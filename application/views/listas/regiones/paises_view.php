<!-- Se cargan los datos necesarios -->
<?php $paises = $this->listas_model->cargar_paises(); ?>

<!-- Tabla responsiva -->
<div id="tabla_paises" class="table-responsive">
    <!-- Tabla -->
    <table id="paises" class="table">
        <!-- Cabecera -->
        <thead>
            <tr>
                <th class="alinear_centro">Opc.</th>
                <th class="alinear_centro">Código</th>
                <th class="alinear_centro">Nombre</th>
                <th class="oculto">Estado</th>
                <th class="alinear_centro">Estado</th>
                <th class="oculto">codigo</th>
            </tr>
        </thead><!-- Cabecera -->
        <!-- Cuerpo -->
        <tbody>
            <?php
            $cont = 1;
            // Recorrido de los paises
            foreach ($paises as $pais) {
            ?>
            <tr>
                <td class="alinear_derecha">
                    <a href="javascript:cargar_departamentos('<?php echo $pais->strCodigo; ?>')" alt="Ver ciudades"><span class="glyphicon glyphicon-search icono"></span></a>
                    <!-- Sólo los super usuarios pueden modificar -->
                    <?php if ($this->session->userdata('tipo') == "3") { ?>
                        <a href="javascript:editar_pais(<?php echo $cont; ?>)" alt="Editar país">
                            <span class="glyphicon glyphicon-edit icono"></span>
                        </a>
                    <?php } ?>
                </td>
                <td ><?php echo substr($pais->strCodigo, 0, 4); ?></td>
                <td id="nombre<?php echo $cont; ?>" ><?php echo $pais->strNombre; ?></td>
                <td id="estado<?php echo $cont; ?>" class="oculto"><?php echo $pais->Estado; ?></td>
                <td><?php if($pais->Estado == "1"){echo "Activo";}else{echo "Inactivo";} ?></td>
                <td id="codigo<?php echo $cont; ?>" class="oculto"><?php echo $pais->strCodigo; ?></td>
            </tr>
            <?php
            $cont++;
            } //Foreach
            ?>
        </tbody><!-- Cuerpo -->
    </table><!-- Tabla -->
</div><!-- Tabla responsiva -->

<!-- Modal nuevo país -->
<div id="modal_nuevo_pais" class="modal fade">
	<form id="form_pais">
        <div class="modal-dialog">
            <div class="modal-content">
				<!-- Cabecera -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Gestion de países</h4>
                </div><!-- Cabecera -->

                <!-- Cuerpo -->
                <div class="modal-body">
                    <!-- Container -->
                    <div class="container">
                        <div class="col-lg-4">
                        	<!-- Código del país -->
                            <input type="hidden" id="input_id_dato" value="">
                            <label for="input_codigo_pais" class="control-label">Código</label>
                            <input id="input_codigo_pais" class="form-control input-sm" type="text" autofocus><!-- Código del país -->
                    	</div>

                    	<div class="col-lg-4">
                        	<!-- Nombre del país -->
                            <label for="input_nombre_pais" class="control-label">Nombre</label>
                            <input id="input_nombre_pais" class="form-control input-sm" type="text"><!-- Nombre del país -->
                    	</div>

                        <div class="col-lg-4">
                            <!-- Estado del país -->
                            <label for="select_estado_pais" class="control-label">Estado</label>
                            <select id="select_estado_pais" class="form-control input-sm">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select><!-- Estado del país -->
                        </div>
                    </div><!-- Container -->
                </div><!-- Cuerpo -->

                <!-- Pie -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <!-- <button type="button" class="btn btn-success" data-dismiss="modal">Guardar</button> -->
                </div><!-- Pie -->
        	</div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- /.modal nuevo país -->

<script type="text/javascript">
    // Borrar formulario    
    function borrar_formulario(){        
        $('#input_id_dato').val('');            
        $('#input_nombre_pais').val('');            
        $("#input_codigo_pais").val('');
        $("#select_estado_pais").val('');
    }

    // Cuando den clic sobre editar     
    function editar_pais(elemento){     
        borrar_formulario();
        //alert('nombre'+elemento);
        //mostrar_elemento($("#" + elemento));     
        var input_nombre_pais = document.getElementById('nombre'+elemento).innerHTML
        var input_codigo_pais = document.getElementById('codigo'+elemento).innerHTML
        var estado_pais = document.getElementById('estado'+elemento).innerHTML
        
        //alert("id_variable"+elemento); 
        $('#modal_nuevo_pais').modal('show');        
        $("#input_id_dato").val(input_codigo_pais);        
        $("#input_nombre_pais").val(input_nombre_pais);        
        $("#input_codigo_pais").val(input_codigo_pais);
        $('#select_estado_pais > option[value="' + estado_pais +'"]').attr('selected', 'selected');
    }

	$(document).ready(function(){
        // Inicialización de la tabla
        $('#paises').dataTable({
            "bProcessing": true,
        }); // Tabla

        //Agregar país
        $("#btn_agregar_pais").on("click", function(){
            //Se abre la ventana
            $('#modal_nuevo_pais').modal('show');
        });//Agregar país

        //Recolección de datos
        var id_dato = $("#input_id_dato");
        var codigo = $("#input_codigo_pais").numericInput();
        var nombre = $("#input_nombre_pais");
        var estado = $("#select_estado_pais");

        //Guardar pais
        $("#form_pais").on("submit", function(){
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
                mostrar_mensaje('Faltan datos', 'Por favor ingrese toda la información para guardar el país.');
            } else {
            	//Arreglo JSON de datos a enviar posteriormente
                datos_formulario = {
                    'Estado': estado.val(),
                    'strNombre': nombre.val(),
                    'strCodigo': codigo.val(),
                    'strTipo': 'P'
                };
                // imprimir(datos_formulario)
                if(id_dato.val()!=''){
                    //Se invoca la petición ajax que guardará el registro
                    pais = ajax("<?php echo site_url('listas/actualizar'); ?>", {"datos": datos_formulario, "tabla": "regiones", "campo": "strCodigo", "id_campo": id_dato.val() }, "html"); 
                    // Si se guardó correctamente
                    if(pais){
                        //Se cierra la ventana
                        $('#modal_nuevo_pais').modal('hide');

                        //Cuando se termine de cerrar
                        $('#modal_nuevo_pais').on('hidden.bs.modal', function (e) {
                            //Se recarga la tabla para que muestre los datos
                            $("#cont_paises").load("listas/cargar_interfaz", {tipo: 'pais'});
                        });
                    };//if
                }else{  
                    //Se invoca la petición ajax que guardará el registro
                    pais = ajax("<?php echo site_url('listas/guardar'); ?>", {"datos": datos_formulario, "tabla": "regiones"}, "html");

                    // Si se guardó correctamente
                    if(pais){
                        //Se cierra la ventana
                        $('#modal_nuevo_pais').modal('hide');

                        //Cuando se termine de cerrar
                        $('#modal_nuevo_pais').on('hidden.bs.modal', function (e) {
                            //Se recarga la tabla para que muestre los datos
                            $("#cont_paises").load("listas/cargar_interfaz", {tipo: 'pais'});
                        });
                    };//if
                }    
            }//if validacion

        	//Se detiene el formulario
            return false;
        });//Guardar pais
    });//document.ready
</script>