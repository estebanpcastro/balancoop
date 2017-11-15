<?php
$id_asociado = $this->input->post('id_asociado');

//Se listan los documentos subidos
// $documentos = $this->cliente_model->listar_documentos_subidos($id_asociado);
// 
// 
// print_r($documentos);

// Se abre la carpeta
$directorio = opendir('./documentos_cliente/'.$id_asociado.'/');
?>
<!-- Tabla responsiva -->
<div id="tabla" class="table-responsive">
    <!-- Tabla -->
    <table id="tabla_documentos" class="table">
        <!-- Cabecera -->
        <thead>
            <tr>
            	<th>Opc.</th>
            	<th>Nro.</th>
            	<th>Archivo</th>
			 </tr>
        </thead><!-- Cabecera -->

        <!-- Cuerpo -->
        <tbody>
			<?php
			// Contador
			$cont = 1;

			//Se leen las fotos en el directorio
			while ($elemento = readdir($directorio)){
			    //Tratamos los elementos . y .. que tienen todas las carpetas
			    if( $elemento != "." && $elemento != ".."){
			        // Si es una carpeta
			        if( is_dir($directorio.$elemento) ){
			            // Muestro la carpeta
			            // echo "<p><strong>CARPETA: ". $elemento ."</strong></p>";
			        } else {
				        //Guardo el fichero en un arreglo
				        //array_push($archivos, $elemento);
				        $archivo_full = base_url().'documentos_cliente/'.$id_asociado.'/'.$elemento;
				        $archivo = $elemento;
				        ?>
						<tr>
							<td>
								<a href="<?php echo $archivo_full; ?>" target="_blank" onClick="window.open(this.href, this.target, 'width=800,height=600'); return false;"><i class="glyphicon glyphicon-search icono"></i></a>
							</td>
							<td><?php echo $cont; ?></td>
							<td><?php echo $archivo; ?></td>
						</tr>
				        <?php
			    		//Aumento del contador
			    		$cont++;
			        }//Fin if
			    }//Fin if
			}//fin while
			?>
		</tbody><!-- Cuerpo -->
    </table><!-- Tabla -->
</div><!-- Tabla responsiva -->

<script type="text/javascript">
	$(document).ready(function(){
		// Inicialización de la tabla
        $('#tabla_documentos').dataTable({
            "bProcessing": true,
        }); // Tabla
	});//document.ready
</script>