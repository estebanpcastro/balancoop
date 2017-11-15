<?php
$cont = 1;
//Se crea un arreglo
$acciones = array();
	
if ($id_asociado) {
	//Se traen los gustos que el cliente tenga asociados
	$gustos_p = $this->cliente_model->cargar_gustos($id_asociado);

	// Se recorren los gustos
	foreach ($gustos_p as $gusto_p) {
		// Se agrega cada gusto al array
		array_push($acciones, $gusto_p->int_IdGusto);
	}
}
?>

<!-- Gustos y preferencias -->
<div class="form-group">	
		<!-- Se recorren los gustos desde base de datos -->
		<?php foreach ($gustos as $gusto) { ?>
			<!-- Si el dato es par, va en primera columna -->
	    	<?php if ($cont %2 == 0) { ?>		
		    	<div class="col-sm-6 checkbox">
		    		<div class="checkbox">
		    			<label>
							<?php if(in_array($gusto->intCodigo, $acciones)) {$check = "checked";} else {$check = "";} ?>
		    				<input value="<?php echo $gusto->intCodigo; ?>" type="checkbox" name="gusto[]" value="" <?php echo $check; ?> >
		    				<?php echo $gusto->strNombre; ?>
		    			</label>
		    		</div>
	    		</div>
			<!-- Si el dato es impar, va en la segunda columna -->
	    	<?php } else { ?>
		    	<div class="col-sm-6 checkbox">
					<div class="checkbox">
		    			<label>
							<?php if(in_array($gusto->intCodigo, $acciones)) {$check = "checked";} else {$check = "";} ?>
		    				<input value="<?php echo $gusto->intCodigo; ?>" type="checkbox" name="gusto[]" value="" <?php echo $check; ?> >
		    				<?php echo $gusto->strNombre; ?>
		    			</label>
		    		</div>
	    		</div>
	    	<?php }//If ?>
		<?php }//Foreach ?>		
</div><!-- Gustos y preferencias -->


