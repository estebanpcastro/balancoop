<?php
//Se cargan los elementos de base de datos
$listas = $this->listas_model->cargar('listas_desplegables');
?>

<!-- Proveedor del producto -->
<select id="select_listas_desplegables" class="form-control input-sm" autofocus>
    <option value="">Seleccione uno de los grupos de las listas desplegables...</option>
    <?php foreach ($listas as $lista) { ?>
        <option value="<?php echo $lista->strTabla; ?>"><?php echo $lista->strNombre; ?></option>
    <?php } ?>
</select><!-- Proveedor del producto -->
<br>

<div id="cont_listas_desplegables"></div>

<script type="text/javascript">
    $(document).ready(function(){
        //Recolección de datos
        var listas = $("#select_listas_desplegables");
        //alert(listas.valk());
        /**
         * Cuando seleccione una lista
         */
        listas.on("change", function(){
            //Si se selecciona alguna lista
            if ($(this).val() != "") {
                //Cargamos la interfaz y mandamos el nombre de la tabla
                $("#cont_listas_desplegables").load("listas/cargar_interfaz", {tipo: 'lista_desplegable', tabla: $(this).val()});
            }//else
        });//lista change

    });//document.rady
</script>