<?php
//Se obtiene el año y el id que viene por post
$id_categoria = $this->input->post('id_categoria');
$id_oficina = $this->input->post('id_oficina');
$anio = $this->input->post('anio');
$id_balance = $this->input->post('id_balance');

// Se consulta el peso de las categorías del balance, para verificar que esté balanceado
$peso = $this->balance_model->consultar_balanceo('D', $id_balance, $id_categoria);

// Si está balanceado
if ($peso == '100') {
	// Variable de clase balanceo color verde
	$clase_balanceo = 'exito';
}else{
	// Variable de clase balanceo color rojo
	$clase_balanceo = 'error';
}

//Si el usuario es responsable
if($this->session->userdata('tipo') == '2'){
	// Declaramos un arreglo para las dimensiones
	$dimensiones = array();

	//Consultamos las variables donde este usuario tiene que configurar algo
	$array_variables = $this->balance_model->cargar_variables_usuario2($anio, $id_oficina, 'C');

	// echo count($array_variables);

	// Recorremos las variables almacenando las dimensiones
	foreach ($array_variables as $array_variable) {
		//Si la dimensión pertenece a esta categoría
		if($array_variable->id_categoria == $id_categoria){
			// echo "id dimension: " .$array_variable->id_dimension."<br>";

			//Agregamos al arreglo de dimensiones cada variable encontrada
			array_push($dimensiones, $this->balance_model->cargar_variable($array_variable->id_dimension));
		}
	}
}else{
	//Se listan las dimensiones
	$dimensiones = $this->balance_model->cargar('D', $anio, $id_categoria, '0');
}
?>

<!-- Panel de dimensiones -->
<div class="panel panel-default">
	<!-- Cabecera -->
	<div class="panel-heading"><b class="<?php echo $clase_balanceo; ?>">Dimensiones</b>
		<!-- Si no es administrador, no puede agregar dimensiones -->
		<?php if($this->session->userdata('tipo') != '2'){ ?>
			<!-- Configurar pesos -->
			<a href="javascript:configurar_pesos('D','<?php echo $id_balance; ?>', '<?php echo $id_categoria; ?>')" class="icono_balance" title="Configurar los pesos"><span class="glyphicon glyphicon-cog"></span></a>
		
			<a href="#" class="icono_balance" style="text-decoration: none;">&nbsp;|&nbsp;</a>
			
			<!-- Eliminar categorías -->
			<a href="javascript:eliminar('D', '<?php echo $id_balance; ?>', '<?php echo $id_categoria; ?>')" class="icono_balance" title="Eliminar la dimensión"><span class="glyphicon glyphicon-remove"></span></a>

			<a href="#" class="icono_balance" style="text-decoration: none;">&nbsp;|&nbsp;</a>
			
			<!-- Crear dimensiones -->
			<a href="javascript:crear('D', '<?php echo $id_balance; ?>', '<?php echo $id_categoria; ?>')" class="icono_balance" title="Agregar una dimensión"><span class="glyphicon glyphicon-plus"></span></a>
		<?php } ?>
	</div>

	<!-- Lista -->
	<div class="list-group">
		<!-- Si no se encuentra ninguna dimensión -->
		<?php if (count($dimensiones) < 1) { ?>
			<p class="list-group-item">No se encontraron dimensiones para esta categoría.</p>
		<?php } ?>

		<!-- Se listan las dimensiones -->
		<?php foreach ($dimensiones as $dimension) { ?>
			<?php
			// Se consulta el peso de las categorías del balance, para verificar que esté balanceado
			$peso = $this->balance_model->consultar_balanceo('V', $id_balance, $dimension->intCodigo);

			// Si está balanceado
			if ($peso == '100') {
				// Variable de clase balanceo color verde
				$clase_balanceo_dimension = 'badge-exito';
			}else{
				// Variable de clase balanceo color rojo
				$clase_balanceo_dimension = 'badge-error';
			}
			?>

			<!-- Dimensiones -->
			<a href="javascript:cargar_variables('<?php echo $dimension->intCodigo; ?>', '<?php echo $id_balance; ?>')" class="list-group-item">
				<!-- Nombre -->
				<?php echo $dimension->strNombre; ?>

				<!-- Peso de la dimensión -->
				<span class="badge <?php echo $clase_balanceo_dimension; ?>"><?php echo $dimension->peso; ?></span>
			</a>

			<!-- Contenedor de variables -->
			<div id="cont_variable<?php echo $dimension->intCodigo; ?>" class="contenedor_balance oculto"></div>
		<?php } // foreach dimensiones ?>
	</div><!-- Lista -->
</div><!-- Panel de dimensiones -->
