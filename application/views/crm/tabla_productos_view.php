<?php
// Si se encuentra el asociado en la empresa específica
if($encontrado == '1'){
    // Se consultan los productos
    $productos = $this->crm_model->consultar_productos_documento($documento);
} else {
    // Arreglo vacío
    $productos = array();
}
?>

<!-- Nombre del asociado -->
<div class="well">
	<p>
		Productos encontrados para este número de identificación <b>
        <a href="<?php echo site_url('cliente/index/')."/".$documento; ?>" target="_blank">(Ver datos)</a> 
	</p>
</div><!-- Nombre del asociado -->

<!-- Tabla responsiva -->
<div id="tabla_empresas" class="table-responsive">
	<!-- Tabla -->
    <table id="tabla_productos" class="table">
    	<!-- Cabecera -->
        <thead>
            <tr>
            	<th class="alinear_centro" width="10%">Opc.</th>
                <th class="alinear_centro" width="5%">Nro.</th>
                <th>Producto</th>
                <th>Línea</th>
                <th>Categoría</th>
                <th>Cantidad</th>
                <th>Valor</th>
                <th>Transferencia</th>
                <th>Año</th>
                <th>Mes</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>cliente</th>
                <th>Teléfono fijo</th>
                <th>Teléfono oficina</th>
                <th>Email</th>
                <th>Oficina</th>
        	</tr>
        </thead><!-- Cabecera -->

        <!-- Cuerpo -->
        <tbody>
        	<?php
            //Contador
            $cont = 1;
            // Recorrido de los datos
            foreach ($productos as $producto) {
            ?>
        	<tr>
        		<td></td>
        		<td><?php echo $cont; ?></td>
        		<td><?php echo $producto->strNombre; ?></td>
        		<td><?php echo $producto->Linea; ?></td>
        		<td><?php echo $producto->Categoria; ?></td>
        		<td><?php echo $producto->Cantidad; ?></td>
                <td><?php echo $producto->Valor; ?></td>
                <td><?php echo $producto->transferencia; ?></td>
        		<td><?php echo $producto->Anio; ?></td>
                <td><?php echo $producto->Mes; ?></td>
                <td><?php echo $producto->Nombre; ?></td>
                <td><?php echo $producto->PrimerApellido." ".$producto->SegundoApellido; ?></td>
                <td><?php echo $producto->Celular_cliente; ?></td>
                <td><?php echo $producto->TelefonoCasa; ?></td>
                <td><?php echo $producto->TelefonoOficina; ?></td>
                <td><?php echo $producto->CorreoElectronico; ?></td>
                <td><?php echo $producto->oficina; ?></td>
        	</tr>
        	<!-- Aumento de contador -->
            <?php $cont++; } //Foreach ?>
    	</tbody><!-- Cuerpo -->
    </table><!-- Tabla -->
</div><!-- Tabla responsiva -->

<script type="text/javascript">
    $(document).ready(function(){
        // Inicialización de la tabla
        $('#tabla_productos').dataTable( {
            "bProcessing": true,
        }); // Tabla
        
        //valor = ajax("<?php echo site_url('crm/actualizar') ?>", {"tipo": "condicional"}, 'JSON');
        //imprimir(valor);        
    });//document.rady
</script>