<!-- Se listan los años -->
<?php $anios = $this->balance_model->listar_anios(); ?>


<!-- Contenedor del balance -->
<div id="cont_balance">
  <!-- Contenedor selects -->
  <div class="well container">
    <form method="post" id="import_csv" enctype="multipart/form-data">
      <div class="col-lg-10">
        <div class="col-lg-4 form-group">
          <label>Seleccione el archivo a importar</label>
          <input type="file" name="csv_file" class="form-control-file"
            id="csv_file" required accept=".csv" required/>
        </div>
        <div class="col-lg-4 form-group">
          <select class="form-control input-sm" id="categoria" required>
            <option value="">--Seleccione la opción a importar --</option>
            <option value="asociados">Asociados</option>
            <option value="aportes">Aportes</option>
            <option value="productos">Productos</option>
            <option value="directivos">Directivos</option>
            <option value="usuarios_sistema">Usuarios del sistema</option>
            <option value="clave_transferencia">Clave transferencia</option>
            <option value="tasa_mercado">Tasa de mercado</option>
            <option value="cliente_producto_credito">Clientes productos
              creditos</option>
            <option value="cliente_producto_captacion">Clientes
              productos captación</option>
            <option value="cliente_producto_social">Clientes productos
              sociales</option>
            <option value="asociados_habiles">Asociados hábiles</option>
            <option value="asociados_beneficiarios">Asociados
              Beneficiaros</option>
            <option value="asociados_conocidos">Asociados conocidos</option>
            <option value="asociados_hijos">Asociados hijos</option>
            <option value="asociados_conyuge">Asociados conyugues</option>
            <option value="asociados_motivo_retiro">Asociados motivo de
              retiro</option>
            <option value="asociados_otros_datos">Asociados Otros datos</option>
            <option value="catalogo_cuentas">Catalogo de cuentas</option>
          </select>
        </div>
      </div>
      <div class="col-lg-10 fecha hide">
        <div class="col-lg-4 form-group">
          <select id="select_anio" class="form-control input-sm">
            <?php foreach ($anios as $anio) { ?>
                <option value="<?php echo $anio->ano; ?>"><?php echo $anio->ano; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-lg-4 form-group">
          <select id="select_mes" class="form-control input-sm">
            <option value="1">Enero</option>
            <option value="2">Febreo</option>
            <option value="3">Marzo</option>
            <option value="4">Abril</option>
            <option value="5">Mayo</option>
            <option value="6">Junio</option>
            <option value="7">Julio</option>
            <option value="8">Agosto</option>
            <option value="9">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
          </select>
        </div>
      </div>
      <!-- Año -->

      <br>
      <div class="col-lg-5">
        <button type="submit" name="import_csv"
          class="btn btn-success btn-block btn-xs" id="import_csv_btn">Importar</button>
         <p class="hide red mesagge_response"></p>
      </div>
    </form>
    <br />
    <div id="imported_csv_data"></div>
  </div>
</div>


<script>
$(document).ready(function(){
	var selected = ["productos", "cliente_producto_credito", "cliente_producto_captacion", "catalogo_cuentas"];
    $("#categoria").change(function(){
    	var categoria = $('#categoria').val();
        if(selected.indexOf(categoria) >= 0) {
          $('.fecha').removeClass('hide');
        } else {
          $('.fecha').addClass('hide');
        }
    });

 $('#import_csv').on('submit', function(event){
  event.preventDefault();
  var formData = new FormData();
    //append your file
  formData.append('file', $('#csv_file').prop('files')[0]);
  var category = $('#categoria').val();
  formData.append('category', category);
  $('.mesagge_response').addClass('hide');

  if(selected.indexOf(category) >= 0) {
    formData.append('mes', $('#select_mes').val());
    formData.append('anio', $('#select_anio').val());
  }

  $.ajax({
   url:"<?php echo base_url(); ?>index.php/import/importcsv",
   method:"POST",
   data:formData,
   contentType:false,
   cache:false,
   processData:false,
   beforeSend:function(){
     $('#import_csv_btn').html('Importando...');
     $('#import_csv_btn').attr('disabled', true);
   },
   success:function(data)
   {
     console.log(data);
     if (data == 'false') {
       $('.mesagge_response').addClass('text-warning');
       $('.mesagge_response').text('Ha ocurrido un error por favor revise el formato y las cabeceras del archivo');

     } else {
       $('.mesagge_response').text('Importación completa');
       $('.mesagge_response').addClass('text-success');
     }
     $('.mesagge_response').removeClass('hide');
     $('#import_csv_btn').html('Importar');
     $('#import_csv')[0].reset();
     $('#import_csv_btn').attr('disabled', false);
     $('.fecha').addClass('hide');
   },
   error: function(response) {
	 var categorias = ["cliente_producto_credito", "cliente_producto_captacion", "cliente_producto_social"];
     if (response.status == 504 && categorias.indexOf(category) >= 0) {
    	 $('#import_csv')[0].reset();
         $('#import_csv_btn').attr('disabled', false);
         $('.mesagge_response').addClass('text-warning');
         $('.mesagge_response').html('El archivo cargado correctamente, los datos se subiran en segundo plano');
         $('.fecha').addClass('hide');
         $('.mesagge_response').removeClass('hide');
     }
   }
  })
 });

});
</script>