<?php
//Se obtiene el año y la oficina que vienen por post
$anio = $this->input->post('anio');
$id_oficina = $this->input->post('id_oficina');

// Se consulta el balance existente con el año y la oficina seleccionados
$balance = $this->balance_model->consultar_balance($anio, $id_oficina);

//Si el usuario es responsable
if($this->session->userdata('tipo') == '2'){
	// Declaramos un arreglo para las cateforías
	$categorias = array();

	//Consultamos las variables donde este usuario tiene que configurar algo
	$variables = $this->balance_model->cargar_variables_usuario($anio, $id_oficina, 'C');
	echo count($variables)." categorias";

	// Recorremos las variables almacenando las categorías
	foreach ($variables as $variable) {
		//Agregamos al arreglo de categorías cada variable encontrada
		array_push($categorias, $this->balance_model->cargar_variable($variable->id_categoria));
	}
}else{
	//Se cargarán todas las categorías
	$categorias = $this->balance_model->cargar('C', $anio, null, $id_oficina);
}
?>

<!-- Si es administrador y si hay categorías -->
<?php if (count($categorias) > 0 && $this->session->userdata('tipo') != '2') { ?>
	<div class="col-lg-6">
		<button id="btn_generar_balance" type="button" class="btn btn-info btn-block btn-xs">Generar informe balance social para esta oficina</button>
	</div>
	<div class="col-lg-6">
		<button id="btn_modal_eliminar_balance" type="button" class="btn btn-danger btn-block btn-xs">Eliminar balance</button>
	</div>
	<div class="clear"><br></div>
<?php } ?>

<!-- Panel de categorias -->
<div class="panel panel-default">
	<!-- Si no existe un balance -->
	<?php if (count($balance) == 0) { ?>
		<div class="panel-heading"><b>No existe el balance</b></div>
		<div class="list-group">
			<p class="list-group-item">No hay un balance creado para el año y oficina seleccionados. Por favor cree uno.</p>
		</div>
	<?php }else{
		// Se consulta el peso de las categorías del balance, para verificar que esté balanceado
		$peso = $this->balance_model->consultar_balanceo('C', $balance->id_balance, '0');

		// Si está balanceado
		if ($peso == '100') {
			// Variable de clase balanceo color verde
			$clase_balanceo = 'exito';
		}else{
			// Variable de clase balanceo color rojo
			$clase_balanceo = 'error';
		}
		?>

		<!-- Como existe, se mostrarán las categorías -->
		<!-- Cabecera -->
		<div class="panel-heading"><b class="<?php echo $clase_balanceo; ?>">Categorías</b>
			<!-- Si no es administrador, no puede agregar categorías -->
			<?php if($this->session->userdata('tipo') != '2'){ ?>
				<!-- Configurar pesos -->
				<a href="javascript:configurar_pesos('C','<?php echo $balance->id_balance; ?>', '0')" class="icono_balance" title="Configurar los pesos"><span class="glyphicon glyphicon-cog"></span></a>

				<a href="#" class="icono_balance" style="text-decoration: none;">&nbsp;|&nbsp;</a>
				
				<!-- Eliminar categorías -->
				<a href="javascript:eliminar('C', '<?php echo $balance->id_balance; ?>', '0')" class="icono_balance" title="Eliminar la categoría"><span class="glyphicon glyphicon-remove"></span></a>

				<a href="#" class="icono_balance" style="text-decoration: none;">&nbsp;|&nbsp;</a>
				
				<!-- Crear categorías -->
				<a href="javascript:crear('C', '<?php echo $balance->id_balance; ?>', '0')" class="icono_balance" title="Agregar una categoría"><span class="glyphicon glyphicon-plus"></span></a>
			<?php } ?>
		</div>

		<!-- Lista -->
		<div id="lista_categorias" class="list-group">
			<!-- Si no se encuentra ninguna categoría -->
			<?php if (count($categorias) < 1) { ?>
				<p class="list-group-item">No se encontraron categorías para esta oficina.</p>
			<?php } ?>

			<!-- Se listan las categorías -->
			<?php foreach ($categorias as $categoria) { ?>
				<?php
				// Se consulta el peso de las categorías del balance, para verificar que esté balanceado
				$peso = $this->balance_model->consultar_balanceo('D', $balance->id_balance, $categoria->intCodigo);

				// Si está balanceado
				if ($peso == '100') {
					// Variable de clase balanceo color verde
					$clase_balanceo_dimension = 'badge-exito';
				}else{
					// Variable de clase balanceo color rojo
					$clase_balanceo_dimension = 'badge-error';
				}
				?>

				<!-- Categorías -->
				<a href="javascript:cargar_dimensiones('<?php echo $categoria->intCodigo; ?>', '<?php echo $balance->id_balance; ?>')" class="list-group-item">
					<!-- Nombre -->
					<span><?php echo $categoria->strNombre; ?></span>

					<!-- Peso de la categoría -->
					<span class="badge <?php echo $clase_balanceo_dimension; ?>"><?php echo $categoria->peso; ?></span>
				</a><!-- Categorías -->
				
				<!-- Contenedor de dimensiones -->
				<div id="cont_dimension<?php echo $categoria->intCodigo; ?>" class="contenedor_balance oculto"></div>
			<?php } //foreach categorías ?>
		</div><!-- Lista -->
	<?php }	?> <!-- if balance count -->
</div><!-- Panel de categorias -->

<script type="text/javascript">
	$(document).ready(function(){
		// Generar balance social
        $("#btn_generar_balance").on("click", function(){
        	//Se obtiene la url y se mandan los parámetros
        	url = "reporte/balance_social/" + $("#select_anio option:selected").text() + "/" + $("#select_oficina").val();

        	//Se abre una nueva ventana con el reporte
        	window.open(url);
        });// Generar balance social

		// Eliminar balance social
        $("#btn_modal_eliminar_balance").on("click", function(){
        	//Se abre la ventana
        	$('#modal_eliminar_balance').modal('show');
        });// Eliminar balance social

        // Eliminar balance social
        $("#btn_eliminar_balance").on("click", function(){
        	// Variables
        	var anio = $("#select_anio");
        	var id_oficina = $("#select_oficina");

        	// Mediante ajax se elimina el balance
        	eliminar = ajax("<?php echo site_url('balance/eliminar'); ?>", {'tipo': 'balance', 'anio': anio.val(), 'id_oficina': id_oficina.val()}, "html");

        	// Si se eliminó
        	if(eliminar == 'true'){
        		//Se cierra la ventana
                $('#modal_eliminar_balance').modal('hide');

                //Cuando se termine de cerrar
                $('#modal_eliminar_balance').on('hidden.bs.modal', function (e) {
                    //Se redirecciona
                    redireccionar("<?php echo site_url('balance'); ?>");
                });
        	} // if

        	// Se detiene el formulario
        	return false;
        });// Eliminar balance social
	});
</script>