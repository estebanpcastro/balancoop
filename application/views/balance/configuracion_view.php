<?php
//Se obtienen los datos que vienen por post
$id_variable = $this->input->post('id_variable');
$anio = $this->input->post('anio');
$anio_anterior = $this->input->post('anio')-1;

//Se consultan las variables
$variables = $this->balance_model->cargar_balances($anio_anterior);

// Se consulta la estructura
$variable = $this->balance_model->cargar_variable($id_variable);

// Si es responsable
if ($this->session->userdata('tipo') == '2') {
	//Activaremos los input para el valor real
	$estado_input_r = '';

	//Desactivaremos los input para el presupuestado
	$estado_input_p = 'disabled';
}else{
	//Desactivaremos los input para el presupuesto real
	$estado_input_r = 'disabled';

	//Activaremos los input para el presupuestado
	$estado_input_p = '';
}
?>

<!-- Si no es administrador, no puede modificar los valores iniciales -->
<?php if($this->session->userdata('tipo') != '2'){ ?>
	<!-- Contenedor de datos de comparación -->
	<div class="container">
		<div class="col-lg-2">
			<label for="select_modo_ingreso<?php echo $id_variable; ?>">Modo de ingreso</label>
			<select id="select_modo_ingreso<?php echo $id_variable; ?>" class="form-control input-sm" autofocus>
				<option value="">Seleccione...</option>
				<option value="1">Manual</option>
				<option value="2">Filtros</option>
		    </select>
		</div>

		<div class="col-lg-2">
			<label for="select_fuente<?php echo $id_variable; ?>">Fuente</label>
			<select id="select_fuente<?php echo $id_variable; ?>" class="form-control input-sm">
				<option value="">Seleccione primero el modo de ingreso...</option>
		    </select>
		</div>

		<!--
        <div class="col-lg-2">
			<label for="select_balance<?php // echo $id_variable; ?>">Balance comparación</label>
			<select id="select_balance<?php // echo $id_variable; ?>" class="form-control input-sm">
				<option value="">Seleccione...</option>
		    </select>
		</div>

		<div class="col-lg-2">
			<label for="select_categoria<?php // echo $id_variable; ?>">Categoría comparación</label>
			<select id="select_categoria<?php // echo $id_variable; ?>" class="form-control input-sm">
                <option value="">Elija primero un balance...</option>
            </select>
		</div>

		<div class="col-lg-2">
			<label for="select_dimension<?php // echo $id_variable; ?>">Dim. comparación</label>
			<select id="select_dimension<?php // echo $id_variable; ?>" class="form-control input-sm">
				<option value="">Elija primero una categoría...</option>
		    </select>
		</div>

		<div class="col-lg-2">
			<label for="select_variable<?php // echo $id_variable; ?>">Variable comparación</label>
			<select id="select_variable<?php // echo $id_variable; ?>" class="form-control input-sm">
				<option value="">Elija primero una dimensión...</option>
		    </select>
		</div>
        -->
	</div><!-- Contenedor de datos de comparación -->
<?php } ?>

<!-- Contenedor de valor presupuestado -->
<div class="container">
    <!-- Presupuesto -->
    <div class="col-lg-12"><legend>Presupuestado</legend></div><!-- Presupuesto -->

    <!-- Enero -->
    <div class="col-lg-1">
        <label for="input_enero<?php echo $id_variable; ?>">Enero</label>
        <input id="input_enero<?php echo $id_variable; ?>" type="text" class="form-control input-sm" <?php echo $estado_input_p;?> >
    </div><!-- Enero -->

    <!-- Febrero -->
    <div class="col-lg-1">
        <label for="input_febrero<?php echo $id_variable; ?>">Febrero</label>
        <input id="input_febrero<?php echo $id_variable; ?>" type="text" class="form-control input-sm" <?php echo $estado_input_p;?> >
    </div><!-- Febrero -->

    <!-- Marzo -->
    <div class="col-lg-1">
        <label for="input_marzo<?php echo $id_variable; ?>">Marzo</label>
        <input id="input_marzo<?php echo $id_variable; ?>" type="text" class="form-control input-sm" <?php echo $estado_input_p;?> >
    </div><!-- Marzo -->

    <!-- Abril -->
    <div class="col-lg-1">
        <label for="input_abril<?php echo $id_variable; ?>">Abril</label>
        <input id="input_abril<?php echo $id_variable; ?>" type="text" class="form-control input-sm" <?php echo $estado_input_p;?> >
    </div><!-- Abril -->

    <!-- Mayo -->
    <div class="col-lg-1">
        <label for="input_mayo<?php echo $id_variable; ?>">Mayo</label>
        <input id="input_mayo<?php echo $id_variable; ?>" type="text" class="form-control input-sm" <?php echo $estado_input_p;?>  >
    </div><!-- Mayo -->

    <!-- Junio -->
    <div class="col-lg-1">
        <label for="input_junio<?php echo $id_variable; ?>">Junio</label>
        <input id="input_junio<?php echo $id_variable; ?>" type="text" class="form-control input-sm" <?php echo $estado_input_p;?> >
    </div><!-- Junio -->

    <!-- Julio -->
    <div class="col-lg-1">
        <label for="input_julio<?php echo $id_variable; ?>">Julio</label>
        <input id="input_julio<?php echo $id_variable; ?>" type="text" class="form-control input-sm" <?php echo $estado_input_p;?> >
    </div><!-- Julio -->

    <!-- Agosto -->
    <div class="col-lg-1">
        <label for="input_agosto<?php echo $id_variable; ?>">Agosto</label>
        <input id="input_agosto<?php echo $id_variable; ?>" type="text" class="form-control input-sm" <?php echo $estado_input_p;?> >
    </div><!-- Agosto -->

    <!-- Septiembre -->
    <div class="col-lg-1">
        <label for="input_septiembre<?php echo $id_variable; ?>">Septiembre</label>
        <input id="input_septiembre<?php echo $id_variable; ?>" type="text" class="form-control input-sm" <?php echo $estado_input_p;?> >
    </div><!-- Septiembre -->

    <!-- Octubre -->
    <div class="col-lg-1">
        <label for="input_octubre<?php echo $id_variable; ?>">Octubre</label>
        <input id="input_octubre<?php echo $id_variable; ?>" type="text" class="form-control input-sm" <?php echo $estado_input_p;?> >
    </div><!-- Octubre -->

    <!-- Noviembre -->
    <div class="col-lg-1">
        <label for="input_noviembre<?php echo $id_variable; ?>">Noviembre</label>
        <input id="input_noviembre<?php echo $id_variable; ?>" type="text" class="form-control input-sm" <?php echo $estado_input_p;?> >
    </div><!-- Noviembre -->

    <!-- Diciembre -->
    <div class="col-lg-1">
        <label for="input_diciembre<?php echo $id_variable; ?>">Diciembre</label>
        <input id="input_diciembre<?php echo $id_variable; ?>" type="text" class="form-control input-sm" <?php echo $estado_input_p;?> >
    </div><!-- Diciembre -->
</div><!-- Contenedor de valor presupuestado -->

<!-- Contenedor de valor real -->
<div class="container">
    <!-- Presupuesto -->
    <div class="col-lg-12"><legend>Real</legend></div><!-- Presupuesto -->

    <!-- Enero -->
    <div class="col-lg-1">
        <label for="input_enero_real<?php echo $id_variable; ?>">Enero</label>
        <input id="input_enero_real<?php echo $id_variable; ?>" type="text" class="form-control input-sm" <?php echo $estado_input_r; ?> >
    </div><!-- Enero -->

    <!-- Febrero -->
    <div class="col-lg-1">
        <label for="input_febrero_real<?php echo $id_variable; ?>">Febrero</label>
        <input id="input_febrero_real<?php echo $id_variable; ?>" type="text" class="form-control input-sm" <?php echo $estado_input_r;?> >
    </div><!-- Febrero -->

    <!-- Marzo -->
    <div class="col-lg-1">
        <label for="input_marzo_real<?php echo $id_variable; ?>">Marzo</label>
        <input id="input_marzo_real<?php echo $id_variable; ?>" type="text" class="form-control input-sm"  <?php echo $estado_input_r;?>>
    </div><!-- Marzo -->

    <!-- Abril -->
    <div class="col-lg-1">
        <label for="input_abril_real<?php echo $id_variable; ?>">Abril</label>
        <input id="input_abril_real<?php echo $id_variable; ?>" type="text" class="form-control input-sm"  <?php echo $estado_input_r;?> >
    </div><!-- Abril -->

    <!-- Mayo -->
    <div class="col-lg-1">
        <label for="input_mayo_real<?php echo $id_variable; ?>">Mayo</label>
        <input id="input_mayo_real<?php echo $id_variable; ?>" type="text" class="form-control input-sm" <?php echo $estado_input_r;?> >
    </div><!-- Mayo -->

    <!-- Junio -->
    <div class="col-lg-1">
        <label for="input_junio_real<?php echo $id_variable; ?>">Junio</label>
        <input id="input_junio_real<?php echo $id_variable; ?>" type="text" class="form-control input-sm" <?php echo $estado_input_r;?> >
    </div><!-- Junio -->

    <!-- Julio -->
    <div class="col-lg-1">
        <label for="input_julio_real<?php echo $id_variable; ?>">Julio</label>
        <input id="input_julio_real<?php echo $id_variable; ?>" type="text" class="form-control input-sm" <?php echo $estado_input_r;?> >
    </div><!-- Julio -->

    <!-- Agosto -->
    <div class="col-lg-1">
        <label for="input_agosto_real<?php echo $id_variable; ?>">Agosto</label>
        <input id="input_agosto_real<?php echo $id_variable; ?>" type="text" class="form-control input-sm" <?php echo $estado_input_r;?> >
    </div><!-- Agosto -->

    <!-- Septiembre -->
    <div class="col-lg-1">
        <label for="input_septiembre_real<?php echo $id_variable; ?>">Septiembre</label>
        <input id="input_septiembre_real<?php echo $id_variable; ?>" type="text" class="form-control input-sm" <?php echo $estado_input_r;?> >
    </div><!-- Septiembre -->

    <!-- Octubre -->
    <div class="col-lg-1">
        <label for="input_octubre_real<?php echo $id_variable; ?>">Octubre</label>
        <input id="input_octubre_real<?php echo $id_variable; ?>" type="text" class="form-control input-sm" <?php echo $estado_input_r;?> >
    </div><!-- Octubre -->

    <!-- Noviembre -->
    <div class="col-lg-1">
        <label for="input_noviembre_real<?php echo $id_variable; ?>">Noviembre</label>
        <input id="input_noviembre_real<?php echo $id_variable; ?>" type="text" class="form-control input-sm" <?php echo $estado_input_r;?> >
    </div><!-- Noviembre -->

    <!-- Diciembre -->
    <div class="col-lg-1">
        <label for="input_diciembre_real<?php echo $id_variable; ?>">Diciembre</label>
        <input id="input_diciembre_real<?php echo $id_variable; ?>" type="text" class="form-control input-sm" <?php echo $estado_input_r;?> >
    </div><!-- Diciembre -->
</div><!-- Contenedor de valor real -->

<div class="container">
    <p></p>
    <button id="btn_guardar_variable<?php echo $id_variable; ?>" type="button" class="btn btn-info btn-block btn-xs">Guardar cambios</button>
    <p></p>
</div>

<?php // if($id_variable > 0){ ?>
    <script type="text/javascript">
        // Cuando el documento esté listo
        $(document).ready(function(){
            var id_variable = "<?php echo $id_variable; ?>";
            var id_variable_comparacion = "<?php echo $variable->id_variable_comparacion; ?>";

            /**
             * Si existen balances en otras oficinas, los cargaremos de entrada
             */
            //Cargaremos las categorías
            balances = ajax("<?php echo site_url('balance/cargar_balances_comparacion'); ?>", {'anio': "<?php echo $anio; ?>"}, "JSON");

            //Si se encontraron balances
            if (balances.length != 0) {
                //Se resetea el select
                $("#select_balance"+id_variable).html('').append("<option value=''>Elija un balance...</option>");
                
                //Se recorren las categorías
                $.each(balances, function(key, val){
                    //Se agrega cada categoría al select
                    $("#select_balance"+id_variable).append("<option id='" + val.id_oficina + "' value='" + val.ano + "'>" + val.ano + " - " + val.strNombre + "</option>");

                });//Fin each
            }else{
                //Option de no encontrados
                $("#select_balance"+id_variable).html('').append("<option value=''>No hay balances del año anterior...</option>");
            }

            /**
             * Campos que cargan información de la variable
             */
            $('#select_modo_ingreso' + id_variable + ' > option[value="<?php echo $variable->modo_ingreso; ?>"]').attr('selected', 'selected');

            // Si ya existe variable de comparación
            if(id_variable_comparacion > 0){
                // Obtenemos el id de la dimensión de esa variable
                id_dimension = ajax("<?php echo site_url('balance/consultar'); ?>", {"id_estructura": id_variable_comparacion}, "html");

                // Obtenemos el id de la categoría de esa dimensión
                id_categoria = ajax("<?php echo site_url('balance/consultar'); ?>", {"id_estructura": id_dimension}, "html");

                // Se consulta los datos del balance al que pertenece la categoría
                datos_balance = ajax("<?php echo site_url('balance/consultar_balance'); ?>", {'id_estructura': id_categoria}, "JSON");

                /**
                 * Cargaremos las categorías
                 */
                categorias = ajax("<?php echo site_url('balance/cargar'); ?>", {'tipo': 'C', 'anio': datos_balance.ano, 'id_variable': null, 'id_oficina': datos_balance.id_agencia}, "JSON");

                //Se resetea el select
                $("#select_categoria" + id_variable).html('').append("<option value=''>Elija una categoría...</option>");

                //Se recorren las categorías
                $.each(categorias, function(key, val){
                    //Se agrega cada categoría al select
                    $("#select_categoria" + id_variable).append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
                });//Fin each

                // Se pone el valor por defecto
                $('#select_categoria' + id_variable + ' > option[value="' + id_categoria + '"]').attr('selected', 'selected');

                /**
                 * Cargaremos las dimensiones
                 */
                dimensiones = ajax("<?php echo site_url('balance/cargar'); ?>", {'tipo': 'D', 'anio': datos_balance.ano, 'id_variable': id_categoria, 'id_oficina': datos_balance.id_agencia}, "JSON");

                //Se resetea el select
                $("#select_dimension" + id_variable).html('').append("<option value=''>Elija una dimensión...</option>");

                //Se recorren las dimensiones
                $.each(dimensiones, function(key, val){
                    //Se agrega cada categoría al select
                    $("#select_dimension" + id_variable).append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
                });//Fin each

                // Se pone el valor por defecto
                $('#select_dimension' + id_variable + ' > option[value="' + id_dimension + '"]').attr('selected', 'selected');

                /**
                 * Cargaremos las variables
                 */
                variables = ajax("<?php echo site_url('balance/cargar'); ?>", {'tipo': 'V', 'anio': datos_balance.ano, 'id_variable': id_dimension, 'id_oficina': datos_balance.id_agencia}, "JSON");

                //Se resetea el select
                $("#select_variable" + id_variable).html('').append("<option value=''>Elija una variable...</option>");

                //Se recorren las variables
                $.each(variables, function(key, val){
                    //Se agrega cada variable al select
                    $("#select_variable" + id_variable).append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
                });//Fin each

                // Se pone el valor por defecto
                $('#select_variable' + id_variable + ' > option[value="' + id_variable_comparacion + '"]').attr('selected', 'selected');

                // Se pone el balance por defecto
                $('#select_balance' + id_variable + ' > option[id="' + datos_balance.id_agencia + '"]').attr('selected', 'selected');
            } // if

            // Presupuestado
            $('#input_enero' + '<?php echo $id_variable; ?>').val("<?php echo $variable->e_p; ?>");
            $('#input_febrero' + '<?php echo $id_variable; ?>').val("<?php echo $variable->f_p; ?>");
            $('#input_marzo' + '<?php echo $id_variable; ?>').val("<?php echo $variable->mr_p; ?>");
            $('#input_abril' + '<?php echo $id_variable; ?>').val("<?php echo $variable->a_p; ?>");
            $('#input_mayo' + '<?php echo $id_variable; ?>').val("<?php echo $variable->m_p; ?>");
            $('#input_junio' + '<?php echo $id_variable; ?>').val("<?php echo $variable->j_p; ?>");
            $('#input_julio' + '<?php echo $id_variable; ?>').val("<?php echo $variable->jl_p; ?>");
            $('#input_agosto' + '<?php echo $id_variable; ?>').val("<?php echo $variable->ag_p; ?>");
            $('#input_septiembre' + '<?php echo $id_variable; ?>').val("<?php echo $variable->s_p; ?>");
            $('#input_octubre' + '<?php echo $id_variable; ?>').val("<?php echo $variable->o_p; ?>");
            $('#input_noviembre' + '<?php echo $id_variable; ?>').val("<?php echo $variable->n_p; ?>");
            $('#input_diciembre' + '<?php echo $id_variable; ?>').val("<?php echo $variable->d_p; ?>");

            // Real
            $('#input_enero_real' + '<?php echo $id_variable; ?>').val("<?php echo $variable->e_r; ?>");
            $('#input_febrero_real' + '<?php echo $id_variable; ?>').val("<?php echo $variable->f_r; ?>");
            $('#input_marzo_real' + '<?php echo $id_variable; ?>').val("<?php echo $variable->mr_r; ?>");
            $('#input_abril_real' + '<?php echo $id_variable; ?>').val("<?php echo $variable->a_r; ?>");
            $('#input_mayo_real' + '<?php echo $id_variable; ?>').val("<?php echo $variable->m_r; ?>");
            $('#input_junio_real' + '<?php echo $id_variable; ?>').val("<?php echo $variable->j_r; ?>");
            $('#input_julio_real' + '<?php echo $id_variable; ?>').val("<?php echo $variable->jl_r; ?>");
            $('#input_agosto_real' + '<?php echo $id_variable; ?>').val("<?php echo $variable->ag_r; ?>");
            $('#input_septiembre_real' + '<?php echo $id_variable; ?>').val("<?php echo $variable->s_r; ?>");
            $('#input_octubre_real' + '<?php echo $id_variable; ?>').val("<?php echo $variable->o_r; ?>");
            $('#input_noviembre_real' + '<?php echo $id_variable; ?>').val("<?php echo $variable->n_r; ?>");
            $('#input_diciembre_real' + '<?php echo $id_variable; ?>').val("<?php echo $variable->d_r; ?>");
        });
    </script>
<?php // } ?>

<script type="text/javascript">
    // Cuando el documento esté listo
    $(document).ready(function(){
    	//Declaración de variables
    	var id_variable = "<?php echo $id_variable; ?>";
    	var balance = $("#select_balance" + id_variable);
    	var categoria = $("#select_categoria" + id_variable);
    	var dimension = $("#select_dimension" + id_variable);
    	var fuente = $("#select_fuente" + id_variable);
    	var modo_ingreso = $("#select_modo_ingreso" + id_variable);
    	var variable = $("#select_variable" + id_variable);

    	//Presupuestado
    	var enero_p = $("#input_enero" + id_variable);
    	var febrero_p = $("#input_febrero" + id_variable);
    	var marzo_p = $("#input_marzo" + id_variable);
    	var abril_p = $("#input_abril" + id_variable);
    	var mayo_p = $("#input_mayo" + id_variable);
    	var junio_p = $("#input_junio" + id_variable);
    	var julio_p = $("#input_julio" + id_variable);
    	var agosto_p = $("#input_agosto" + id_variable);
    	var septiembre_p = $("#input_septiembre" + id_variable);
    	var octubre_p = $("#input_octubre" + id_variable);
    	var noviembre_p = $("#input_noviembre" + id_variable);
    	var diciembre_p = $("#input_diciembre" + id_variable);

    	//Real
    	var enero_r = $("#input_enero_real" + id_variable);
    	var febrero_r = $("#input_febrero_real" + id_variable);
    	var marzo_r = $("#input_marzo_real" + id_variable);
    	var abril_r = $("#input_abril_real" + id_variable);
    	var mayo_r = $("#input_mayo_real" + id_variable);
    	var junio_r = $("#input_junio_real" + id_variable);
    	var julio_r = $("#input_julio_real" + id_variable);
    	var agosto_r = $("#input_agosto_real" + id_variable);
    	var septiembre_r = $("#input_septiembre_real" + id_variable);
    	var octubre_r = $("#input_octubre_real" + id_variable);
    	var noviembre_r = $("#input_noviembre_real" + id_variable);
    	var diciembre_r = $("#input_diciembre_real" + id_variable);

        /**
         * Dependiendo del modo de ingreso que seleccione, cargará los datos
         */
        modo_ingreso.on("change", function(){
            //Si es 1
            if($(this).val() == "1"){
                //Cargaremos los usuarios
                usuarios = ajax("<?php echo site_url('listas/cargar_usuarios_sistema'); ?>", {'': ''}, "JSON");

                //Se resetea el select
                fuente.html('').append("<option value=''>Elija un usuario...</option>");

                //Se recorren los usuarios
                $.each(usuarios, function(key, val){
                    //Se agrega cada usuario al select
                    fuente.append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
                });//Fin each
            }else if($(this).val() == "2"){
                //Cargaremos los filtros
                filtros = ajax("<?php echo site_url('balance/cargar_filtros'); ?>", {dato: 'null'}, "JSON");

                //Se resetea el select
                fuente.html('').append("<option value=''>Elija un filtro...</option>");

                //Se recorren los filtros
                $.each(filtros, function(key, val){
                    //Se agrega cada filtro al select
                    fuente.append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
                });//Fin each
            }// if
        }); // modo ingreso change

        /**
         * Si modo de ingreso ya está seleccionado
         */
        if (modo_ingreso.val() == "1") {
            //Cargaremos los usuarios
            usuarios = ajax("<?php echo site_url('listas/cargar_usuarios_sistema'); ?>", {'': ''}, "JSON");

            //Se resetea el select
            fuente.html('').append("<option value=''>Elija un usuario...</option>");

            //Se recorren los usuarios
            $.each(usuarios, function(key, val){
                //Se agrega cada usuario al select
                fuente.append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
            });//Fin each
        } else if(modo_ingreso.val() == "2"){
            //Cargaremos los filtros
            filtros = ajax("<?php echo site_url('balance/cargar_filtros'); ?>", {dato: 'null'}, "JSON");

            //Se resetea el select
            fuente.html('').append("<option value=''>Elija un filtro...</option>");

            //Se recorren los filtros
            $.each(filtros, function(key, val){
                //Se agrega cada filtro al select
                fuente.append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
            });//Fin each
        } // if

        /**
         * Dependiendo del balance seleccionado, cargará las categorías
         */
        balance.on("change", function(){
            //Si se selecciona un balance
            if($(this).val() != ""){
                //Cargaremos las categorías
                categorias = ajax("<?php echo site_url('balance/cargar'); ?>", {'tipo': 'C', 'anio': $(this).val(), 'id_variable': null, 'id_oficina': $("#select_balance"+id_variable+" option:selected").attr("id")}, "JSON");

                //Se resetea el select
                categoria.html('').append("<option value=''>Elija una categoría...</option>");

                //Se recorren las categorías
                $.each(categorias, function(key, val){
                    //Se agrega cada categoría al select
                    categoria.append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
                });//Fin each
            }else{
                // Se resetean los selects anteriores
                categoria.html('').append("<option value=''>Elija primero una categoría...</option>");
                dimension.html('').append("<option value=''>Elija primero una dimensión...</option>");
                variable.html('').append("<option value=''>Elija primero una variable...</option>");
            } // if
        }); // balance change

        /**
         * Dependiendo de la categoría seleccionada, cargará las dimensiones
         */
        categoria.on("change", function(){
            //Si se selecciona una categoría
            if($(this).val() != ""){
                //Cargaremos las dimensiones
                dimensiones = ajax("<?php echo site_url('balance/cargar'); ?>", {'tipo': 'D', 'anio': $("#select_balance"+ id_variable).val(), 'id_variable': $(this).val()}, "JSON");

                //Se resetea el select
                dimension.html('').append("<option value=''>Elija una dimensión...</option>");

                //Se recorren las dimensiones
                $.each(dimensiones, function(key, val){
                    //Se agrega cada categoría al select
                    dimension.append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
                });//Fin each
            }else{
                // Se resetean los selects anteriores
                dimension.html('').append("<option value=''>Elija primero una dimensión...</option>");
                variable.html('').append("<option value=''>Elija primero una variable...</option>");
            }
        }); // categorías change

        /**
         * Dependiendo de la dimensión seleccionada, cargará las variables
         */
        dimension.on("change", function(){
            //Si se selecciona una dimensión
            if($(this).val() != ""){
                //Cargaremos las variables
                variables = ajax("<?php echo site_url('balance/cargar'); ?>", {'tipo': 'V', 'anio': $("#select_balance" + id_variable).val(), 'id_variable': $(this).val()}, "JSON");

                //Se resetea el select
                variable.html('').append("<option value=''>Elija una variable...</option>");

                //Se recorren las variables
                $.each(variables, function(key, val){
                    //Se agrega cada variable al select
                    variable.append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
                });//Fin each
            }else{
                // Se resetean los selects anteriores
                variable.html('').append("<option value=''>Elija primero una variable...</option>");
            }
        }); // dimensión change

        /**
         * Cuando se guarden los cambios de la variable
         */
        $("#btn_guardar_variable" + id_variable).on("click", function(){
            // Recogemos los datos en un arreglo
            datos = {
                'modo_ingreso': modo_ingreso.val(),
                'fuente': fuente.val(),
                // 'id_balance': balance.val(),
                'id_variable_comparacion': variable.val(),
                'e_p': enero_p.val(),
                'f_p': febrero_p.val(),
                'mr_p': marzo_p.val(),
                'a_p': abril_p.val(),
                'm_p': mayo_p.val(),
                'j_p': junio_p.val(),
                'jl_p': julio_p.val(),
                'ag_p': agosto_p.val(),
                's_p': septiembre_p.val(),
                'o_p': octubre_p.val(),
                'n_p': noviembre_p.val(),
                'd_p': diciembre_p.val(),
                'e_r': enero_r.val(),
                'f_r': febrero_r.val(),
                'mr_r': marzo_r.val(),
                'a_r': abril_r.val(),
                'm_r': mayo_r.val(),
                'j_r': junio_r.val(),
                'jl_r': julio_r.val(),
                'ag_r': agosto_r.val(),
                's_r': septiembre_r.val(),
                'o_r': octubre_r.val(),
                'n_r': noviembre_r.val(),
                'd_r': diciembre_r.val()
            };// datos
            // imprimir(datos);
            
            //Procedemos a actualizar la variable por medio de ajax
            actualizar = ajax("<?php echo site_url('balance/actualizar'); ?>", {"datos": datos, "id_variable": id_variable}, "html");

            //Si se actualizó correctamente
            if(actualizar == 'true'){
                //Se muestra el mensaje de exito
                mostrar_mensaje('Registro exitoso', 'La variable se configuró exitosamente.');
            } // if
        }); // btn_guardar_variable
	}); // document.ready
</script>

<?php // if($id_variable > 0){ ?>
    <script type="text/javascript">
        // Cuando el documento esté listo
        $(document).ready(function(){
            var id_variable = "<?php echo $id_variable; ?>";

            /**
             * Campos que cargan información de la variable
             */
            $('#select_modo_ingreso' + id_variable + ' > option[value="<?php echo $variable->modo_ingreso; ?>"]').attr('selected', 'selected');
            $('#select_fuente' + id_variable + ' > option[value="<?php echo $variable->fuente; ?>"]').attr('selected', 'selected');
        });
    </script>
<?php // } ?>