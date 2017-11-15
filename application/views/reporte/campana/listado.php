<?php
// Se cargan los datos necesarios
$id_usuario = $this->input->post("id_usuario");
$id_campana = $this->input->post("id_campana");
$datos_campana = $this->reporte_model->cargar_datos_campana($id_campana, $id_usuario);
$estados = $this->listas_model->cargar('oportunidad_estados');
$fases = $this->listas_model->cargar('oportunidad_fases');
$tipos = $this->listas_model->cargar('productos_lineas');
$usuarios = $this->listas_model->cargar_usuarios_sistema();
$productos = $this->reporte_model->cargar_productos_campana($id_campana, $id_usuario);
?>

<!-- Informe de resultados de campaña -->
<div class="col-sm-4">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Informe de resultados de campaña</h3>
        </div>
        <div class="panel-body" id="datos_personales">
            <!-- Columna 1 -->
            <ul class="list-group" style="text-align: left">
                <li class="list-group-item">
                    <span class="badge"><?php echo $datos_campana->strNombre; ?></span> Nombre
                </li>
                <li class="list-group-item">
                    <span class="badge"><?php echo $datos_campana->fecha_inicia; ?></span> Fecha de inicio
                </li>
                <li class="list-group-item">
                    <span class="badge"><?php echo $datos_campana->fecha_finaliza; ?></span> Fecha final
                </li>
                <li class="list-group-item">
                    <span class="badge"><?php echo $datos_campana->Oficina; ?></span> Oficina
                </li>
                <li class="list-group-item">
                    <span class="badge"><?php if($datos_campana->Estado == '1'){echo "Activo";}else{echo "Inactivo";} ?></span> Estado
                </li>
                <li class="list-group-item">
                    <span class="badge"><?php echo $datos_campana->Oportunidades; ?></span> Cantidad de oportunidades
                </li>
                <li class="list-group-item">
                    <span class="badge"><?php echo $datos_campana->Comentarios; ?></span> Cantidad de comentarios
                </li>
                <li class="list-group-item">
                    <span class="badge"><?php echo "$ ".number_format($datos_campana->costo_estimado, 0, '', '.'); ?></span> Costo estimado
                </li>
                <li class="list-group-item">
                    <span class="badge"><?php echo "$ ".number_format($datos_campana->beneficio_estimado, 0, '', '.'); ?></span> utilidad estimada
                </li>
                <li class="list-group-item">
                    <span class="badge"><?php echo number_format($datos_campana->Cantidad_personas, 0, '', '.'); ?></span> Invitados
                </li>

                <li class="list-group-item">
                    <span class="badge"><?php echo number_format($datos_campana->Invitados_Agregados, 0, '', '.'); ?></span> Personas agregadas a la campaña
                </li>
            </ul><!-- Columna 1 -->
            
            <!-- Columna 2 -->
            <ul class="list-group col-sm-4" style="text-align: left">
                
            </ul><!-- Columna 2 -->
            
            <!-- Columna 3 -->
            <ul class="list-group col-sm-4" style="text-align: left">
                
            </ul><!-- Columna 3 -->
        </div>
    </div><!-- Informe de resultados de campaña -->
</div>

<div id="cont_datos_personales" class="col-lg-3">
    <!-- Oportunidades por cada estado -->
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Oportunidades por cada estado</h3>
        </div>
        <div class="panel-body">
            <table class="table">
                <tr>
                    <th>Estado</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>
                <?php
                $cantidad = 0;
                $total = 0;
                foreach ($estados as $estado) {
                    // Se consultan los valores por estado
                    $oportunidad_estado = $this->reporte_model->oportunidad_estado($id_campana, $estado->intCodigo);
                    $cantidad = $oportunidad_estado->Cantidad + $cantidad;
                    $total = $oportunidad_estado->Total + $total;
                ?>
                    <tr>
                        <td><?php echo $estado->strNombre; ?></td>
                        <td class="text-right"><?php echo number_format($oportunidad_estado->Cantidad, 0, '', '.'); ?></td>
                        <td class="text-right"><?php echo number_format($oportunidad_estado->Total, 0, '', '.'); ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th class="text-right">Totales</th>
                    <th class="text-right"><?php echo number_format($cantidad, 0, '', '.'); ?></th>
                    <th class="text-right"><?php echo number_format($total, 0, '', '.'); ?></th>
                </tr>
            </table>
        </div>
    </div><!-- Oportunidades por cada estado -->

    <!-- Oportunidades por cada fase -->
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Oportunidades por cada fase</h3>
        </div>
        <div class="panel-body">
            <table class="table">
                <tr>
                    <th>Estado</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>
                <?php
                $cantidad = 0;
                $total = 0;
                foreach ($fases as $fase) {
                    // Se consultan los valores por estado
                    $oportunidad_fase = $this->reporte_model->oportunidad_fase($id_campana, $fase->intCodigo);
                    $cantidad = $oportunidad_fase->Cantidad + $cantidad;
                    $total = $oportunidad_fase->Total + $total;
                ?>
                    <tr>
                        <td><?php echo $fase->strNombre; ?></td>
                        <td class="text-right"><?php echo number_format($oportunidad_fase->Cantidad, 0, '', '.'); ?></td>
                        <td class="text-right"><?php echo number_format($oportunidad_fase->Total, 0, '', '.'); ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th class="text-right">Totales</th>
                    <th class="text-right" class="text-right"><?php echo number_format($cantidad, 0, '', '.'); ?></th>
                    <th class="text-right" class="text-right"><?php echo number_format($total, 0, '', '.'); ?></th>
                </tr>
            </table>
        </div>
    </div><!-- Oportunidades por cada fase -->
</div>

<div id="cont_datos_personales" class="col-lg-5">
    <!-- Productos -->
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Productos</h3>
        </div>
        <div class="panel-body">
            <table class="table">
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Valor</th>
                    <th>Transferencia</th>
                </tr>
                <?php
                $cantidad = 0;
                $total_valor = 0;
                $total_transferencia = 0;
                
                foreach ($productos as $producto) {
                    $cantidad = $producto->cantidad + $cantidad;
                    $total_valor = $producto->valor + $total_valor;
                    $total_transferencia = $producto->transferencia + $total_transferencia;
                ?>
                    <tr>
                        <td><?php echo $producto->strNombre; ?></td>
                        <td class="text-right"><?php echo number_format($producto->cantidad, 0, '', '.'); ?></td>
                        <td class="text-right"><?php echo number_format($producto->valor, 0, '', '.'); ?></td>
                        <td class="text-right"><?php echo number_format($producto->transferencia, 0, '', '.'); ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th class="text-right">Totales</th>
                    <th class="text-right" class="text-right"><?php echo number_format($cantidad, 0, '', '.'); ?></th>
                    <th class="text-right" class="text-right"><?php echo number_format($total_valor, 0, '', '.'); ?></th>
                    <th class="text-right" class="text-right"><?php echo number_format($total_transferencia, 0, '', '.'); ?></th>
                </tr>
            </table>
        </div>
    </div><!-- Productos -->
</div>