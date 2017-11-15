<!-- Tabla responsiva -->
<div class="table-responsive">
	<!-- Tabla -->
	<table id="tabla_filtros" class="table">
		<!-- Cabecera -->
		<thead>
            <tr>
				<th class="text-center" width="5%">Opciones</th>
				<th class="text-center">Nro.</th>
				<th class="text-center">Nombre</th>
				<th class="text-center">Estado</th>
			</tr>
        </thead><!-- Cabecera -->
		<!-- Cuerpo -->
        <tbody>
        	<?php
            //Contador
            $cont = 1;
            // Recorrido de los filtros
            foreach ($filtros as $filtro) {
            ?>
            <tr>
				<td>
					<a onClick="javascript:editar('productos', <?php echo $filtro->intCodigo; ?>)" class="icono"><span class="glyphicon glyphicon-edit"></span></a>
				</td>
				<td class="text-right"><?php echo $cont; ?></td>
				<td><?php echo $filtro->strNombre; ?></td>
				<td><?php echo $estado = ($filtro->Estado == 1) ? "Activo" : "Inactivo" ; ?></td>
            </tr>
            <?php
            //Aumento de contador
            $cont++;
            } //Foreach
            ?>
		</tbody><!-- Cuerpo -->
	</tabla><!-- Tabla -->
</div><!-- Tabla responsiva -->

<script type="text/javascript">

	$(document).ready(function(){
        // Inicialización de la tabla
        $('#tabla_filtros').dataTable( {
            "bProcessing": true,
        }); // Tabla
    });//document.rady
</script>