<?php
//Si ya existe empresa (o sea, sesión iniciada)
if ($this->session->userdata('id_empresa')) {
    //Se declara el id de la empresa
    $id_empresa = $this->session->userdata('nombre_usuario');
}
?>

<!-- Oculto -->
<input id="id_usuario_oculto" type="hidden" value="<?php echo $this->session->userdata('id_usuario'); ?>">

<!-- Id asociado de la transferencia -->
<input type="hidden" id="id_asociado_transferencia">

<!-- Contenedor principal -->
<div id="cont_inicio" class="col-lg-12">
    <!-- Contenedor del banner e información de eventos -->
    <div id="cont_inicio" class="col-lg-8">
        <!-- Banner -->
        <img src="<?php echo base_url().'img/cabezote_inicio.png' ?>" class="img-responsive" alt="Balancoop"><!-- Banner -->

        <!-- Banner -->
        <img src="<?php echo base_url().'img/publicidad.png' ?>" class="img-responsive" alt="Balancoop"><!-- Banner -->

        <!-- Información de la empresa usuaria -->
        <div class="col-lg-6">
            

            <!-- <h2>SEGMENTACIÓN</h2> -->
            <!-- <p>Nuestro sistema, le permite administrar toda la relación comercial, con sus clientes, asociados, prospectos. Oportunidades, Citas, Llamadas, Reuniones, Campañas, Agenda, Productos, Etc.</p> -->
            <!-- <p><a class="btn btn-default" href="http://balancoop.com/como-funciona.html" target="_blank">Más detalles &raquo;</a></p> -->
        </div><!-- Información de la empresa usuaria -->

        <div class="col-lg-6">
            <!-- <h2>BALANCE SOCIAL</h2> -->
            <!-- <p>Conforme va registrando sus actuaciones con los asociados, el sistema de CRM, le va alimentando automáticamente el balance social cooperativo por indicadores.</p> -->
            <!-- <p><a class="btn btn-default" href="http://balancoop.com/compa-ia.html" target="_blank">Más detalles &raquo;</a></p> -->
        </div>
    </div><!-- Contenedor del banner e información de eventos -->

    <!-- Contenedor de Inicio de sesión -->
    <div class="col-lg-4">
        <!-- Si no ha iniciado sesión -->
        <?php if(!$this->session->userdata('id_usuario')){ ?>
            <!-- Sesión para los asociados -->
            <div class="well row">
                <form id="sesion_asociado">
                    <h3>Asociados <small>Genere su transferencia solidaria.</small></h3>
                    
                    <!-- Empresa -->
                    <div class="col-sm-6">
                        <select id="select_empresa" class="col-sm-6 form-control input-sm">
                            <option value="">Empresa</option>
                            <?php foreach ($empresas as $empresa) { ?>
                                <option value="<?php echo $empresa->intCodigo; ?>"><?php echo $empresa->strNombre; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Empresa -->

                    <!-- Oficina -->
                    <div class="col-sm-6">
                        <select id="select_oficina" class="col-sm-6 form-control input-sm">
                            <option value="">Oficina</option>
                        </select>
                    </div><br><br> <!-- Oficina -->
                    
                    <!-- Usuario -->
                    <div class="col-sm-9">
                        <input id="input_documento" type="text" placeholder="Digite su número de cédula" class="form-control input-md" >
                    </div><!-- Usuario -->

                    <!-- Clave -->
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-primary btn-block btn-md">Entrar</button>
                    </div><!-- Clave -->
                </form>
            </div><!-- Sesión para los asociados -->
        
            <!-- Sesión para los usuarios -->
            <div class="well row">
                <form id="sesion_usuario">
                    <h3>Usuarios del sistema <small>Ingrese si posee datos de registro en nuestro sistema.</small></h3>

                    <div class="col-sm-12">
                        <input id="input_nit" type="text" placeholder="Digite el NIT de la empresa" class="form-control input-md" autofocus ><br>

                        <input id="input_usuario" type="text" placeholder="Digite su nombre de usuario" class="form-control input-md" ><br>
                        <input id="input_password" type="password" placeholder="Digite su contraseña" class="form-control input-md" ><br>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-md">Iniciar sesión</button>
                </form>
            </div><!-- Sesión para los usuarios -->
        </div><!-- Contenedor de Inicio de sesión -->
    <?php } else { ?>
        <div class="jumbotron">
            <!-- Logo -->
            <figure>
                <center>
                    <!-- Si existe empresa -->
                    <?php if (isset($id_empresa)) { $imagen = base_url()."img/logos/".$this->session->userdata('id_empresa').".png"; ?>
                        <!-- Carga imagen -->
                        <img id="logo_empresa" src="<?php echo $imagen; ?>" alt="" align="center">    
                    <?php } ?>
                </center>
            </figure><!-- Logo -->
            <h2>Sesión iniciada <small><?php echo $this->session->userdata('nombre_usuario'); ?></small></h2><br>
            <h4><a id="btn_datos" href="#"><span class="glyphicon glyphicon-user"></span> Modificar mis datos</a></h4>
            <h4><a href="<?php echo site_url('inicio/cerrar_sesion'); ?>"><span class="glyphicon glyphicon-remove"></span> Cerrar sesión</a></h4>
        </div>
    <?php } ?>
</div><!-- Contenedor principal -->
<div id="cont_datos"></div>
<div id="cont_crear_clave"></div>
<div class="clear"></div>

<script type="text/javascript">       
    function crear_clave(){
        imprimir("aqui")
        //Cargamos la interfaz
        // $("#cont_crear_clave").load("<?php echo site_url('inicio/cargar_interfaz'); ?>", {tipo: 'usuario_clave_crear', id_usuario: $("#id_asociado_transferencia").val()});

        // Se envía email con los datos para  
    } // crear_clave

    // Cuando el documento esté listo
    $(document).ready(function(){
        // Se almacena el tipo de usuario
        id_tipo_usuario = "<?php echo $this->session->userdata('tipo'); ?>";

        // Si el usuario es 2 (configurador)
        if(id_tipo_usuario == "2"){
            // Mensaje
            imprimir("Configurando estados...");

            // Se invoca el ajax que actualizará los estados
            estado_consejero = ajax("<?php echo site_url('inicio/actualizar_estados') ?>", {"tipo": "consejero"}, "html");
            estado_delegado = ajax("<?php echo site_url('inicio/actualizar_estados') ?>", {"tipo": "delegado"}, "html");
            estado_junta = ajax("<?php echo site_url('inicio/actualizar_estados') ?>", {"tipo": "junta"}, "html");
            estado_comites = ajax("<?php echo site_url('inicio/actualizar_estados') ?>", {"tipo": "comites"}, "html");
            

            // Mensajes
            imprimir(estado_consejero + " registros afectados como consejero");
            imprimir(estado_delegado + " registros afectados como delegado");
            imprimir(estado_junta + " registros afectados como junta");
            imprimir(estado_comites + " registros afectados como comités");
        } else {
            // Mensaje
            imprimir("Estados no se configurarán.");
        }

        // Modificar datos del usuario
        $("#btn_datos").on("click", function(){
            //Cargamos la interfaz
            $("#cont_datos").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'usuario_modificar', id_usuario: $("#id_usuario_oculto").val()});
        }); // Modificar datos del usuario

        //Recolección de datos de sesión
        var documento = $("#input_documento").numericInput();
        var empresa = $("#select_empresa");
        var nit = $("#input_nit");
        var oficina = $("#select_oficina");
        var usuario = $("#input_usuario");
        var password = $("#input_password");

        /**
         * Cuando se seleccione una empresa
         */
        empresa.on("change", function(){
            //Si se selecciona alguna empresa
            if ($(this).val() != "") {
                //Por ajax se consultan las oficinas
                oficinas = ajax("<?php echo site_url('inicio/cargar_oficinas'); ?>", {'id_empresa': $(this).val()}, "JSON");
                
                // Si trae oficinas
                if (oficinas.length > 0) {
                    //Se resetea el select y se agrega una option vacia
                    $(oficina).html('').append("<option value='0'>Todas las oficinas</option>");
                } else {
                    //Se resetea el select y se agrega una option de no encontrado
                    $(oficina).html('').append("<option value=''>Ninguna oficina encontrada...</option>");
                } //if

                //Se recorren las oficinas
                $.each(oficinas, function(key, val){
                    //Se agrega cada oficina al select
                    $(oficina).append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
                })//Fin each
            };
        });

        //submit asociado
        $("#sesion_asociado").on("submit", function(){
            //Datos a validar
            datos_obligatorios = new Array(
                documento.val(),
                oficina.val()
            );

            //Se ejecuta la validación de los campos obligatorios
            validacion = validar_campos_vacios(datos_obligatorios);

            //Si no supera la validacíón
            if (!validacion) {
                //Se muestra el mensaje de error
                mostrar_mensaje('Documento no digitado', 'Por favor digite su número de documento de identificación y seleccione la empresa y la oficina.');

                return false;
            } // if

            //Validaremos la información mediante ajax
            encontrado = ajax("<?php echo site_url('transferencia/buscar_asociado'); ?>", {"documento": documento.val(), "id_empresa": empresa.val()}, 'JSON');

            // Si se encontró el usuario
            if(encontrado) {
                imprimir(encontrado.id_Asociado)
                // Se muestra la pantalla para pedir contraseña
                $("#cont_datos").load("<?php echo site_url('inicio/cargar_interfaz'); ?>", {"tipo": 'usuario_clave', "id_asociado": encontrado.id_Asociado, "documento": documento.val(), "id_empresa": empresa.val(), "id_oficina": oficina.val()});               
            } else {
                //Se muestra el mensaje de error
                mostrar_mensaje('No se ha podido entrar', 'El número que ingresó no ha sido encontrado en nuestra base de datos. Por favor verifíquelo e intente nuevamente');
            } //if

            //Se detiene el formulario
            return false;
        });//submit asociado

        //submit usuario
        $("#sesion_usuario").on("submit", function(){
            imprimir("Validando usuario del sistema...");

            //Datos a validar
            datos_obligatorios = new Array(
                nit.val(),
                usuario.val(),
                password.val()
            );

            //Se ejecuta la validación de los campos obligatorios
            validacion = validar_campos_vacios(datos_obligatorios);

            //Si no supera la validacíón
            if (!validacion) {
                //Se muestra el mensaje de error
                mostrar_mensaje('Faltan datos', 'Por favor digite el NIT o documento, nombre de usuario y la contraseña.');
            } else {
                //Primero, verificaremos el id de la empresa, según el nit
                empresa = ajax("<?php echo site_url('inicio/obtener_id_empresa'); ?>", {'documento': nit.val()}, 'JSON');

                sesion_usuario = ajax("<?php echo site_url('inicio/validar_sesion'); ?>", {'nit': nit.val(), 'usuario': usuario.val(), 'password': password.val(), 'id_empresa': empresa.intCodigo}, 'html');

                //Si la sesion no es exitosa
                if(!sesion_usuario) {
                    mostrar_mensaje('No se ha podido iniciar sesión', 'El usuario y la contraseña no coinciden en la base de datos. Verifique que los haya digitado bien, al igual que el número del NIT.');
                } else {
                    //Se redirecciona
                    redireccionar("<?php echo site_url(''); ?>");
                } //if

            } // if

            //Se detiene el formulario
            return false;
        });//submit usuario
    });//document.ready
</script>