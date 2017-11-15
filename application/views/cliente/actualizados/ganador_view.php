<!-- Se consultan las oficinas que tienen usuarios -->
<?php $oficinas_participantes = $this->cliente_model->listar_oficinas_participantes($id_oficina); ?>

<!-- Modal ganador -->
<div id="modal_ganador" class="modal fade" style="text-align: left;">
	<div class="modal-dialog">
		<div class="modal-content">
    		<!-- Cabecera -->
            <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 id="titulo_mensaje" class="modal-title">Ganador (es)</h4>
            </div><!-- Cabecera -->

            <!-- Cuerpo -->
            <div class="modal-body">
            	<table class="table table-hover table-bordered">
				  	<tr>
				  		<th>Oficina</th>
				  		<th>Nombre</th>
				  		<th>Correo</th>
				  		<th>Celular</th>
				  	</tr>
					<?php
					// Se recorren las oficinas
					foreach ($oficinas_participantes as $oficina) {
						// Ganador de la oficina
						$ganador = $this->cliente_model->usuario_ganador($oficina->id_oficina, $mes, $anio);

						// Si no hay ganador
						if (count($ganador) == 0) {
							?>
							<tr>
								<td colspan="5">No hay ganador por seleccionar.</td>
							</tr>
							<?php
						}else{
							?>
							<tr>
								<td><?php echo $ganador->Oficina; ?></td>
								<td><?php echo $ganador->Nombre." ".$ganador->PrimerApellido." ".$ganador->SegundoApellido; ?></td>
								<td><?php echo $ganador->CorreoElectronico; ?></td>
								<td><?php echo $ganador->Celular_cliente; ?></td>
							</tr>
							<?php
						}
					}
					?>
				</table>
        	</div><!-- Cuerpo -->

            <!-- Pie -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div><!-- Pie -->
        </div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- Modal ganador -->

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		//Se abre la ventana
        $('#modal_ganador').modal('show');
    });//document.ready
</script>