<!-- Título -->
<center><h3>Filtros de producto</h3></center>

<!-- botón de creación -->
<button onClick="javascript:crear('productos')" type="button" class="btn btn-success btn-block btn-xs">Crear filtro de producto</button>

<script type="text/javascript">
    // Cuando el documento esté listo
    $(document).ready(function(){
        //Cargamos la tabla
        listar("productos");
    });//document.ready
</script>
