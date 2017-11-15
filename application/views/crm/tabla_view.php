<?php
// Se listan los campos
$campos = $this->crm_model->listar_campos($id_filtro);
// echo "Campos: ".$campos;

// Se listan los nombres de los campos
$nombres_campos = $this->crm_model->listar_nombres_campos($id_filtro);
// print_r($nombres_campos);
// echo count($nombres_campos);

// Se listan las condiciones
$condiciones = $this->crm_model->listar_condiciones($id_filtro, date("Y"));
// echo "Condiciones: ".$condiciones;

// Se listan las relaciones
$relaciones = $this->crm_model->listar_relaciones($id_filtro);
// echo "relaciones: ".$relaciones;
// print_r($relaciones);

// Se reunen y se envía para que arme la consulta
$datos = $this->crm_model->listar_crm($campos, $relaciones, $condiciones);
// echo count($datos);
// echo $datos;

// echo "<b>Select </b>$campos<br>from asociados<br>{$relaciones}<br>{$condiciones}";
// exit();
?>

<!-- Tabla responsiva -->
<div class="table-responsive">
    <!-- Tabla -->
    <table id="crm" class="table">
        <!-- Cabecera -->
        <thead>
            <tr>
                <th class="alinear_centro" width="5%">Nro.</th>
                <?php foreach ($nombres_campos as $campo) { ?>
                    <th><?php echo $campo->Nombre; ?></th>
                <?php } //Foreach ?>
            </tr>
        </thead><!-- Cabecera -->
        <!-- Cuerpo -->
        <tbody>
            <?php
            //Contador
            $cont = 1;
            // Recorrido de los datos
            foreach ($datos as $dato) {
            ?>
            <tr>
                <td class="alinear_derecha"><?php echo $cont; ?></td>                
                <?php foreach ($nombres_campos as $campo) { ?>
                    <td>
                        <?php
                            //print_r($dato);                                                         
                            $datos_nom = explode(".", $campo->Nombre_Campo);                            
                            $nombre_dato =  $datos_nom[1];
                            //$dato->$nombre_dato;
                            echo $dato->$nombre_dato;
                        ?>
                    </td>
                <?php } //Foreach ?>
            </tr>
            <?php
            //Aumento de contador
            $cont++;
            } //Foreach
            ?>
        </tbody><!-- Cuerpo -->
</div><!-- Tabla responsiva -->

<script type="text/javascript">
    $(document).ready(function(){
        // Inicialización de la tabla
        $('#crm').dataTable( {
            "bProcessing": true,
        }); // Tabla      
    });//document.rady
</script>