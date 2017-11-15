<?php
$asociados = $this->crm_model->consultar_asociados_producto($id_producto);

//Preparar la cadena de texto
$producto = str_replace(' ', '_', $producto);
?>

<?php if(count($asociados) == 1){ ?>
    <div class="well">
        <p>
            <b>No se encontraron asociados con este producto</b>
        </p>
    </div>
<?php }else{ ?>
    <!-- Nombre del asociado -->
    <div class="well">
        <p>
            <b>Asociados que han comprado este producto (<?php echo number_format(count($asociados), 0, '', '.'); ?>)</b> - <span id="exportar_excel"><a href="#">Exportar a Excel</a></span>
        </p>
    </div><!-- Nombre del asociado -->

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
                    <th>Agencia</th>
                    <th>Línea</th>
                    <th>Categoría</th>
                    <th>Valor</th>
                    <th>Transferencia</th>
                    <th>Año</th>
                    <th>Mes</th>
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
                        <a href="<?php echo site_url('cliente/index/')."/".$asociado->id_cliente; ?>" target="_blank">
                            <span class="glyphicon glyphicon-search icono"></span>
                        </a>
                        <a href="<?php echo site_url('cliente/detalles/')."/".$asociado->id_cliente; ?>" target="_blank">
                            <span class="glyphicon glyphicon-th-list icono"></span>
                        </a>
                    </td>
                    <td><?php echo $cont; ?></td>
                    <td><?php echo $asociado->id_cliente; ?></td>
                    <td><?php echo $asociado->Nombre; ?></td>
                    <td><?php echo $asociado->PrimerApellido." ".$asociado->SegundoApellido; ?></td>
                    <td><?php echo $asociado->Celular_cliente; ?></td>
                    <td><?php echo $asociado->CorreoElectronico; ?></td>
                    <td><?php echo $asociado->TelefonoCasa; ?></td>
                    <td><?php echo $asociado->TelefonoOficina; ?></td>
                    <td><?php echo $asociado->Oficina; ?></td>
                    <td><?php echo $asociado->Linea; ?></td>
                    <td><?php echo $asociado->Categoria; ?></td>
                    <td><?php echo $asociado->valor; ?></td>
                    <td><?php echo $asociado->transferencia; ?></td>
                    <td><?php echo $asociado->ano; ?></td>
                    <td><?php echo $asociado->mes; ?></td>
                </tr>
                <!-- Aumento de contador -->
                <?php $cont++; } //Foreach ?>
            </tbody><!-- Cuerpo -->
        </table><!-- Tabla -->
    </div><!-- Tabla responsiva -->
<?php } ?>

<script type="text/javascript">
    $(document).ready(function(){
        // Inicialización de la tabla
        $('#tabla_productos').dataTable({
            "bProcessing": true,
        }); // Tabla

        //Exportar a excel
        $("#exportar_excel > a").on("click", function(){
            $("#exportar_excel > a").text("Generando el reporte. Por favor espere...");

            producto = "<?php echo $producto; ?>";

            location.href = "<?php echo site_url('reporte/crm_productos/').'/'.$id_producto; ?>";

            return false;           
        }); // exportar excel
    });//document.ready
</script>