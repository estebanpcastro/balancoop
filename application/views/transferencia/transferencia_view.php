	<?php
// se verifica si los datos vienen por get
if ($this->uri->segment(6) == "get") {
	//Cuando la transferencia se genera desde afuera, los datos se toman por get
	// echo "Vienen por GET<br>";
	
	$anio = date("Y") -1 ;
	$id_empresa = $this->uri->segment(3);
	$id_oficina = $this->uri->segment(4);
	$identificacion = $this->uri->segment(5);
}

//Puede que estando dentro lo modifique, y estos vienen por post
if($this->input->post('metodo') == 'post') {
	//Cuando es generada desde el usuario logueado o desde dentro, es por POST
	// echo "Vienen por POST<br>";
	
	$anio = $this->input->post('anio');
	$id_empresa = $this->input->post('id_empresa');
	$id_oficina = $this->input->post('id_oficina');
	$identificacion = $this->input->post('identificacion');
}

// Se declaran las variables en cero
$compras_anio_seleccionado = 0;
$compras_anio_actual = 0;
$compras_ultimos_meses = 0;

//Datos
$datos_asociado = $this->transferencia_model->buscar_asociado($identificacion, $id_empresa);
$datos_generales = array("anio" => $anio, "id_oficina" => $id_oficina, "id_empresa" => $id_empresa, "identificacion" => $identificacion);

// echo "datos del asociado " . $datos_asociado->Nombre."<br>";
//print_r($datos_generales);

//
$anio_actual = $this->transferencia_model->compras_anio_actual($id_empresa, $datos_generales);
if (isset($anio_actual->Total_Compras)) {
	$compras_anio_actual = $anio_actual->Total_Compras;
}

//
$anio_seleccionado = $this->transferencia_model->compras_anio_seleccionado($id_empresa, $datos_generales);
if (isset($anio_seleccionado->Total_Compras) == 1) {
	$compras_anio_seleccionado = $anio_seleccionado->Total_Compras;
}

//
$ultimos_meses = $this->transferencia_model->compras_ultimos_meses($id_empresa, $datos_generales);
if (isset($ultimos_meses->Total_Compras) == 1) {
	$compras_ultimos_meses = $ultimos_meses->Total_Compras;
}

//Transferencias por mes
$transferencias = $this->transferencia_model->transferencias_mensuales($id_empresa, $datos_generales);
?>

<!-- Nombre del asociado -->
<div class="well">
	<?php if(count($datos_asociado) > 0){ ?>
		<p>
			Transferencia solidaria de <b><?php echo $datos_asociado->Nombre." ".$datos_asociado->PrimerApellido." ".$datos_asociado->SegundoApellido; ?></b><!--  - <a href="<?php //echo site_url('cliente/detalles/')."/".$identificacion; ?>" target="_blank">(Ver detalles del asociado)</a>  --> <?php //if ($datos_asociado->id_EstadoactualEntidad == "1"){echo " (Activo)";}else{echo " (Inactivo)";}; ?></b>
		</p>
	<?php }else{ ?>
		<p>No se encontró el asociado</p>
	<?php } ?>
	<p>Utiliza nuestros servicios y recibe una mayor transferencia solidaria. Somos una Cooperativa con alto beneficio social.<br> Accede a los siguientes enlaces y conoce todo lo que podemos hacer por tí.</p>
</div><!-- Nombre del asociado -->

<!-- Resumen general -->
<div class="row">
	<div class="table-responsive">
		<table class="table">
			<thead>
				<th class="text-center">Categorías</th>
				<th class="text-center">Líneas</th>
				<th class="text-center">Asociados</th>
				<th class="text-center">Total Transferencia solidaria como cooperativa a sus asociados</th>
				<th class="text-center">Promedio de transferencia solidaria como cooperativa a sus asociados</th>
				<th class="text-center">Su transferencia</th>
				<th class="text-center">Su transferencia solidaria comparada con el promedio de la cooperativa</th>
			</thead>

			<tbody>
				<?php
				$transferencia_acumulada = 0	;
				$promedio_acumulado = 0	;
				$total_promedio_transferencia_asociado = 0	;
				$acumulado_transferencia_asociado = 0	;
				$acumulado_comparacion = 0	;
				
				// Se recorren las categorías
				foreach ($this->listas_model->cargar_productos_categorias($id_empresa) as $categoria) {
					// Cantidad de asociados
					$asociados = $this->transferencia_model->asociados_por_categoria($id_empresa, $id_oficina, $anio, $categoria->intCodigo);

					// Transferencia total
					$transferencia_total = $this->transferencia_model->transferencia_por_categoria($id_empresa, $id_oficina, $anio, $categoria->intCodigo);
					$transferencia_acumulada += $transferencia_total;

					// Promedio de transferencia
					if ($asociados > 0) {
						$promedio_transferencia = $transferencia_total / $asociados;
					} else {
						$promedio_transferencia = 0;
					}

					$promedio_acumulado += $promedio_transferencia;

					// Transferencia asociado
					$transferencia_asociado = $this->transferencia_model->transferencia_por_asociado($id_empresa, $id_oficina, $anio, $categoria->intCodigo, $identificacion);
					$acumulado_transferencia_asociado += $transferencia_asociado;

					// Diferencia en transferencia
					$comparacion_transferencia = $transferencia_asociado - $promedio_transferencia;
					
					// COndición para poner los valores negativos en cero
					$valor_comparacion = ($comparacion_transferencia < 0) ? 0 : $comparacion_transferencia ;
					$valor_comparacion_acumulado = (!$acumulado_comparacion) ? 0 : $acumulado_comparacion ;

					$acumulado_comparacion = $acumulado_comparacion + $valor_comparacion;
					
					// // Color de la comparación
					// $color_comparacion = ($comparacion_transferencia < 0) ? "text-danger" : "" ;

				?>
					<tr style="font-size: 0.9em">
						<td width="25%"><?php echo $categoria->strNombre; ?></td>
						<td width="25%"></td>
						<td width="10%" class="text-right"><?php echo number_format($asociados, 0, '', '.'); ?></td>
						<td width="10%" class="text-right"><?php echo "$ ".number_format($transferencia_total, 0, '', '.'); ?></td>
						<td width="10%" class="text-right"><?php echo "$ ".number_format($promedio_transferencia, 0, '', '.'); ?></td>
						<td width="10%" class="text-right"><?php echo "$ ".number_format($transferencia_asociado, 0, '', '.'); ?></td>
						<td width="10%" class="text-right <?php // echo $color_comparacion; ?>"><?php echo "$".number_format($valor_comparacion, 0, '', '.'); ?></td>
					</tr>
				<?php
				} // foreach

				// $color_acumulado_comparacion = ($acumulado_comparacion < 0) ? "text-danger" : "" ;
				?>
					
				<tr style="font-size: 0.9em">
					<td></td>
					<td></td>
					<td class="text-right"><b>Totales</b></td>
					<td class="text-right"><b><?php echo "$ ".number_format($transferencia_acumulada, 0, "", "."); ?></b></td>
					<td class="text-right"><b><?php echo "$ ".number_format($promedio_acumulado, 0, "", "."); ?></b></td>
					<td class="text-right"><b><?php echo "$ ".number_format($acumulado_transferencia_asociado, 0, "", "."); ?></b></td>
					<td class="text-right <?php //echo $color_comparacion; ?>"><b><?php echo "$ ".number_format($valor_comparacion_acumulado, 0, "", "."); ?></b></td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div>
</div><!-- Resumen general -->

<p class="well">
	El resultado de la comparación de su transferencia solidaria en promedio que entregó nuestra entidad por asociado, debe dar un valor negativo o un valor positivo. Si su transferencia es positiva, eso indica que usted está utilizando nuestros servicios adecuadamente y como resultado nuestra entidad le está realizando mayor transferencia solidaria. Esto como resultado monetario en diferencia de tasas de mercado de productos de captación o colocación o la participación activa de las actividades sociales que realiza nuestra entidad. Si el resultado es negativo, es consecuencia de su baja utilización de nuestros servicios o de asistencia a nuestras actividades sociales.
</p>

<!-- Compras del año seleccionado -->
<ul class="nav nav-pills nav-stacked col-sm-3">
	<li class="active">
		<a href="#">
			<span class="badge pull-right"><?php echo "$".number_format($compras_anio_seleccionado, 0, '', '.'); ?></span>
			Transferencia en el año <?php echo $datos_generales['anio']; ?>
		</a>
	</li>
</ul><!-- Compras del año seleccionado -->

<!-- Compras del año actual -->
<ul class="nav nav-pills nav-stacked col-sm-3">
	<li class="active">
		<a href="#">
			<span class="badge pull-right"><?php echo "$".number_format($compras_anio_actual, 0, '', '.'); ?></span>
			Transferencia este año <?php echo "(".date('Y').")"; ?>
		</a>
	</li>
</ul><!-- Compras del año actual -->

<!-- Compras últimos tres meses -->
<ul class="nav nav-pills nav-stacked col-sm-3">
	<li class="active">
		<a href="#">
			<span class="badge pull-right"><?php echo "$".number_format($compras_ultimos_meses, 0, '', '.'); ?></span>
			Últimos 3 meses
		</a>
	</li>
</ul><!-- Compras últimos tres meses -->

<!-- Estado del asociado -->
<ul class="nav nav-pills nav-stacked col-sm-3">
	<li class="active">
		<a href="#">
			<span class="badge pull-right"><?php echo "$".number_format($this->transferencia_model->total_transferencias($id_empresa, $datos_generales['identificacion']), 0, '', '.'); ?></span>
			Transferencia acumulada
		</a>
	</li>
</ul><!-- Estado del asociado -->
<?php if($transferencias != 'false'){ ?>
<br>
	<table class="table table-hover">
		<thead>
			<tr>
				<th align="center">Oficina</th>
				<th align="center">Mes</th>
				<th align="center">Producto</th>
				<th align="center">Línea</th>
				<th align="center">Categoría</th>
				<th align="center">Cantidad</th>
				<th align="center">Movimiento</th>
				<th align="center">Transferencias</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$total_compras = 0;
			$total_transferencias = 0;
			foreach ($transferencias as $transferencia) {
			?>
				<tr style="font-size: 0.9em">
					<td><?php echo $this->listas_model->obtener_nombre_oficina($transferencia->id_agencia); ?></td>
					<td><?php echo $transferencia->Mes; ?></td>
					<td><?php echo $transferencia->Producto; ?></td>
					<td><?php echo $transferencia->Linea; ?></td>
					<td><?php echo $transferencia->Categoria; ?></td>
					<td class="text-right"><?php echo $transferencia->Cantidad; ?></td>
					<td align="right"><?php echo "$".number_format($transferencia->Compras, 0, '', '.'); ?></td>
					<td align="right"><?php echo "$".number_format($transferencia->Transferencias, 0, '', '.') ; ?></td>
				</tr>
			<?php
				$total_compras += $transferencia->Compras;
				$total_transferencias += $transferencia->Transferencias;
			}
			?>
			
			<!-- <tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td align="right"><b>Total año <?php // echo $anio; ?></b></td>
				<td align="right"><b><?php // echo "$".number_format($total_compras, 0, '', '.'); ?></b></td>
				<td align="right"><b><?php // echo "$".number_format($total_transferencias, 0, '', '.'); ?></b></td>
			</tr> -->
		</tbody>
	</table>
<?php }else{ ?>
	<div class="clear"></div>
	<p></p>
	<div class="well">
		No hay transferencia solidaria registrada para el período y la oficina seleccionados.
	</div>
<?php } ?>