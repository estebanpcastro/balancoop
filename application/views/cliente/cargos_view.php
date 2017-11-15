<?php
$dias = $this->listas_model->listar_dias();
$meses = $this->listas_model->listar_meses();
$anios = $this->listas_model->listar_anios();
$cargos = $this->listas_model->cargar('cargos');

//Tomamos los datos que vienen por post
$datos = $this->input->post('datos');
?>

<!-- Contenedor cargo -->
<div id="cont_cargo<?php echo $numero; ?>">
    <legend>
        <!-- Borrar registro -->
        <a href="javascript:eliminar('cont_cargo<?php echo $numero ?>','guardar_cargo<?php echo $numero ?>')" title="Eliminar este cargo">
            <span class="glyphicon glyphicon-remove"></span>                
        </a><!-- Borrar registro -->

        <!-- Expandir - Contraer -->
        <a href="javascript:expandir_contraer('cont_cargo<?php echo $numero ?>')" title="Expandir / Contraer datos">
            Cargo <?php echo $numero; ?>
            <span class="glyphicon glyphicon-resize-vertical"></span>
        </a><!-- Expandir - Contraer -->
    </legend>

	<!-- Cargo -->
    <div class="form-group">
        <div class="col-sm-12">
            <select id="input_cargo<?php echo $numero ?>" class="form-control input-sm">
                <option value="">Cargo...</option>
                <?php foreach ($cargos as $cargo) { ?>
                    <option value="<?php echo $cargo->intCodigo; ?>"><?php echo $cargo->strNombre; ?></option>
                <?php } ?>
            </select>
        </div>
    </div><!-- Cargo -->

    <!-- Lugar y Actividad de cargo -->
    <div class="form-group">
        <div class="col-sm-6">
            <input id="input_lugar_cargo<?php echo $numero ?>" class="form-control input-sm" type="text" placeholder="Lugar" >
        </div>
        <div class="col-sm-6">
            <input id="input_actividad_cargo<?php echo $numero ?>" class="form-control input-sm" type="text" placeholder="Actividad">
        </div>
    </div><!-- Lugar y Actividad de cargo -->

    <!-- Fecha de Inicio -->
    <div class="form-group">
        <label for="dia_inicio_cargo<?php echo $numero; ?>" class="col-sm-5 control-label">Fecha de inicio</label>

        <!-- Día -->
        <div class="col-sm-2">
            <select id="dia_inicio_cargo<?php echo $numero; ?>" class="form-control input-sm">
                <option value="00">Día</option>
                <?php foreach ($dias as $dia) { ?>
                    <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                <?php } ?>
            </select>
        </div><!-- Día -->
        
        <!-- Mes -->
        <div class="col-sm-2">
            <select id="mes_inicio_cargo<?php echo $numero; ?>" class="form-control input-sm">
                <option value="00">Mes</option>
                <?php foreach ($meses as $mes) { ?>
                    <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                <?php } ?>
            </select>
        </div><!-- Mes -->
        
        <!-- Año -->
        <div class="col-sm-3">
            <select id="anio_inicio_cargo<?php echo $numero; ?>" class="form-control input-sm" >
                <option value="0000">Año</option>
                <?php foreach ($anios as $anio) { ?>
                    <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                <?php } ?>
            </select>
        </div><!-- Año -->
    </div><!-- Fecha de Inicio -->

    <!-- Fecha final -->
    <div class="form-group">
        <label for="dia_fin_cargo<?php echo $numero; ?>" class="col-sm-5 control-label">Fecha final</label>

        <!-- Día -->
        <div class="col-sm-2">
            <select id="dia_fin_cargo<?php echo $numero; ?>" class="form-control input-sm">
                <option value="00">Día</option>
                <?php foreach ($dias as $dia) { ?>
                    <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                <?php } ?>
            </select>
        </div><!-- Día -->
        
        <!-- Mes -->
        <div class="col-sm-2">
            <select id="mes_fin_cargo<?php echo $numero; ?>" class="form-control input-sm">
                <option value="00">Mes</option>
                <?php foreach ($meses as $mes) { ?>
                    <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                <?php } ?>
            </select>
        </div><!-- Mes -->
        
        <!-- Año -->
        <div class="col-sm-3">
            <select id="anio_fin_cargo<?php echo $numero; ?>" class="form-control input-sm" >
                <option value="0000">Año</option>
                <?php foreach ($anios as $anio) { ?>
                    <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                <?php } ?>
            </select>
        </div><!-- Año -->
    </div><!-- Fecha final -->    
</div><!-- Contenedor Cargo -->

<!-- Si el estado es Guardar, se guardara el registro -->
<div id="cont_cargos_guardar" class="oculto">
    <div class="form-group">
        <!-- Estado Guardado -->
        <div class="col-sm-7">
            <select id="guardar_cargo<?php echo $numero ?>" class="form-control input-sm">
                <option value="true">Guardar</option>
                <option value="">Seleccione...</option>
                <option value="false">Inactivo</option>                    
            </select>
        </div><!-- Estado Guardado -->                
    </div>
</div><!-- cont_cargos_guardar -->

<script type="text/javascript">
    $(document).ready(function(){
        /**
         * Campos que cargan información del cliente seleccionado, en caso de que lo haya
         */
        $('#input_cargo' + '<?php echo $numero; ?>' + ' > option[value="<?php echo $datos["id_cargo"]; ?>"]').attr('selected', 'selected');
        $('#input_lugar_cargo' + '<?php echo $numero; ?>').val("<?php echo $datos['lugar']; ?>");
        $('#input_actividad_cargo' + '<?php echo $numero; ?>').val("<?php echo $datos['actividad']; ?>");
        
        //Fecha inicio 
        $('#dia_inicio_cargo' + '<?php echo $numero; ?>' + ' > option[value="<?php echo substr($datos["fecha_inicio"], 8, 2); ?>"]').attr('selected', 'selected');
        $('#mes_inicio_cargo' + '<?php echo $numero; ?>' + ' > option[value="<?php echo substr($datos["fecha_inicio"], 5, 2); ?>"]').attr('selected', 'selected');
        $('#anio_inicio_cargo' + '<?php echo $numero; ?>' + ' > option[value="<?php echo substr($datos["fecha_inicio"], 0, 4); ?>"]').attr('selected', 'selected');

        //Fecha final 
        $('#dia_fin_cargo' + '<?php echo $numero; ?>' + ' > option[value="<?php echo substr($datos["fecha_final"], 8, 2); ?>"]').attr('selected', 'selected');
        $('#mes_fin_cargo' + '<?php echo $numero; ?>' + ' > option[value="<?php echo substr($datos["fecha_final"], 5, 2); ?>"]').attr('selected', 'selected');
        $('#anio_fin_cargo' + '<?php echo $numero; ?>' + ' > option[value="<?php echo substr($datos["fecha_final"], 0, 4); ?>"]').attr('selected', 'selected');
    });//Document.ready
</script>