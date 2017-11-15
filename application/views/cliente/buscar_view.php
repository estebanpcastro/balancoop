<?php
// Se resetea el actualizador
$this->session->set_userdata('Actualizacion', '0');

// Si es formulario de actualización
if ($this->uri->segment(3) == md5('Actualización')) {
    // Se imprime el título del formulario
    echo '<center><h3>Actualización de datos del asociado</h3></center>';
} // if

// echo $this->session->userdata("Actualizacion")."<br>";
// echo $this->session->userdata("id_empresa")."<br>";
?>

<center>
    <form id="form_busqueda" role="search">
        <div class="form-group">
            <div class="col-sm-10">
                <?php
                // Si viene un número de cédula
                if ($this->uri->segment(3)) {
                    // Si el número es la clave de actualización
                    if ($this->uri->segment(3) === '93ab1912d6c36beb191f27453aa284db') {
                        // Variable de sesión
                        $this->session->set_userdata('Actualizacion', '1');
                        $this->session->set_userdata('id_empresa', $this->uri->segment(4));
                        ?>
                        <div class="form-group">
                            <div class="col-sm-8">
                                <!-- Input vacío -->
                                <input  id="input_busqueda" type="text" class="form-control" value="" autofocus>
                            </div>

                            <div class="col-sm-4">
                            <!-- Empresa -->
                                <select id="select_empresa_actualizacion" class="col-sm-6 form-control input-sm">
                                    <option value="0">Empresa</option>
                                    <?php foreach ($this->listas_model->cargar('empresas_usuarias') as $empresa) { ?>
                                        <option value="<?php echo $empresa->intCodigo; ?>"><?php echo $empresa->strNombre; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <?php
                    }else{
                        // Si ha iniciado sesión
                        if ($this->session->userdata('id_usuario')) {
                            ?>
                            <!-- Input con la cédula -->
                            <input  id="input_busqueda" type="text" class="form-control" value="<?php echo $this->uri->segment(3); ?>" autofocus>
                            <?php
                        }
                    }
                 }else{
                    // Si ha iniciado sesión
                    if ($this->session->userdata('id_usuario')) {
                        // Input vacío
                        echo '<input  id="input_busqueda" type="text" class="form-control" placeholder="Digite el número de cédula del cliente" autofocus>';
                    }
                }
                ?>
            </div>
            <div class="col-sm-2s">
                <?php
                // Si ha iniciado sesión o es clave de búsqueda
                if ($this->session->userdata('id_usuario') || $this->uri->segment(3) === '93ab1912d6c36beb191f27453aa284db') {
                    echo '<button type="submit" class="btn btn-default">Buscar</button>';
                }
                ?>
            </div>
        </div>
    </form>

    <!-- Input oculto con el id del asociado -->
    <input type="hidden" id="input_id_asociado">

    <!-- Contenedor de cliente -->
    <div id="cont_cliente"></div>
</center>

<script type="text/javascript">
    $(document).ready(function(){
        // Declaración de variables
        var busqueda = $("#input_busqueda");
        var id_asociado = $("#input_id_asociado"); 
        
        /**
         * Cuando se busque la cédula
         */
        $("#form_busqueda").on("submit", function(){
            var actualizado = "<?php echo $this->session->userdata('Actualizacion'); ?>";
            var id_empresa_sesion = "<?php echo $this->session->userdata('id_empresa'); ?>";
            var id_empresa_actualizacion = $("#select_empresa_actualizacion");
            var id_empresa = null;

            // Validar que se haya escrito algo
            if($.trim(busqueda.val()) == ""){
                // Se muestra el mensaje de error
                mostrar_mensaje('Digite un número de cédula', 'Por favor digite un número de cédula.');

                return false;
            }// if

            // Si es de actualización y no tiene la empresa elegida
            if (actualizado == 1 && id_empresa_actualizacion.val() == "0") {
                //Se muestra el mensaje de error
                mostrar_mensaje('Seleccione la empresa', 'Seleccione la empresa.');

                return false;
            };

            if (actualizado == 1) {
                // Se asigna el id
                id_empresa = id_empresa_actualizacion.val();

                // Se carga el id de la empresa a la sesión por ajax
                sesion_empresa = ajax("<?php echo site_url('actualizacion/nueva_sesion_empresa'); ?>", {id_empresa: id_empresa}, "html");
            }else{
                id_empresa = id_empresa_sesion;
            }

            // Petición para buscar el documento
            encontrado = ajax("<?php echo site_url('cliente/buscar'); ?>", {'documento': busqueda.val(), 'id_empresa': id_empresa}, 'json');
            // imprimir(encontrado);
            // imprimir("Empresa " + id_empresa);
            
            //Si se encontró
            if(encontrado != 'false'){
                //Se envía el id a un input invisible
                id_asociado.val(encontrado.id_Asociado);
            }

            /**
             * Cargaremos las vistas del asociado, y traeremos contenido, si el id existe
             */
            $("#cont_cliente").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {"tipo": 'cliente', "id_asociado": id_asociado.val()});

            //Se muestra la barra de carga
            cargando($("#cont_cliente"));
            
            // Se detiene el formulario
            return false;
        });// form busqueda
    });//Document.ready
</script>