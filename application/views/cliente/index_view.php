<?php 
// Tamaño de las cajas
$tamanio = 6;

//Si viene un id de asociado, se usará para cargar datos, sino, cargaremos todo vacío
if (isset($id_asociado)) {
	//Se consultan los datos del asociado
    $asociado = $this->cliente_model->cargar_asociado($id_asociado);

    if ($this->session->userdata('Actualizacion') == '1') {
        // Tamaño de las cajas
        $tamanio = 12;
    }
    ?>
        <input type="hidden" id="id_asociado_oculto" value="<?php echo $id_asociado; ?>">
    <?php
}else{
    ?>
        <input type="hidden" id="id_asociado_oculto" value="0">
    <?php
}
?>

<input type="hidden" id="actualizacion" value="<?php echo $this->session->userdata('Actualizacion'); ?>">
<input type="hidden" id="fecha_actualizacion">
<input type="hidden" id="es_actualizacion" value="<?php echo $this->session->userdata('Actualizacion'); ?>">


<!-- Formulario -->
<form id="form_cliente" class="form-horizontal" role="form">
	<!-- Columna 1 -->
    <div id="cont_datos_personales" class="col-lg-<?php echo $tamanio; ?>">
        <!-- Panel datos personales -->
    	<?php $this->load->view('cliente/datos_personales_view'); ?><!-- Panel datos personales -->

        <!-- Panel datos de residencia -->
        <?php $this->load->view('cliente/datos_residencia_view'); ?><!-- Panel datos de residencia -->

        <!-- Panel datos del cónyugue -->
        <?php $this->load->view('cliente/datos_conyugue_view'); ?><!-- Panel datos del cónyugue -->

        <!-- Panel Gustos y preferencias -->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <!-- Expandir - Contraer --> 
                <a style="color:#FFFFFF" href="javascript:expandir_contraer('datos_gustos')">        
                    <h3 class="panel-title"><span class="glyphicon glyphicon-camera"></span> Gustos y preferencias</h3>
                </a><!-- Expandir - Contraer -->  
            </div>
            <div class="panel-body" id="datos_gustos">
                <div class="oculto">
                    <!-- Panel gustos y preferencias -->
                    <?php $this->load->view('cliente/gustos_view'); ?><!-- Panel gustos y preferencias -->
                </div>
            </div>
        </div><!-- Panel Gustos y preferencias -->

        <!-- Panel Hijos -->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-sort-by-attributes-alt"></span> Hijos</h3>
            </div>
            <div class="panel-body">
                <!-- Contenedor para agregar los hijos -->
                <div id="hijos"></div>

                <!-- Botón agregar hijo -->
                <button id="btn_agregar_hijo" type="button" class="btn btn-info btn-block btn-xs">Agregar hijo</button>
            </div>
        </div><!-- Panel Hijos -->
    </div><!-- Columna 1 -->

    <!-- Columna 2 -->
    <div class="col-lg-6">
        <!-- Cuando sea actualización de datos eterno, no se visualiza -->
        <?php if ($this->session->userdata('Actualizacion') !== '1') { ?>
            <!-- Panel Beneficiarios -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-ok-sign"></span> Beneficiarios</h3>
                </div>
                <div class="panel-body">

                    <!-- Contenedor para agregar los beneficiarios -->
                    <div id="beneficiarios"></div>

                    <!-- Botón agregar beneficiario -->
                    <button id="btn_agregar_beneficiario" type="button" class="btn btn-info btn-block btn-xs">Agregar beneficiario</button>
                </div>
            </div><!-- Panel Beneficiarios -->
        <?php } ?>
        
        <!-- Cuando sea actualización de datos eterno, no se visualiza -->
        <?php if ($this->session->userdata('Actualizacion') !== '1') { ?>
            <!-- Panel Personas conocidas -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-thumbs-up"></span> Personas conocidas</h3>
                </div>
                <div class="panel-body">
                    <!-- Contenedor para agregar los conocidos -->
                    <div id="conocidos"></div>

                    <!-- Botón agregar beneficiario -->
                    <button id="btn_agregar_conocido" type="button" class="btn btn-info btn-block btn-xs">Agregar conocido</button>
                </div>
            </div><!-- Panel Personas conocidas -->
        <?php } ?>

        <!-- Cuando sea actualización de datos eterno, no se visualiza -->
        <?php if ($this->session->userdata('Actualizacion') !== '1') { ?>
            <!-- Panel Cargos -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-plus"></span> Cargos</h3>
                </div>
                <div class="panel-body">
                    <!-- Contenedor para agregar los cargos -->
                    <div id="cargos"></div>

                    <!-- Botón agregar cargo -->
                    <button id="btn_agregar_cargos" type="button" class="btn btn-info btn-block btn-xs">Agregar cargo</button>
                </div>
            </div><!-- Panel Cargos -->
        <?php } ?>
    </div>

    <!-- Guardar -->
    <button type="submit" class="col-lg-12 btn btn-success btn-lg btn-block">Guardar</button>
</form><!-- Formulario -->

<script type="text/javascript">
    $(document).ready(function(){
        var id_asociado = $("#id_asociado_oculto").val();

        //Recolección de datos personales
        var asignado = $("#input_asignado");
        var responsable = $("#input_responsable");
        var codigo_asociado = $("#input_codigo_asociado");
        var tipo_identificacion = $("#input_tipo_identificacion");
        var lugar_expedicion = $("#input_lugar_expedicion");
        var identificacion_cliente = $("#input_identificacion_cliente").numericInput();
        var designacion_cliente = $("#input_designacion_cliente");
        var nombre_cliente = $("#input_nombre_cliente");
        var apellido1 = $("#input_apellido1");
        var apellido2 = $("#input_apellido2");
        var dia_nacimiento_cliente = $("#dia_nacimiento_cliente");
        var mes_nacimiento_cliente = $("#mes_nacimiento_cliente");
        var anio_nacimiento_cliente = $("#anio_nacimiento_cliente");
        var lugar_nacimiento = $("#input_lugar_nacimiento");
        var genero_cliente = $("#input_genero_cliente");
        var cabeza_familia_cliente = $("#input_cabeza_familia_cliente");
        var origen_cliente = $("#input_origen_cliente");
        var tipo = $("#input_tipo");
        var email_cliente = $("#input_email_cliente");
        var dia_ingreso_cliente = $("#dia_ingreso_cliente");
        var mes_ingreso_cliente = $("#mes_ingreso_cliente");
        var anio_ingreso_cliente = $("#anio_ingreso_cliente");
        var numero_carne = $("#input_numero_carne");
        var estado_actual_entidad = $("#input_estado_actual_entidad");
        var dia_retiro_cliente = $("#dia_retiro_cliente");
        var mes_retiro_cliente = $("#mes_retiro_cliente");
        var anio_retiro_cliente = $("#anio_retiro_cliente");
        var motivo_retiro = $("#input_motivo_retiro");
        var estado_empleado = $("#input_estado_empleado");
        var estado_delegado = $("#input_estado_delegado");
        var dia_inicio_cliente = $("#dia_inicio_cliente");
        var mes_inicio_cliente = $("#mes_inicio_cliente");
        var anio_inicio_cliente = $("#anio_inicio_cliente");
        var tipo_empleado = $("#input_tipo_empleado");
        var ubicacion_empleado = $("#input_ubicacion_empleado");
        var dia_inicio_delegado = $("#dia_inicio_delegado");
        var mes_inicio_delegado = $("#mes_inicio_delegado");
        var anio_inicio_delegado = $("#anio_inicio_delegado");
        var dia_fin_delegado = $("#dia_fin_delegado");
        var mes_fin_delegado = $("#mes_fin_delegado");
        var anio_fin_delegado = $("#anio_fin_delegado");
        var estado_consejero = $("#input_estado_consejero");
        var dia_inicio_consejero = $("#dia_inicio_consejero");
        var mes_inicio_consejero = $("#mes_inicio_consejero");
        var anio_inicio_consejero = $("#anio_inicio_consejero");
        var dia_fin_consejero = $("#dia_fin_consejero");
        var mes_fin_consejero = $("#mes_fin_consejero");
        var anio_fin_consejero = $("#anio_fin_consejero");
        var estado_junta = $("#input_estado_junta");
        var dia_inicio_junta = $("#dia_inicio_junta");
        var mes_inicio_junta = $("#mes_inicio_junta");
        var anio_inicio_junta = $("#anio_inicio_junta");
        var dia_fin_junta = $("#dia_fin_junta");
        var mes_fin_junta = $("#mes_fin_junta");
        var anio_fin_junta = $("#anio_fin_junta");
        var estado_directivo = $("#input_estado_directivo");
        var estado_comites = $("#input_estado_comites");
        var dia_inicio_comites = $("#dia_inicio_comites");
        var mes_inicio_comites = $("#mes_inicio_comites");
        var anio_inicio_comites = $("#anio_inicio_comites");
        var dia_fin_comites = $("#dia_fin_comites");
        var mes_fin_comites = $("#mes_fin_comites");
        var anio_fin_comites = $("#anio_fin_comites");
        var habil = $("#input_habil");
        var rango_ingreso = $("#input_rango_ingreso");
        var grupo_familiar = $("#input_grupo_familiar").numericInput();
        var recibir_emails = $("#input_recibir_emails");
        var recibir_medios_internos = $("#input_recibir_medios");
        var oficina_cliente = $("#input_oficina_cliente");
        var estado_civil = $("#input_estado_civil");
        var escolaridad_cliente = $("#input_escolaridad_cliente");
        var industria_cliente = $("#input_industria_cliente");
        var profesion_cliente = $("#input_profesion_cliente");
        var conocimiento_cooperativismo = $("#input_conocimiento_cooperativismo");
        var total_ano_actual = $("#input_total_ano_actual").numericInput();
        var total_ultimo_trimestre = $("#input_total_ultimo_trimestre").numericInput();
        var ingreso_real = $("#input_ingreso_real").numericInput();
        var centro_costos_cliente = $("#input_centro_costos_cliente").numericInput();
        var aporte_social_cliente = $("#input_aporte_social_cliente").numericInput();
        var cuota_admision_cliente = $("#input_cuota_admision_cliente").numericInput();

        //Recolección de datos de residencia
        var direccion_cliente = $("#input_direccion_cliente");
        var pais_cliente = $("#input_pais_cliente");
        var departamento_cliente = $("#input_departamento_cliente");
        var ciudad_cliente = $("#input_ciudad_cliente");
        var barrio_cliente = $("#input_barrio_cliente");
        var zona_cliente = $("#input_zona_cliente");
        var estrato_cliente = $("#input_estrato_cliente");
        var celular_cliente = $("#input_celular_cliente").numericInput();
        var tel_casa_cliente = $("#input_tel_casa_cliente").numericInput();
        var tel_oficina_cliente = $("#input_tel_oficina_cliente").numericInput();
        var otro_telefono_cliente = $("#input_otro_telefono_cliente").numericInput();

        //Recolección de datos del cónyugue
        var nombre_conyugue = $("#input_nombre_conyugue");
        var identificacion_conyugue = $("#input_identificacion_conyugue").numericInput();
        var direccion_conyugue = $("#input_direccion_conyugue");
        var pais_conyugue = $("#input_pais_conyugue");
        var departamento_conyugue = $("#input_departamento_conyugue");
        var ciudad_conyugue = $("#input_ciudad_conyugue");
        var barrio_conyugue = $("#input_barrio_conyugue");
        var zona_conyugue = $("#input_zona_conyugue");
        var estrato_conyugue = $("#input_estrato_conyugue");
        var dia_nacimiento_conyugue = $("#dia_nacimiento_conyugue");
        var mes_nacimiento_conyugue = $("#mes_nacimiento_conyugue");
        var anio_nacimiento_conyugue = $("#anio_nacimiento_conyugue");
        var genero_conyugue = $("#input_genero_conyugue");
        var email_conyugue = $("#input_email_conyugue");
        var celular_conyugue = $("#input_celular_conyugue").numericInput();
        var tel_casa_conyugue = $("#input_tel_casa_conyugue").numericInput();
        var tel_oficina_conyugue = $("#input_tel_oficina_conyugue").numericInput();
        var otro_telefono_conyugue = $("#input_otro_telefono_conyugue").numericInput();

        /**
         * Cambio de género
         */
        // genero_cliente.on("change", function(){
        //     //Si el género es diferente a masculino
        //     if ($(this).val() != "1") {
        //         //Se muestra el contenedor que pide si es cabeza de familia
        //         mostrar_elemento($("#cont_cabeza_familia"));
        //     } else {
        //         //Se oculta info no necesaria
        //         ocultar_elemento($("#cont_cabeza_familia"));
        //     }
        // });//Genero change

        /**
         * Cuando cambie el estado actual en la entidad
         */
        estado_actual_entidad.on("change", function(){
            //Si el estado es diferente a activo
            if ($(this).val() != "1") {
                //Se muestra el contenedor con más info
                mostrar_elemento($("#cont_estado"));
            } else {
                //Se oculta info no necesaria
                ocultar_elemento($("#cont_estado"));
            }
        });//estado_actual change

        /**
         * Cuando cambie el estado como Empleado Cooperativa
         */
        estado_empleado.on("change", function(){
            // Si es empleado
            if($(this).val() == "1") {
                //Se muestra el contenedor con más info
                mostrar_elemento($("#cont_empleado"));
            } else {
                //Se oculta info no necesaria
                ocultar_elemento($("#cont_empleado"));
            }
        });//estado Empleado change

        /**
         * Cuando cambie el estado como delegado
         */
        estado_delegado.on("change", function(){
            // Si está activo
            if($(this).val() == "1") {
                //Se muestra el contenedor con más info
                mostrar_elemento($("#cont_delegado"));
            } else {
                //Se oculta info no necesaria
                ocultar_elemento($("#cont_delegado"));
            }
        });//estado delegado change

        /**
         * Cuando cambie el estado como consejero
         */
        estado_consejero.on("change", function(){
            // Si está activo
            if($(this).val() == "1") {                
                //Se muestra el contenedor con más info
                mostrar_elemento($("#cont_consejero"));                
            } else {
                //Se oculta info no necesaria
                ocultar_elemento($("#cont_consejero"));
            }
        });//estado consejero change

        /**
         * Cuando cambie el estado como junta
         */
        estado_junta.on("change", function(){
            // Si está activo
            if($(this).val() == "1") {
                //Se muestra el contenedor con más info
                mostrar_elemento($("#cont_junta"));                
            } else {
                //Se oculta info no necesaria
                ocultar_elemento($("#cont_junta"));
            }
        });//estado junta change

        /**
         * Cuando cambie el estado como comité
         */
        estado_comites.on("change", function(){
            // Si está activo
            if($(this).val() == "1") {
                //Se muestra el contenedor con más info
                mostrar_elemento($("#cont_comites"));
            } else {
                //Se oculta info no necesaria
                ocultar_elemento($("#cont_comites"));
            }
        });//estado comité change

        /**
         * Selección de país y carga de los departamentos del cliente
         */
        pais_cliente.on("change", function(){
            //Si se selecciona un país
            if ($(this).val() != "") {
                imprimir("cargando departamentos del cliente...");

                //Se realiza la consulta por ajax
                departamentos = ajax("<?php echo site_url('listas/cargar_departamentos'); ?>", {'codigo_pais': $(this).val()}, "JSON");

                // Si trae departamentos
                if (departamentos.length > 0) {
                    //Se resetea el select y se agrega una option vacia
                    $(departamento_cliente).html('').append("<option value=''>Seleccione...</option>");
                } else {
                    //Se resetea el select y se agrega una option de no encontrado
                    $(departamento_cliente).html('').append("<option value=''>Ningún departamento encontrado...</option>");
                } //if

                //Se recorren los departamentos
                $.each(departamentos, function(key, val){
                    //Se agrega cada departamento al select
                    $(departamento_cliente).append("<option value='" + val.strCodigo + "'>" + val.strNombre + "</option>");
                })//Fin each
            }//If
        }); //Pais change 

        // Si ya hay un país seleccionado, cargaremos los departamentos de ese país
        if (pais_cliente.val() != "") {
            //Se realiza la consulta por ajax
            departamentos = ajax("<?php echo site_url('listas/cargar_departamentos'); ?>", {'codigo_pais': $(this).val()}, "JSON");

            // Si trae departamentos
            if (departamentos.length > 0) {
                //Se resetea el select y se agrega una option vacia
                $(departamento_cliente).html('').append("<option value=''>Seleccione...</option>");
            } else {
                //Se resetea el select y se agrega una option de no encontrado
                $(departamento_cliente).html('').append("<option value=''>Ningún departamento encontrado...</option>");
            } //if

            //Se recorren los departamentos
            $.each(departamentos, function(key, val){
                //Se agrega cada departamento al select
                $(departamento_cliente).append("<option value='" + val.strCodigo + "'>" + val.strNombre + "</option>");
            })//Fin each

            // Cargados los departamentos, seleccionaremos el departamento por defecto
            select_por_defecto("input_departamento_cliente", "<?php echo $asociado->Departamento_Cliente; ?>");
        };

        /**
         * Selección del departamento y carga de las ciudades del cliente
         */
        departamento_cliente.on("change", function(){
            imprimir("cargando ciudades del cliente...");

            //Se realiza la consulta por ajax
            ciudades = ajax("<?php echo site_url('listas/cargar_ciudades'); ?>", {'codigo_departamento': $(this).val()}, "JSON");

            // Si trae ciudades
            if (ciudades.length > 0) {
                //Se resetea el select y se agrega una option vacia
                $(ciudad_cliente).html('').append("<option value=''>Seleccione...</option>");
            } else {
                //Se resetea el select y se agrega una option de no encontrado
                $(ciudad_cliente).html('').append("<option value=''>Ninguna ciudad encontrada...</option>");
            } //if

            //Se recorren los ciudades
            $.each(ciudades, function(key, val){
                //Se agrega cada ciudad al select
                $(ciudad_cliente).append("<option value='" + val.strCodigo + "'>" + val.strNombre + "</option>");
            })//Fin each
        }); //Departamento change

        // Si ya hay un departamento seleccionado, cargaremos las ciudades de ese departamento
        if ($("#input_departamento_cliente").val() != "") {
            //Se realiza la consulta por ajax
            ciudades = ajax("<?php echo site_url('listas/cargar_ciudades'); ?>", {'codigo_departamento': $(this).val()}, "JSON");

            //Si encuentra ciudades
            if (ciudades.length > 0) {
                //Se resetea el select y se agrega una option vacia
                $(ciudad_cliente).html('').append("<option value=''>Seleccione...</option>");
            } else {
                //Se resetea el select y se agrega una option de no encontrado
                $(ciudad_cliente).html('').append("<option value=''>Ninguna ciudad encontrada...</option>");
            } //if

            //Se recorren los ciudades
            $.each(ciudades, function(key, val){
                //Se agrega cada ciudad al select
                $(ciudad_cliente).append("<option value='" + val.strCodigo + "'>" + val.strNombre + "</option>");
            })//Fin each

            // Cargadas las ciudades, seleccionaremos la ciudad por defecto
            select_por_defecto("input_ciudad_cliente", "<?php echo $asociado->ciudad_cliente; ?>");
        }

        /**
         * Selección de la ciudad y carga de los barrios del cliente
         */
        ciudad_cliente.on("change", function(){
            imprimir("cargando barrios del cliente...");

            //Se realiza la consulta por ajax
            barrios = ajax("<?php echo site_url('listas/cargar_barrios'); ?>", {'codigo_ciudad': $(this).val()}, "JSON");

            // Si trae barrios
            if (barrios.length > 0) {
                //Se resetea el select y se agrega una option vacia
                $(barrio_cliente).html('').append("<option value=''>Seleccione...</option>");
            } else {
                //Se resetea el select y se agrega una option de no encontrado
                $(barrio_cliente).html('').append("<option value=''>Ningún barrio encontrado...</option>");
            } //if

            //Se recorren los barrios
            $.each(barrios, function(key, val){
                //Se agrega cada barrio al select
                $(barrio_cliente).append("<option value='" + val.strCodigo + "'>" + val.strNombre + "</option>");
            })//Fin each
        }); //Ciudad change

        // Si ya hay una ciudad seleccionada, cargaremos los barrios de esa ciudad
        if (ciudad_cliente.val() != "") {
            //Se realiza la consulta por ajax
            barrios = ajax("<?php echo site_url('listas/cargar_barrios'); ?>", {'codigo_ciudad': $(this).val()}, "JSON");

            // Si trae barrios
            if (barrios.length > 0) {
                //Se resetea el select y se agrega una option vacia
                $(barrio_cliente).html('').append("<option value=''>Seleccione...</option>");
            } else {
                //Se resetea el select y se agrega una option de no encontrado
                $(barrio_cliente).html('').append("<option value=''>Ningún barrio encontrado...</option>");
            } //if

            //Se recorren los barrios
            $.each(barrios, function(key, val){
                //Se agrega cada barrio al select
                $(barrio_cliente).append("<option value='" + val.strCodigo + "'>" + val.strNombre + "</option>");
            })//Fin each

            // Cargadas los barrios, seleccionaremos el barrio por defecto
            select_por_defecto("input_barrio_cliente", "<?php echo $asociado->Barrio_Cliente; ?>");
        }


        /**
         * Selección de país y carga de los departamentos del cónyugue
         */
        pais_conyugue.on("change", function(){
            //Si se selecciona un país
            if ($(this).val() != "") {
                imprimir("cargando departamentos del cónyuge...");

                //Se realiza la consulta por ajax
                departamentos = ajax("<?php echo site_url('listas/cargar_departamentos'); ?>", {'codigo_pais': $(this).val()}, "JSON");
                
                // Si trae departamentos
                if (departamentos.length > 0) {
                    //Se resetea el select y se agrega una option vacia
                    $(departamento_conyugue).html('').append("<option value=''>Seleccione...</option>");
                } else {
                    //Se resetea el select y se agrega una option de no encontrado
                    $(departamento_conyugue).html('').append("<option value=''>Ningún departamento encontrado...</option>");
                } //if

                //Se recorren los departamentos
                $.each(departamentos, function(key, val){
                    //Se agrega cada departamento al select
                    $(departamento_conyugue).append("<option value='" + val.strCodigo + "'>" + val.strNombre + "</option>");
                })//Fin each
            }//If
        }); //Pais change

        // Si ya hay un país seleccionado, cargaremos los departamentos de ese país
        if (pais_conyugue.val() != "") {
            //Se realiza la consulta por ajax
            departamentos = ajax("<?php echo site_url('listas/cargar_departamentos'); ?>", {'codigo_pais': $(this).val()}, "JSON");
            
            // Si trae departamentos
            if (departamentos.length > 0) {
                //Se resetea el select y se agrega una option vacia
                $(departamento_conyugue).html('').append("<option value=''>Seleccione...</option>");
            } else {
                //Se resetea el select y se agrega una option de no encontrado
                $(departamento_conyugue).html('').append("<option value=''>Ningún departamento encontrado...</option>");
            } //if

            //Se recorren los departamentos
            $.each(departamentos, function(key, val){
                //Se agrega cada departamento al select
                $(departamento_conyugue).append("<option value='" + val.strCodigo + "'>" + val.strNombre + "</option>");
            })//Fin each

            // Cargados los departamentos, seleccionaremos el departamento por defecto
            select_por_defecto("input_departamento_conyugue", "<?php echo $asociado->Departamento_Conyugue; ?>");
        }



        /**
         * Selección del departamento y carga de las ciudades del cónyugue
         */
        departamento_conyugue.on("change", function(){
            //Se realiza la consulta por ajax
            ciudades = ajax("<?php echo site_url('listas/cargar_ciudades'); ?>", {'codigo_departamento': $(this).val()}, "JSON");

            // Si trae ciudades
            if (ciudades.length > 0) {
                //Se resetea el select y se agrega una option vacia
                $(ciudad_conyugue).html('').append("<option value=''>Seleccione...</option>");
            } else {
                //Se resetea el select y se agrega una option de no encontrado
                $(ciudad_conyugue).html('').append("<option value=''>Ninguna ciudad encontrada...</option>");
            } //if

            //Se recorren los ciudades
            $.each(ciudades, function(key, val){
                //Se agrega cada ciudad al select
                $(ciudad_conyugue).append("<option value='" + val.strCodigo + "'>" + val.strNombre + "</option>");
            })//Fin each
        }); //Departamento change 

        // Si ya hay un departamento seleccionado, cargaremos las ciudades de ese departamento
        if (departamento_conyugue.val() != "") {
            //Se realiza la consulta por ajax
            ciudades = ajax("<?php echo site_url('listas/cargar_ciudades'); ?>", {'codigo_departamento': $(this).val()}, "JSON");

            // Si trae ciudades
            if (ciudades.length > 0) {
                //Se resetea el select y se agrega una option vacia
                $(ciudad_conyugue).html('').append("<option value=''>Seleccione...</option>");
            } else {
                //Se resetea el select y se agrega una option de no encontrado
                $(ciudad_conyugue).html('').append("<option value=''>Ninguna ciudad encontrada...</option>");
            } //if

            //Se recorren los ciudades
            $.each(ciudades, function(key, val){
                //Se agrega cada ciudad al select
                $(ciudad_conyugue).append("<option value='" + val.strCodigo + "'>" + val.strNombre + "</option>");
            })//Fin each

            // Cargadas los ciduades, seleccionaremos la ciudad por defecto
            select_por_defecto("input_ciudad_conyugue", "<?php echo $asociado->ciudad_conyugue; ?>");

        }


        /**
         * Selección de la ciudad y carga de los barrios del cónyugue
         */
        ciudad_conyugue.on("change", function(){
            imprimir("cargando barrios del cónyugue...");

            //Se realiza la consulta por ajax
            barrios = ajax("<?php echo site_url('listas/cargar_barrios'); ?>", {'codigo_ciudad': $(this).val()}, "JSON");

            // Si trae barrios
            if (barrios.length > 0) {
                //Se resetea el select y se agrega una option vacia
                $(barrio_conyugue).html('').append("<option value=''>Seleccione...</option>");
            } else {
                //Se resetea el select y se agrega una option de no encontrado
                $(barrio_conyugue).html('').append("<option value=''>Ningún barrio encontrado...</option>");
            } //if

            //Se recorren los barrios
            $.each(barrios, function(key, val){
                //Se agrega cada barrio al select
                $(barrio_conyugue).append("<option value='" + val.strCodigo + "'>" + val.strNombre + "</option>");
            })//Fin each
        }); //Ciudad change   

        // Si ya hay una ciudad seleccionada, cargaremos los barrios de esa ciudad

        if (ciudad_conyugue.val() != "") {
            //Se realiza la consulta por ajax
            barrios = ajax("<?php echo site_url('listas/cargar_barrios'); ?>", {'codigo_ciudad': $(this).val()}, "JSON");

            // Si trae barrios
            if (barrios.length > 0) {
                //Se resetea el select y se agrega una option vacia
                $(barrio_conyugue).html('').append("<option value=''>Seleccione...</option>");
            } else {
                //Se resetea el select y se agrega una option de no encontrado
                $(barrio_conyugue).html('').append("<option value=''>Ningún barrio encontrado...</option>");
            } //if

            //Se recorren los barrios
            $.each(barrios, function(key, val){
                //Se agrega cada barrio al select
                $(barrio_conyugue).append("<option value='" + val.strCodigo + "'>" + val.strNombre + "</option>");
            })//Fin each

            // Cargadas los barrios, seleccionaremos el barrio seleccionado
            select_por_defecto("input_barrio_conyugue", "<?php echo $asociado->Barrio_Conyugue; ?>");
        }

        /**
         * Beneficiarios
         */
        //Contador de beneficiarios
        total_beneficiarios = 1;

        //Si es un asociado existente
        if (id_asociado) {
            // Verificaremos si existen beneficiarios creados
            beneficiarios_existentes = ajax("<?php echo site_url('cliente/cargar') ?>", {"tipo": "beneficiario", "id_asociado": id_asociado}, 'JSON');

            //Recorreremos los beneficiarios para crearlos en pantalla
            $.each(beneficiarios_existentes, function(key, val){
                datos = {
                    "nombre": val.strNombre,
                    "telefono_casa": val.TelefonoCasa,
                    "telefono_oficina": val.TelefonoOficina,
                    "email": val.Email
                }

                //En el contenedor debeneficiarios, agregamos un contenedor por cada beneficiario
                $("#beneficiarios").append("<div id='beneficiario" + total_beneficiarios + "'></div>");

                //Cargamos la vista en el div
                $("#beneficiario" + total_beneficiarios).load("<?php echo site_url('cliente/agregar_beneficiarios'); ?>", {numero: total_beneficiarios, datos: datos});
                
                //Se aumenta el total de beneficiarios
                total_beneficiarios++;
            }); //Fin each
        }; // if

        //Agregar beneficiario
        $("#btn_agregar_beneficiario").on("click", function(){
            //En el contenedor debeneficiarios, agregamos un contenedor por cada beneficiario
            $("#beneficiarios").append("<div id='beneficiario" + total_beneficiarios + "'></div>");

            //Cargamos la vista en el div
            $("#beneficiario" + total_beneficiarios).load("<?php echo site_url('cliente/agregar_beneficiarios'); ?>", {numero: total_beneficiarios});
            
            //Se aumenta el total de beneficiarios
            total_beneficiarios++;
        });//Agregar beneficiario

        /**
         * Hijos
         */
        //Contador de hijos
        total_hijos = 1;

        //Si es un asociado existente
        if (id_asociado) {
            // Verificaremos si existen hijos creados
            hijos_existentes = ajax("<?php echo site_url('cliente/cargar') ?>", {"tipo": "hijo", "id_asociado": id_asociado}, 'JSON');

            //Recorreremos los hijos para crearlos en pantalla
            $.each(hijos_existentes, function(key, val){
                datos = {
                    "nombre": val.strNombre,
                    "telefono_casa": val.TelefonoCasa,
                    "telefono_oficina": val.TelefonoOficina,
                    "email": val.Email,
                    "fecha_nacimiento": val.FechaNacimiento,
                    "id_genero": val.id_Genero
                }

                //En el contenedor de hijos, agregamos un contenedor por cada hijo
                $("#hijos").append("<div id='hijo" + total_hijos + "'></div>");

                //Cargamos la vista en el div
                $("#hijo" + total_hijos).load("<?php echo site_url('cliente/agregar_hijos'); ?>", {numero: total_hijos, datos: datos});

                //Se aumenta el total de hijos
                total_hijos++;
            }); //Fin each
        }; // if

        //Agregar hijo
        $("#btn_agregar_hijo").on("click", function(){
            //En el contenedor de hijos, agregamos un contenedor por cada hijo
            $("#hijos").append("<div id='hijo" + total_hijos + "'></div>");

            //Cargamos la vista en el div
            $("#hijo" + total_hijos).load("<?php echo site_url('cliente/agregar_hijos'); ?>", {numero: total_hijos});

            //Se aumenta el total de hijos
            total_hijos++;
        });//Agregar hijo

        /**
         * Conocidos
         */
        //Contador de conocidos
        total_conocidos = 1;

        //Si es un asociado existente
        if (id_asociado) {
            // Verificaremos si existen beneficiarios creados
            conocidos_existentes = ajax("<?php echo site_url('cliente/cargar') ?>", {"tipo": "conocido", "id_asociado": id_asociado}, 'JSON');

            //Recorreremos los conocidos para crearlos en pantalla
            $.each(conocidos_existentes, function(key, val){
                //Arreglo con la info
                datos = {
                    "nombre": val.strNombre,
                    "telefono_casa": val.TelefonoCasa,
                    "telefono_oficina": val.TelefonoOficina,
                    "email": val.Email,
                    "fecha_nacimiento": val.FechaNacimiento,
                    "id_genero": val.id_Genero,
                    "id_parentesco": val.id_Parentesco
                }; // datos

                //En el contenedor de conocidos, agregamos un contenedor por cada conocido
                $("#conocidos").append("<div id='conocido" + total_conocidos + "'></div>");

                //Cargamos la vista en el div
                $("#conocido" + total_conocidos).load("<?php echo site_url('cliente/agregar_conocidos'); ?>", {numero: total_conocidos, datos: datos});

                //Se aumenta el total de conocidos
                total_conocidos++;
            });// each
        } //if
        
        //Agregar conocido
        $("#btn_agregar_conocido").on("click", function(){
            //En el contenedor de conocidos, agregamos un contenedor por cada persona conocida
            $("#conocidos").append("<div id='conocido" + total_conocidos + "'></div>");

            //Cargamos la vista en el div
            $("#conocido" + total_conocidos).load("<?php echo site_url('cliente/agregar_conocidos'); ?>", {numero: total_conocidos});

            //Se aumenta el total de conocidos
            total_conocidos++;
        });//Agregar conocido

        /**
         * Cargos
         */
        //Contador de cargos
        total_cargos = 1;

        //Si es un asociado existente
        if (id_asociado) {
            // Verificaremos si existen cargos creados
            cargos_existentes = ajax("<?php echo site_url('cliente/cargar') ?>", {"tipo": "cargo", "id_asociado": id_asociado}, 'JSON');

            //Recorreremos los cargos para crearlos en pantalla
            $.each(cargos_existentes, function(key, val){
                //Arreglo con la info
                datos = {
                    "id_cargo": val.id_cargo,
                    "lugar": val.Lugar,
                    "actividad": val.Actividad,
                    "fecha_inicio": val.Fecha_Inicio,
                    "fecha_final": val.Fecha_Final
                }; // datos
                // imprimir(datos)

                //En el contenedor de cargos, agregamos un contenedor por cada cargo
                $("#cargos").append("<div id='cargo" + total_cargos + "'></div>");

                //Cargamos la vista en el div
                $("#cargo" + total_cargos).load("<?php echo site_url('cliente/agregar_cargos'); ?>", {numero: total_cargos, datos: datos});

                //Se aumenta el total de cargos
                total_cargos++;
            });// each
        } //if

        //Agregar cargo
        $("#btn_agregar_cargos").on("click", function(){
            //En el contenedor de cargos, agregamos un contenedor por cada cargo
            $("#cargos").append("<div id='cargo" + total_cargos + "'></div>");

            //Cargamos la vista en el div
            $("#cargo" + total_cargos).load("<?php echo site_url('cliente/agregar_cargos'); ?>", {numero: total_cargos});

            //Se aumenta el total de cargos
            total_cargos++;
        });//Agregar cargo

        //Agregar producto
        $("#btn_agregar_producto").on("click", function(){
            //En el contenedor debeneficiarios, agregamos un contenedor por cada producto
            $("#productos").append("<div id='producto" + total_productos + "'></div>");

            //Cargamos la vista en el div
            $("#producto" + total_productos).load("<?php echo site_url('cliente/agregar_productos'); ?>", {numero: total_productos});
            
            //Se aumenta el total de productos
            total_productos++;
        });//Agregar producto

        //Submit
        $("#form_cliente").on("submit", function(){
            //Se redeclara el id de asociado
            var id_asociado = "<?php echo $id_asociado; ?>";
            
            //Recolección de datos de gustos y preferencias
            var gustos = new Array();

            //Se recorren los gustos chequeados
            $("input[name='gusto[]']:checked").each(function() {
                //Se agrega el check al arreglo
                gustos.push($(this).val());
            });//each

            // Si es actualización 
            if($("#es_actualizacion").val() == '1'){
                actualizado = '1';
                fecha_actualizacion  = "<?php echo date('Y-m-d H:i:s'); ?>";
            }else{
                actualizado = $("#actualizacion").val();
                fecha_actualizacion = $("#fecha_actualizacion").val();
            }

            /**
             * Fechas
             */
            fecha_inicio_comites = anio_inicio_comites.val() + "-" + mes_inicio_comites.val() + "-" + dia_inicio_comites.val();
            fecha_inicio_empleado = anio_inicio_cliente.val() + "-" + mes_inicio_cliente.val() + "-" + dia_inicio_cliente.val();
            fecha_ingreso = anio_ingreso_cliente.val() + "-" + mes_ingreso_cliente.val() + "-" + dia_ingreso_cliente.val();
            fecha_retiro = anio_retiro_cliente.val() + "-" + mes_retiro_cliente.val() + "-" + dia_retiro_cliente.val();
            fecha_inicio_consejero = anio_inicio_consejero.val() + "-" + mes_inicio_consejero.val() + "-" + dia_inicio_consejero.val();
            fecha_inicio_delegado = anio_inicio_delegado.val() + "-" + mes_inicio_delegado.val() + "-" + dia_inicio_delegado.val();
            fecha_inicio_junta = anio_inicio_junta.val() + "-" + mes_inicio_junta.val() + "-" + dia_inicio_junta.val();
            fecha_fin_consejero = anio_fin_consejero.val() + "-" + mes_fin_consejero.val() + "-" + dia_fin_consejero.val();
            fecha_fin_comites = anio_fin_comites.val() + "-" + mes_fin_comites.val() + "-" + dia_fin_comites.val();
            fecha_fin_delegado = anio_fin_delegado.val() + "-" + mes_fin_delegado.val() + "-" + dia_fin_delegado.val();
            fecha_fin_junta = anio_fin_junta.val() + "-" + mes_fin_junta.val() + "-" + dia_fin_junta.val();
            fecha_nacimiento = anio_nacimiento_cliente.val() + "-" + mes_nacimiento_cliente.val() + "-" + dia_nacimiento_cliente.val();
            fecha_nacimiento_conyugue = anio_nacimiento_conyugue.val() + "-" + mes_nacimiento_conyugue.val() + "-" + dia_nacimiento_conyugue.val();

            if (fecha_inicio_comites == "1969-12-31") { fecha_inicio_comites = null; };
            if (fecha_inicio_empleado == "1969-12-31") { fecha_inicio_empleado = null; };
            if (fecha_ingreso == "1969-12-31") { fecha_ingreso = null; };
            if (fecha_retiro == "1969-12-31") { fecha_retiro = null; };
            if (fecha_inicio_consejero == "1969-12-31") { fecha_inicio_consejero = null; };
            if (fecha_inicio_delegado == "1969-12-31") { fecha_inicio_delegado = null; };
            if (fecha_inicio_junta == "1969-12-31") { fecha_inicio_junta = null; };
            if (fecha_fin_consejero == "1969-12-31") { fecha_fin_consejero = null; };
            if (fecha_fin_comites == "1969-12-31") { fecha_fin_comites = null; };
            if (fecha_fin_delegado == "1969-12-31") { fecha_fin_delegado = null; };
            if (fecha_fin_junta == "1969-12-31") { fecha_fin_junta = null; };
            if (fecha_nacimiento == "1969-12-31") { fecha_nacimiento = null; };
            if (fecha_nacimiento_conyugue == "1969-12-31") { fecha_nacimiento_conyugue = null; };

            //Arreglo JSON de datos a enviar posteriormente
            datos_formulario = {
                'id_Asociado': "<?php echo $this->session->userdata('id_empresa'); ?>" + '-' + identificacion_cliente.val(),
                'Actualizado': actualizado,
                'Fecha_Actualizacion': fecha_actualizacion,
                'AporteSocial': aporte_social_cliente.val(),
                'Barrio_Cliente': barrio_cliente.val(), 
                'Barrio_Conyugue': barrio_conyugue.val(),
                'Celular_cliente': celular_cliente.val(),
                'Celular_Conyuge': celular_conyugue.val(),
                'CentrodeCostos': centro_costos_cliente.val(),
                'CorreoElectronico': email_cliente.val(),
                'CuotadeAdmision': cuota_admision_cliente.val(),                
                'ciudad_cliente': ciudad_cliente.val(),
                'ciudad_conyugue': ciudad_conyugue.val(),
                'Departamento_Cliente': departamento_cliente.val(),
                'Departamento_Conyugue': departamento_conyugue.val(),
                'Direccion': direccion_cliente.val(),
                'Direccion_Conyuge': direccion_conyugue.val(),
                'Email_Conyuge': email_conyugue.val(),
                'EstadocomoConsejero': estado_consejero.val(),
                'Estado_Empleado': estado_empleado.val(),
                'EstadocomoDelegado': estado_delegado.val(),
                'EstadocomoJuntadeVigilancia': estado_junta.val(),
                'EstadoDirectivo': estado_directivo.val(),
                'EstadoenComites': estado_comites.val(),
                'FechadeIngresoalaCooperativa': fecha_ingreso,
                'FechadeRetiro': fecha_retiro,
                'Fecha_Inicio_Comites': fecha_inicio_comites,
                'Fecha_Inicio_Empleado': fecha_inicio_empleado,
                'Fecha_Inicio_Consejero': fecha_inicio_consejero,
                'Fecha_Inicio_Delegado': fecha_inicio_delegado,
                'Fecha_Inicio_Junta': fecha_inicio_junta,
                'Fecha_Fin_Consejero': fecha_fin_consejero,
                'Fecha_Fin_Comites': fecha_fin_comites,
                'Fecha_Fin_Delegado': fecha_fin_delegado,
                'Fecha_Fin_Junta': fecha_fin_junta,
                'FechaNacimiento': fecha_nacimiento,
                'FechaNacimiento_Conyugue': fecha_nacimiento_conyugue,
                'Habil': habil.val(),
                'id_Asignado': asignado.val(),
                'id_CabezadeFamilia': cabeza_familia_cliente.val(),
                'id_Conocimiento_Cooperativismo': conocimiento_cooperativismo.val(),
                'id_Designacion': designacion_cliente.val(),
                'id_Empresa': "<?php echo $this->session->userdata('id_empresa'); ?>",
                'id_Escolaridad': escolaridad_cliente.val(),
                'id_EstadoactualEntidad': estado_actual_entidad.val(),
                'id_EstadoCivil': estado_civil.val(),
                'id_Estrato': estrato_cliente.val(),
                'id_Estrato_Conyuge': estrato_conyugue.val(),
                'id_Genero_cliente': genero_cliente.val(),
                'id_Genero_Conyugue': genero_conyugue.val(),
                'id_GrupoFamiliar': grupo_familiar.val(),
                'id_Industria': industria_cliente.val(),
                'id_MotivoRetiro': motivo_retiro.val(),
                'id_Oficina': oficina_cliente.val(),
                'id_Origendelcliente': origen_cliente.val(),
                'id_Profesion': profesion_cliente.val(),
                'id_RangodeIngresomensual': rango_ingreso.val(),
                'id_Responsable': responsable.val(),
                'id_strCodigo_Asociado': codigo_asociado.val(),
                'id_Tipo': tipo.val(),
                'id_TipodeIdentificacion': tipo_identificacion.val(),
                'id_tipoempleado': tipo_empleado.val(),
                'id_ubicacionempleado': ubicacion_empleado.val(),
                'id_Zona': zona_cliente.val(),
                'id_Zona_Conyuge': zona_conyugue.val(),
                'Identificacion': identificacion_cliente.val(),
                'Identificacion_Conyuge': identificacion_conyugue.val(),
                'Ingresoreal': ingreso_real.val(),
                'LugardeExpedicion': lugar_expedicion.val(),
                'Lugardenacimiento': lugar_nacimiento.val(),
                'Nombre': nombre_cliente.val(),
                'NombredelConyuge': nombre_conyugue.val(),
                'NumerodeCarne': numero_carne.val(),
                'OtroTelefono': otro_telefono_cliente.val(),
                'OtroTelefono_Conyuge': otro_telefono_conyugue.val(),
                'Pais_Cliente': pais_cliente.val(),
                'Pais_Conyugue': pais_conyugue.val(),
                'Recibiremail': recibir_emails.val(),
                'Recibir_medios_internos': recibir_medios_internos.val(),
                'PrimerApellido': apellido1.val(),
                'SegundoApellido': apellido2.val(),
                'TelefonoCasa': tel_casa_cliente.val(),
                'TelefonoCasa_Conyuge': tel_casa_conyugue.val(),
                'TelefonoOficina': tel_oficina_cliente.val(),
                'TelefonoOficina_Conyuge': tel_oficina_conyugue.val(),
                'TotalAnoActual': total_ano_actual.val(),
                'TotalUltimoTrim': total_ultimo_trimestre.val()
            }//datos_formulario
            // imprimir(datos_formulario);
            
            // Se verifica que el número de carné exista
            existe_carne = ajax("<?php echo site_url('cliente/validar_carne'); ?>", {numero: numero_carne.val(), identificacion: identificacion_cliente.val()}, 'HTML');

            // Si existe el número de carné
            if (existe_carne == 'true') {
                // Se muestra el mensaje de error
                mostrar_mensaje('Aun no se puede continuar', 'El número de carné ya existe. Por favor cámbielo');

                // se detiene el formulario
                return false;
            };
            
            // Dependiendo si es guardado o modificación
            if("<?php echo $id_asociado; ?>") {
                imprimir("Actualizando...");

                //Se invoca la petición ajax que actualizará el asociado
                actualizar = ajax("<?php echo site_url('cliente/actualizar'); ?>", {"datos": datos_formulario, "tipo": "asociado", "id_asociado": id_asociado}, "html");

                // Si se actualizó
                if (actualizar) {
                    // Ahora procedemos a actualizar los gustos del asociado
                    guardar_gustos = ajax("<?php echo site_url('cliente/guardar_gustos'); ?>", {"datos": gustos, "id_asociado": id_asociado}, "JSON");

                    //Se limpia el formulario
                    // limpiar("#cliente");

                    //Se muestra el mensaje de exito
                    // mostrar_mensaje('Registro exitoso', 'El asociado ' + nombre_cliente.val() + ' ' + apellido1.val() + ' se actualizó exitosamente.');
                    mostrar_mensaje('Registro exitoso', 'Sus datos se han actualizado correctamente.');
                };
            }else{
                imprimir("Guardando...");

                //Se invoca la petición ajax que guardará el registro
                asociado = ajax("<?php echo site_url('cliente/guardar'); ?>", {"datos": datos_formulario, "tipo": "asociado"}, "JSON");

                // Si se guardó
                if (asociado) {
                    var id_asociado = asociado.id_asociado;

                    // Ahora procedemos a guardar los gustos del asociado
                    guardar_gustos = ajax("<?php echo site_url('cliente/guardar_gustos'); ?>", {"datos": gustos, "id_asociado": id_asociado}, "JSON");

                    //Se limpia el formulario
                    // limpiar("#cliente");

                    //Se muestra el mensaje de exito
                    mostrar_mensaje('Registro exitoso', 'El asociado ' + nombre_cliente.val() + ' ' + apellido1.val() + ' se guardó exitosamente.');
                };
            }

            // Se actualizan los datos personales del cliente
            datos_cliente = ajax("<?php echo site_url('cliente/actualizar_datos_cliente_producto'); ?>", {"id_cliente": identificacion_cliente.val()}, "html");

            //Si hay beneficiarios
            if (total_beneficiarios > 1) {
                //Se borran todos los beneficiarios anteriores
                ajax("<?php echo site_url('cliente/borrar') ?>", {'id_asociado': id_asociado, "tipo": "beneficiarios"}, 'html')

                //Recorremos cada beneficiario
                for (var i = 1; i < total_beneficiarios; i++){
                    var guardar_beneficiario = $("#guardar_beneficiario" + i).val()
                    //se valida que el registro se guarde
                    if(guardar_beneficiario=='true'){   
                        //Se declara un arreglo con cada beneficiario
                        var datos_beneficiario = {
                            id_Asociado: id_asociado,
                            strNombre: $("#input_nombre_beneficiario" + i).val(),
                            TelefonoCasa:  $("#input_tel_casa_beneficiario" + i).val(),
                            TelefonoOficina:  $("#input_tel_oficina_beneficiario" + i).val(),
                            Email:  $("#input_email_beneficiario" + i).val(),
                        }
                        // imprimir(datos_beneficiario)

                        //Por medio de ajax insertamos cada beneficiario
                        ajax("<?php echo site_url('cliente/guardar') ?>", {'datos': datos_beneficiario, "tipo": "beneficiario"}, 'JSON')
                    };    
                }; //for
            } //if

            //Si hay hijos
            if (total_hijos > 1) {
                //Se borran todos los beneficiarios anteriores
                ajax("<?php echo site_url('cliente/borrar') ?>", {'id_asociado': id_asociado, "tipo": "hijos"}, 'html');

                //Recorremos cada hijo
                for (var i = 1; i < total_hijos; i++){
                    var guardar_hijo = $("#guardar_hijo" + i).val()
                    //se valida que el registro se guarde
                    if(guardar_hijo=='true'){   
                        //Se declara un arreglo con cada hijo
                        var datos_hijo = {
                            id_Asociado: id_asociado,
                            strNombre: $("#input_nombre_hijo" + i).val(),
                            TelefonoCasa:  $("#input_tel_casa_hijo" + i).val(),
                            TelefonoOficina:  $("#input_tel_oficina_hijo" + i).val(),
                            Email:  $("#input_email_hijo" + i).val(),
                            FechaNacimiento: $("#anio_nacimiento_hijo" + i).val() + "-" + $("#mes_nacimiento_hijo" + i).val() + "-" + $("#dia_nacimiento_hijo" + i).val(),
                            id_Genero: $("#input_genero_hijo" + i).val(),
                        }
                        // imprimir(datos_hijo)

                        //Por medio de ajax insertamos cada hijo
                        ajax("<?php echo site_url('cliente/guardar') ?>", {'datos': datos_hijo, "tipo": "hijo"}, 'json');
                    };    
                }; //for
            } //if

            //Si hay conocidos
            if (total_conocidos > 1) {
                //Se borran todos los beneficiarios anteriores
                ajax("<?php echo site_url('cliente/borrar') ?>", {'id_asociado': id_asociado, "tipo": "conocidos"}, 'html');

                //Recorremos cada conocido
                for (var i = 1; i < total_conocidos; i++){
                    var guardar_conocido = $("#guardar_conocido" + i).val()
                    //se valida que el registro se guarde
                    if(guardar_conocido=='true'){   
                        //Se declara un arreglo con cada conocido
                        var datos_conocido = {
                            id_Asociado: id_asociado,
                            strNombre: $("#input_nombre_conocido" + i).val(),
                            TelefonoCasa:  $("#input_tel_casa_conocido" + i).val(),
                            TelefonoOficina:  $("#input_tel_oficina_conocido" + i).val(),
                            Email:  $("#input_email_conocido" + i).val(),
                            FechaNacimiento: $("#anio_nacimiento_conocido" + i).val() + "-" + $("#mes_nacimiento_conocido" + i).val() + "-" + $("#dia_nacimiento_conocido" + i).val(),
                            id_Genero: $("#input_genero_conocido" + i).val(),
                            id_Parentesco: $("#input_parentesco_conocido" + i).val(),
                        }
                        // imprimir(datos_conocido)

                        //Por medio de ajax insertamos cada conocido
                        ajax("<?php echo site_url('cliente/guardar') ?>", {'datos': datos_conocido, "tipo": "conocido"}, 'json');
                    };    
                }; //for conocidos
            } //if

            //Si hay cargos
            if (total_cargos > 1) {
                //Se borran todos los cargos anteriores
                ajax("<?php echo site_url('cliente/borrar') ?>", {'id_asociado': id_asociado, "tipo": "cargos"}, 'html');

                //Recorremos cada cargo
                for (var i = 1; i < total_cargos; i++){
                    var guardar_cargos = $("#guardar_cargo" + i).val()
                    //se valida que el registro se guarde
                    if(guardar_cargos=='true'){                                                                  
                        //Se declara un arreglo con cada cargo                            
                        var datos_cargo = {
                            id_Asociado: id_asociado,
                            id_cargo: $("#input_cargo" + i).val(),
                            Lugar:  $("#input_lugar_cargo" + i).val(),
                            Actividad:  $("#input_actividad_cargo" + i).val(),
                            Fecha_Inicio: $("#anio_inicio_cargo" + i).val() + "-" + $("#mes_inicio_cargo" + i).val() + "-" + $("#dia_inicio_cargo" + i).val(),
                            Fecha_Final: $("#anio_fin_cargo" + i).val() + "-" + $("#mes_fin_cargo" + i).val() + "-" + $("#dia_fin_cargo" + i).val(),
                        }                            
                        // imprimir(datos_cargo) 

                        //Por medio de ajax insertamos cada cargo
                        ajax("<?php echo site_url('cliente/guardar') ?>", {'datos': datos_cargo, "tipo": "cargo"}, 'json');
                    };
                }; //for
            } //if

            return false;
        }); // Submit
    });
</script>

<?php if ($id_asociado){ ?>
    <script type="text/javascript">
        $(document).ready(function(){// Datos de actualiación externa
            $("#actualizacion").val("<?php echo $asociado->Actualizado; ?>");
            $("#fecha_actualizacion").val("<?php echo $asociado->Fecha_Actualizacion; ?>");
        });
    </script>
<?php } ?>