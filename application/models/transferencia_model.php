<?php
/**
* Modelo encargado de gestionar toda la informacion que pueda ser usada en
* la transferencia solidaria
* 
* @author 		       John Arley Cano Salinas
* @author 		       Oscar Humberto Morales
*/
Class Transferencia_model extends CI_Model{
	function asociados_por_categoria($id_empresa, $id_oficina, $anio, $id_categoria){
		$sql = 
        "SELECT DISTINCT
			cp.id_cliente
		FROM
			clientes_productos AS cp
		LEFT JOIN productos AS p ON cp.id_producto = p.intCodigo
		WHERE
			cp.id_empresa = $id_empresa
		-- AND cp.id_agencia = $id_oficina
		AND cp.ano = $anio
		AND p.id_categoria = $id_categoria";

        return count($this->db->query($sql)->result());
	}

	function transferencia_por_categoria($id_empresa, $id_oficina, $anio, $id_categoria){
		$sql = 
        "SELECT
			sum(cp.transferencia) Total
		FROM
			clientes_productos AS cp
		LEFT JOIN productos AS p ON cp.id_producto = p.intCodigo
		WHERE
			cp.id_empresa = $id_empresa
		-- AND cp.id_agencia = $id_oficina
		AND cp.ano = $anio
		AND p.id_categoria = $id_categoria";

        return $this->db->query($sql)->row()->Total;
	}

	function transferencia_por_asociado($id_empresa, $id_oficina, $anio, $id_categoria, $identificacion){
		$sql = 
        "SELECT
			sum(cp.transferencia) Total
		FROM
			clientes_productos AS cp
		LEFT JOIN productos AS p ON cp.id_producto = p.intCodigo
		WHERE
			cp.id_empresa = $id_empresa
		-- AND cp.id_agencia = $id_oficina
		AND cp.ano = $anio
		AND p.id_categoria = $id_categoria
		AND cp.id_cliente = $identificacion";

        return $this->db->query($sql)->row()->Total;
	}

	function buscar_asociado($documento, $id_empresa){
        $sql = 
        "SELECT
        *
        FROM
        asociados
        WHERE Identificacion = {$documento}
        AND id_Empresa = '{$id_empresa}'";

        return $this->db->query($sql)->row();
    }

	function listar_anios(){
        $this->db->select('ano');
        $this->db->group_by('ano');
        $this->db->order_by('ano');

        return $this->db->get('clientes_productos')->result();
	}

	function compras_anio_actual($id_empresa, $datos){
		//Id de oficina cuando se seleccionan todas
		$oficina = "";

		//Si 
		if ($datos['id_oficina'] != "0") {
			$oficina = " clientes_productos.id_agencia = {$datos['id_oficina']} AND ";
		}

		$sql =
		"SELECT
			IFNULL(sum(clientes_productos.transferencia),0) AS Total_Compras
		FROM
			clientes_productos
		WHERE
			{$oficina}
			clientes_productos.ano = Date_format(now(),'%Y') AND
			clientes_productos.id_cliente = {$datos['identificacion']} AND
			clientes_productos.id_empresa = {$id_empresa}
		GROUP BY
			clientes_productos.ano";

		$resultado = $this->db->query($sql)->row();

		if ($resultado) {
			return $resultado;
		} else {
			return "false";
		}
	}

	function compras_anio_seleccionado($id_empresa, $datos){
		//Id de oficina cuando se seleccionan todas
		$oficina = "";

		//Si 
		if ($datos['id_oficina'] != "0") {
			$oficina = " clientes_productos.id_agencia = {$datos['id_oficina']} AND ";
		}

		$sql =
		"SELECT
			IFNULL(sum(clientes_productos.transferencia), 0) AS Total_Compras
		FROM
			clientes_productos
		WHERE
			{$oficina}
			clientes_productos.ano = {$datos['anio']} AND
			clientes_productos.id_cliente = {$datos['identificacion']} AND
			clientes_productos.id_empresa = {$id_empresa}
		GROUP BY
			clientes_productos.ano";

		$resultado = $this->db->query($sql)->row();

		if ($resultado) {
			return $resultado;
		} else {
			return "false";
		}
	}

	function compras_ultimos_meses($id_empresa, $datos){
		//Id de oficina cuando se seleccionan todas
		$oficina = "";

		//Si 
		if ($datos['id_oficina'] != "0") {
			$oficina = " clientes_productos.id_agencia = {$datos['id_oficina']} AND ";
		}

		$sql =
		"SELECT
			IFNULL(sum(clientes_productos.transferencia), 0) AS Total_Compras
		FROM
			clientes_productos
		WHERE
			clientes_productos.ano = Date_format(now(),'%Y') AND
			clientes_productos.mes <= DATE_SUB(now(),INTERVAL '90' DAY) AND
			clientes_productos.id_cliente = {$datos['identificacion']} AND
			clientes_productos.id_empresa = {$id_empresa}
		GROUP BY
			clientes_productos.ano";

		$resultado = $this->db->query($sql)->row();

		if ($resultado) {
			return $resultado;
		} else {
			return "false";
		}
	}

	function transferencias_mensuales($id_empresa, $datos){
		//Id de oficina cuando se seleccionan todas
		$oficina = "";

		//Si 
		if ($datos['id_oficina'] != "0") {
			// $oficina = " clientes_productos.id_agencia = {$datos['id_oficina']} AND ";
			$oficina = " cp.id_agencia = {$datos['id_oficina']} AND ";
		}

		$sql_ =
		"SELECT
		clientes_productos.mes AS Mes,
		clientes_productos.id_agencia,
		IFNULL(sum(clientes_productos.valor),0) AS Compras,
		IFNULL(sum(clientes_productos.transferencia),0) AS Transferencias
		FROM
		clientes_productos
		WHERE
		{$oficina}
		clientes_productos.ano = {$datos['anio']} AND
		clientes_productos.id_cliente = {$datos['identificacion']} AND
			clientes_productos.id_empresa = {$id_empresa}
		GROUP BY
		clientes_productos.id_agencia,
		clientes_productos.mes
		ORDER BY
		clientes_productos.mes ASC";

		$sql = 
		"SELECT
			cp.id_agencia,
			cp.mes Mes,
			productos.intCodigo AS id_producto,
			productos.strNombre AS Producto,
			pc.strNombre AS Categoria,
			pl.strNombre AS Linea,
			IFNULL(sum(cp.valor),0) AS Compras,
			IFNULL(sum(cp.transferencia),0) AS Transferencias,
			COUNT(cp.id_producto) Cantidad,
			IFNULL(sum(cp.Valor),0) AS Valor
		FROM
			clientes_productos AS cp
		LEFT JOIN productos ON cp.id_producto = productos.intCodigo
		LEFT JOIN productos_lineas AS pl ON productos.id_linea = pl.intCodigo
		LEFT JOIN productos_categorias AS pc ON pc.intCodigo = productos.id_categoria
		WHERE
			{$oficina}
			cp.ano = {$datos['anio']} AND
			cp.id_cliente = {$datos['identificacion']} AND
			cp.id_empresa = {$id_empresa}
		GROUP BY
			cp.id_producto,
			cp.id_agencia,
			cp.mes
		ORDER BY
			cp.mes DESC";

		$resultado = $this->db->query($sql)->result();

		if ($resultado) {
			return $resultado;
		} else {
			return "false";
		}
	}

	function total_transferencias($id_empresa, $identificacion){
		$sql =
		"SELECT
		ifnull(sum(clientes_productos.transferencia), 0) AS Total
		FROM
		clientes_productos
		WHERE
		clientes_productos.id_cliente = {$identificacion} AND
		clientes_productos.id_empresa = {$id_empresa}";

		$resultado = $this->db->query($sql)->row();

		return $resultado->Total;
	}
}/* Fin del archivo transferencia_model.php */
/* Ubicación: ./application/models/transferencia_model.php */