<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="http://balancoop.com">
        <img id="logo" src="<?php echo base_url().'img/logo.png' ?>" class="img-responsive" alt="Balancoop">
    </a>
</div>
<div class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
        <!-- Inicio -->
        <li class="menu_principal"><a href="<?php echo site_url(''); ?>">Inicio</a></li><!-- Inicio -->

        <!-- Si ya ha iniciado sesión -->
        <?php if($this->session->userdata('id_usuario')){ ?>
            <!-- Cliente -->
            <li class="menu_principal"><a href="<?php echo site_url('cliente'); ?>">Hoja de vida</a></li><!-- Cliente -->

            <!-- CRM -->
            <li class="menu_principal"><a href="<?php echo site_url('crm'); ?>">Segmentación</a></li><!-- CRM -->

            <!-- Balance social -->
            <li class="menu_principal"><a href="<?php echo site_url('balance'); ?>">Balance social</a></li><!-- Balance social -->

            <!-- Transferencia Solidaria -->
            <li class="menu_principal"><a href="<?php echo site_url('transferencia/index/'.$this->session->userdata('id_empresa').'/0/'.$this->session->userdata('identificacion').'/get/'); ?>">Transferencia Solidaria</a></li>

                <!-- Mientras el usuario no sea asignado -->
                <?php if($this->session->userdata('tipo') != "2"){ ?>
                <!-- Administración -->
                <li class="dropdown">
                    <!-- Título del menú -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: white;">Administración <b class="caret"></b></a>

                    <!-- Opciones -->
                    <ul class="dropdown-menu">
                        <!-- Actualización -->
                        <!-- <li><a href="<?php // echo site_url('cliente/actualizados'); ?>">Actualización</a></li> -->
                        <!-- <li class="divider"></li> -->

                        <!-- Importar -->
                        <!-- <li><a href="<?php // echo site_url('importacion'); ?>">Importar</a></li> -->

                        <!-- Filtros -->
                        <li><a href="<?php echo site_url('filtros'); ?>">Filtros</a></li>

                        <!-- Listas -->
                        <li><a href="<?php echo site_url('listas'); ?>">Listas</a></li>

                        <!-- Listas -->
                        <li class="divider"></li>
                        <li><a href="<?php echo site_url('import'); ?>">Importacion</a></li>
                        <!-- <li><a href="<?php // echo site_url('inicio/proyectos'); ?>">Proyectos</a></li> -->

                        <!-- Reporte de campañas -->
                        <!--<li><a href="<?php // echo site_url('reporte/campana'); ?>">Reporte de campañas</a></li>-->
                    </ul><!-- Opciones -->
                </li><!-- Administración -->
            <?php } ?>

            <!-- Cerrar sesión -->
            <li class="derecha menu_principal"><a href="<?php echo site_url('inicio/cerrar_sesion'); ?>"><?php echo "Cerrar sesión"; //echo $this->session->userdata('nombre_usuario'); ?></a></li><!-- Cerrar sesión -->
        <?php } ?>
    </ul>
</div><!--/.navbar-collapse -->

<script>
    // Ejecución de las edades actualizadas
    // ajax("<?php echo site_url('crm/actualizar') ?>", {"tipo": "condicional"}, 'JSON', true);
</script>