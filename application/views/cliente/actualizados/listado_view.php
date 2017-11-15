<!-- Se consultan los clientes -->
<?php $asociados = $this->cliente_model->listar_usuarios_actualizados($id_oficina, $mes, $anio); ?>

<!-- Tabla responsiva -->
<div class="table-responsive">
    <!-- Tabla -->
    <table id="productos" class="table">
        <!-- Cabecera -->
        <thead>
            <tr>
            	<th>Nro</th>
            	<th>Nombre</th>
            	<th>Cédula</th>
                <th>Oficina</th>
            	<th>Fecha</th>
            </tr>
        </thead><!-- Cabecera -->

        <!-- Cuerpo -->
        <tbody>
        	<?php
        	//Contador
            $cont = 1;
            // Recorrido de los productos
            foreach ($asociados	 as $asociado) {
            ?>
        	<tr>
                <td class="alinear_derecha"><?php echo $cont; ?></td>
        		<td><?php echo $asociado->Nombres; ?></td>
        		<td class="text-right" ><?php echo number_format($asociado->Identificacion, 0, '', '.'); ?></td>
                <td><?php echo $asociado->Oficina; ?></td>
        		<td><?php echo $asociado->Fecha; ?></td>
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
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Inicialización de la tabla
        $('#productos').dataTable( {
            "bProcessing": true,
        }); // Tabla
	});//document.ready
</script>