<!-- Opciones de filtrado -->
<div id="panel_filtros" class="well row">
	<!-- Filtrar por (4) -->
    <div class="col-lg-12">
        <!-- Row -->
        <div class="row">
            <!-- Búsqueda rápida -->
            <div class="form-group col-sm-4">
                <label for="filtro_seleccion_busqueda_rapida" class="control-label">Búsqueda rápida</label>
                <select type="select" id="filtro_seleccion_busqueda_rapida" class="form-control input-sm col-sm" autofocus>
                    <option value="">Seleccione...</option>
                    <?php foreach ($this->crm_model->cargar_filtros_segmentacion('busqueda_rapida') as $busqueda_rapida) { ?>
                        <option value="<?php echo $busqueda_rapida->intCodigo; ?>"><?php echo $busqueda_rapida->strNombre; ?></option>
                    <?php } ?>
                </select>
            </div><!-- Búsqueda rápida -->

            <!-- Filtros del sistema -->
            <div class="form-group col-sm-4">
                <label for="filtro_seleccion_sistema" class="control-label">Del sistema</label>
                <select type="select" id="filtro_seleccion_sistema" class="form-control input-sm col-sm" autofocus>
                    <option value="">Seleccione...</option>
                    <?php foreach ($this->crm_model->cargar_filtros_segmentacion('es_sistema') as $filtro_sistema) { ?>
                        <option value="<?php echo $filtro_sistema->intCodigo; ?>"><?php echo $filtro_sistema->strNombre; ?></option>
                    <?php } ?>
                </select>
            </div><!-- Filtros del sistema -->

            <!-- Filtro del cliente -->
            <div class="form-group col-sm-4">
                <label for="filtro_seleccion_cliente" class="control-label">Del cliente</label>
                <select type="select" id="filtro_seleccion_cliente" class="form-control input-sm col-sm" autofocus>
                    <option value="">Seleccione...</option>
                    <?php foreach ($this->crm_model->cargar_filtros_segmentacion('es_cliente') as $filtro_cliente) { ?>
                        <option value="<?php echo $filtro_cliente->intCodigo; ?>"><?php echo $filtro_cliente->strNombre; ?></option>
                    <?php } ?>
                </select>
            </div><!-- Filtro del cliente -->

            <!-- Ir a filtros -->
            <div class="form-group col-sm-2">
                <!-- <label class="control-label">Gestión de filtros</label>
                               
               Botón agregar condicional
               <button id="btn_filtros" type="button" class="btn btn-info btn-block btn-xs">Ir</button> 
                -->               
            </div><!-- Ir a filtros -->
        </div><!-- Row -->
    </div><!-- Filtrar por (4) -->
</div><!-- Opciones de filtrado -->

<!-- SQLs -->
<div id="cont_sql"></div>

<!-- Tabla -->
<div id="tabla"></div>

<script type="text/javascript">
    //Cuando el DOM esté listo
    $(document).ready(function() {
        // //Verificamos si el usuario tiene filtro port defecto
        // id_filtro_por_defecto = "<?php echo $this->session->userdata('id_filtro_por_defecto'); ?>";

        // /**
        //  * Si trae algun filtro
        //  */
        // if(id_filtro_por_defecto) {
        //     imprimir('El filtro por defecto es ' + id_filtro_por_defecto)

        //     //Cargamos la interfaz
        //     $("#crm_tabla").load("listas/cargar_interfaz", {tipo: 'tabla', id_filtro: id_filtro_por_defecto});
            
        //     //Se muestra la barra de carga
        //     cargando($("#crm_tabla"));
        // }// if

        /**
         * Si el filtro es de selección, deberá cambiar toda la tabla
         */
        $("[id^='filtro_seleccion_']").on("change", function(){
            if ($(this).val() != "") {
                imprimir("Cargando una nueva tabla... Es el filtro " + $(this).val());

                //Cargamos la interfaz
                $("#tabla").load("listas/cargar_interfaz", {tipo: 'tabla', id_filtro: $(this).val()});

                //Se muestra la barra de carga
                cargando($("#tabla"));
            };
        });//change 

        // /**
        //  * Cuando se dé clic en generar filtros aplicados
        //  */
        // $("#btn_generar_filtro").on('click', function(){
        //     //Declaración de variables
        //     if ($("#check_responsable").is(':checked')) {logueado_responsable = " AND asociados.id_Responsable = "+"<?php echo $this->session->userdata('id_usuario'); ?>"}else{logueado_responsable = ''}; //Si es responsable, mandaremos el id del usuario logueado
        //     if ($("#check_asignado").is(':checked')) {asignado = " AND asociados.id_Asignado = "+"<?php echo $this->session->userdata('id_usuario'); ?>"}else{asignado = ''}; //Si es asignado, mandaremos el id del usuario logueado
        //     if ($("#select_campana").val() == "") {campana = ""}else{campana = " AND campana_cliente.strNombre LIKE '%" + $("#select_campana option:selected").text() + "%'"}; //Si selecciona una campaña, mandaremos texto
        //     //if($("#select_oportunidad").val() == ""){oportunidad = "";}else{oportunidad = " AND campana_cliente.strNombre = '" + $("#select_campana option:selected").text() + "'";}; // Para las oportunidades, también usamos texto
        //     if($.trim($("#input_producto").val()) == ""){producto = "";}else{producto = " AND productos.strNombre LIKE '%" + $("#input_producto").val() + "%'";}; // Para los productos, texto con LIKE
        //     if ($("#select_responsable").val() == "") {usuario_responsable = ""}else{usuario_responsable = " AND asociados.id_Responsable = '" + $("#select_responsable").val() + "'"}; //Si selecciona un usuario responsable
        //     if ($("#select_asignado").val() == "") {usuario_asignado = ""}else{usuario_asignado = " AND asociados.id_Asignado = '" + $("#select_asignado").val() + "'"}; //Si selecciona un usuario asignado

        //     //Se recogen los datos en un arreglo
        //     datos_filtro = {
        //         'asignado': asignado,
        //         'campana': campana,
        //         'logueado_responsable': logueado_responsable,
        //         // 'oportunidad': oportunidad,
        //         'producto': producto,
        //         'usuario_asignado': usuario_asignado,
        //         'usuario_responsable': usuario_responsable,
        //     }
        //     // imprimir(datos_filtro)
            
        //     // Imprimimos en pantalla 
        //     $("#cont_sql").html('');
        //     $("#cont_sql").append(datos_filtro.asignado);
        //     $("#cont_sql").append(datos_filtro.campana);
        //     $("#cont_sql").append(datos_filtro.logueado_responsable);
        //     $("#cont_sql").append(datos_filtro.oportunidad);
        //     $("#cont_sql").append(datos_filtro.producto);
        //     $("#cont_sql").append(datos_filtro.usuario_asignado);
        //     $("#cont_sql").append(datos_filtro.usuario_responsable);

            
        // }); // click generar filtros

        // //ir a filtros
        // $("#btn_filtros").on("click", function(){
        //     //Cargamos la vista en el div
        //     location.href="<?php echo site_url('filtros'); ?>";
        // });//ir a filtros


    }); // document.ready
</script>
