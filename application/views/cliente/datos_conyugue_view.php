<?php 
//Si viene un id de asociado, usaremos el nombre para título, sino, vacío
if ($id_asociado) { 
    //Se consultan los datos del asociado
    $asociado = $this->cliente_model->cargar_asociado($id_asociado);

    // Usamos el nombre como título
    $titulo = $asociado->Nombre." ".$asociado->PrimerApellido." ".$asociado->SegundoApellido;
}
?>
<div class="panel panel-primary">    
    <div class="panel-heading">
        <!-- Expandir - Contraer --> 
        <a style="color:#FFFFFF" href="javascript:expandir_contraer('datos_conyugue')">
            <h3 class="panel-title"><span class="glyphicon glyphicon-link"></span> Datos del cónyuge</h3>
        </a><!-- Expandir - Contraer -->    
    </div>
    <div class="panel-body" id="datos_conyugue">
        <div class="oculto">
            <!-- Nombre del cónyugue -->
            <div class="form-group">
                <label for="input_nombre_conyugue" class="col-sm-5 control-label">Nombre</label>
                <div class="col-sm-7">
                    <input id="input_nombre_conyugue" class="form-control input-sm" type="text">
                </div>
            </div><!-- Nombre del cónyuge -->

            <!-- Número de identificación cónyuge -->
            <div class="form-group">
                <label for="input_identificacion_conyugue" class="col-sm-5 control-label">Número de identificación</label>
                <div class="col-sm-7">
                    <input id="input_identificacion_conyugue" class="form-control input-sm" type="text">
                </div>
            </div><!-- Número de identificación cónyugue -->

            <!-- Dirección cónyugue -->
            <div class="form-group">
                <label for="input_direccion_conyugue" class="col-sm-5 control-label">Dirección</label>
                <div class="col-sm-7">
                    <input id="input_direccion_conyugue" class="form-control input-sm" type="text">
                </div>
            </div><!-- Dirección cónyugue -->

            <!-- País cónyugue -->
            <div class="form-group">
                <label for="input_pais_conyugue" class="col-sm-5 control-label">País</label>
                <div class="col-sm-7">
                    <select id="input_pais_conyugue" class="form-control input-sm" >
                        <option value="">Seleccione...</option>
                        <?php foreach ($paises as $pais) { ?>
                            <option value="<?php echo $pais->strCodigo ?>"><?php echo $pais->strNombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div><!-- País cónyugue -->

            <!-- Departamento cónyugue -->
            <div class="form-group">
                <label for="input_departamento_conyugue" class="col-sm-5 control-label">Departamento</label>
                <div class="col-sm-7">
                    <select id="input_departamento_conyugue" class="form-control input-sm" >
                        <option value="">Seleccione primero un departamento</option>
                    </select>
                </div>
            </div><!-- Departamento cónyugue -->

            <!-- Ciudad cónyugue -->
            <div class="form-group">
                <label for="input_ciudad_conyugue" class="col-sm-5 control-label">Ciudad</label>
                <div class="col-sm-7">
                    <select id="input_ciudad_conyugue" class="form-control input-sm" >
                        <option value="">Seleccione primero una ciudad</option>
                    </select>
                </div>
            </div><!-- Ciudad cónyugue -->

            <!-- Barrio cónyugue -->
            <div class="form-group">
                <label for="input_barrio_conyugue" class="col-sm-5 control-label">Barrio</label>
                <div class="col-sm-7">
                    <select id="input_barrio_conyugue" class="form-control input-sm" >
                        <option value="">Seleccione primero una ciudad</option>
                    </select>
                </div>
            </div><!-- Barrio cónyugue -->

            <!-- Zona cónyugue -->
            <div class="form-group">
                <label for="input_zona_conyugue" class="col-sm-5 control-label">Zona</label>
                <div class="col-sm-7">
                    <select id="input_zona_conyugue" class="form-control input-sm" >
                        <option value="">Seleccione...</option>
                        <?php foreach ($zonas as $zona) { ?>
                        <option value="<?php echo $zona->intCodigo; ?>"><?php echo $zona->strNombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div><!-- Zona cónyugue -->

            <!-- Estrato cónyugue -->
            <div class="form-group">
                <label for="input_estrato_conyugue" class="col-sm-5 control-label">Estrato</label>
                <div class="col-sm-7">
                    <select id="input_estrato_conyugue" class="form-control input-sm" >
                        <option value="">Seleccione...</option>
                            <?php foreach ($estratos as $estrato) { ?>
                        <option value="<?php echo $estrato->intCodigo; ?>"><?php echo $estrato->strNombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div><!-- Estrato cónyugue -->

            <!-- Fecha de nacimiento del cónyugue -->
            <div class="form-group">
                <label for="fecha_nacimiento_conyugue" class="col-sm-5 control-label">Fecha de nacimiento</label>
                
                <!-- Día -->
                <div class="col-sm-2">
                    <select id="dia_nacimiento_conyugue" class="form-control input-sm">
                        <option value="00">Día</option>
                        <?php foreach ($dias as $dia) { ?>
                            <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                        <?php } ?>
                    </select>
                </div><!-- Día -->
                
                <!-- Mes -->
                <div class="col-sm-2">
                    <select id="mes_nacimiento_conyugue" class="form-control input-sm">
                        <option value="00">Mes</option>
                        <?php foreach ($meses as $mes) { ?>
                            <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div><!-- Mes -->
                
                <!-- Año -->
                <div class="col-sm-3">
                    <select id="anio_nacimiento_conyugue" class="form-control input-sm" >
                        <option value="0000">Año</option>
                        <?php foreach ($anios as $anio) { ?>
                            <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                        <?php } ?>
                    </select>
                </div><!-- Año -->
            </div><!-- Fecha de nacimiento del cónyugue -->

            <!-- Género del cónyugue -->
            <div class="form-group">
                <label for="input_genero_conyugue" class="col-sm-5 control-label">Género</label>
                <div class="col-sm-7">
                    <select id="input_genero_conyugue" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                            <?php foreach ($generos as $genero) { ?>
                        <option value="<?php echo $genero->intCodigo; ?>"><?php echo $genero->strNombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div><!-- Género del cónyugue -->

            <!-- Correo electrónico del cónyugue -->
            <div class="form-group">
                <label for="input_email_conyugue" class="col-sm-5 control-label">Correo electrónico</label>
                <div class="col-sm-7">
                    <input id="input_email_conyugue" class="form-control input-sm" type="text">
                </div>
            </div><!-- Correo electrónico del cónyugue -->

            <!-- Teléfono celular del cónyugue -->
            <div class="form-group">
                <label for="input_celular_conyugue" class="col-sm-5 control-label">Teléfono celular</label>
                <div class="col-sm-7">
                    <input id="input_celular_conyugue" class="form-control input-sm" type="text">
                </div>
            </div><!-- Teléfono celular del cónyugue -->

            <!-- Teléfono casa del cónyugue -->
            <div class="form-group">
                <label for="input_tel_casa_conyugue" class="col-sm-5 control-label">Teléfono casa</label>
                <div class="col-sm-7">
                    <input id="input_tel_casa_conyugue" class="form-control input-sm" type="text">
                </div>
            </div><!-- Teléfono casa del cónyugue -->

            <!-- Teléfono oficina del cónyugue -->
            <div class="form-group">
                <label for="input_tel_oficina_conyugue" class="col-sm-5 control-label">Teléfono oficina</label>
                <div class="col-sm-7">
                    <input id="input_tel_oficina_conyugue" class="form-control input-sm" type="text">
                </div>
            </div><!-- Teléfono oficina del cónyugue -->

            <!-- Otro teléfono del cónyugue -->
            <div class="form-group">
                <label for="input_otro_telefono_conyugue" class="col-sm-5 control-label">Otro teléfono</label>
                <div class="col-sm-7">
                    <input id="input_otro_telefono_conyugue" class="form-control input-sm" type="text">
                </div>
            </div><!-- Otro teléfono del cónyugue -->
        </div>    
    </div>
</div><!-- Panel datos del cónyugue -->

<?php if ($id_asociado) { ?>
    <script type="text/javascript">
        $(document).ready(function(){ 
            /**
             * Campos que cargan información del cliente seleccionado, en caso de que lo haya
             */
            $("#input_nombre_conyugue").val("<?php echo $asociado->NombredelConyuge; ?>");
            $("#input_identificacion_conyugue").val("<?php echo $asociado->Identificacion_Conyuge; ?>");
            $("#input_direccion_conyugue").val("<?php echo $asociado->Direccion_Conyuge; ?>");
            $('#input_pais_conyugue > option[value="<?php echo $asociado->Pais_Conyugue; ?>"]').attr('selected', 'selected');
            $('#input_zona_conyugue > option[value="<?php echo $asociado->id_Zona_Conyuge; ?>"]').attr('selected', 'selected');
            $('#input_estrato_conyugue > option[value="<?php echo $asociado->id_Estrato_Conyuge; ?>"]').attr('selected', 'selected');
            
            // Fecha de nacimiento 
            $('#dia_nacimiento_conyugue > option[value="<?php echo substr($asociado->FechaNacimiento_Conyugue, 8, 2); ?>"]').attr('selected', 'selected');
            $('#mes_nacimiento_conyugue > option[value="<?php echo substr($asociado->FechaNacimiento_Conyugue, 5, 2); ?>"]').attr('selected', 'selected');
            $('#anio_nacimiento_conyugue > option[value="<?php echo substr($asociado->FechaNacimiento_Conyugue, 0, 4); ?>"]').attr('selected', 'selected');
            
            $('#input_genero_conyugue > option[value="<?php echo $asociado->id_Genero_Conyugue; ?>"]').attr('selected', 'selected');
            $("#input_email_conyugue").val("<?php echo $asociado->Email_Conyuge; ?>");
            $("#input_celular_conyugue").val("<?php echo $asociado->Celular_Conyuge; ?>");
            $("#input_tel_casa_conyugue").val("<?php echo $asociado->TelefonoCasa_Conyuge; ?>");
            $("#input_tel_oficina_conyugue").val("<?php echo $asociado->TelefonoOficina_Conyuge; ?>");
            $("#input_otro_telefono_conyugue").val("<?php echo $asociado->OtroTelefono_Conyuge; ?>");
        }); //document.ready
    </script>
<?php } ?>