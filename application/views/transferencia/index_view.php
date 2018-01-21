<?php
// Se listan los años
$anios = $this->transferencia_model->listar_anios();

?>
<!-- Contenedor principal -->
<div class="col-lg-12">
    <!-- Contenedor del banner -->
    <div class="col-lg-8">
        <!-- Banner -->
        <img src="<?php echo base_url().'img/cabezote_transferencia.png' ?>" class="img-responsive" alt="Transferencia solidaria"><!-- Banner -->
    </div><!-- Contenedor del banner -->

    <!-- Contenedor con los datos filtrados (año, oficina y usuario) -->
    <div class="col-lg-4">
        <div class="well row">
        <br>
          <center><b>Desde esta sección puede generar su transeferencia solidaria seleccionando el año y la empresa</center>
        <br>
        <!-- Año -->
        <div class="col-lg-6">
            <select id="select_anio" class="form-control input-sm" autofocus>
                <?php foreach ($anios as $anio) { ?>
                    <option value="<?php echo $anio->ano; ?>"><?php echo $anio->ano; ?></option>
                <?php } ?>
            </select>
        </div><!-- Año -->

        <!-- Oficina -->
        <div class="col-lg-6">
            <select id="select_oficina" class="form-control input-sm">
                <option value="0">Todas las oficinas</option>
                <?php foreach ($oficinas as $oficina) { ?>
                    <option value="<?php echo $oficina->intCodigo; ?>"><?php echo $oficina->strNombre; ?></option>
                <?php } ?>
            </select>
        </div><br><br><!-- Oficina -->

        <!-- Identificación -->
        <div class="col-lg-6">
            <?php $class = ($this->session->userdata('es_asociado_login')) ? 'hide' : ''; ?>
            <input id="input_identificacion" class="form-control <?php echo $class; ?> input-sm" type="text" placeholder="Identificación">
        </div><!-- Identificación -->

        <!-- Generar transferencia -->
        <div class="col-lg-6">
                <button id="btn_generar_transferencia" type="button" class="btn btn-info btn-block btn-xs">Generar transferencia</button>
        </div><!-- Generar transferencia -->
    </div><!-- Contenedor con los datos filtrados (año, oficina y usuario) -->

    <!-- Contenedor formulario cambio transeferencia -->
    <div class="well row" id="form_claves">
      <br>
      <center><b>Desde esta seccion puede cambiar su contraseña</center>
      <br>
      <div class="col-lg-6">
        <!-- Contraseña 1 -->
        <input id="input_clave1" class="form-control input-sm" type="password" placeholder="Contraseña *"><!-- Contraseña 1 -->
      </div>

      <div class="col-lg-6">
        <!-- Contraseña 2 -->
        <input id="input_clave2" class="form-control input-sm" type="password" placeholder="Repita la contraseña *"><!-- Contraseña 2 -->
      </div>
      <div class="col-lg-6">
        <br>
        <button type="submit" onClick="javascript:cambiar_clave()" id="btn_guardar" class="btn btn-info btn-block btn-xs">Guardar</button>
      </div><!-- Generar transferencia -->
    </div><!-- Contenedor formulario cambio contraseña asociado -->
  </div>
</div><!-- Contenedor principal -->
<div class="clear"></div>
<br>

<!-- Contenedor de transferencia solidaria -->
<center>
    <div id="cont_transferencia"><?php $this->load->view('transferencia/transferencia_view'); ?></div>
</center><!-- Contenedor de transferencia solidaria -->

<script type="text/javascript">
    $(document).ready(function(){
        //Se toma el id de la empresa basado por get
        var empresa = "<?php echo $this->uri->segment(3); ?>";

        if ("<?php echo $this->input->post('id_empresa'); ?>") {
            var id_empresa = "<?php echo $this->input->post('id_empresa'); ?>";
        } else if("<?php echo $this->uri->segment(3); ?>") {
            var id_empresa = "<?php echo $this->uri->segment(3); ?>";
        } else{
            //Se toma el id de la empresa
            var id_empresa = "<?php echo $this->session->userdata('id_empresa'); ?>";

            /**
             * Cargaremos los datos por defecto
             */
            $("#select_anio").val("<?php echo date('Y')-1; ?>");
            $("#select_oficina").val("<?php echo $this->uri->segment(4); ?>");

        }

        //Por ajax se consultan las oficinas
        oficinas = ajax("<?php echo site_url('inicio/cargar_oficinas'); ?>", {'id_empresa': id_empresa}, "JSON");

        // Si trae oficinas
        if (oficinas.length > 0) {
            //Se resetea el select y se agrega una option vacia
            $($("#select_oficina")).html('').append("<option value='0'>Todas las oficinas</option>");
        } else {
            //Se resetea el select y se agrega una option de no encontrado
            $($("#select_oficina")).html('').append("<option value=''>Ninguna oficina encontrada...</option>");
        } //if

        //Se recorren las oficinas
        $.each(oficinas, function(key, val){
            //Se agrega cada oficina al select
            $("#select_oficina").append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
        })//Fin each

        if (empresa) {
            /**
             * Cargaremos los datos por defecto
             */
            var session = "<?php echo $this->session->userdata('tipo'); ?>";
            $("#select_anio").val("<?php echo date('Y')-1; ?>");
            $("#select_oficina").val("<?php echo $this->uri->segment(4); ?>");
            $("#input_identificacion").val("<?php echo $this->uri->segment(5); ?>");
        }

        // Generar transferencia
        $("#btn_generar_transferencia").on("click", function(){
            $("#cont_transferencia").load("<?php echo site_url('inicio/cargar_interfaz'); ?>", {tipo: 'transferencia_vista', anio: $("#select_anio").val(), id_empresa: id_empresa, id_oficina: $("#select_oficina").val(), identificacion: $("#input_identificacion").val(), metodo: "post"});
        }); //Generar transferencia
    });
    function cambiar_clave(){
        // Recolección de datos
        var clave1 = $("#input_clave1");
        var clave2 = $("#input_clave2");

        //Datos a validar
        datos_obligatorios = new Array(
            clave1.val(),
            clave2.val()
        ); // datos
        // imprimir(datos_obligatorios)

        //Se ejecuta la validación de los campos obligatorios
        validacion = validar_campos_vacios(datos_obligatorios);

        //Si no supera la validacíón
        if (!validacion) {
            //Se muestra el mensaje de error
            mostrar_mensaje('Aun no se ha completado el proceso', 'Por favor diligencie ambas contraseñas.');

            return false;
        } // if

        // Si la contraseña no es igual
        if (clave1.val() != clave2.val()) {
            //Se muestra el mensaje de error
            mostrar_mensaje('Contraseñas diferentes', 'Las contraseñas no coinciden.');

            // Se detiene el formulario
            return false;
        };

        // Se actualiza la contraseña
        var empresa = "<?php echo $this->uri->segment(3); ?>";
        var idAsociado = empresa + '-' + $("#input_identificacion").val();
        ajax("<?php echo site_url('cliente/actualizar'); ?>", {"datos": {'Clave_Transferencia': clave1.val(), "Fecha_Cambio_Clave": "<?php echo date('Y-m-d h:i:s'); ?>"}, "tipo": "asociado", "id_asociado": idAsociado}, "html");
        mostrar_mensaje('Contraseña cambiada', 'Su contraseña ha sido actualizada.');
        clave1.val('');
        clave2.val('');
     } // cambiar_clave
</script>