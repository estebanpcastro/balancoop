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
        <a style="color:#FFFFFF" href="javascript:expandir_contraer('datos_residencia')">
            <h3 class="panel-title"><span class="glyphicon glyphicon-home"></span> Datos de residencia</h3>
        </a><!-- Expandir - Contraer -->    
    </div>    
    <div class="panel-body" id="datos_residencia" >  
    <div class="oculto">              
        <!-- Dirección cliente -->
        <div class="form-group">
            <label for="input_direccion_cliente" class="col-sm-5 control-label">Dirección</label>
            <div class="col-sm-7">
                <input id="input_direccion_cliente" class="form-control input-sm" type="text">
            </div>
        </div><!-- Dirección cliente -->

        <!-- País cliente -->
        <div class="form-group">
            <label for="input_pais_cliente" class="col-sm-5 control-label">País</label>
            <div class="col-sm-7">
                <select id="input_pais_cliente" class="form-control input-sm">
                    <option value="">Seleccione...</option>
                        <?php foreach ($paises as $pais) { ?>
                        <option value="<?php echo $pais->strCodigo; ?>"><?php echo $pais->strNombre; ?></option>
                        <?php } ?>
                </select>
            </div>
        </div><!-- País cliente -->

        <!-- Departamento cliente -->
        <div class="form-group">
            <label for="input_departamento_cliente" class="col-sm-5 control-label">Departamento</label>
            <div class="col-sm-7">
                <select id="input_departamento_cliente" class="form-control input-sm" >
                    <option value="">Seleccione primero un país</option>
                </select>
            </div>
        </div><!-- Departamento cliente -->

        <!-- Ciudad cliente -->
        <div class="form-group">
            <label for="input_ciudad_cliente" class="col-sm-5 control-label">Ciudad</label>
            <div class="col-sm-7">
                <select id="input_ciudad_cliente" class="form-control input-sm" >
                    <option value="">Seleccione primero un departamento</option>
                </select>
            </div>
        </div><!-- Ciudad cliente -->

        <!-- Barrio cliente -->
        <div class="form-group">
            <label for="input_barrio_cliente" class="col-sm-5 control-label">Barrio</label>
            <div class="col-sm-7">
                <select id="input_barrio_cliente" class="form-control input-sm" >
                    <option value="">Seleccione primero una ciudad</option>
                </select>
            </div>
        </div><!-- Barrio cliente -->

        <!-- Zona cliente -->
        <div class="form-group">
            <label for="input_zona_cliente" class="col-sm-5 control-label">Zona</label>
            <div class="col-sm-7">
                <select id="input_zona_cliente" class="form-control input-sm" >
                    <option value="">Seleccione...</option>
                    <?php foreach ($zonas as $zona) { ?>
                    <option value="<?php echo $zona->intCodigo; ?>"><?php echo $zona->strNombre; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div><!-- Zona cliente -->

        <!-- Estrato cliente -->
        <div class="form-group">
            <label for="input_estrato_cliente" class="col-sm-5 control-label">Estrato</label>
            <div class="col-sm-7">
                <select id="input_estrato_cliente" class="form-control input-sm" >
                    <option value="">Seleccione...</option>
                        <?php foreach ($estratos as $estrato) { ?>
                    <option value="<?php echo $estrato->intCodigo; ?>"><?php echo $estrato->strNombre; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div><!-- Estrato cliente -->

        <!-- Teléfono celular del cliente -->
        <div class="form-group">
            <label for="input_celular_cliente" class="col-sm-5 control-label">Teléfono celular</label>
            <div class="col-sm-7">
                <input id="input_celular_cliente" class="form-control input-sm" type="text">
            </div>
        </div><!-- Teléfono celular del cliente -->

        <!-- Teléfono casa del cliente -->
        <div class="form-group">
            <label for="input_tel_casa_cliente" class="col-sm-5 control-label">Teléfono casa</label>
            <div class="col-sm-7">
                <input id="input_tel_casa_cliente" class="form-control input-sm" type="text">
            </div>
        </div><!-- Teléfono casa del cliente -->

        <!-- Teléfono oficina del cliente -->
        <div class="form-group">
            <label for="input_tel_oficina_cliente" class="col-sm-5 control-label">Teléfono oficina</label>
            <div class="col-sm-7">
                <input id="input_tel_oficina_cliente" class="form-control input-sm" type="text">
            </div>
        </div><!-- Teléfono oficina del cliente -->

        <!-- Otro teléfono del cliente -->
        <div class="form-group">
            <label for="input_otro_telefono_cliente" class="col-sm-5 control-label">Otro teléfono</label>
            <div class="col-sm-7">
                <input id="input_otro_telefono_cliente" class="form-control input-sm" type="text">
            </div>
        </div><!-- Otro teléfono del cliente -->        
    </div>
    </div>
</div><!-- Panel datos de residencia -->

<?php if ($id_asociado) { ?>
    <script type="text/javascript">
        $(document).ready(function(){ 
            imprimir("<?php echo $asociado->Pais_Cliente; ?>")
            /**
             * Campos que cargan información del cliente seleccionado, en caso de que lo haya
             */
            $("#input_direccion_cliente").val("<?php echo $asociado->Direccion; ?>");
            $('#input_pais_cliente > option[value="<?php echo $asociado->Pais_Cliente; ?>"]').attr('selected', 'selected');
            $('#input_zona_cliente > option[value="<?php echo $asociado->id_Zona; ?>"]').attr('selected', 'selected');
            $('#input_estrato_cliente > option[value="<?php echo $asociado->id_Estrato; ?>"]').attr('selected', 'selected');
            $("#input_celular_cliente").val("<?php echo $asociado->Celular_cliente; ?>");
            $("#input_tel_casa_cliente").val("<?php echo $asociado->TelefonoCasa; ?>");
            $("#input_tel_oficina_cliente").val("<?php echo $asociado->TelefonoOficina; ?>");
            $("#input_otro_telefono_cliente").val("<?php echo $asociado->OtroTelefono; ?>");
        }); //document.ready
    </script>
<?php } ?>