<!-- Se cargan los proveedores -->
<?php $proveedores = $this->listas_model->cargar_proveedores(); ?>

<!-- Botón agregar proveedor -->
<button id="btn_agregar_proveedor" type="button" class="btn btn-info btn-block">Agregar proveedor</button>
<br>

<!-- Tabla responsiva -->
<div class="table-responsive">
    <!-- Tabla -->
    <table id="proveedores" class="table">
        <!-- Cabecera -->
        <thead>
            <tr>
                <th class="alinear_centro" width="10%">Opc.</th>
                <th class="alinear_centro" width="5%">Id</th>
                <th class="alinear_centro">Nombre</th>
                <th class="alinear_centro">Nit</th>
                <th class="oculto">nit</th>
                <th class="oculto">Codigo verificación</th>
            </tr>
        </thead><!-- Cabecera -->
        <!-- Cuerpo -->
        <tbody>
            <?php
            //Contador
            $cont = 1;
            // Recorrido de los proveedores
            foreach ($proveedores as $proveedor) {
            ?>
            <tr>
                <td>
                    <span onclick="javascript:editar_dato(<?php echo $proveedor->intCodigo; ?>)" class="glyphicon glyphicon-edit"></span>
                </td><!-- Opciones -->
                <td class="alinear_derecha"><?php echo $proveedor->intCodigo; ?></td>
                <td id="input_nombre<?php echo $proveedor->intCodigo; ?>"><?php echo $proveedor->strNombre; ?></td>
                <td ><?php echo $proveedor->Nit.'-'.$proveedor->Codigo_Verificacion; ?></td>
                <td id="input_nit<?php echo $proveedor->intCodigo; ?>" class="oculto"><?php echo $proveedor->Nit; ?></td>
                <td id="input_nit_codigo_verificacion<?php echo $proveedor->intCodigo; ?>" class="oculto"><?php echo $proveedor->Codigo_Verificacion; ?></td>            
            </tr>
            <?php
            //Aumento de contador
            $cont++;
            } //Foreach
            ?>
        </tbody><!-- Cuerpo -->
    </table><!-- Tabla -->
</div><!-- Tabla responsiva -->

<!-- Modal nuevo proveedor -->
<div id="modal_nuevo_proveedor" class="modal fade">
    <form id="form_proveedor">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Cabecera -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Agregar nuevo proveedor</h4>
                </div><!-- Cabecera -->

                <!-- Cuerpo -->
                <div class="modal-body">
                    <!-- Container -->
                    <div class="container">
                        <div class="col-lg-12">
                            <!-- Nombre del proveedor -->
                            <input type="hidden" id="input_id_dato" value="">
                            <label for="input_nombre" class="control-label">Nombre *</label>
                            <input id="input_nombre" class="form-control input-sm" type="text" autofocus><!-- Nombre del proveedor -->
                        </div>
                    </div><!-- Container -->

                    <!-- Container -->
                        <div class="container">
                            <div class="col-lg-9">
                                <!-- Nit del proveedor -->
                                <label for="input_nit" class="control-label">Nit *</label>
                                <input id="input_nit" class="form-control input-sm" type="text" ><!-- Nit del proveedor -->
                            </div>

                            <div class="col-lg-3">
                                <!-- Código del Nit del proveedor -->
                                <label for="input_nit_codigo_verificacion" class="control-label">Código ver. *</label>
                                <input id="input_nit_codigo_verificacion" class="form-control input-sm" type="text" ><!-- Código del Nit del proveedor -->
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
</div><!-- /.modal nuevo proveedor -->

<script type="text/javascript">
    
    // Borrar formulario    
    function borrar_formulario(){        
        $('#input_id_dato').val('');            
        $('#input_nombre').val('');            
        $("#input_nit").val('');
        $("#input_nit_codigo_verificacion").val('');
    }

    // Cuando den clic sobre editar     
    function editar_dato(elemento){     
        borrar_formulario();
        
        //mostrar_elemento($("#" + elemento));     
        var input_nombre = document.getElementById('input_nombre'+elemento).innerHTML
        var input_nit = document.getElementById('input_nit'+elemento).innerHTML
        var input_nit_codigo_verificacion = document.getElementById('input_nit_codigo_verificacion'+elemento).innerHTML
        
        //alert("id_variable"+elemento); 
        $('#modal_nuevo_proveedor').modal('show');        
        $("#input_id_dato").val(elemento);        
        $("#input_nombre").val(input_nombre);        
        $("#input_nit").val(input_nit);
        $("#input_nit_codigo_verificacion").val(input_nit_codigo_verificacion);
        
    }

	$(document).ready(function(){
        // Inicialización de la tabla
        $('#proveedores').dataTable( {
            "bProcessing": true,
        }); // Tabla

        //Agregar proveedor
        $("#btn_agregar_proveedor").on("click", function(){
            //Se abre la ventana
            $('#modal_nuevo_proveedor').modal('show');
            borrar_formulario();
        });//Agregar proveedor

        //Recolección de datos
        var id_dato = $("#input_id_dato");
        var nombre = $("#input_nombre");
        var nit = $("#input_nit").numericInput();
        var codigo_verificacion = $("#input_nit_codigo_verificacion").numericInput();

        //Guardar proveedor
        $("#form_proveedor").on("submit", function(){
            //Datos a validar
            datos_obligatorios = new Array(
                nombre.val(),
                nit.val(),
                codigo_verificacion.val()
            );

            //Se ejecuta la validación de los campos obligatorios
            validacion = validar_campos_vacios(datos_obligatorios);

            //Si no supera la validacíón
            if (!validacion) {
                //Se muestra el mensaje de error
                mostrar_mensaje('Faltan datos', 'Por favor digite el nombre del proveedor.');
            } else {
                //Arreglo JSON de datos a enviar posteriormente
                datos_formulario = {
                    'strNombre': nombre.val(),
                    'Nit': nit.val(),
                    'Codigo_Verificacion': codigo_verificacion.val(),
                    'id_empresa': "<?php echo $this->session->userdata('id_empresa') ?>"
                };
                // imprimir(datos_formulario)
                 
                if(id_dato.val()!=''){
                    //Se invoca la petición ajax que guardará el registro
                    proveedor = ajax("<?php echo site_url('listas/actualizar'); ?>", {"datos": datos_formulario, "tabla": "proveedores", "campo": "intCodigo", "id_campo": id_dato.val() }, "html"); 

                    // Si se guardó correctamente
                    if(proveedor){
                        //Se cierra la ventana
                        $('#modal_nuevo_proveedor').modal('hide');

                        //Cuando se termine de cerrar
                        $('#modal_nuevo_proveedor').on('hidden.bs.modal', function (e) {
                            //Se recarga la tabla para que muestre los datos
                            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'proveedor'});
                        });
                    };//if
                }else{  
                    //Se invoca la petición ajax que guardará el registro
                    proveedor = ajax("<?php echo site_url('listas/guardar'); ?>", {"datos": datos_formulario, "tabla": "proveedores"}, "html");

                    // Si se guardó correctamente
                    if(proveedor){
                        //Se cierra la ventana
                        $('#modal_nuevo_proveedor').modal('hide');

                        //Cuando se termine de cerrar
                        $('#modal_nuevo_proveedor').on('hidden.bs.modal', function (e) {
                            //Se recarga la tabla para que muestre los datos
                            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'proveedor'});
                        });
                    };//if
                }    
            }//if validacion
            
            //Se detiene el formulario
            return false;
        });//Guardar proveedor
	});//document.ready
</script>