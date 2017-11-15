<?php
Class Reporte_model extends CI_Model{
	function cargar_datos_campana($id_campana, $id_usuario){
		$usuario_oportunidad = "";
		$usuario_comentario = "";
		$usuario_agregado = "";

		if ($id_usuario > 0) {
			$usuario_oportunidad = "AND oportunidad_x_cliente.id_usuario_creador = {$id_usuario}";
			$usuario_comentario = "AND cliente_comentarios.id_usuario_creador = {$id_usuario}";
			$usuario_agregado = "AND clientes_campanas.id_usuario_creador = {$id_usuario}";
		}

		$sql = 
		"SELECT
			campanas.intCodigo,
			campanas.strNombre,
			campanas.fecha_inicia,
			din_agencias.strNombre AS Oficina,
			campanas.tipo_campana,
			if(campanas.costo_estimado = '', 0, campanas.costo_estimado) as costo_estimado,
			if(campanas.beneficio_estimado = '', 0, campanas.beneficio_estimado) as beneficio_estimado,
			campanas.descripcion,
			
			# Oportunidades (con id de usuario)
			(SELECT
				COUNT(oportunidad_x_cliente.intCodigo)
			FROM
				oportunidad_x_cliente
				INNER JOIN usuarios_sistema ON oportunidad_x_cliente.id_usuario_creador = usuarios_sistema.intCodigo
			WHERE
				oportunidad_x_cliente.id_campana = campanas.intCodigo
				{$usuario_oportunidad}
				AND usuarios_sistema.id_empresa = {$this->session->userdata('id_empresa')}) AS Oportunidades,
		
			# Comentarios (con id de usuario)
			(SELECT
				COUNT(cliente_comentarios.intCodigo)
			FROM
				cliente_comentarios
				INNER JOIN usuarios_sistema ON cliente_comentarios.id_usuario_creador = usuarios_sistema.intCodigo
			WHERE
				cliente_comentarios.id_campana = campanas.intCodigo
				{$usuario_comentario}
				AND usuarios_sistema.id_empresa = '{$this->session->userdata('id_empresa')}') AS Comentarios,

			# Agregados (con id de usuario)
			(SELECT
				COUNT(clientes_campanas.intCodigo)
			FROM
				clientes_campanas
			WHERE
				clientes_campanas.id_campana = {$id_campana}
				AND clientes_campanas.id_empresa = '{$this->session->userdata('id_empresa')}'
				{$usuario_agregado}) AS Invitados_Agregados,

			campanas.Estado,
			campanas.fecha_finaliza,
			campanas.numero_invitados AS Cantidad_personas
		FROM
			campanas
			LEFT JOIN din_agencias ON campanas.id_agencia = din_agencias.intCodigo
		WHERE
			campanas.intCodigo = {$id_campana}
			AND campanas.id_empresa = '{$this->session->userdata('id_empresa')}'";

		return $this->db->query($sql)->row();
	}

	function cargar_productos_campana($id_campana, $id_usuario){
		$usuario_campana = "";

		if ($id_usuario > 0) {
			$usuario_campana = "AND clientes_productos.id_usuario_creador = {$id_usuario}";
		}

		$sql =
		"SELECT
			COUNT(clientes_productos.intCodigo) AS cantidad,
			productos.strNombre,
			Sum(clientes_productos.valor) AS valor,
			Sum(clientes_productos.transferencia) AS transferencia
		FROM
			clientes_productos
			INNER JOIN productos ON clientes_productos.id_producto = productos.intCodigo
		WHERE
			clientes_productos.id_empresa = '{$this->session->userdata('id_empresa')}'
			AND clientes_productos.id_campana = {$id_campana} 
			{$usuario_campana}
		GROUP BY
			clientes_productos.id_producto";
		
		return $this->db->query($sql)->result();
	}

	function cargar_productos_mes($id_producto_cliente){
		$sql =
		"SELECT
		clientes_productos.id_cliente,
		clientes_productos.intCodigo,
		productos.strNombre,
		clientes_productos.valor,
		clientes_productos.transferencia,
		clientes_productos.Nombre,
		clientes_productos.PrimerApellido,
		clientes_productos.SegundoApellido,
		clientes_productos.TelefonoCasa,
		(SELECT
		count(clientes_productos.intCodigo) 
		FROM
		clientes_productos
		WHERE
		clientes_productos.ano = '".date('Y')."' AND
		clientes_productos.mes = '".date('m')."' AND
		clientes_productos.id_producto = productos.intCodigo) AS Veces
		FROM
		clientes_productos
		INNER JOIN productos ON clientes_productos.id_producto = productos.intCodigo
		WHERE
		clientes_productos.intCodigo = {$id_producto_cliente}";
		
		return $this->db->query($sql)->row();
	}

	function oportunidad_estado($id_campana, $id_estado){
		$sql =
		"SELECT
		count(oportunidad_x_cliente.id_campana) AS Cantidad,
		sum(oportunidad_x_cliente.valor_estimado) AS Total
		FROM
		oportunidad_x_cliente
		WHERE
		oportunidad_x_cliente.id_campana = {$id_campana} AND
		oportunidad_x_cliente.id_estado_oportunidad = {$id_estado}";

		return $this->db->query($sql)->row();
	}

	function oportunidad_fase($id_campana, $id_fase){
		$sql =
		"SELECT
		Count(oportunidad_x_cliente.id_fase) AS Cantidad,
		Sum(oportunidad_x_cliente.valor_estimado) AS Total
		FROM
		oportunidad_x_cliente
		WHERE
		oportunidad_x_cliente.id_campana = {$id_campana} AND
		oportunidad_x_cliente.id_fase = {$id_fase}";
		
		return $this->db->query($sql)->row();
	}
}
/* Fin del archivo reporte_model.php */
/* Ubicación: ./application/models/reporte_model.php */