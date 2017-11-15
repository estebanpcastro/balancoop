<!-- Paises -->
<div class="col-lg-3">
	<!-- Sólo los super usuarios y configuradores pueden crear datos a listas -->
	<?php if ($this->session->userdata('tipo') != "2") { ?>
		<!-- Agregar País -->
		<button id="btn_agregar_pais" type="button" class="btn btn-info btn-block">Agregar País</button>
	<?php } ?>
	<p></p>
	<div id="cont_paises">
		<!-- Se carga la vista -->
		<?php $this->load->view('listas/regiones/paises_view'); ?>	
	</div>
</div><!-- Paises -->

<!-- Departamentos -->
<div class="col-lg-3">
	<div id="cont_departamentos">
		<div class="page-header">
			<h1>Departamentos <small>Seleccione primero un país para ver sus departamentos.</small></h1>
		</div>
	</div>
</div><!-- Departamentos -->

<!-- Ciudades -->
<div class="col-lg-3">
	<div id="cont_ciudades">
		<div class="page-header">
			<h1>Ciudades <small>Seleccione un departamento.</small></h1>
		</div>
	</div>
</div><!-- Ciudades -->

<!-- Barrio -->
<div class="col-lg-3">
	<div id="cont_barrios">
		<div class="page-header">
			<h1>Barrios <small>Seleccione una ciudad.</small></h1>
		</div>
	</div>
</div><!-- Barrio -->

<script type="text/javascript">
	//Funcion que carga los departamentos
	function cargar_departamentos(codigo_pais){
		//Se recarga la tabla para que muestre los datos
	    $("#cont_departamentos").load("listas/cargar_interfaz", {tipo: 'departamento', codigo_pais: codigo_pais});
	}

	//Funcion que carga las ciudades
	function cargar_ciudades(codigo_departamento){
		//Se recarga la tabla para que muestre los datos
	    $("#cont_ciudades").load("listas/cargar_interfaz", {tipo: 'ciudad', codigo_departamento: codigo_departamento});
	}

	//Funcion que carga los barrios
	function cargar_barrios(codigo_ciudad){
		//Se recarga la tabla para que muestre los datos
	    $("#cont_barrios").load("listas/cargar_interfaz", {tipo: 'barrio', codigo_ciudad: codigo_ciudad});
	}

    $(document).ready(function(){
    	
    });//document.ready
</script>