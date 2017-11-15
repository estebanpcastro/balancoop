<?php
//Se cargan los elementos de base de datos
$campanas = $this->listas_model->cargar_campanas($this->session->userdata('id_empresa'));
$usuarios = $this->listas_model->cargar('usuarios_sistema');
$tipos = $this->listas_model->cargar('tipo_campana');
$oficinas =  $this->listas_model->cargar_empresa('din_agencias', $this->session->userdata('id_empresa'));
$dias = $this->listas_model->listar_dias();
$meses = $this->listas_model->listar_meses();
$anios = $this->listas_model->listar_anios();
?>

<input type="hidden" id="id_campana">

<!-- Botón agregar campaña -->
<button id="btn_agregar_campana" type="button" class="btn btn-info btn-block">Agregar campaña</button>
<br>

<!-- Tabla responsiva -->
<div class="table-responsive">
    <!-- Tabla -->
	<table id="productos" class="table">
		<!-- Cabecera -->
		<thead>
            <tr>
				<th class="alinear_centro" width="10%">Opc.</th>
                <th class="alinear_centro" width="5%">Id</th>
				<th>Nombre</th>
				<th>Descripción</th>
				<th>Fecha Inicial</th>
				<th>Fecha Final</th>
				<th>Usuario creador</th>
				<th>Usuario responsable</th>
				<th>Usuario asignado</th>							
				<th>Estado</th>
        	</tr>
        </thead><!-- Cabecera -->
		<!-- Cuerpo -->
        <tbody>
        	<?php
            //Contador
            $cont = 1;
            // Recorrido de las campanas
            foreach ($campanas as $campana) {
            	//Usuarios
            	$asignado = $this->listas_model->cargar_datos_usuario($campana->id_usuario_asignado);
            	$creador = $this->listas_model->cargar_datos_usuario($campana->id_usuario_creador);
            	$responsable = $this->listas_model->cargar_datos_usuario($campana->id_usuario_responsable);
            ?>
			<tr>
				<td>
					<a href="javascript:editar_campana(<?php echo $campana->intCodigo; ?>)">
                        <span class="glyphicon glyphicon-edit icono"></span>            
                    </a>
				</td>
                <td class="alinear_derecha"><?php echo $campana->intCodigo; ?></td>
                <td><?php echo $campana->strNombre; ?></td>
                <td><?php echo $campana->descripcion; ?></td>
                <td><?php echo $campana->fecha_inicia; ?></td>
                <td><?php echo $campana->fecha_finaliza; ?></td>
                <td><?php if(isset($creador->strNombre)){ echo $creador->strNombre; }  ?></td>
                <td><?php if(isset($responsable->strNombre)){ echo $responsable->strNombre; }  ?></td>
                <td><?php if(isset($asignado->strNombre)){ echo $asignado->strNombre; }  ?></td>
                <td><?php if(date("Y-m-d", strtotime($campana->fecha_finaliza)) > date("Y-m-d")) {echo "Activo";}else{echo "Inactivo";} ?></td>
			</tr>
			<?php
            //Aumento de contador
            $cont++;
            } //Foreach
            ?>
    	</tbody><!-- Cuerpo -->
	</tabla><!-- Tabla -->
</div><!-- Tabla responsiva -->

<!-- Modal nueva campaña -->
<div id="modal_nueva_campana" class="modal fade">
    <form id="form_campana">
    	<div class="modal-dialog">
    		<div class="modal-content">
	    		<!-- Cabecera -->
	            <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h4 id="titulo_mensaje" class="modal-title">Gestión de campañas</h4>
	            </div><!-- Cabecera -->

	            <!-- Cuerpo -->
	            <div class="modal-body">
					<!-- Container -->
					<div class="container">
						<div class="col-lg-12">
							<input type="hidden" id="input_id_campana" value="">

							<!-- Nombre de la campaña -->
           	 				<label for="input_nombre" class="control-label">Nombre *</label>
							<input id="input_nombre" class="form-control input-sm" type="text" placeholder="Obligatorio" autofocus ><!-- Nombre de la campaña -->
						</div>

						<div class="col-lg-12">
							<!-- Descripción de la campaña -->
							<label for="input_descripcion" class="control-label">Descripción *</label>
							<textarea id="input_descripcion" class="form-control input-sm" type="text" ></textarea><!-- Descripción de la campaña -->
						</div>
						<br>
						<div class="form-group">						    
						    <!-- Fecha de Inicio -->
					        <label for="dia_inicio" class="col-sm-3 control-label">Fecha inicio</label>

					        <!-- Día -->
					        <div class="col-sm-3">
					            <select id="dia_inicio" class="form-control input-sm">
					                <option value="00">Día</option>
					                <?php foreach ($dias as $dia) { ?>
					                    <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
					                <?php } ?>
					            </select>
					        </div><!-- Día -->
					        
					        <!-- Mes -->
					        <div class="col-sm-3">
					            <select id="mes_inicio" class="form-control input-sm">
					                <option value="00">Mes</option>
					                <?php foreach ($meses as $mes) { ?>
					                    <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
					                <?php } ?>
					            </select>
					        </div><!-- Mes -->
					        
					        <!-- Año -->
					        <div class="col-sm-3">
					            <select id="anio_inicio" class="form-control input-sm" >
					                <option value="0000">Año</option>
					                <?php foreach ($anios as $anio) { ?>
					                    <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
					                <?php } ?>
					            </select>
					        </div><!-- Año -->
						</div>
						<br>
						<div class="form-group">
							<label for="dia_fin" class="col-sm-3 control-label">Fecha final</label>
					        <!-- Día -->
					        <div class="col-sm-3">
					            <select id="dia_fin" class="form-control input-sm">
					                <option value="00">Día</option>
					                <?php foreach ($dias as $dia) { ?>
					                    <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
					                <?php } ?>
					            </select>
					        </div><!-- Día -->
					        
					        <!-- Mes -->
					        <div class="col-sm-3">
					            <select id="mes_fin" class="form-control input-sm">
					                <option value="00">Mes</option>
					                <?php foreach ($meses as $mes) { ?>
					                    <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
					                <?php } ?>
					            </select>
					        </div><!-- Mes -->
					        
					        <!-- Año -->
					        <div class="col-sm-3">
					            <select id="anio_fin" class="form-control input-sm" >
					                <option value="0000">Año</option>
					                <?php foreach ($anios as $anio) { ?>
					                    <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
					                <?php } ?>
					            </select>
					        </div><!-- Año -->
						</div>

						<div class="col-lg-6">
							<!-- Oficinas -->
							<label for="select_oficinas">Oficinas</label>
							<select id="select_oficinas" class="form-control input-sm">
								<option value="0">Todas las oficinas</option>
								<?php foreach ($oficinas as $oficina) { ?>
			                        <option value="<?php echo $oficina->intCodigo; ?>"><?php echo $oficina->strNombre; ?></option>
			                    <?php } ?>
	                        </select><!-- Oficinas -->
						</div>

						<div class="col-lg-6">
							<!-- Tipo de campaña -->
							<label for="select_tipo_campana">Tipo de campaña</label>
							<select id="select_tipo_campana" class="form-control input-sm">
								<?php foreach ($tipos as $tipo) { ?>
			                        <option value="<?php echo $tipo->intCodigo; ?>"><?php echo $tipo->strNombre; ?></option>
			                    <?php } ?>
	                        </select><!-- Tipo de campaña -->
						</div>

						<div class="col-lg-4">
							<!-- Valor estimado -->
							<label for="input_valor_estimado">Valor estimado</label>
							<div class="col-sm-12 input-group input-group-sm">
								<span class="input-group-addon">$</span>
			                    <input id="input_valor_estimado" type="text" class="form-control" />
							</div><!-- Valor estimado -->
						</div>

						<div class="col-lg-4">
							<!-- Valor real -->
							<label for="input_valor_real">Valor real</label>
							<div class="col-sm-12 input-group input-group-sm">
								<span class="input-group-addon">$</span>
			                    <input id="input_valor_real" type="text" class="form-control" />
							</div><!-- Valor real -->
						</div>

						<div class="col-lg-4">
							<!-- A invitar -->
           	 				<label for="input_invitar" class="control-label">A invitar</label>
							<input id="input_invitar" class="form-control input-sm" type="text" ><!-- A invitar -->
						</div>
					</div><!-- Container -->
	        	</div><!-- Cuerpo -->

                <!-- Pie -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btn_guardar" class="btn btn-success">Guardar</button>
                </div><!-- Pie -->
            </div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</form>
</div><!-- Modal nueva campaña -->






<script type="text/javascript">
	function editar_campana(id_campana){
        // Se pone el id de la campaña
        $("#id_campana").val(id_campana);

       	// Consultamos los datos del usuario específico
        dato_campana = ajax("<?php echo site_url('listas/cargar_campana'); ?>", {'tipo': 'campana', 'id_campana': id_campana}, "JSON");
        // imprimir(dato_campana);
		
        // Se ponen los datos 
        $("#input_nombre").val(dato_campana.strNombre);
        $("#input_descripcion").val(dato_campana.descripcion);
        $('#dia_inicio > option[value="' + dato_campana.fecha_inicia.substring(8,10) + '"]').attr('selected', 'selected');
        $('#mes_inicio > option[value="' + dato_campana.fecha_inicia.substring(5,7) + '"]').attr('selected', 'selected');
        $('#anio_inicio > option[value="' + dato_campana.fecha_inicia.substring(0,4) + '"]').attr('selected', 'selected');
        $('#dia_fin > option[value="' + dato_campana.fecha_finaliza.substring(8,10) + '"]').attr('selected', 'selected');
        $('#mes_fin > option[value="' + dato_campana.fecha_finaliza.substring(5,7) + '"]').attr('selected', 'selected');
        $('#anio_fin > option[value="' + dato_campana.fecha_finaliza.substring(0,4) + '"]').attr('selected', 'selected');
        $('#select_oficinas > option[value="' + dato_campana.id_agencia + '"]').attr('selected', 'selected');
        $('#select_tipo_campana > option[value="' + dato_campana.tipo_campana + '"]').attr('selected', 'selected');
		$("#input_valor_real").val(dato_campana.costo_real);
		$("#input_valor_estimado").val(dato_campana.costo_estimado);
		$("#input_invitar").val(dato_campana.numero_invitados);

        //Se abre la ventana
        $('#modal_nueva_campana').modal('show');
    }

	// Cuando el DOM esté listo   
	$(document).ready(function(){
		//Recolección de datos
		var id_campana = $('#input_id_campana');    
        var nombre = $("#input_nombre");
        var descripcion = $("#input_descripcion");
        var dia_inicio = $("#dia_inicio");
        var mes_inicio = $("#mes_inicio");
        var anio_inicio = $("#anio_inicio");
        var dia_fin = $("#dia_fin");
        var mes_fin = $("#mes_fin");
        var anio_fin = $("#anio_fin");
        var tipo = $("#select_tipo_campana");
        var valor_estimado = $("#input_valor_estimado");
        var valor_real = $("#input_valor_real");
        var invitar = $("#input_invitar");
        var oficina = $("#select_oficinas");

        // Inicialización de la tabla
        $('#productos').dataTable( {
            "bProcessing": true,
        }); // Tabla

		//Agregar campana
        $("#btn_agregar_campana").on("click", function(){
        	// Se quita el id de la campaña
            $("#id_campana").val(0);

            //Se limpia el formulario
            limpiar("form");

            //Se abre la ventana
            $('#modal_nueva_campana').modal('show');
        });//Agregar campana

        //Guardar campaña
        $("#btn_guardar").on("click", function(){
        	//Datos a validar
            datos_obligatorios = new Array(
            	nombre.val()
            );

            //Se ejecuta la validación de los campos obligatorios
            validacion = validar_campos_vacios(datos_obligatorios);

            //Si no supera la validacíón
            if (!validacion) {
                //Se muestra el mensaje de error
                mostrar_mensaje('Aun no se ha completado el registro de la campaña', 'Por favor escriba un nombre para esta campaña.');
            } else {
            	//Arreglo JSON de datos a enviar posteriormente
	            datos_formulario = {
	            	'id_empresa': "<?php echo $this->session->userdata('id_empresa'); ?>",
	            	'id_agencia': oficina.val(),
	            	'tipo_campana': tipo.val(),
	            	'fecha_inicia': anio_inicio.val()+"-"+mes_inicio.val()+"-"+dia_inicio.val(),
	            	'fecha_finaliza': anio_fin.val()+"-"+mes_fin.val()+"-"+dia_fin.val(),
	            	'costo_estimado': valor_estimado.val(),
					'costo_real': valor_real.val(),
					'numero_invitados': invitar.val(),
	            	'id_usuario_creador': "<?php echo $this->session->userdata('id_usuario'); ?>",
					'descripcion': descripcion.val(),
					'strNombre': nombre.val()
	            };
	            // imprimir(datos_formulario);

	            //  Si es para actualizar, o sea, tiene id de campaña
                if ($("#id_campana").val() > 0) {
                	imprimir("Actualizando...");

                	//Se invoca la petición ajax que actualizará el registro
		            ajax("<?php echo site_url('listas/actualizar'); ?>", {"datos": datos_formulario, "tabla": "campanas", "campo": "intCodigo", "id_campo": $("#id_campana").val() }, "html");

		            //Se cierra la ventana
		            $('#modal_nueva_campana').modal('hide');

		            //Cuando se termine de cerrar
		            $('#modal_nueva_campana').on('hidden.bs.modal', function (e) {
		                //Se recarga la tabla para que muestre los datos
		                $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'campana'});
		            });
	            }else{
	            	imprimir("Guardando...");

	            	//Se invoca la petición ajax que guardará el registro
		            ajax("<?php echo site_url('listas/guardar'); ?>", {"datos": datos_formulario, "tabla": "campanas"}, "html");
		            
					//Se cierra la ventana
		            $('#modal_nueva_campana').modal('hide');

		            //Cuando se termine de cerrar
		            $('#modal_nueva_campana').on('hidden.bs.modal', function (e) {
		                //Se recarga la tabla para que muestre los datos
		                $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'campana'});
		            });
	            }
            }//if validacion

        	//Se detiene el formulario
            return false;
        });//Guardar campaña
	});//document.rady
</script>
