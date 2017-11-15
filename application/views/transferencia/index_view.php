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
            <input id="input_identificacion" class="form-control input-sm" type="text" placeholder="Identificación">
        </div><!-- Identificación -->
        
        <!-- Generar transferencia -->
        <div class="col-lg-6">
                <button id="btn_generar_transferencia" type="button" class="btn btn-info btn-block btn-xs">Generar transferencia</button>
        </div><!-- Generar transferencia -->
    </div><!-- Contenedor con los datos filtrados (año, oficina y usuario) -->
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
            $("#select_anio").val("<?php echo date('Y')-1; ?>");
            $("#select_oficina").val("<?php echo $this->uri->segment(4); ?>");
            $("#input_identificacion").val("<?php echo $this->uri->segment(5); ?>");
        }

        // Generar transferencia
        $("#btn_generar_transferencia").on("click", function(){
            $("#cont_transferencia").load("<?php echo site_url('inicio/cargar_interfaz'); ?>", {tipo: 'transferencia_vista', anio: $("#select_anio").val(), id_empresa: id_empresa, id_oficina: $("#select_oficina").val(), identificacion: $("#input_identificacion").val(), metodo: "post"});
        }); //Generar transferencia
    });
</script>