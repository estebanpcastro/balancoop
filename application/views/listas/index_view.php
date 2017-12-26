<?php
 ?>
<!-- Si el usuario es responsable, no puede crear listas, en caso que quiera entrar forzadamente por la URL -->
<?php if($this->session->userdata('tipo') != '2'){ ?>
    <center>
        <div class="btn-group btn-group-sm">
            <button id="btn_campanas" type="button" class="btn btn-default">Campañas</button>
            <!-- Si el usuario es superadministrador -->
            <?php if($this->session->userdata('tipo') == "3"){ ?>
                <button id="btn_empresas" type="button" class="btn btn-default">Empresas</button>
                <button id="btn_listas_desplegables" type="button" class="btn btn-default">Listas desplegables</button>
            <?php } ?>

<!--             <button id="btn_encuestas" type="button" class="btn btn-default">Encuestas</button> -->
            <button id="btn_oficinas" type="button" class="btn btn-default">Oficinas</button>
<!--             <button id="btn_preguntas" type="button" class="btn btn-default">Preguntas</button> -->
            <button id="btn_proveedores" type="button" class="btn btn-default">Proveedores</button>
            <button id="btn_productos" type="button" class="btn btn-default">Productos</button>
            <button id="btn_regiones" type="button" class="btn btn-default">Regiones</button>
            <button id="btn_usuarios" type="button" class="btn btn-default">Usuarios</button>
            <button id="btn_claves" type="button" class="btn btn-default">Contraseñas de asociados</button>
        </div>
    <center>
    <p></p>
<?php } ?>

<!-- Contenedor donde se cargará la información -->
<div id="cont_listas"></div><br>

<script type="text/javascript">
    $(document).ready(function(){
        // Cotraseñas
        $("#btn_claves").on("click", function(){
            //Cargamos la interfaz
            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'claves'});

            //Se muestra la barra de carga
            cargando($("#cont_listas"));
        }); // Cotraseñas

        // Campañas
        $("#btn_campanas").on("click", function(){
            //Cargamos la interfaz
            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'campana'});

            //Se muestra la barra de carga
            cargando($("#cont_listas"));
        }); // Campañas

        // Encuestas
        $("#btn_encuestas").on("click", function(){
            //Cargamos la interfaz
            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'encuesta'});

            //Se muestra la barra de carga
            cargando($("#cont_listas"));
        }); // Campañas

        // Preguntas
        $("#btn_preguntas").on("click", function(){
            //Cargamos la interfaz
            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'preguntas'});

            //Se muestra la barra de carga
            cargando($("#cont_listas"));
        }); // Proveedores

        // Proveedores
        $("#btn_proveedores").on("click", function(){
            //Cargamos la interfaz
            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'proveedor'});

            //Se muestra la barra de carga
            cargando($("#cont_listas"));
        }); // Proveedores

        // Productos
        $("#btn_productos").on("click", function(){
            //Cargamos la interfaz
            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'producto'});

            //Se muestra la barra de carga
            cargando($("#cont_listas"));
        }); // Productos

        // Empresas
        $("#btn_empresas").on("click", function(){
            //Cargamos la interfaz
            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'empresa_oficina', empresa: '1'});

            //Se muestra la barra de carga
            cargando($("#cont_listas"));
        }); // Empresas

        // Oficinas
        $("#btn_oficinas").on("click", function(){
            //Cargamos la interfaz
            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'empresa_oficina', empresa: '2'});

            //Se muestra la barra de carga
            cargando($("#cont_listas"));
        }); // Oficinas

        // Listas desplegables
        $("#btn_listas_desplegables").on("click", function(){
            //Cargamos la interfaz
            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'lista'});

            //Se muestra la barra de carga
            cargando($("#cont_listas"));
        }); // Listas desplegables

        // Regiones
        $("#btn_regiones").on("click", function(){
            //Cargamos la interfaz
            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'region'});

            //Se muestra la barra de carga
            cargando($("#cont_listas"));
        }); // Regiones

        // Usuarios
        $("#btn_usuarios").on("click", function(){
            //Cargamos la interfaz
            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'usuario'});

            //Se muestra la barra de carga
            cargando($("#cont_listas"));
        }); // Usuarios
    });//document.ready
</script>