<?php 
// Consulta de asociados
$asociados = $this->cliente_model->buscar_nombre($nombre);

?>
<!-- Tabla responsiva -->
<div id="tabla_empresas"  class="table-responsive">
    <!-- Tabla -->
    <table id="tabla_productos" class="table">
        <!-- Cabecera -->
        <thead>
            <tr>
                <th class="alinear_centro" width="10%">Opc.</th>
                <th class="alinear_centro" width="5%">Nro.</th>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Celular</th>
                <th>Correo</th>
                <th>Teléfono casa</th>
                <th>Teléfono oficina</th>
            </tr>
        </thead><!-- Cabecera -->

        <!-- Cuerpo -->
        <tbody>
            <?php
            //Contador
            $cont = 1;
            
            // Recorrido de los datos
            foreach ($asociados as $asociado) {
                // $dato = $this->transferencia_model->buscar_asociado($asociado['id_cliente'], $this->session->userdata('id_empresa'));
            ?>
            <tr>
                <td>
                    <a href="<?php echo site_url('cliente/index/')."/".$asociado->Identificacion; ?>" target="_blank">
                        <span class="glyphicon glyphicon-search icono"></span>
                    </a>
                </td>
                <td><?php echo $cont; ?></td>
                <td><?php echo $asociado->Identificacion; ?></td>
                <td><?php echo $asociado->Nombre; ?></td>
                <td><?php echo $asociado->PrimerApellido." ".$asociado->SegundoApellido; ?></td>
                <td><?php echo $asociado->Celular_cliente; ?></td>
                <td><?php echo $asociado->CorreoElectronico; ?></td>
                <td><?php echo $asociado->TelefonoCasa; ?></td>
                <td><?php echo $asociado->TelefonoOficina; ?></td>
            </tr>
            <!-- Aumento de contador -->
            <?php $cont++; } //Foreach ?>
        </tbody><!-- Cuerpo -->
    </table><!-- Tabla -->
</div><!-- Tabla responsiva -->

<script type="text/javascript">
    $(document).ready(function(){
        // Inicialización de la tabla
        $('#tabla_productos').dataTable( {}); // Tabla

        //Exportar a excel
        /*$("#exportar_excel > a").on("click", function(){
            $("#exportar_excel > a").text("Generando el reporte. Por favor espere...");

            producto = "<?php echo $producto; ?>";

            location.href = "<?php echo site_url('reporte/crm_productos/').'/'.$producto; ?>";

            return false;           
        }); // exportar excel*/
    });//document.ready
</script>