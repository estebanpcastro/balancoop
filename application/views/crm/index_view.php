<center>
    <strong>Búsqueda </strong>
    <div class="btn-group btn-group-sm">
        <button id="btn_cedula" type="button" class="btn btn-default">Por cédula</button>
        <button id="btn_nombres" type="button" class="btn btn-default">Por nombres</button>
        <button id="btn_filtro_asociados" type="button" class="btn btn-default">Por filtros de asociado</button>
        <button id="btn_filtro_productos" type="button" class="btn btn-default">Por filtros de productos</button>
    </div>
<center> 
<p></p>

<!-- Contenedor -->
<div id="cont_crm"></div>

<script type="text/javascript">
    $(document).ready(function(){
        // Búsqueda por cédula
        $("#btn_cedula").on("click", function(){
            //Cargamos la interfaz
            $("#cont_crm").load("listas/cargar_interfaz", {tipo: 'crm_cedula'});

            //Se muestra la barra de carga
            cargando($("#cont_crm"));
        }); // Búsqueda por cédula

        // Búsqueda por nombres
        $("#btn_nombres").on("click", function(){
            //Cargamos la interfaz
            $("#cont_crm").load("listas/cargar_interfaz", {tipo: 'crm_nombres'});

            //Se muestra la barra de carga
            cargando($("#cont_crm"));
        }); // Búsqueda por nombres

        // Búsqueda por producto
        $("#btn_filtro_productos").on("click", function(){
            //Cargamos la interfaz
            $("#cont_crm").load("listas/cargar_interfaz", {tipo: 'crm_producto'});

            //Se muestra la barra de carga
            cargando($("#cont_crm"));
        }); // Búsqueda por producto

        // Búsqueda por filtros
        $("#btn_filtro_asociados").on("click", function(){
            //Cargamos la interfaz
            $("#cont_crm").load("listas/cargar_interfaz", {tipo: 'crm_filtro'});

            //Se muestra la barra de carga
            cargando($("#cont_crm"));
        }); // Búsqueda por filtros
    });//document.ready
</script>