<!-- Se cargan las encuestas de la empresa -->
<?php $encuestas = $this->listas_model->cargar_encuestas(); ?>

<!-- Tabla responsiva -->
<div class="table-responsive">
    <!-- Tabla -->
    <table id="tbl_encuestas" class="table">
        <!-- Cabecera -->
        <thead>
            <tr>
                <th class="alinear_centro" width="5%">Opc.</th>
                <th class="alinear_centro" width="5%">Id</th>
                <th class="alinear_centro" width="35%">Producto</th>
                <th class="alinear_centro" width="45%">Pregunta</th>
                <th class="alinear_centro" width="10%">Periodicidad</th>
			</tr>
        </thead><!-- Cabecera -->
        <!-- Cuerpo -->
        <tbody>
            <!-- Recorrido de las encuestas -->
            <?php foreach ($encuestas as $encuesta) { ?>
                <tr>
                    <td>
                        <span onclick="javascript:editar(<?php echo $encuesta->intCodigo; ?>)" class="glyphicon glyphicon-edit"></span>
                    </td>
                    <td width="5%" class="text-right"><?php echo $encuesta->intCodigo; ?></td>
                    <td><?php echo $encuesta->producto; ?></td>
                    <td><?php echo $encuesta->pregunta; ?></td>
                    <td><?php echo $encuesta->periodicidad; ?></td>
                </tr>
            <?php } // foreach ?>
    	</tbody><!-- Cuerpo -->
    </table><!-- Tabla -->
</div><!-- Tabla responsiva -->

<script type="text/javascript">
    $(document).ready(function(){
        // Inicialización de la tabla
        $('#tbl_encuestas').dataTable( {
            "bProcessing": true
        }); // Tabla
    }); 
</script>