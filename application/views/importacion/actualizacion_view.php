<div class="col-lg-4">
    <fieldset>
        <legend><h2>2. Tabla</h2></legend>
        
        <label class="radio-inline">
            <input type="radio" name="tabla" id="tabla" value="asociados" checked> Asociados
        </label><br>
    </fieldset>
</div>

<div class="col-lg-4">
    <fieldset>
        <legend><h2>3. Formato</h2></legend>
        
        <p>Descargue la plantilla con los campos actualizados de la base de datos, para que la importación no genere errores</p>

        <button id="btn_plantilla_asociados" type="button" class="btn btn-success btn-sm btn-block">Descargar &raquo;</button>
    </fieldset>
</div>

<div class="col-lg-4">
    <fieldset>
        <legend><h2>4. Subir</h2></legend>
        
        <p>Suba el archivo en CSV. Si el registro ya existe, actualizará la información. En caso de que no exista, creará el nuevo registro.</p>
       
        <form action="<?php echo site_url('importacion/subir/asociados'); ?>" method="post"  enctype="multipart/form-data">
           <input type="file" name="archivo">
           <input type="submit" value="Importar" class="btn btn-info btn-sm">
       </form>
    </fieldset>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        // Generar plantilla
        $("#btn_plantilla_asociados").on("click", function(){
            location.href = "<?php echo site_url('reporte/formato_importacion'); ?>" + "/" + $("#tabla:checked").val();
        }); // exportar excel
    });//document.ready
</script>