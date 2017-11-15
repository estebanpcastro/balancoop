<?php
//Si es empresa
if ($empresa == "1") {
	//Se define el título y los datos a cargar
	$titulo = "Empresa";
	$datos = $this->listas_model->cargar_empresas_usuarias();
} else {
	//Se define el título y los datos a cargar
	$titulo = "Oficina";
	$datos =  $this->listas_model->cargar_empresa('din_agencias', $this->session->userdata('id_empresa'));
}

//Se cargan los datos necesarios
$paises = $this->listas_model->cargar_paises();
?>

<!-- Si es empresa, y si es super administrador -->
<?php if ($empresa == "1" && ($this->session->userdata('tipo') == "3")){ ?>
	<!-- Botón agregar empresa -->
	<button id="btn_agregar" type="button" class="btn btn-info btn-block">Agregar <?php echo $titulo; ?></button>
<!-- Si es oficina y no es responsable -->
<?php }elseif($empresa == "2" && $this->session->userdata('tipo') != "2"){ ?>
	<!-- Botón agregar oficina -->
	<button id="btn_agregar" type="button" class="btn btn-info btn-block">Agregar <?php echo $titulo; ?></button>
<?php }//if ?>
<br>

<!-- Tabla responsiva -->
<div id="tabla_empresas" class="table-responsive" class="table">
	<!-- Tabla -->
	<table id="tabla_datos">
		<!-- Cabecera -->
		<thead>
			<tr>
				<th class="alinear_centro" width="10%">Opc.</th>
                <th class="alinear_centro" width="5%">Id</th>
                <th class="alinear_centro">Nombre</th>
                <th class="alinear_centro">Razón social</th>
                <th class="alinear_centro">Nit</th>
                <th class="oculto">select_ciudad</th>
                <th class="oculto">select_estado</th>
                <th class="oculto">select_departamento</th>
                <th class="oculto">input_email_contacto</th>
                <th class="oculto">input_direccion1</th>
                <th class="oculto">input_direccion2</th>
                <th class="oculto">input_telefono1</th>
                <th class="oculto">input_telefono2</th>
                <th class="oculto">input_fax</th>
                <th class="oculto">input_celular</th>
                <th class="oculto">input_nombre_contacto</th>
                <th class="oculto">select_pais</th>
                <th class="oculto">input_telefono_contacto</th>
			</tr>
		</thead><!-- Cabecera -->

		<!-- Cuerpo -->
        <tbody>
        	<?php
            // Recorrido de los datos
            foreach ($datos as $dato) {
            ?>
			<tr>
				<td>
					<!-- Sólo los super usuarios pueden modificar -->
					<?php if ($this->session->userdata('tipo') == "3") { ?>
						<span onclick="javascript:editar_dato(<?php echo $dato->intCodigo; ?>)" class="glyphicon glyphicon-edit"></span>
					<?php } ?>
				</td>
				<td class="alinear_derecha"><?php echo $dato->intCodigo; ?></td>
				<td id="input_nombre<?php echo $dato->intCodigo; ?>"><?php echo $dato->strNombre; ?></td>
                <td id="input_razon_social<?php echo $dato->intCodigo; ?>"><?php echo $dato->razon_social; ?></td>
                <td id="input_nit<?php echo $dato->intCodigo; ?>"><?php echo $dato->nit; ?></td>
                <td id="select_ciudad<?php echo $dato->intCodigo; ?>" class="oculto"><?php echo $dato->id_ciudad; ?></td>
                <td id="select_estado<?php echo $dato->intCodigo; ?>" class="oculto"><?php echo $dato->Estado; ?></td>
                <td id="select_departamento<?php echo $dato->intCodigo; ?>" class="oculto"><?php echo $dato->id_estado; ?></td>
                <td id="input_email_contacto<?php echo $dato->intCodigo; ?>" class="oculto"><?php echo $dato->email_contacto; ?></td>
                <td id="input_direccion1<?php echo $dato->intCodigo; ?>" class="oculto"><?php echo $dato->direccion1; ?></td>
                <td id="input_direccion2<?php echo $dato->intCodigo; ?>" class="oculto"><?php echo $dato->direccion2; ?></td>
                <td id="input_telefono1<?php echo $dato->intCodigo; ?>" class="oculto"><?php echo $dato->telefono1; ?></td>
                <td id="input_telefono2<?php echo $dato->intCodigo; ?>" class="oculto"><?php echo $dato->telefono2; ?></td>
                <td id="input_fax<?php echo $dato->intCodigo; ?>" class="oculto"><?php echo $dato->fax; ?></td>
                <td id="input_celular<?php echo $dato->intCodigo; ?>" class="oculto"><?php echo $dato->celular; ?></td>
                <td id="input_nombre_contacto<?php echo $dato->intCodigo; ?>" class="oculto"><?php echo $dato->nombre_contacto; ?></td>
                <td id="select_pais<?php echo $dato->intCodigo; ?>" class="oculto"><?php echo $dato->id_pais; ?></td>
                <td id="input_telefono_contacto<?php echo $dato->intCodigo; ?>" class="oculto"><?php echo $dato->telefono_contacto; ?></td>
			</tr>
            <?php } //Foreach ?>
        </tbody><!-- Cuerpo -->
	</table><!-- Tabla -->
</div><!-- Tabla responsiva -->

<!-- Modal nuevo dato -->
<div id="modal_nuevo_dato" class="modal fade">
	<form id="form_datos">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Cabecera -->
                <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Agregar <?php echo $titulo; ?></h4>
                </div><!-- Cabecera -->

				<!-- Cuerpo -->
                <div class="modal-body">
					<!-- Titulo -->
					<legend><?php echo $titulo; ?></legend>

					<!-- Container -->
					<div class="container">
						<div class="col-lg-12">
							<input type="hidden" id="input_id_dato" value="">
							<!-- Nombre -->
	       	 				<label for="input_nombre" class="control-label">Nombre *</label>
							<input id="input_nombre" class="form-control input-sm" type="text" placeholder="Obligatorio" autofocus><!-- Nombre -->
						</div>
					</div><!-- Container -->
					
					<!-- Container -->
					<div class="container">
						<div class="col-lg-6">
							<!-- nit -->
	       	 				<label for="input_nit" class="control-label">Nit *</label>
							<input id="input_nit" class="form-control input-sm" type="text" placeholder="Obligatorio" ><!-- nit -->
						</div>

						<div class="col-lg-6">
							<!-- Razón social -->
	       	 				<label for="input_razon_social" class="control-label">Razón social </label>
							<input id="input_razon_social" class="form-control input-sm" type="text" ><!-- Razón social -->
						</div>
					</div><!-- Container -->

					<!-- Container -->
					<div class="container">
						<div class="col-lg-6">
							<!-- Teléfono 1 -->
	       	 				<label for="input_telefono1" class="control-label">Teléfono 1 *</label>
							<input id="input_telefono1" class="form-control input-sm" type="text" placeholder="Obligatorio" ><!-- Teléfono 1 -->
						</div>

						<div class="col-lg-6">
							<!-- Teléfono 2 -->
	       	 				<label for="input_telefono2" class="control-label">Teléfono 2</label>
							<input id="input_telefono2" class="form-control input-sm" type="text" ><!-- Teléfono 2 -->
						</div>
					</div><!-- Container -->
					
					<!-- Container -->
					<div class="container">
						<div class="col-lg-6">
							<!-- Fax -->
	       	 				<label for="input_fax" class="control-label">Fax</label>
							<input id="input_fax" class="form-control input-sm" type="text" ><!-- Fax -->
						</div>

						<div class="col-lg-6">
							<!-- Celular -->
	       	 				<label for="input_celular" class="control-label">Celular</label>
							<input id="input_celular" class="form-control input-sm" type="text" ><!-- Celular -->
						</div>
					</div><!-- Container -->

					<!-- Container -->
					<div class="container">
						<div class="col-lg-6">
							<!-- Dirección 1 -->
	       	 				<label for="input_direccion1" class="control-label">Dirección 1 *</label>
							<input id="input_direccion1" class="form-control input-sm" type="text" placeholder="Obligatorio" ><!-- Dirección 1 -->
						</div>

						<div class="col-lg-6">
							<!-- Dirección 2 -->
	       	 				<label for="input_direccion2" class="control-label">Dirección 2</label>
							<input id="input_direccion2" class="form-control input-sm" type="text" ><!-- Dirección 2 -->
						</div>
					</div><!-- Container -->

					<!-- Container -->
					<div class="container">
						<div class="col-lg-4">
							<!-- País -->
	       	 				<label for="select_pais" class="control-label">País</label>
							<select id="select_pais" class="form-control input-sm">
			                    <option value="">Seleccione...</option>
		                        <?php foreach ($paises as $pais) { ?>
				                    <option value="<?php echo $pais->strCodigo; ?>"><?php echo $pais->strNombre; ?></option>
			                    <?php } ?>
			                </select><!-- País -->
						</div>

						<div class="col-lg-4">
							<!-- Departamento -->
	       	 				<label for="select_departamento" class="control-label">Departamento</label>
							<select id="select_departamento" class="form-control input-sm" >
			                    <option value="">Seleccione primero un país</option>
			                </select><!-- Departamento -->
						</div>

						<div class="col-lg-4">
							<!-- Ciudad -->
	       	 				<label for="select_ciudad" class="control-label">Ciudad</label>
							<select id="select_ciudad" class="form-control input-sm" >
			                    <option value="">Seleccione primero un departamento</option>
			                </select><!-- Ciudad -->
						</div>
					</div><!-- Container -->

					<div class="col-lg-12">
                        <!-- Estado -->
                        <label for="select_estado" class="control-label">Estado</label>
                        <select id="select_estado" class="form-control input-sm">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                        <!-- Estado -->
                    </div>

					<!-- Contacto -->
					<legend>Contacto</legend>

					<!-- Container -->
					<div class="container">
						<div class="col-lg-12">
							<!-- Nombre del contacto -->
	       	 				<label for="input_nombre_contacto" class="control-label">Nombre *</label>
							<input id="input_nombre_contacto" class="form-control input-sm" type="text" placeholder="Obligatorio" ><!-- Nombre del contacto -->
						</div>
					</div><!-- Container -->

					<!-- Container -->
					<div class="container">
						<div class="col-lg-6">
							<!-- Email contacto -->
	       	 				<label for="input_email_contacto" class="control-label">Email *</label>
							<input id="input_email_contacto" class="form-control input-sm" type="text" placeholder="Obligatorio" ><!-- Email contacto -->
						</div>

						<div class="col-lg-6">
							<!-- Teléfono -->
	       	 				<label for="input_telefono_contacto" class="control-label">Teléfono *</label>
							<input id="input_telefono_contacto" class="form-control input-sm" type="text" placeholder="Obligatorio" ><!-- Teléfono -->
						</div>
					</div><!-- Container -->
            	</div><!-- Cuerpo -->

            	<!-- Pie -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div><!-- Pie -->
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</form>
</div><!-- Modal nuevo dato -->


<script type="text/javascript">

	// Borrar formulario    
    function borrar_formulario(){        
        $('#input_id_dato').val('');	        
        $("#select_ciudad").val('');
        $("#select_departamento").val('');
        $("#input_email_contacto").val('');
        $("#input_direccion1").val('');
        $("#input_direccion2").val('');
        $("#input_telefono1").val('');
        $("#input_telefono2").val('');        
        $("#input_fax").val('');
        $("#input_celular").val('');
        $("#input_nit").val('');
        $("#input_nombre").val('');
        $("#input_nombre_contacto").val('');
        $("#select_pais").val('');
        $("#input_razon_social").val('');
        $("#input_telefono_contacto").val('');
    }

	// Cuando den clic sobre editar     
    function editar_dato(elemento){    	
    	borrar_formulario();
    	
    	//mostrar_elemento($("#" + elemento));     
        var select_ciudad = document.getElementById('select_ciudad'+elemento).innerHTML
        var select_departamento = document.getElementById('select_departamento'+elemento).innerHTML
        var input_email_contacto = document.getElementById('input_email_contacto'+elemento).innerHTML
        var input_direccion1 = document.getElementById('input_direccion1'+elemento).innerHTML
        var input_direccion2 = document.getElementById('input_direccion2'+elemento).innerHTML
        var select_estado = document.getElementById('select_estado'+elemento).innerHTML
        var input_telefono1 = document.getElementById('input_telefono1'+elemento).innerHTML             
        var input_telefono2 = document.getElementById('input_telefono2'+elemento).innerHTML      
        var input_fax = document.getElementById('input_fax'+elemento).innerHTML      
        var input_celular = document.getElementById('input_celular'+elemento).innerHTML      
        var input_nit = document.getElementById('input_nit'+elemento).innerHTML           
        var input_nombre = document.getElementById('input_nombre'+elemento).innerHTML           
        var input_nombre_contacto = document.getElementById('input_nombre_contacto'+elemento).innerHTML           
        var select_pais = document.getElementById('select_pais'+elemento).innerHTML           
        var input_razon_social = document.getElementById('input_razon_social'+elemento).innerHTML           
        var input_telefono_contacto = document.getElementById('input_telefono_contacto'+elemento).innerHTML           

        //alert("id_variable"+elemento); 
        $('#modal_nuevo_dato').modal('show');
        $('#input_id_dato').val(elemento);
        $("#select_pais").val(select_pais);
        if(select_pais!=''){
            //Se realiza la consulta por ajax
            departamentos = ajax("<?php echo site_url('listas/cargar_departamentos'); ?>", {'codigo_pais': select_pais}, "JSON");

            // Si trae departamentos
            if (departamentos.length > 0) {
                //Se resetea el select y se agrega una option vacia
                $('#select_departamento').html('').append("<option value=''>Seleccione...</option>");
            } else {
                //Se resetea el select y se agrega una option de no encontrado
                $('#select_departamento').html('').append("<option value=''>Ningún departamento encontrado...</option>");
            } //if

            //Se recorren los departamentos
            $.each(departamentos, function(key, val){
                //Se agrega cada departamento al select
                $('#select_departamento').append("<option value='" + val.strCodigo + "'>" + val.strNombre + "</option>");
            })//Fin each
        }	        
        $("#select_departamento").val(select_departamento);
        if(select_departamento!=''){
			//Se realiza la consulta por ajax
            ciudades = ajax("<?php echo site_url('listas/cargar_ciudades'); ?>", {'codigo_departamento': select_departamento}, "JSON");

            // Si trae ciudades
            if (ciudades.length > 0) {
                //Se reseteia el select y se agrega una option vacia
                $("#select_ciudad").html('').append("<option value=''>Seleccione...</option>");
            } else {
                //Se resetea el select y se agrega una option de no encontrado
                $("#select_ciudad").html('').append("<option value=''>Ninguna ciudad encontrada...</option>");
            } //if

            //Se recorren los ciudades
            $.each(ciudades, function(key, val){
                //Se agrega cada ciudad al select
                $("#select_ciudad").append("<option value='" + val.strCodigo + "'>" + val.strNombre + "</option>");
            })//Fin each
        }	        
        $("#select_ciudad").val(select_ciudad);        
        $("#select_estado").val(select_estado);        
        $("#input_email_contacto").val(input_email_contacto);
        $("#input_direccion1").val(input_direccion1);
        $("#input_direccion2").val(input_direccion2);
        $("#input_telefono1").val(input_telefono1);
        $("#input_telefono2").val(input_telefono2);        
        $("#input_fax").val(input_fax);
        $("#input_celular").val(input_celular);
        $("#input_nit").val(input_nit);
        $("#input_nombre").val(input_nombre);
        $("#input_nombre_contacto").val(input_nombre_contacto);       
        $("#input_razon_social").val(input_razon_social);
        $("#input_telefono_contacto").val(input_telefono_contacto);
        
    }

	$(document).ready(function(){
        // Inicialización de la tabla
        $('#tabla_datos').dataTable( {
            "bProcessing": true,
        }); // Tabla
       
        //Agregar
        $("#btn_agregar").on("click", function(){
            //Se abre la ventana
            $('#modal_nuevo_dato').modal('show');
            borrar_formulario();
        });//Agregar

        //Recolección de datos
        var id_dato = $("#input_id_dato");
        var celular = $("#input_celular");
        var ciudad = $("#select_ciudad");
        var departamento = $("#select_departamento");
        var email_contacto = $("#input_email_contacto");
        var estado = $("#select_estado");
        var direccion1 = $("#input_direccion1");
        var direccion2 = $("#input_direccion2");
        var empresa = "<?php echo $empresa; ?>";
        var fax = $("#input_fax");
        var nit = $("#input_nit");
        var nombre = $("#input_nombre");
        var nombre_contacto = $("#input_nombre_contacto");
        var pais = $("#select_pais");
        var razon_social = $("#input_razon_social");
        var telefono1 = $("#input_telefono1").numericInput();
        var telefono2 = $("#input_telefono2").numericInput();
        var telefono_contacto = $("#input_telefono_contacto").numericInput();
        var titulo = "<?php echo $titulo; ?>";

        /**
         * Selección de país y carga de los departamentos
         */
        pais.on("change", function(){
            //Si se selecciona un país
            if ($(this).val() != "") {
                //Se realiza la consulta por ajax
                departamentos = ajax("<?php echo site_url('listas/cargar_departamentos'); ?>", {'codigo_pais': $(this).val()}, "JSON");

                // Si trae departamentos
                if (departamentos.length > 0) {
                    //Se resetea el select y se agrega una option vacia
                    $(departamento).html('').append("<option value=''>Seleccione...</option>");
                } else {
                    //Se resetea el select y se agrega una option de no encontrado
                    $(departamento).html('').append("<option value=''>Ningún departamento encontrado...</option>");
                } //if

                //Se recorren los departamentos
                $.each(departamentos, function(key, val){
                    //Se agrega cada departamento al select
                    $(departamento).append("<option value='" + val.strCodigo + "'>" + val.strNombre + "</option>");
                })//Fin each
            }//If
        }); //Pais change

		 /**
         * Selección del departamento y carga de las ciudades
         */
        departamento.on("change", function(){
            //Se realiza la consulta por ajax
            ciudades = ajax("<?php echo site_url('listas/cargar_ciudades'); ?>", {'codigo_departamento': $(this).val()}, "JSON");

            // Si trae ciudades
            if (ciudades.length > 0) {
                //Se reseteia el select y se agrega una option vacia
                $(ciudad).html('').append("<option value=''>Seleccione...</option>");
            } else {
                //Se resetea el select y se agrega una option de no encontrado
                $(ciudad).html('').append("<option value=''>Ninguna ciudad encontrada...</option>");
            } //if

            //Se recorren los ciudades
            $.each(ciudades, function(key, val){
                //Se agrega cada ciudad al select
                $(ciudad).append("<option value='" + val.strCodigo + "'>" + val.strNombre + "</option>");
            })//Fin each
        }); //Departamento change

        //Guardar
        $("#form_datos").on("submit", function(){
    		//Datos a validar
            datos_obligatorios = new Array(
				direccion1.val(),
				email_contacto.val(),
				telefono_contacto.val(),
				nit.val(),
				nombre_contacto.val(),
				nombre.val(),
				telefono1.val()
            );

            //Se ejecuta la validación de los campos obligatorios
            validacion = validar_campos_vacios(datos_obligatorios);

            //Si no supera la validacíón
            if (!validacion) {
                //Se muestra el mensaje de error
                mostrar_mensaje('Aun no se ha completado el registro de la ' + titulo, 'Por favor complete los datos obligatorios para proceder al registro de la ' + titulo);
            } else {
            	//Si es oficina
            	if (empresa == "2") {
            		//Definimos la tabla
        			tabla = "din_agencias";

            		//Arreglo JSON de datos a enviar posteriormente
		            datos_formulario = {
		            	'celular': celular.val(),
						'id_ciudad': ciudad.val(),
						'id_estado': departamento.val(),
						'email_contacto': email_contacto.val(),
						'direccion1': direccion1.val(),
						'direccion2': direccion2.val(),
						'fax': fax.val(),
						'nit': nit.val(),
						'strNombre': nombre.val(),
						'nombre_contacto': nombre_contacto.val(),
						'Estado': estado.val(),
						'id_pais': pais.val(),
						'razon_social': razon_social.val(),
						'telefono1': telefono1.val(),
						'telefono2': telefono2.val(),
						'telefono_contacto': telefono_contacto.val(),
						'id_empresa': "<?php echo $this->session->userdata('id_empresa'); ?>"
		            };
            	} else {
            		//Definimos la tabla
        			tabla = "empresas_usuarias";

            		//Arreglo JSON de datos a enviar posteriormente
		            datos_formulario = {
		            	'celular': celular.val(),
						'id_ciudad': ciudad.val(),
						'id_estado': departamento.val(),
						'email_contacto': email_contacto.val(),
						'direccion1': direccion1.val(),
						'direccion2': direccion2.val(),
						'Estado': estado.val(),
						'fax': fax.val(),
						'nit': nit.val(),
						'strNombre': nombre.val(),
						'nombre_contacto': nombre_contacto.val(),
						'id_pais': pais.val(),
						'razon_social': razon_social.val(),
						'telefono1': telefono1.val(),
						'telefono2': telefono2.val(),
						'telefono_contacto': telefono_contacto.val(),
		            };
            	};//if
	            // imprimir(datos_formulario)

	            if(id_dato.val()!=''){
	            	//Se invoca la petición ajax que guardará el registro
		            dato = ajax("<?php echo site_url('listas/actualizar'); ?>", {"datos": datos_formulario, "tabla": tabla, "campo": "intCodigo", "id_campo": id_dato.val() }, "html");

		            // Si se guardó correctamente
		            if(dato){
						//Se cierra la ventana
			            $('#modal_nuevo_dato').modal('hide');

			            //Cuando se termine de cerrar
			            $('#modal_nuevo_dato').on('hidden.bs.modal', function (e) {
			                //Se recarga la tabla para que muestre los datos
			                $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'empresa_oficina', empresa: empresa});
			            });
		            }//if
	            }else{ 
		            //Se invoca la petición ajax que guardará el registro
		            dato = ajax("<?php echo site_url('listas/guardar'); ?>", {"datos": datos_formulario, "tabla": tabla}, "html");

		            // Si es empresa
		            if(tabla == 'empresas_usuarias'){
		            	// Se recolectan los datos necesarios
		            	datos_usuario_nuevo = {
		            		'id_empresa': dato,
		            		'id_tipo_usuario': 1,
		            		'login': 'admin',
		            		'password': '8cb2237d0679ca88db6464eac60da96345513964',
		            		'strNombre': nombre_contacto.val()
		            	}
		            	// imprimir(datos_usuario_nuevo);
		            	
		            	// Se procede a guardar el registro
                    	ajax("<?php echo site_url('cliente/guardar') ?>", {'datos': datos_usuario_nuevo, "tipo": "usuario_sistema"}, 'JSON');
		            }

		            // Si se guardó correctamente
		            if(dato){
						//Se cierra la ventana
			            $('#modal_nuevo_dato').modal('hide');

			            //Cuando se termine de cerrar
			            $('#modal_nuevo_dato').on('hidden.bs.modal', function (e) {
			                //Se recarga la tabla para que muestre los datos
			                $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'empresa_oficina', empresa: empresa});
			            });
		            }//if
		        }    
            }//if validacion

        	//Se detiene el formulario
            return false;
        });//Guardar
    });//document.ready
</script>