<center>
    <div class="btn-group btn-group-sm">
        <button id="btn_campanas" type="button" class="btn btn-default">Campañas</button>
        <!-- <button id="btn_documentos" type="button" class="btn btn-default">Documentos</button> -->
        <button id="btn_comentarios" type="button" class="btn btn-default">Comentarios</button>
        <button id="btn_oportunidades" type="button" class="btn btn-default">Oportunidades</button>
        <button id="btn_productos" type="button" class="btn btn-default">Productos</button>
    </div>
<center> 
<p></p>

<!-- Contenedor donde se cargará la información -->
<div id="cont_detalle"></div><br>

<script type="text/javascript">
    $(document).ready(function(){
        // Comentarios
        $("#btn_comentarios").on("click", function(){
            //Cargamos la interfaz
            $("#cont_detalle").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'cliente_comentario', "id_asociado": "<?php echo $this->uri->segment(3); ?>"});

            //Se muestra la barra de carga
            cargando($("#cont_detalle"));
        }); // Comentarios

        // Documentos
        $("#btn_documentos").on("click", function(){
            //Cargamos la interfaz
            $("#cont_detalle").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'cliente_documento', "id_asociado": "<?php echo $this->uri->segment(3); ?>"});

            //Se muestra la barra de carga
            cargando($("#cont_detalle"));
        }); // Documentos

        // Campañas
        $("#btn_campanas").on("click", function(){
            imprimir('Cargando campañas...');
            //Cargamos la interfaz
            $("#cont_detalle").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'cliente_campana', "id_asociado": "<?php echo $this->uri->segment(3); ?>"});

            //Se muestra la barra de carga
            cargando($("#cont_detalle"));
        }); // Campañas

        // Oportunidades
        $("#btn_oportunidades").on("click", function(){
            //Cargamos la interfaz
            $("#cont_detalle").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'cliente_oportunidad', "id_asociado": "<?php echo $this->uri->segment(3); ?>"});

            //Se muestra la barra de carga
            cargando($("#cont_detalle"));
        }); // Oportunidades

        // Productos
        $("#btn_productos").on("click", function(){
            //Cargamos la interfaz
            $("#cont_detalle").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'cliente_producto', "id_asociado": "<?php echo $this->uri->segment(3); ?>"});

            //Se muestra la barra de carga
            cargando($("#cont_detalle"));
        }); // Productos
    });//document.ready
</script>