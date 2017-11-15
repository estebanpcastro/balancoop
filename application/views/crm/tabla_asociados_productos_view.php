<?php 
// echo "filtro " . $id_filtro;
// echo "<br>oficina " . $id_oficina;
// echo "<br>año " . $anio;

// Se consulta el filtro para conocer el id del producto
$filtro = $this->filtro_model->cargar_filtro_producto($id_filtro);

// print_r($filtro);

// echo "<br>Producto " . $filtro->id_producto;
?>
<!-- Tabla responsiva -->
<div id="tabla_empresas" class="table-responsive">
	<!-- Tabla -->
    <table id="tabla_productos" class="table">
    	<!-- Cabecera -->
        <thead>
            <tr>
                <th>Opc.</th>
            	<th>Nro.</th>
            	<th>Nombres</th>
                <th>Apellidos</th>
            	<th>Identificación</th>
            	<th>Email</th>
            	<th>Fijo</th>
                <th>Celular</th>
                <th>Teléfono oficina</th>
                <th>ano</th>
                <th>mes</th>
            	<th>dia</th>
            </tr>
        </thead><!-- Cabecera -->

        <!-- Cuerpo -->
        <tbody>
        	<?php
            /*
            echo "Producto $filtro->id_producto<br>";
            echo "Contiene $filtro->contiene<br>";
            echo "Género $filtro->id_genero<br>";
            echo "Oficina $id_oficina<br>";
            echo "Año $anio<br>";
            */
           
            //Contador
            $cont = 1;
            
            // Recorrido de los datos
            foreach ($this->crm_model->consultar_productos_asociado($filtro->id_producto, $filtro->contiene, $filtro->id_genero, $id_oficina, $anio) as $asociado) {
            ?>
            <tr>
                <td>
                    <a href="<?php echo site_url('cliente/index/')."/".$asociado->id_cliente; ?>" target="_blank">
                        <span class="glyphicon glyphicon-search icono"></span>
                    </a>
                </td>
        		<td class="text-right"><?php echo $cont; ?></td>
        		<td><?php echo $asociado->Nombre; ?></td>
        		<td><?php echo $asociado->PrimerApellido." ".$asociado->SegundoApellido; ?></td>
                <td class="text-right"><?php echo number_format($asociado->id_cliente, 0, '', '.'); ?></td>
        		<td><?php echo $asociado->CorreoElectronico; ?></td>
        		<td><?php echo $asociado->TelefonoCasa; ?></td>
        		<td><?php echo $asociado->Celular_cliente; ?></td>
                <td><?php echo $asociado->TelefonoOficina; ?></td>
                <td><?php echo $asociado->ano; ?></td>
                <td><?php echo $asociado->mes; ?></td>
        		<td><?php echo $asociado->dia; ?></td>
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
    });//document.rady
</script>