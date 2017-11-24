<html>
<head>
    <title>How to Import CSV Data into Mysql using Codeigniter</title>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</head>
<body>
 <div class="container box">
  <h3 align="center">How to Import CSV Data into Mysql using Codeigniter</h3>
  <br />

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
      <option value="clientes_productos">Clientes productos</option>
    </select>
   </div>
   <br />
   <button type="submit" name="import_csv" class="btn btn-info" id="import_csv_btn">Import CSV</button>
  </form>
  <br />
  <div id="imported_csv_data"></div>
 </div>
</body>
</html>

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
