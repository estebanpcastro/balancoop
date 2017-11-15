<!-- Se cargan las preguntas de la empresa -->
<?php $preguntas = $this->listas_model->cargar_preguntas(); ?>

<!-- Tabla responsiva -->
<div class="table-responsive">
    <!-- Tabla -->
    <table id="tbl_preguntas" class="table">
        <!-- Cabecera -->
        <thead>
            <tr>
                <th class="alinear_centro" width="10%">Opc.</th>
                <th class="alinear_centro" width="5%">Id</th>
                <th class="alinear_centro" >Descripción</th>
			</tr>
        </thead><!-- Cabecera -->
        <!-- Cuerpo -->
        <tbody>
            <!-- Recorrido de las preguntas -->
            <?php foreach ($preguntas as $pregunta) { ?>
                <tr>
                    <td>
                        <span onclick="javascript:editar(<?php echo $pregunta->intCodigo; ?>)" class="glyphicon glyphicon-edit"></span>
                    </td>
                    <td width="5%" class="text-right"><?php echo $pregunta->intCodigo; ?></td>
                    <td><?php echo $pregunta->descripcion; ?></td>
                </tr>
            <?php } // foreach ?>
    	</tbody><!-- Cuerpo -->
    </table><!-- Tabla -->
</div><!-- Tabla responsiva -->

<script type="text/javascript">
    $(document).ready(function(){
        // Inicialización de la tabla
        $('#tbl_preguntas').dataTable( {
            "bProcessing": true
        }); // Tabla
    }); 
</script>