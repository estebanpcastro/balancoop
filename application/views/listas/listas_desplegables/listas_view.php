<?php
//Se cargan los elementos de base de datos
$datos = $this->listas_model->cargar($tabla);
?>

<!-- Nombre de la tabla -->
<input type="hidden" id="tabla_lista" value="<?php echo $tabla; ?>">

<!-- Sólo los super administradores pueden crear-->
<?php if ($this->session->userdata('tipo') == "3") { ?>
    <!-- Botón agregar dato -->
    <button id="btn_agregar_dato" type="button" class="btn btn-info btn-block">Agregar dato a la lista</button>
<?php } ?>
<br>

<!-- Tabla responsiva -->
<div class="table-responsive">
	<!-- Tabla -->
	<table id="tabla_listas" class="table">
		<!-- Cabecera -->
        <thead>
            <th class="alinear_centro" width="10%">Opc.</th>
            <th class="alinear_centro" width="5%">Nro.</th>
            <th class="alinear_centro">Nombre</th>
            <th class="alinear_centro">Estado</th>
            <th class="oculto">Estado</th>
        </thead><!-- Cabecera -->
        <!-- Cuerpo -->
        <tbody>
            <?php
            //Contador
            $cont = 1;
            // Recorrido de los productos
            foreach ($datos as $dato) {
            ?>
            <tr>
                <td>
                    <span onclick="javascript:editar_dato(<?php echo $dato->intCodigo; ?>)" class="glyphicon glyphicon-edit"></span>
                </td>
                <td class="alinear_derecha"><?php echo $cont; ?></td>
                <td id="input_nombre<?php echo $dato->intCodigo; ?>"><?php echo $dato->strNombre; ?></td>
                <td ><?php if($dato->Estado) {echo "Activo";}else{echo "Inactivo";} ?></td>
                <td id="select_estado<?php echo $dato->intCodigo; ?>" class="oculto"><?php echo $dato->Estado; ?></td>
            </tr>
            <?php
            //Aumento de contador
            $cont++;
            } //Foreach
            ?>
        </tbody><!-- Cuerpo -->
	</table><!-- Listas -->
<div><!-- Tabla responsiva -->

<!-- Modal nuevo dato a una lista -->
<div id="modal_nuevo_dato" class="modal fade">
    <form id="form_dato">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Cabecera -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Agregar nuevo dato a la lista desplegable</h4>
                </div><!-- Cabecera -->

                <!-- Cuerpo -->
                <div class="modal-body">
                    <!-- Container -->
                    <div class="container">
                        <div class="col-lg-6">
                            <!-- Nombre del dato -->
                            <input type="hidden" id="input_id_dato" value="">
                            <label for="input_nombre" class="control-label">Nombre del dato</label>
                            <input id="input_nombre" class="form-control input-sm" type="text" autofocus ><!-- Nombre del dato -->
                        </div>
                        <div class="col-lg-6">
                            <!-- Estado del dato -->
                            <label for="select_estado" class="control-label">Estado del dato</label>
                            <select id="select_estado" class="form-control input-sm">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select><!-- Estado del dato -->
                        </div>
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
</div><!-- Modal nuevo dato a una lista -->

<script type="text/javascript">
    
    // Borrar formulario    
    function borrar_formulario(){        
        $('#input_id_dato').val('');            
        $('#input_nombre').val('');            
        $("#select_estado").val('1');
    }

    // Cuando den clic sobre editar     
    function editar_dato(elemento){     
        borrar_formulario();
        
        //mostrar_elemento($("#" + elemento));     
        var input_nombre = document.getElementById('input_nombre'+elemento).innerHTML
        var select_estado = document.getElementById('select_estado'+elemento).innerHTML
        
        //alert("id_variable"+elemento); 
        $('#modal_nuevo_dato').modal('show');        
        $("#input_id_dato").val(elemento);        
        $("#input_nombre").val(input_nombre);        
        $("#select_estado").val(select_estado);
        
    }

    $(document).ready(function(){
        // Inicialización de la tabla
        $('#tabla_listas').dataTable( {
            "bProcessing": true,
        }); // Tabla

        //Agregar dato a la lista
        $("#btn_agregar_dato").on("click", function(){
            //Se abre la ventana
            $('#modal_nuevo_dato').modal('show');
            borrar_formulario();
        });//Agregar dato a la lista

        //Recolección de datos
        var id_dato = $("#input_id_dato");
        var nombre = $("#input_nombre");
        var estado = $("#select_estado");
        var tabla = $("#tabla_lista");
        //alert(tabla.val());

        //Guardar dato
        $("#form_dato").on("submit", function(){
            //Datos a validar
            datos_obligatorios = new Array(
                nombre.val()
            );

            //Se ejecuta la validación de los campos obligatorios
            validacion = validar_campos_vacios(datos_obligatorios);

            //Si no supera la validacíón
            if (!validacion) {
                //Se muestra el mensaje de error
                mostrar_mensaje('Aun no se ha completado el registro', 'Por favor ingrese el nombre del dato que va a ingresar en la lista.');
            } else {
                // Arreglo JSON de datos a enviar posteriormente
                datos_formulario = {
                    'Estado': estado.val(),
                    'strNombre': nombre.val()
                };
                imprimir(datos_formulario);
                if(id_dato.val()!=''){
                    //Se invoca la petición ajax que guardará el registro
                    dato = ajax("<?php echo site_url('listas/actualizar'); ?>", {"datos": datos_formulario, "tabla": tabla.val(), "campo": "intCodigo", "id_campo": id_dato.val() }, "html"); 
                    
                    // Si se guardó correctamente
                    if(dato){
                        imprimir("Se actualizó")
                        //Se cierra la ventana
                        $('#modal_nuevo_dato').modal('hide');

                        //Cuando se termine de cerrar
                        $('#modal_nuevo_dato').on('hidden.bs.modal', function (e) {
                            //Se recarga la tabla para que muestre los datos
                            $("#cont_listas_desplegables").load("listas/cargar_interfaz", {tipo: 'lista_desplegable', tabla: tabla.val()});
                        });
                    }
                }else{ 
                    //Se invoca la petición ajax que guardará el registro
                    dato = ajax("<?php echo site_url('listas/guardar'); ?>", {"datos": datos_formulario, "tabla": tabla.val()}, "html");
                    
                    // Si se guardó correctamente
                    if(dato){
                        imprimir("Seguardó")
                        //Se cierra la ventana
                        $('#modal_nuevo_dato').modal('hide');

                        //Cuando se termine de cerrar
                        $('#modal_nuevo_dato').on('hidden.bs.modal', function (e) {
                            //Se recarga la tabla para que muestre los datos
                            $("#cont_listas_desplegables").load("listas/cargar_interfaz", {tipo: 'lista_desplegable', tabla: tabla.val()});
                        });
                    }
                }    
            }//if validacion

            //Se detiene el formulario
            return false;
        });//Guardar dato
    });//document.rady
</script>