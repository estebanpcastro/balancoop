<!-- Se listan los años -->
<?php $anios = $this->balance_model->listar_anios(); ?>

<h3>Creación de balance nuevo</h3>

<!-- Contenedor principal -->
<div class="well container">
    <!-- Contenedor tipo -->
    <div id="cont_tipo">
        <!-- Opción 1 -->
        <div class="col-lg-4">
            <div class="radio">
                <label>
                    <input type="radio" name="tipo" id="optionsRadios1" value="1" checked>
                    Crear el balance a partir del balance modelo
                </label>
            </div>
        </div><!-- Opción 1 -->
        
        <!-- Opción 2 -->
        <div class="col-lg-4">
            <div class="radio">
                <label>
                    <input type="radio" name="tipo" id="optionsRadios2" value="2">
                    Crear a partir de un balance existente
                </label>
            </div>
        </div><!-- Opción 2 -->
        
        <!-- Opción 3 -->
        <div class="col-lg-4">
            <div class="radio">
                <label>
                    <input type="radio" name="tipo" id="optionsRadios2" value="3">
                    Crear un balance nuevo
                </label>
            </div>
        </div><!-- Opción 3 -->
    </div><!-- Contenedor tipo -->

    <!-- Contenedor balance nuevo -->
    <div id="cont_balance_nuevo">
        <div class="form-group">
            <label for="input_anio_nuevo" class="col-sm-2 control-label">Año</label>
            <div class="col-sm-4">
                <input id="input_anio_nuevo" class="form-control input-sm" type="text" autofocus>
            </div>
        </div>

        <div class="form-group">
            <label for="select_oficina_nuevo" class="col-sm-2 control-label">Oficina</label>
            <div class="col-sm-4">
                <select id="select_oficina_nuevo" class="form-control input-sm">
                    <option value="">Seleccione...</option>
                </select>
            </div>
        </div>
    </div><!-- Contenedor balance nuevo -->

    <br>
    <legend></legend>

    <!-- Contenedor balance existente -->
    <div id="cont_balance_existente" class="oculto">
        <div class="form-group">
            <label for="select_anio_existente" class="col-sm-2 control-label">Año del balance a copiar</label>
            <div class="col-sm-4">
                <select id="select_anio_existente" class="form-control input-sm">
                <?php foreach ($anios as $anio) { ?>
                    <option value="<?php echo $anio->ano; ?>"><?php echo $anio->ano; ?></option>
                <?php } ?>
            </select>
            </div>
        </div>

        <div class="form-group">
            <label for="select_oficina_existente" class="col-sm-2 control-label">Oficina del balance a copiar</label>
            <div class="col-sm-4">
                <select id="select_oficina_existente" class="form-control input-sm">
                    <option value="">Seleccione...</option>
                </select>
            </div>
        </div>
    </div><!-- Contenedor balance existente -->

    <div class="clear"></div>

    <button id="btn_atras" type="button" class="btn btn-default">Volver</button>
    <button id="btn_guardar" type="button" class="btn btn-success">Guardar</button>
</div><!-- Contenedor principal -->

<script type="text/javascript">
	$(document).ready(function(){
    	//Declaración de variables
        var anio = $("#input_anio_nuevo").numericInput();
    	var oficina = $("#select_oficina_nuevo");

    	/*
         * Por ajax se consultan las oficinas
         */
        oficinas = ajax("<?php echo site_url('inicio/cargar_oficinas'); ?>", {'id_empresa': "<?php echo $this->session->userdata('id_empresa'); ?>"}, "JSON");
        
        // Si trae oficinas
        if (oficinas.length > 0) {
        } else {
            //Se resetea el select y se agrega una option de no encontrado
            $("#select_oficina_nuevo, #select_oficina_existente").html('').append("<option value=''>Ninguna oficina encontrada...</option>");
        } //if

        //Se recorren las oficinas
        $.each(oficinas, function(key, val){
            //Se agrega cada oficina al select
            $("#select_oficina_nuevo, #select_oficina_existente").append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
        })//Fin each

        $('input[name=tipo]').on("change", function(){
            //Si es 2
            if($(this).val() == '2'){
                //Se muestra el contenedor de balance existente
                $("#cont_balance_existente").show();
            }else{
                //Se oculta el input de años
                $("#cont_balance_existente").hide();
            }
        });

        /**
         * Al dar clic en atrás
         */
        $("#btn_atras").on("click", function(){
        	// Se redirecciona al módulo de balance
			redireccionar("<?php echo site_url('balance'); ?>");
		});// clic 

        /**
         * Guardar balance
         */
        $("#btn_guardar").on("click", function(){
        	//Campos obligatorios
        	var datos_obligatorios = new Array(
        		anio.val(),
        		oficina.val()
    		);

        	//Se ejecuta la validación
            validacion = validar_campos_vacios(datos_obligatorios);

            // Si no se supera la validación
            if (!validacion) {
            	//Se muestra el mensaje de error
                mostrar_mensaje('Aun no se ha guardado el balance', 'Por favor digite el año y seleccione una oficina.');

                // Se detiene el formulario
                return false;
            }else{
            	//Tomamos el valor del tipo de balance
        		tipo = $('input[name=tipo]:checked').attr('value');
                
                // Se almacenan los datos en un arreglo
                datos = {
                    'ano': anio.val(),
                    'id_empresa': "<?php echo $this->session->userdata('id_empresa'); ?>",
                    'id_agencia': oficina.val()
                }//datos
                // imprimir(datos);
                
                //Se valida que no exista el balance para ese año en esa oficina
                balance_existe = ajax("<?php echo site_url('balance/validar'); ?>", {"datos": datos}, "html");

                //Si existe el balance
                if(balance_existe != 'false'){
                    //Se muestra el mensaje de error
                    mostrar_mensaje('Aun no se ha guardado el balance', 'Ya existe un balance para el año ' + anio.val() + ' y la oficina ' + $('#select_oficina_nuevo option:selected').text() + '.');

                    // Se detiene el formulario
                    return false;
                }else{
                    /**
                     * Dependiendo del caso, se copiará un id de balance
                     */
                    if (tipo == '1') {
                        //El balance a copiar será el balance 1
                        id_balance_copia = '1';

                        //Ejecutamos el ajax que consulta y crea el nuevo balance, obteniendo el id.
                        balance = ajax("<?php echo site_url('balance/crear_balance'); ?>", {tipo: 'balance', datos: datos}, "JSON");

                        //Declaración de variable
                        id_balance = balance.id_balance;
                    }else if(tipo == '2'){
                        //Se declaran las variables
                        var anio_existente = $("#select_anio_existente");
                        var oficina_existente = $("#select_oficina_existente");

                        //Campos obligatorios
                        var datos_obligatorios = new Array(
                            anio_existente.val(),
                            oficina_existente.val()
                        );

                        //Se ejecuta la validación
                        validacion = validar_campos_vacios(datos_obligatorios);

                        // Si no se supera la validación
                        if (!validacion) {
                            //Se muestra el mensaje de error
                            mostrar_mensaje('Aun no se ha guardado el balance', 'Por favor digite el año y seleccione una oficina  del balance existente.');

                            // Se detiene el formulario
                            return false;
                        }else{
                            // Se almacenan los datos en un arreglo
                            datos_existente = {
                                'ano': anio_existente.val(),
                                'id_empresa': "<?php echo $this->session->userdata('id_empresa'); ?>",
                                'id_agencia': oficina_existente.val()
                            }//datos
                            // imprimir(datos)
                            
                            //Validamos que exista ese balance
                            balance_existe = ajax("<?php echo site_url('balance/validar'); ?>", {"datos": datos_existente}, "html");

                            //Si no existe el balance
                            if(balance_existe == 'false'){
                                //Se muestra el mensaje de error
                                mostrar_mensaje('Aun no se ha guardado el balance', 'El balance que seleccionó a copiar no existe. Seleccione uno que exista');

                                // Se detiene el formulario
                                return false;
                            }else{
                                //El balance a copiar será el balance 1
                                id_balance_copia = balance_existe;

                                //Ejecutamos el ajax que consulta y crea el nuevo balance, obteniendo el id.
                                balance = ajax("<?php echo site_url('balance/crear_balance'); ?>", {tipo: 'balance', datos: datos}, "JSON");

                                //Declaración de variable
                                id_balance = balance.id_balance;

                                // imprimir("Creó el balance "+id_balance+" nuevo a partir del balance " + id_balance_copia)
                            }// if
                        }// if validacion
                    }else if(tipo == '3'){
                        //Ejecutamos el ajax que consulta y crea el nuevo balance, obteniendo el id.
                        balance = ajax("<?php echo site_url('balance/crear_balance'); ?>", {tipo: 'balance', datos: datos}, "JSON");

                        //Declaración de variable
                        id_balance = balance.id_balance;
                    }//if

                    //Las estructuras se crean en los casos 1 y 2
                    if(tipo != '3'){
                        //Para el tipo 1, crearemos el balance modelo
                        estructuras = ajax("<?php echo site_url('balance/crear_estructuras'); ?>", {'id_balance_copia': id_balance_copia, 'id_balance_nuevo': id_balance}, "html");
                    }// if

        			//Se muestra el mensaje de éxito
                	mostrar_mensaje('Balance creado', 'Se creó el balance del año ' + anio.val() + ' para la la oficina ' + $('#select_oficina_nuevo option:selected').text() + '.');

                    //Arreglo con los campos a resetear
                    datos = {
                        'e_r': '0',
                        'f_r': '0',
                        'mr_r': '0',
                        'a_r': '0',
                        'm_r': '0',
                        'j_r': '0',
                        'jl_r': '0',
                        'ag_r': '0',
                        's_r': '0',
                        'o_r': '0',
                        'n_r': '0',
                        'd_r': '0',
                        'id_variable_comparacion': '0'
                    }//datos
                    imprimir(datos)

                    //Por último, resetearemos los valores de los valores reales para que queden en cero
                    borrar_valores_reales = ajax("<?php echo site_url('balance/borrar_valores_reales'); ?>", {'id_balance': id_balance, 'datos': datos}, "html");
        		}// if
            } // if validacion
        });// clic 
    });
</script>