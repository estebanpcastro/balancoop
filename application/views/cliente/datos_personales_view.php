<?php 
//Título genérico
$titulo = "Creación de asociado nuevo";

//Si viene un id de asociado, usaremos el nombre para título, sino, vacío
if ($id_asociado) { 
    //Se consultan los datos del asociado
    $asociado = $this->cliente_model->cargar_asociado($id_asociado);

    // Usamos el nombre como título
    $titulo = $asociado->Nombre." ".$asociado->PrimerApellido." ".$asociado->SegundoApellido;
    ?>

    <?php if ($this->session->userdata('Actualizacion') === '0') { ?>
        <center>
            <a href="<?php echo site_url("cliente/detalles")."/".$asociado->Identificacion; ?>" target="_blank" class="btn btn-info btn-block btn-xs">
                <center>Ver detalles</center>
            </a>
        </center>  
    <?php } ?>
<?php } ?>
<br>

<div class="panel panel-primary">
    <div class="panel-heading">
        <!-- Expandir - Contraer --> 
        <a style="color:#FFFFFF" href="javascript:expandir_contraer('datos_personales')">
            <h3 class="panel-title"><span class="glyphicon glyphicon-user"></span> <?php echo $titulo; ?> - Datos personales</h3>
        </a><!-- Expandir - Contraer -->
    </div>
    <div class="panel-body" id="datos_personales">
        <div class="oculto">
            <!-- Asignado -->
            <div class="form-group">
                <label for="input_asignado" class="col-sm-5 control-label">Asignado</label>
                <div class="col-sm-7">
                    <select id="input_asignado" class="form-control input-sm" autofocus>
                        <option value="">Seleccione...</option>
                        <?php foreach ($usuarios as $usuario) { ?>
                            <option value="<?php echo $usuario->intCodigo; ?>"><?php echo $usuario->strNombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div><!-- Asignado -->

            <!-- Responsable -->
            <div class="form-group">
                <label for="input_responsable" class="col-sm-5 control-label">Responsable</label>
                <div class="col-sm-7">
                    <select id="input_responsable" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                            <?php foreach ($usuarios as $usuario) { ?>
                        <option value="<?php echo $usuario->intCodigo; ?>"><?php echo $usuario->strNombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div><!-- Responsable -->
            
            <!-- Código del asociado -->
            <div class="form-group">
                <label for="input_codigo_asociado" class="col-sm-5 control-label">Código del Asociado</label>
                <div class="col-sm-7">
                    <input id="input_codigo_asociado" class="form-control input-sm" type="text" maxlength="25">
                </div>
            </div><!-- Código del asociado -->

            <!-- Tipo de identificación -->
            <div class="form-group">
                <label for="input_tipo_identificacion" class="col-sm-5 control-label">Tipo de identificación</label>
                <div class="col-sm-7">
                    <select id="input_tipo_identificacion" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                        <?php foreach ($tipos_documento as $tipo_documento) { ?>
                            <option value="<?php echo $tipo_documento->intCodigo; ?>"><?php echo $tipo_documento->strNombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div><!-- Tipo de identificación -->

            <!-- Lugar de expedición -->
            <div class="form-group">
                <label for="input_lugar_expedicion" class="col-sm-5 control-label">Lugar de expedición</label>
                <div class="col-sm-7">
                    <input id="input_lugar_expedicion" class="form-control input-sm" type="text">
                </div>
            </div><!-- Lugar de expedición -->


            <!-- Número de identificación cliente -->
            <div class="form-group">
                <label for="input_identificacion_cliente" class="col-sm-5 control-label">Número de identificación</label>
                <div class="col-sm-7">
                    <input id="input_identificacion_cliente" class="form-control input-sm" type="text">
                </div>
            </div><!-- Número de identificación cliente -->

            <!-- Designación cliente -->
            <div class="form-group">
                <label for="input_designacion_cliente" class="col-sm-5 control-label">Designación</label>
                <div class="col-sm-7">
                    <select id="input_designacion_cliente" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                        <?php foreach ($designaciones as $designacion) { ?>
                            <option value="<?php echo $designacion->intCodigo; ?>"><?php echo $designacion->strNombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div><!-- Designación cliente -->

            <!-- Nombre cliente -->
            <div class="form-group">
                <label for="input_nombre_cliente" class="col-sm-5 control-label">Nombre</label>
                <div class="col-sm-7">
                    <input id="input_nombre_cliente" class="form-control input-sm" type="text">
                </div>
            </div><!-- Nombre cliente -->

            <!-- Primer apellido -->
            <div class="form-group">
                <label for="input_apellido1" class="col-sm-5 control-label">Primer apellido</label>
                <div class="col-sm-7">
                    <input id="input_apellido1" class="form-control input-sm" type="text">
                </div>
            </div><!-- Primer apellido -->

            <!-- Segundo apellido -->
            <div class="form-group">
                <label for="input_apellido2" class="col-sm-5 control-label">Segundo apellido</label>
                <div class="col-sm-7">
                    <input id="input_apellido2" class="form-control input-sm" type="text">
                </div>
            </div><!-- Segundo apellido -->

            <!-- Fecha de nacimiento del cliente -->
            <div class="form-group">
                <label for="dia_nacimiento_cliente" class="col-sm-5 control-label">Fecha de nacimiento</label>
                
                <!-- Día -->
                <div class="col-sm-2">
                    <select id="dia_nacimiento_cliente" class="form-control input-sm">
                        <option value="">Día</option>
                        <?php foreach ($dias as $dia) { ?>
                            <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                        <?php } ?>
                    </select>
                </div><!-- Día -->
                
                <!-- Mes -->
                <div class="col-sm-2">
                    <select id="mes_nacimiento_cliente" class="form-control input-sm">
                        <option value="00">Mes</option>
                        <?php foreach ($meses as $mes) { ?>
                            <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div><!-- Mes -->
                
                <!-- Año -->
                <div class="col-sm-3">
                    <select id="anio_nacimiento_cliente" class="form-control input-sm" >
                        <option value="0000">Año</option>
                        <?php foreach ($anios as $anio) { ?>
                            <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                        <?php } ?>
                    </select>
                </div><!-- Año -->
            </div><!-- Fecha de nacimiento del cliente -->

            <!-- Lugar de nacimiento -->
            <div class="form-group">
                <label for="input_lugar_nacimiento" class="col-sm-5 control-label">Lugar de nacimiento</label>
                <div class="col-sm-7">
                    <input id="input_lugar_nacimiento" class="form-control input-sm" type="text">
                </div>
            </div><!-- Lugar de nacimiento -->

            <!-- Género del cliente -->
            <div class="form-group">
                <label for="input_genero_cliente" class="col-sm-5 control-label">Género</label>
                <div class="col-sm-7">
                    <select id="input_genero_cliente" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                            <?php foreach ($generos as $genero) { ?>
                        <option value="<?php echo $genero->intCodigo; ?>"><?php echo $genero->strNombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div><!-- Género del cliente -->
            
            <!-- Si el género es diferente a masculino, preguntará si es cabeza de familia -->
            <div id="cont_cabeza_familia">
                <!-- ¿Es cabeza de familia? -->
                <div class="form-group">
                    <label for="input_cabeza_familia_cliente" class="col-sm-5 control-label">¿Es cabeza de familia?</label>
                    <div class="col-sm-7">
                        <select id="input_cabeza_familia_cliente" class="form-control input-sm">
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div><!-- ¿Es cabeza de familia? -->
            </div><!-- cont_cabeza_familia -->

            <!-- Origen del cliente -->
            <div class="form-group">
                <label for="input_origen_cliente" class="col-sm-5 control-label">Origen del cliente</label>
                <div class="col-sm-7">
                    <select id="input_origen_cliente" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                        <?php foreach ($origenes_cliente as $origen_cliente) { ?>
                            <option value="<?php echo $origen_cliente->intCodigo; ?>"><?php echo $origen_cliente->strNombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div><!-- Origen del cliente -->

            <!-- Tipo -->
            <div class="form-group">
                <label for="input_tipo" class="col-sm-5 control-label">Tipo</label>
                <div class="col-sm-7">
                    <select id="input_tipo" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                            <?php foreach ($tipos_cliente as $tipo_cliente) { ?>
                        <option value="<?php echo $tipo_cliente->intCodigo; ?>"><?php echo $tipo_cliente->strNombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div><!-- Tipo -->

            <!-- Correo electrónico del cliente -->
            <div class="form-group">
                <label for="input_email_cliente" class="col-sm-5 control-label">Correo electrónico</label>
                <div class="col-sm-7">
                    <input id="input_email_cliente" class="form-control input-sm" type="text">
                </div>
            </div><!-- Correo electrónico del cliente -->
            
            <!-- Fecha de ingreso a la cooperativa -->
            <div class="form-group">
                <label for="dia_ingreso_cliente" class="col-sm-5 control-label">Fecha de ingreso a la cooperativa</label>
                <!-- Día -->
                <div class="col-sm-2">
                    <select id="dia_ingreso_cliente" class="form-control input-sm">
                        <option value="00">Día</option>
                        <?php foreach ($dias as $dia) { ?>
                            <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                        <?php } ?>
                    </select>
                </div><!-- Día -->
                
                <!-- Mes -->
                <div class="col-sm-2">
                    <select id="mes_ingreso_cliente" class="form-control input-sm">
                        <option value="00">Mes</option>
                        <?php foreach ($meses as $mes) { ?>
                            <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div><!-- Mes -->
                
                <!-- Año -->
                <div class="col-sm-3">
                    <select id="anio_ingreso_cliente" class="form-control input-sm" >
                        <option value="0000">Año</option>
                        <?php foreach ($anios as $anio) { ?>
                            <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                        <?php } ?>
                    </select>
                </div><!-- Año -->
            </div><!-- Fecha de ingreso a la cooperativa -->

            <!-- Número de carné -->
            <div class="form-group">
                <label for="input_numero_carne" class="col-sm-5 control-label">Número de carné</label>
                <div class="col-sm-7">
                    <input id="input_numero_carne" class="form-control input-sm" type="text">
                </div>
            </div><!-- Número de carné -->

            <!-- Estado actual en la entidad -->
            <div class="form-group">
                <label for="input_estado_actual_entidad" class="col-sm-5 control-label">Estado actual en la entidad</label>
                <div class="col-sm-7">
                    <select id="input_estado_actual_entidad" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                            <?php foreach ($estados_usuario as $estados) { ?>
                        <option value="<?php echo $estados->intCodigo; ?>"><?php echo $estados->strNombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div><!-- Estado actual en la entidad -->            

            <!-- Si el estado es diferente de activo, mostrará esta información  -->
            <div id="cont_estado" class="oculto">
                <!-- Fecha de retiro del cliente -->
                <div class="form-group">
                    <label for="dia_retiro_cliente" class="col-sm-5 control-label">Fecha de retiro</label>
                    <!-- Día -->
                    <div class="col-sm-2">
                        <select id="dia_retiro_cliente" class="form-control input-sm">
                            <option value="00">Día</option>
                            <?php foreach ($dias as $dia) { ?>
                                <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Día -->
                    
                    <!-- Mes -->
                    <div class="col-sm-2">
                        <select id="mes_retiro_cliente" class="form-control input-sm">
                            <option value="00">Mes</option>
                            <?php foreach ($meses as $mes) { ?>
                                <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Mes -->
                    
                    <!-- Año -->
                    <div class="col-sm-3">
                        <select id="anio_retiro_cliente" class="form-control input-sm" >
                            <option value="0000">Año</option>
                            <?php foreach ($anios as $anio) { ?>
                                <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Año -->
                </div><!-- Fecha de retiro del cliente -->
                
                <!-- Motivo del retiro -->
                <div class="form-group">
                    <label for="input_motivo_retiro" class="col-sm-5 control-label">Motivo del retiro</label>
                    <div class="col-sm-7">
                        <select id="input_motivo_retiro" class="form-control input-sm">
                            <option value="">Seleccione...</option>
                                <?php foreach ($motivos_retiro as $motivo_retiro) { ?>
                            <option value="<?php echo $motivo_retiro->intCodigo; ?>"><?php echo $motivo_retiro->strNombre; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div><!-- Motivo del retiro -->
            </div><!-- cont_estado -->
            
            <!-- ¿Empleado de la cooperativa? -->
            <div class="form-group">
                <label for="input_estado_empleado" class="col-sm-5 control-label">¿Empleado de la cooperativa? </label>
                <div class="col-sm-7">
                    <select id="input_estado_empleado" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                        <option value="0">No</option>
                        <option value="1">Si</option>
                    </select>
                </div>
            </div><!-- ¿Empleado de la cooperativa?-->

            <!-- Si el estado es activo, muestra fechas de inicio  -->
            <div id="cont_empleado" class="oculto">
                <div class="form-group">
                    <!-- Fecha de inicio -->
                    <label for="dia_inicio_cliente" class="col-sm-5 control-label"></label>
                    
                    <!-- Día -->
                    <div class="col-sm-2">
                        <select id="dia_inicio_cliente" class="form-control input-sm">
                            <option value="00">Día</option>
                            <?php foreach ($dias as $dia) { ?>
                                <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Día -->
                    
                    <!-- Mes -->
                    <div class="col-sm-2">
                        <select id="mes_inicio_cliente" class="form-control input-sm">
                            <option value="00">Mes</option>
                            <?php foreach ($meses as $mes) { ?>
                                <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Mes -->
                    
                    <!-- Año -->
                    <div class="col-sm-3">
                        <select id="anio_inicio_cliente" class="form-control input-sm" >
                            <option value="0000">Año</option>
                            <?php foreach ($anios as $anio) { ?>
                                <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Año -->
                </div>
                <div class="form-group">
                    <!-- Tipo Empleado -->
                    <label class="col-sm-5 control-label">Tipo Empleado</label>
                    <div class="col-sm-7">
                        <select id="input_tipo_empleado" class="form-control input-sm">
                            <option value="">Seleccione...</option>
                                <?php foreach ($tipo_empleados as $tipo_empleado) { ?>
                            <option value="<?php echo $tipo_empleado->intCodigo; ?>"><?php echo $tipo_empleado->strNombre; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Tipo Empleado -->
                </div>
                <div class="form-group">    
                    <!-- Ubicacion Empleado -->
                    <label class="col-sm-5 control-label">Ubicación Empleado</label>
                    <div class="col-sm-7">
                        <select id="input_ubicacion_empleado" class="form-control input-sm">
                            <option value="">Seleccione...</option>
                                <?php foreach ($ubicacion_empleados as $ubicacion_empleado) { ?>
                            <option value="<?php echo $ubicacion_empleado->intCodigo; ?>"><?php echo $ubicacion_empleado->strNombre; ?></option>
                            <?php } ?>
                        </select>            
                    </div>
                </div>
            </div><!-- cont_empleado -->

            <!-- Estado como delegado -->
            <div class="form-group">
                <label for="input_estado_delegado" class="col-sm-5 control-label">Estado como delegado</label>
                <div class="col-sm-7">
                    <select id="input_estado_delegado" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                        <option value="0">Inactivo</option>
                        <option value="1">Activo</option>
                    </select>
                </div>
            </div><!-- Estado como delegado -->

            <!-- Si el estado es activo, muestra fechas de inicio y fin -->
            <div id="cont_delegado" class="oculto">
                <div class="form-group">
                    <!-- Fecha de inicio -->
                    <label class="col-sm-5 control-label">Fecha de inicio</label>
                    
                    <!-- Día -->
                    <div class="col-sm-2">
                        <select id="dia_inicio_delegado" class="form-control input-sm">
                            <option value="00">Día</option>
                            <?php foreach ($dias as $dia) { ?>
                                <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Día -->
                    
                    <!-- Mes -->
                    <div class="col-sm-2">
                        <select id="mes_inicio_delegado" class="form-control input-sm">
                            <option value="00">Mes</option>
                            <?php foreach ($meses as $mes) { ?>
                                <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Mes -->
                    
                    <!-- Año -->
                    <div class="col-sm-3">
                        <select id="anio_inicio_delegado" class="form-control input-sm" >
                            <option value="0000">Año</option>
                            <?php foreach ($anios as $anio) { ?>
                                <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Año -->
                </div>

                <div class="form-group">
                    <!-- Fecha final -->
                    <label class="col-sm-5 control-label">Fecha Final</label>

                    <!-- Día -->
                    <div class="col-sm-2">
                        <select id="dia_fin_delegado" class="form-control input-sm">
                            <option value="00">Día</option>
                            <?php foreach ($dias as $dia) { ?>
                                <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Día -->
                    
                    <!-- Mes -->
                    <div class="col-sm-2">
                        <select id="mes_fin_delegado" class="form-control input-sm">
                            <option value="00">Mes</option>
                            <?php foreach ($meses as $mes) { ?>
                                <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Mes -->
                    
                    <!-- Año -->
                    <div class="col-sm-3">
                        <select id="anio_fin_delegado" class="form-control input-sm" >
                            <option value="0000">Año</option>
                            <?php foreach ($anios as $anio) { ?>
                                <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Año -->
                </div>
            </div><!-- cont_delegado -->

            <!-- Estado como consejero -->
            <div class="form-group">
                <label for="input_estado_consejero" class="col-sm-5 control-label">Estado como consejero</label>
                <div class="col-sm-7">
                    <select id="input_estado_consejero" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                        <option value="0">Inactivo</option>
                        <option value="1">Activo</option>
                    </select>
                </div>
            </div><!-- Estado como consejero -->

            <!-- Si el estado es activo, muestra fechas de inicio y fin -->
            <div id="cont_consejero" class="oculto">
                <div class="form-group">
                    <!-- Fecha de inicio -->
                    <label class="col-sm-5 control-label">Fecha de inicio</label>
                    
                    <!-- Día -->
                    <div class="col-sm-2">
                        <select id="dia_inicio_consejero" class="form-control input-sm">
                            <option value="00">Día</option>
                            <?php foreach ($dias as $dia) { ?>
                                <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Día -->
                    
                    <!-- Mes -->
                    <div class="col-sm-2">
                        <select id="mes_inicio_consejero" class="form-control input-sm">
                            <option value="00">Mes</option>
                            <?php foreach ($meses as $mes) { ?>
                                <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Mes -->
                    
                    <!-- Año -->
                    <div class="col-sm-3">
                        <select id="anio_inicio_consejero" class="form-control input-sm" >
                            <option value="0000">Año</option>
                            <?php foreach ($anios as $anio) { ?>
                                <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Año -->
                </div>

                <div class="form-group">
                    <!-- Fecha final -->
                    <label class="col-sm-5 control-label">Fecha Final</label>

                    <!-- Día -->
                    <div class="col-sm-2">
                        <select id="dia_fin_consejero" class="form-control input-sm">
                            <option value="00">Día</option>
                            <?php foreach ($dias as $dia) { ?>
                                <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Día -->
                    
                    <!-- Mes -->
                    <div class="col-sm-2">
                        <select id="mes_fin_consejero" class="form-control input-sm">
                            <option value="00">Mes</option>
                            <?php foreach ($meses as $mes) { ?>
                                <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Mes -->
                    
                    <!-- Año -->
                    <div class="col-sm-3">
                        <select id="anio_fin_consejero" class="form-control input-sm" >
                            <option value="0000">Año</option>
                            <?php foreach ($anios as $anio) { ?>
                                <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Año -->
                </div>
            </div><!-- cont_consejero -->
            
            <!-- Estado como junta de vigilancia -->
            <div class="form-group">
                <label for="input_estado_junta" class="col-sm-5 control-label">Estado como junta de vigilancia</label>
                <div class="col-sm-7">
                    <select id="input_estado_junta" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                        <option value="0">Inactivo</option>
                        <option value="1">Activo</option>
                    </select>
                </div>
            </div><!-- Estado como junta de vigilancia -->

            <!-- Si el estado es activo, muestra fechas de inicio y fin -->
            <div id="cont_junta" class="oculto">
                <div class="form-group">
                    <!-- Fecha de inicio -->
                    <label class="col-sm-5 control-label">Fecha de inicio</label>
                    
                    <!-- Día -->
                    <div class="col-sm-2">
                        <select id="dia_inicio_junta" class="form-control input-sm">
                            <option value="00">Día</option>
                            <?php foreach ($dias as $dia) { ?>
                                <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Día -->
                    
                    <!-- Mes -->
                    <div class="col-sm-2">
                        <select id="mes_inicio_junta" class="form-control input-sm">
                            <option value="00">Mes</option>
                            <?php foreach ($meses as $mes) { ?>
                                <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Mes -->
                    
                    <!-- Año -->
                    <div class="col-sm-3">
                        <select id="anio_inicio_junta" class="form-control input-sm" >
                            <option value="0000">Año</option>
                            <?php foreach ($anios as $anio) { ?>
                                <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Año -->
                </div>

                <div class="form-group">
                    <!-- Fecha final -->
                    <label class="col-sm-5 control-label">Fecha Final</label>

                    <!-- Día -->
                    <div class="col-sm-2">
                        <select id="dia_fin_junta" class="form-control input-sm">
                            <option value="00">Día</option>
                            <?php foreach ($dias as $dia) { ?>
                                <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Día -->
                    
                    <!-- Mes -->
                    <div class="col-sm-2">
                        <select id="mes_fin_junta" class="form-control input-sm">
                            <option value="00">Mes</option>
                            <?php foreach ($meses as $mes) { ?>
                                <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Mes -->
                    
                    <!-- Año -->
                    <div class="col-sm-3">
                        <select id="anio_fin_junta" class="form-control input-sm" >
                            <option value="0000">Año</option>
                            <?php foreach ($anios as $anio) { ?>
                                <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Año -->
                </div>
            </div><!-- cont_junta -->

            <!-- Si el estado de consejero o el estado de junta es activo, muestra estado directivo (apelación) -->
            <div id="cont_junta_consejero">
                <div class="form-group">
                    <!-- Estado Directivo -->
                    <label for="input_estado_directivo" class="col-sm-5 control-label">Estado tribunal de apelación</label>
                    <div class="col-sm-7">
                        <select id="input_estado_directivo" class="form-control input-sm">
                            <option value="">Seleccione...</option>
                            <option value="0">Inactivo</option>
                            <option value="1">Activo</option>
                        </select>
                    </div><!-- Estado Directivo (apelación) -->                
                </div>
            </div><!-- cont_junta_consejero -->

            <!-- Estado en comités -->
            <div class="form-group">
                <label for="input_estado_comites" class="col-sm-5 control-label">Estado en comités</label>
                <div class="col-sm-7">
                    <select id="input_estado_comites" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                        <option value="0">Inactivo</option>
                        <option value="1">Activo</option>
                    </select>
                </div>
            </div><!-- Estado en comités -->

            <!-- Si el estado es activo, muestra fechas de inicio y fin -->
            <div id="cont_comites" class="oculto">
                <div class="form-group">
                    <!-- Fecha de inicio -->
                    <label class="col-sm-5 control-label">Fecha de inicio</label>
                    
                    <!-- Día -->
                    <div class="col-sm-2">
                        <select id="dia_inicio_comites" class="form-control input-sm">
                            <option value="00">Día</option>
                            <?php foreach ($dias as $dia) { ?>
                                <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Día -->
                    
                    <!-- Mes -->
                    <div class="col-sm-2">
                        <select id="mes_inicio_comites" class="form-control input-sm">
                            <option value="00">Mes</option>
                            <?php foreach ($meses as $mes) { ?>
                                <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Mes -->
                    
                    <!-- Año -->
                    <div class="col-sm-3">
                        <select id="anio_inicio_comites" class="form-control input-sm" >
                            <option value="0000">Año</option>
                            <?php foreach ($anios as $anio) { ?>
                                <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Año -->
                </div>

                <div class="form-group">
                    <!-- Fecha final -->
                    <label class="col-sm-5 control-label">Fecha Final</label>

                    <!-- Día -->
                    <div class="col-sm-2">
                        <select id="dia_fin_comites" class="form-control input-sm">
                            <option value="00">Día</option>
                            <?php foreach ($dias as $dia) { ?>
                                <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Día -->
                    
                    <!-- Mes -->
                    <div class="col-sm-2">
                        <select id="mes_fin_comites" class="form-control input-sm">
                            <option value="00">Mes</option>
                            <?php foreach ($meses as $mes) { ?>
                                <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Mes -->
                    
                    <!-- Año -->
                    <div class="col-sm-3">
                        <select id="anio_fin_comites" class="form-control input-sm" >
                            <option value="0000">Año</option>
                            <?php foreach ($anios as $anio) { ?>
                                <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Año -->
                </div>
            </div><!-- cont_comites -->

            <!-- ¿Está habil? -->
            <div class="form-group">
                <label for="input_habil" class="col-sm-5 control-label">¿Está habil?</label>
                <div class="col-sm-7">
                    <select id="input_habil" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                        <option value="0">No</option>
                        <option value="1">Si</option>
                    </select>
                </div>
            </div><!-- ¿Está habil? -->

            <!-- Rango de ingreso mensual -->
            <div class="form-group">
                <label for="input_rango_ingreso" class="col-sm-5 control-label">Rango de ingreso mensual</label>
                <div class="col-sm-7">
                    <select id="input_rango_ingreso" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                            <?php foreach ($rangos_salario as $rango_salario) { ?>
                        <option value="<?php echo $rango_salario->intCodigo; ?>"><?php echo $rango_salario->strNombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div><!-- Rango de ingreso mensual -->

            <!-- Grupo familiar -->
            <div class="form-group">
                <label for="input_grupo_familiar" class="col-sm-5 control-label">Grupo familiar</label>
                <div class="col-sm-7">
                    <select id="input_grupo_familiar" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                            <?php foreach ($grupos_familiares as $grupo_familiar) { ?>
                        <option value="<?php echo $grupo_familiar->intCodigo; ?>"><?php echo $grupo_familiar->strNombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div><!-- Grupo familiar -->

            <!-- ¿Desea recibir emails? -->
            <div class="form-group">
                <label for="input_recibir_emails" class="col-sm-5 control-label">¿Desea recibir emails?</label>
                <div class="col-sm-7">
                    <select id="input_recibir_emails" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                        <option value="1">Si</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div><!-- ¿Desea recibir emails? -->

            <!-- ¿Desea recibir información por medios internos? -->
            <div class="form-group">
                <label for="input_recibir_medios" class="col-sm-5 control-label">¿Desea recibir información por medios internos?</label>
                <div class="col-sm-7">
                    <select id="input_recibir_medios" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                        <option value="1">Si</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div><!-- ¿Desea recibir información por medios internos? -->

            <!-- Estado civil -->
            <div class="form-group">
                <label for="input_estado_civil" class="col-sm-5 control-label">Estado civil</label>
                <div class="col-sm-7">
                    <select id="input_estado_civil" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                            <?php foreach ($estados_civiles as $estado_civil) { ?>
                        <option value="<?php echo $estado_civil->intCodigo; ?>"><?php echo $estado_civil->strNombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div><!-- Estado civil -->

            <!-- Oficina -->
            <div class="form-group">
                <label for="input_oficina_cliente" class="col-sm-5 control-label">Oficina</label>
                <div class="col-sm-7">
                    <select id="input_oficina_cliente" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                        <?php foreach ($this->listas_model->cargar_empresa('din_agencias', $this->session->userdata('id_empresa')) as $oficina) { ?>
                            <option value="<?php echo $oficina->intCodigo; ?>"><?php echo $oficina->strNombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div><!-- Oficina -->

            <!-- Escolaridad -->
            <div class="form-group">
                <label for="input_escolaridad_cliente" class="col-sm-5 control-label">Escolaridad</label>
                <div class="col-sm-7">
                    <select id="input_escolaridad_cliente" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                            <?php foreach ($escolaridades as $escolaridad) { ?>
                        <option value="<?php echo $escolaridad->intCodigo; ?>"><?php echo $escolaridad->strNombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div><!-- Escolaridad -->

            <!-- Industria -->
            <div class="form-group">
                <label for="input_industria_cliente" class="col-sm-5 control-label">Industria</label>
                <div class="col-sm-7">
                    <select id="input_industria_cliente" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                            <?php foreach ($industrias as $industria) { ?>
                        <option value="<?php echo $industria->intCodigo; ?>"><?php echo $industria->strNombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div><!-- Industria -->

            <!-- Profesión -->
            <div class="form-group">
                <label for="input_profesion_cliente" class="col-sm-5 control-label">Profesión</label>
                <div class="col-sm-7">
                    <select id="input_profesion_cliente" class="form-control input-sm">
                        <option value="">Seleccione...</option>
                            <?php foreach ($profesiones as $profesion) { ?>
                        <option value="<?php echo $profesion->intCodigo; ?>"><?php echo $profesion->strNombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div><!-- Profesión -->
            
            <!-- Conocimiento del cooperativismo -->
            <div class="form-group">
                <label for="input_conocimiento_cooperativismo" class="col-sm-5 control-label">Conocimiento del cooperativismo</label>
                <div class="col-sm-7">
                    <select id="input_conocimiento_cooperativismo" class="form-control input-sm" >
                        <option value="">Seleccione...</option>
                        <?php foreach ($conocimientos as $conocimiento) { ?>
                            <option value="<?php echo $conocimiento->intCodigo; ?>"><?php echo $conocimiento->strNombre; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div><!-- Conocimiento del cooperativismo -->

            <!-- Centro de costos -->
            <div class="form-group">
                <label for="input_centro_costos_cliente" class="col-sm-5 control-label">Centro de costos</label>
                <div class="col-sm-7">
                    <input id="input_centro_costos_cliente" class="form-control input-sm" type="text">
                </div>
            </div><!-- Centro de costos -->

            <!-- Aporte social -->
            <div class="form-group">
                <label for="input_aporte_social_cliente" class="col-sm-5 control-label">Aporte social</label>
                <div class="col-sm-7 input-group input-group-sm">
                    <span class="input-group-addon">$</span>
                    <input id="input_aporte_social_cliente" type="text" class="form-control" />
                    <span class="input-group-addon">.00</span>
                </div>
            </div><!-- Aporte social -->

            <!-- Cuota de admisión -->
            <div class="form-group">
                <label for="input_cuota_admision_cliente" class="col-sm-5 control-label">Cuota de admisión</label>
                <div class="col-sm-7 input-group input-group-sm">
                    <span class="input-group-addon">$</span>
                    <input id="input_cuota_admision_cliente" type="text" class="form-control" />
                    <span class="input-group-addon">.00</span>
                </div>
            </div><!-- Cuota de admisión -->

            <!-- Ingreso real -->
            <div class="form-group">
                <label for="input_ingreso_real" class="col-sm-5 control-label">Ingreso real</label>
                <div class="col-sm-7 input-group input-group-sm">
                    <span class="input-group-addon">$</span>
                    <input id="input_ingreso_real" type="text" class="form-control" />
                    <span class="input-group-addon">.00</span>
                </div>
            </div><!-- Ingreso real -->

            <!-- Total último trimestre -->
            <div class="form-group">
                <label for="input_total_ultimo_trimestre" class="col-sm-5 control-label">Total último trimestre</label>
                <div class="col-sm-7 input-group input-group-sm">
                    <span class="input-group-addon">$</span>
                    <input id="input_total_ultimo_trimestre" type="text" class="form-control" />
                    <span class="input-group-addon">.00</span>
                </div>
            </div><!-- Total último trimestre -->

            <!-- Total año actual -->
            <div class="form-group">
                <label for="input_total_ano_actual" class="col-sm-5 control-label">Total año actual</label>
                <div class="col-sm-7 input-group input-group-sm">
                    <span class="input-group-addon">$</span>
                    <input id="input_total_ano_actual" type="text" class="form-control" />
                    <span class="input-group-addon">.00</span>
                </div>
            </div><!-- Total año actual -->
        </div>    
    </div>
</div>

<?php if ($id_asociado) { ?>
    <script type="text/javascript">
        $(document).ready(function(){ 
            /**
             * Campos que cargan información del cliente seleccionado, en caso de que lo haya
             */
            $('#input_asignado > option[value="<?php echo $asociado->id_Asignado; ?>"]').attr('selected', 'selected');
            $('#input_responsable > option[value="<?php echo $asociado->id_Responsable; ?>"]').attr('selected', 'selected');
            $("#input_codigo_asociado").val("<?php echo $asociado->id_strCodigo_Asociado; ?>");
            $("#input_tipo_identificacion").val("<?php echo $asociado->id_TipodeIdentificacion; ?>");
            $("#input_lugar_expedicion").val("<?php echo $asociado->LugardeExpedicion; ?>");
            $("#input_identificacion_cliente").val("<?php echo $asociado->Identificacion; ?>");
            $("#input_designacion_cliente").val("<?php echo $asociado->id_Designacion; ?>");
            $("#input_nombre_cliente").val("<?php echo $asociado->Nombre; ?>");
            $("#input_apellido1").val("<?php echo $asociado->PrimerApellido; ?>");
            $("#input_apellido2").val("<?php echo $asociado->SegundoApellido; ?>");
            
            // Fecha de nacimiento
            $('#dia_nacimiento_cliente > option[value="<?php echo substr($asociado->FechaNacimiento, 8, 2); ?>"]').attr('selected', 'selected');
            $('#mes_nacimiento_cliente > option[value="<?php echo substr($asociado->FechaNacimiento, 5, 2); ?>"]').attr('selected', 'selected');
            $('#anio_nacimiento_cliente > option[value="<?php echo substr($asociado->FechaNacimiento, 0, 4); ?>"]').attr('selected', 'selected');
            
            $("#input_lugar_nacimiento").val("<?php echo $asociado->Lugardenacimiento; ?>");
            $('#input_genero_cliente > option[value="<?php echo $asociado->id_Genero_cliente; ?>"]').attr('selected', 'selected');
            $('#input_cabeza_familia_cliente > option[value="<?php echo $asociado->id_CabezadeFamilia; ?>"]').attr('selected', 'selected');
            $('#input_origen_cliente > option[value="<?php echo $asociado->id_Origendelcliente; ?>"]').attr('selected', 'selected');
            $('#input_tipo > option[value="<?php echo $asociado->id_Tipo; ?>"]').attr('selected', 'selected');
            $("#input_email_cliente").val("<?php echo $asociado->CorreoElectronico; ?>");
            
            // Fecha de ingreso a la cooperativa 
            $('#dia_ingreso_cliente > option[value="<?php echo substr($asociado->FechadeIngresoalaCooperativa, 8, 2); ?>"]').attr('selected', 'selected');
            $('#mes_ingreso_cliente > option[value="<?php echo substr($asociado->FechadeIngresoalaCooperativa, 5, 2); ?>"]').attr('selected', 'selected');
            $('#anio_ingreso_cliente > option[value="<?php echo substr($asociado->FechadeIngresoalaCooperativa, 0, 4); ?>"]').attr('selected', 'selected');
            
            $("#input_numero_carne").val("<?php echo $asociado->NumerodeCarne; ?>");
            $('#input_estado_actual_entidad > option[value="<?php echo $asociado->id_EstadoactualEntidad; ?>"]').attr('selected', 'selected');
            if ($("#input_estado_actual_entidad").val() != "1") {mostrar_elemento($("#cont_estado"));}; 
            
            // Fecha de retiro 
            $('#dia_retiro_cliente > option[value="<?php echo substr($asociado->FechadeRetiro, 8, 2); ?>"]').attr('selected', 'selected');
            $('#mes_retiro_cliente > option[value="<?php echo substr($asociado->FechadeRetiro, 5, 2); ?>"]').attr('selected', 'selected');
            $('#anio_retiro_cliente > option[value="<?php echo substr($asociado->FechadeRetiro, 0, 4); ?>"]').attr('selected', 'selected');
            
            $('#input_motivo_retiro > option[value="<?php echo $asociado->id_MotivoRetiro; ?>"]').attr('selected', 'selected');
            $('#input_estado_empleado > option[value="<?php echo $asociado->Estado_Empleado; ?>"]').attr('selected', 'selected');
            if ($("#input_estado_empleado").val() == "1") {mostrar_elemento($("#cont_empleado"));}; 
            
            // Fecha de inicio en la cooperativa 
            $('#dia_inicio_cliente > option[value="<?php echo substr($asociado->Fecha_Inicio_Empleado, 8, 2); ?>"]').attr('selected', 'selected');
            $('#mes_inicio_cliente > option[value="<?php echo substr($asociado->Fecha_Inicio_Empleado, 5, 2); ?>"]').attr('selected', 'selected');
            $('#anio_inicio_cliente > option[value="<?php echo substr($asociado->Fecha_Inicio_Empleado, 0, 4); ?>"]').attr('selected', 'selected');
            
            $('#input_tipo_empleado > option[value="<?php echo $asociado->id_tipoempleado; ?>"]').attr('selected', 'selected');
            $('#input_ubicacion_empleado > option[value="<?php echo $asociado->id_ubicacionempleado; ?>"]').attr('selected', 'selected');
            
            // Delegado
            $('#input_estado_delegado > option[value="<?php echo $asociado->EstadocomoDelegado; ?>"]').attr('selected', 'selected');
            if ($("#input_estado_delegado").val() == "1") {mostrar_elemento($("#cont_delegado"));}; 
            
            // Fecha de inicio delegado 
            $('#dia_inicio_delegado > option[value="<?php echo substr($asociado->Fecha_Inicio_Delegado, 8, 2); ?>"]').attr('selected', 'selected');
            $('#mes_inicio_delegado > option[value="<?php echo substr($asociado->Fecha_Inicio_Delegado, 5, 2); ?>"]').attr('selected', 'selected');
            $('#anio_inicio_delegado > option[value="<?php echo substr($asociado->Fecha_Inicio_Delegado, 0, 4); ?>"]').attr('selected', 'selected');
            
            // Fecha final delegado 
            $('#dia_fin_delegado > option[value="<?php echo substr($asociado->Fecha_Fin_Delegado, 8, 2); ?>"]').attr('selected', 'selected');
            $('#mes_fin_delegado > option[value="<?php echo substr($asociado->Fecha_Fin_Delegado, 5, 2); ?>"]').attr('selected', 'selected');
            $('#anio_fin_delegado > option[value="<?php echo substr($asociado->Fecha_Fin_Delegado, 0, 4); ?>"]').attr('selected', 'selected');
            
            // Consejero
            $('#input_estado_consejero > option[value="<?php echo $asociado->EstadocomoConsejero; ?>"]').attr('selected', 'selected');
            if ($("#input_estado_consejero").val() == "1") {mostrar_elemento($("#cont_consejero"));}; 
            
            // Fecha inicio consejero 
            $('#dia_inicio_consejero > option[value="<?php echo substr($asociado->Fecha_Inicio_Consejero, 8, 2); ?>"]').attr('selected', 'selected');
            $('#mes_inicio_consejero > option[value="<?php echo substr($asociado->Fecha_Inicio_Consejero, 5, 2); ?>"]').attr('selected', 'selected');
            $('#anio_inicio_consejero > option[value="<?php echo substr($asociado->Fecha_Inicio_Consejero, 0, 4); ?>"]').attr('selected', 'selected');
            
            // Fecha final consejero 
            $('#dia_fin_consejero > option[value="<?php echo substr($asociado->Fecha_Fin_Consejero, 8, 2); ?>"]').attr('selected', 'selected');
            $('#mes_fin_consejero > option[value="<?php echo substr($asociado->Fecha_Fin_Consejero, 5, 2); ?>"]').attr('selected', 'selected');
            $('#anio_fin_consejero > option[value="<?php echo substr($asociado->Fecha_Fin_Consejero, 0, 4); ?>"]').attr('selected', 'selected');

            // Junta de vigilancia
            $('#input_estado_junta > option[value="<?php echo $asociado->EstadocomoJuntadeVigilancia; ?>"]').attr('selected', 'selected');
            if ($("#input_estado_junta").val() == "1") {mostrar_elemento($("#cont_junta"));}; 
            
            // Fecha  junta de vigilancia 
            $('#dia_inicio_junta > option[value="<?php echo substr($asociado->Fecha_Inicio_Junta, 8, 2); ?>"]').attr('selected', 'selected');
            $('#mes_inicio_junta > option[value="<?php echo substr($asociado->Fecha_Inicio_Junta, 5, 2); ?>"]').attr('selected', 'selected');
            $('#anio_inicio_junta > option[value="<?php echo substr($asociado->Fecha_Inicio_Junta, 0, 4); ?>"]').attr('selected', 'selected');
            
            // Fecha  junta de vigilancia 
            $('#dia_fin_junta > option[value="<?php echo substr($asociado->Fecha_Fin_Junta, 8, 2); ?>"]').attr('selected', 'selected');
            $('#mes_fin_junta > option[value="<?php echo substr($asociado->Fecha_Fin_Junta, 5, 2); ?>"]').attr('selected', 'selected');
            $('#anio_fin_junta > option[value="<?php echo substr($asociado->Fecha_Fin_Junta, 0, 4); ?>"]').attr('selected', 'selected');

            // Tribunal de apelación
            $('#input_estado_directivo > option[value="<?php echo $asociado->EstadoDirectivo; ?>"]').attr('selected', 'selected');

            // Comités
            $('#input_estado_comites > option[value="<?php echo $asociado->EstadoenComites; ?>"]').attr('selected', 'selected');
            if ($("#input_estado_comites").val() == "1") {mostrar_elemento($("#cont_comites"));}; 
            
            // Fecha de inicio comités 
            $('#dia_inicio_comites > option[value="<?php echo substr($asociado->Fecha_Inicio_Comites, 8, 2); ?>"]').attr('selected', 'selected');
            $('#mes_inicio_comites > option[value="<?php echo substr($asociado->Fecha_Inicio_Comites, 5, 2); ?>"]').attr('selected', 'selected');
            $('#anio_inicio_comites > option[value="<?php echo substr($asociado->Fecha_Inicio_Comites, 0, 4); ?>"]').attr('selected', 'selected');
            
            // Fecha final comités 
            $('#dia_fin_comites > option[value="<?php echo substr($asociado->Fecha_Fin_Comites, 8, 2); ?>"]').attr('selected', 'selected');
            $('#mes_fin_comites > option[value="<?php echo substr($asociado->Fecha_Fin_Comites, 5, 2); ?>"]').attr('selected', 'selected');
            $('#anio_fin_comites > option[value="<?php echo substr($asociado->Fecha_Fin_Comites, 0, 4); ?>"]').attr('selected', 'selected');

            $('#input_habil > option[value="<?php echo $asociado->Habil; ?>"]').attr('selected', 'selected');
            $('#input_rango_ingreso > option[value="<?php echo $asociado->id_RangodeIngresomensual; ?>"]').attr('selected', 'selected');
            $('#input_grupo_familiar > option[value="<?php echo $asociado->id_GrupoFamiliar; ?>"]').attr('selected', 'selected');
            $('#input_recibir_emails > option[value="<?php echo $asociado->Recibiremail; ?>"]').attr('selected', 'selected');
            $('#input_recibir_medios > option[value="<?php echo $asociado->Recibir_medios_internos; ?>"]').attr('selected', 'selected');
            $('#input_estado_civil > option[value="<?php echo $asociado->id_EstadoCivil; ?>"]').attr('selected', 'selected');
            $('#input_empresa_cliente > option[value="<?php echo $asociado->id_Empresa; ?>"]').attr('selected', 'selected');
            $('#input_oficina_cliente > option[value="<?php echo $asociado->id_Oficina; ?>"]').attr('selected', 'selected');
            $('#input_escolaridad_cliente > option[value="<?php echo $asociado->id_Escolaridad; ?>"]').attr('selected', 'selected');
            $('#input_industria_cliente > option[value="<?php echo $asociado->id_Industria; ?>"]').attr('selected', 'selected');
            $('#input_profesion_cliente > option[value="<?php echo $asociado->id_Profesion; ?>"]').attr('selected', 'selected');
            $('#input_conocimiento_cooperativismo > option[value="<?php echo $asociado->id_Conocimiento_Cooperativismo; ?>"]').attr('selected', 'selected');
            
            $("#input_centro_costos_cliente").val("<?php echo $asociado->CentrodeCostos; ?>");
            $("#input_aporte_social_cliente").val("<?php echo $asociado->AporteSocial; ?>");
            $("#input_cuota_admision_cliente").val("<?php echo $asociado->CuotadeAdmision; ?>");
            $("#input_ingreso_real").val("<?php echo $asociado->Ingresoreal; ?>");
            $("#input_total_ultimo_trimestre").val("<?php echo $asociado->TotalUltimoTrim; ?>");
            $("#input_total_ano_actual").val("<?php echo $asociado->TotalAnoActual; ?>");
        }); //document.ready
    </script>
<?php } ?>