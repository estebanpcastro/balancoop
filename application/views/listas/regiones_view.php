<?php
//Se cargan los datos necesarios
$paises = $this->listas_model->cargar_paises();
?>

<!-- Paises -->
<div class="col-lg-3">
	<button id="btn_agregar_pais" type="button" class="btn btn-info btn-block">Agregar País</button>

	<!-- Tabla responsiva -->
	<div id="tabla_paises" class="table-responsive" class="table">
		<!-- Tabla -->
		<table id="tabla_datos">
			<!-- Cabecera -->
			<thead>
				<tr>
					<th></th>
				</tr>
			</thead><!-- Cabecera -->

			<!-- Cuerpo -->
    		<tbody>
				<tr>
					<td></td>
					<?php
					/*foreach ($paises as $pais) {
						echo $pais->strNombre."<br>";
					}*/
					?>
				</tr>
			</tbody><!-- Cuerpo -->
		</table><!-- Tabla -->
	</div><!-- Tabla responsiva -->
</div><!-- Pais -->

<!-- Departamentos -->
<div class="col-lg-3">
	<button id="btn_agregar_departamento" type="button" class="btn btn-info btn-block">Agregar Departamento</button>
</div><!-- Departamentos -->

<!-- Ciudades -->
<div class="col-lg-3">
	<button id="btn_agregar_ciudad" type="button" class="btn btn-info btn-block">Agregar Ciudad</button>
</div><!-- Ciudades -->

<!-- Barrios -->
<div class="col-lg-3">
	<button id="btn_agregar_barrio" type="button" class="btn btn-info btn-block">Agregar Barrio</button>
</div><!-- Barrios -->

<script type="text/javascript">
	$(document).ready(function(){
        // Inicialización de la tabla
        $('#tabla_paises').dataTable( {
            "bProcessing": true,
        }); // Tabla
    });//document.ready
</script>