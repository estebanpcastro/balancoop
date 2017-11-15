<?php
//Tomamos los datos que vienen por post
$datos = $this->input->post('datos');
?>
<!-- Contenedor beneficiario -->
<div id="cont_beneficiario<?php echo $numero; ?>">
    <legend>
        <!-- Borrar registro -->
        <a href="javascript:eliminar('cont_beneficiario<?php echo $numero ?>','guardar_beneficiario<?php echo $numero ?>')" title="Eliminar este beneficiario">
            <span class="glyphicon glyphicon-remove"></span>    
        </a><!-- Borrar registro -->

        <!-- Expandir - Contraer -->
        <a href="javascript:expandir_contraer('cont_beneficiario<?php echo $numero ?>')" title="Expandir / Contraer datos">
            Beneficiario <?php echo $numero; ?>
            <span class="glyphicon glyphicon-resize-vertical"></span>
        </a><!-- Expandir - Contraer -->
    </legend>

    <!-- Nombre y teléfono de casa del beneficiario -->
    <div class="form-group">
        <div class="col-sm-6">
            <input id="input_nombre_beneficiario<?php echo $numero ?>" class="form-control input-sm" type="text" placeholder="Nombre" value="<?php echo $datos['nombre']; ?>">
        </div>
        <div class="col-sm-6">
            <input id="input_tel_casa_beneficiario<?php echo $numero ?>" class="form-control input-sm" type="text" placeholder="Teléfono casa" value="<?php echo $datos['telefono_casa']; ?>">
        </div>
    </div><!-- Nombre y teléfono de casa del beneficiario -->

    <!-- Teléfono oficina y email del beneficiario -->
    <div class="form-group">
        <div class="col-sm-6">
            <input id="input_tel_oficina_beneficiario<?php echo $numero ?>" class="form-control input-sm" type="text" placeholder="Teléfono oficina"  value="<?php echo $datos['telefono_oficina']; ?>">
        </div>
        <div class="col-sm-6">
            <input id="input_email_beneficiario<?php echo $numero ?>" class="form-control input-sm" type="text" placeholder="Correo electrónico"  value="<?php echo $datos['email']; ?>">
        </div>
    </div><!-- Teléfono oficina y email del beneficiario -->    
</div><!-- Contenedor beneficiario -->

<!-- Si el estado es Guardar, se guardara el registro -->
<div id="cont_beneficiario_guardar" class="oculto">-->
    <div class="form-group">
        <!-- Estado Guardado -->
        <div class="col-sm-7">
            <select id="guardar_beneficiario<?php echo $numero ?>" class="form-control input-sm">
                <option value="true">Guardar</option>
                <option value="">Seleccione...</option>
                <option value="false">Inactivo</option>                    
            </select>
        </div><!-- Estado Guardado -->                
    </div>
</div><!-- cont_cargos_guardar -->
