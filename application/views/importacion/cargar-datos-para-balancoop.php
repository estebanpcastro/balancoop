<div class="col-lg-12">
    <!-- Contenedor del banner -->
    <div class="col-lg-8">
        <!-- Banner -->
        <img src="<?php echo base_url().'img/cabezote_transferencia.png' ?>" class="img-responsive" alt="Transferencia solidaria"><!-- Banner -->
    </div><!-- Contenedor del banner -->
  <div class="col-lg-8">
  <form method="post" id="import_csv" enctype="multipart/form-data">
   <div class="form-group">
    <label>Select CSV File</label>
    <input type="file" name="csv_file" class="form-control-file" id="csv_file" required accept=".csv" />
    <label for="categoria">Select list:</label>
    <select class="form-control" id="categoria">
      <option value="0">--Seleccione una opcion --</option>
      <option value="asociados">Asociados</option>
      <option value="aportes">Aportes</option>
      <option value="productos">Productos</option>
      <option value="directivos">Directivos</option>
      <option value="usuarios_sistema">Usuarios del sistema</option>
      <option value="clave_transferencia">Transferencia de cartera</option>
      <option value="tasa_mercado">Tasa de mercado</option>
      <option value="cliente_producto_credito">Clientes productos creditos</option>
      <option value="cliente_producto_captacion">Clientes productos captación</option>
      <option value="cliente_producto_social">Clientes productos sociales</option>
      <option value="asociados_habiles">Asociados hábiles</option>
      <option value="asociados_beneficiarios">Asociados Beneficiaros</option>
      <option value="asociados_conocidos">Asociados conocidos</option>
      <option value="asociados_hijos">Asociados hijos</option>
      <option value="asociados_conyuge">Asociados conyugues</option>
      <option value="asociados_motivo_retiro">Asociados motivo de retiro</option>
      <option value="asociados_otros_datos">Asociados Otros datos</option>

    </select>
   </div>
   <br />
   <button type="submit" name="import_csv" class="btn btn-info" id="import_csv_btn">Import CSV</button>
  </form>
  </div>
  <br />
  <div id="imported_csv_data"></div>
</div>


<script>
$(document).ready(function(){

 $('#import_csv').on('submit', function(event){
  event.preventDefault();
  var formData = new FormData();
    //append your file
  formData.append('file', $('#csv_file').prop('files')[0]);
  formData.append('category', $('#categoria').val());

  $.ajax({
   url:"<?php echo base_url(); ?>index.php/importdata/importcsv",
   method:"POST",
   data:formData,
   contentType:false,
   cache:false,
   processData:false,
   beforeSend:function(){
     $('#import_csv_btn').html('Importing...');
   },
   success:function(data)
   {
     console.log(data);

     $('#import_csv')[0].reset();
     $('#import_csv_btn').attr('disabled', false);
     $('#import_csv_btn').html('Import Done');
    //load_data();
   }
  })
 });

});
</script>
