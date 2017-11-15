<?php
$dias = $this->listas_model->listar_dias();
$meses = $this->listas_model->listar_meses();
$anios = $this->listas_model->listar_anios();
$generos = $this->listas_model->cargar('generos');
$parentescos = $this->listas_model->cargar('parentescos');

//Tomamos los datos que vienen por post
$datos = $this->input->post('datos');
?>

<!-- Contenedor conocido -->
<div id="cont_conocido<?php echo $numero; ?>">
    <legend>
        <!-- Borrar registro -->
        <a href="javascript:eliminar('cont_conocido<?php echo $numero ?>','guardar_conocido<?php echo $numero ?>')" title="Eliminar este conocido">
            <span class="glyphicon glyphicon-remove"></span>    
        </a><!-- Borrar registro -->

        <!-- Expandir - Contraer -->
        <a href="javascript:expandir_contraer('cont_conocido<?php echo $numero ?>')" title="Expandir / Contraer datos">
            Conocido <?php echo $numero; ?>
            <span class="glyphicon glyphicon-resize-vertical"></span>
        </a><!-- Expandir - Contraer -->
    </legend>

    <!-- Nombre y teléfono del conocido -->
    <div class="form-group">
        <div class="col-sm-6">
            <input id="input_nombre_conocido<?php echo $numero ?>" class="form-control input-sm" type="text" placeholder="Nombre"  value="<?php echo $datos['nombre']; ?>">
        </div>
        <div class="col-sm-6">
            <input id="input_tel_casa_conocido<?php echo $numero ?>" class="form-control input-sm" type="text" placeholder="Teléfono casa" value="<?php echo $datos['telefono_casa']; ?>">
        </div>
    </div><!-- Nombre y teléfono del conocido -->

    <!-- Teléfono oficina y email del conocido -->
    <div class="form-group">
        <div class="col-sm-6">
            <input id="input_tel_oficina_conocido<?php echo $numero ?>" class="form-control input-sm" type="text" placeholder="Teléfono oficina" value="<?php echo $datos['telefono_oficina']; ?>">
        </div>
        <div class="col-sm-6">
            <input id="input_email_conocido<?php echo $numero ?>" class="form-control input-sm" type="text" placeholder="Correo electrónico" value="<?php echo $datos['email']; ?>">
        </div>
    </div><!-- Teléfono oficina y email del conocido -->

    <!-- Fecha de nacimiento y género del conocido -->
    <div class="form-group">
        <!-- Día -->
        <div class="col-sm-2">
            <select id="dia_nacimiento_conocido<?php echo $numero ?>" class="form-control input-sm">
                <option value="00">Día</option>
                <?php foreach ($dias as $dia) { ?>
                    <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                <?php } ?>
            </select>
        </div><!-- Día -->
        
        <!-- Mes -->
        <div class="col-sm-2">
            <select id="mes_nacimiento_conocido<?php echo $numero ?>" class="form-control input-sm">
                <option value="00">Mes</option>
                <?php foreach ($meses as $mes) { ?>
                    <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                <?php } ?>
            </select>
        </div><!-- Mes -->
        
        <!-- Año -->
        <div class="col-sm-2">
            <select id="anio_nacimiento_conocido<?php echo $numero ?>" class="form-control input-sm" >
                <option value="0000">Año</option>
                <?php foreach ($anios as $anio) { ?>
                    <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                <?php } ?>
            </select>
        </div><!-- Año -->

        <div class="col-sm-6">
            <select id="input_genero_conocido<?php echo $numero ?>" class="form-control input-sm">
                <option value="">Género...</option>
                <?php foreach ($generos as $genero) { ?>
                    <option value="<?php echo $genero->intCodigo; ?>"><?php echo $genero->strNombre; ?></option>
                <?php } ?>
            </select>
        </div>
    </div><!-- Fecha de nacimiento del conocido -->

    <!-- Parentezco del conocido -->
    <div class="form-group">
        <div class="col-sm-12">
            <select id="input_parentesco_conocido<?php echo $numero ?>" class="form-control input-sm">
                <option value="">Parentesco...</option>
                <?php foreach ($parentescos as $parentesco) { ?>
                    <option value="<?php echo $parentesco->intCodigo; ?>"><?php echo $parentesco->strNombre; ?></option>
                <?php } ?>
            </select>
        </div>
    </div><!-- Parentezco del conocido -->    
</div><!-- Contenedor conocido -->

<!-- Si el estado es Guardar, se guardara el registro -->
<div id="cont_conocido_guardar" class="oculto">-->
    <div class="form-group">
        <!-- Estado Guardado -->
        <div class="col-sm-7">
            <select id="guardar_conocido<?php echo $numero ?>" class="form-control input-sm">
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
        $('#input_genero_conocido' + '<?php echo $numero; ?>' + ' > option[value="<?php echo $datos["id_genero"]; ?>"]').attr('selected', 'selected');
        $('#input_parentesco_conocido' + '<?php echo $numero; ?>' + ' > option[value="<?php echo $datos["id_parentesco"]; ?>"]').attr('selected', 'selected');

        // Fecha de nacimiento 
        $('#dia_nacimiento_conocido' + '<?php echo $numero; ?>' + ' > option[value="<?php echo substr($datos["fecha_nacimiento"], 8, 2); ?>"]').attr('selected', 'selected');
        $('#mes_nacimiento_conocido' + '<?php echo $numero; ?>' + ' > option[value="<?php echo substr($datos["fecha_nacimiento"], 5, 2); ?>"]').attr('selected', 'selected');
        $('#anio_nacimiento_conocido' + '<?php echo $numero; ?>' + ' > option[value="<?php echo substr($datos["fecha_nacimiento"], 0, 4); ?>"]').attr('selected', 'selected');
	});//Document.ready
</script>