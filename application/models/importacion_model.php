<?php

class Importacion_model extends CI_Model
{

    function contar_cliente_producto($datos)
    {
        $sql = "SELECT
		CONCAT(REPEAT('0', 4 - LENGTH(cp.ano)), cp.ano, '-', REPEAT('0', 2 - LENGTH(cp.mes)), cp.mes, '-', REPEAT('0', 2 - LENGTH(cp.dia)), cp.dia) AS Fecha
		FROM
		clientes_productos AS cp
		WHERE 
		cp.id_empresa = '{$this->session->userdata('id_empresa')}' AND 
		CONCAT(REPEAT('0', 4 - LENGTH(cp.ano)), cp.ano, '-', REPEAT('0', 2 - LENGTH(cp.mes)), cp.mes, '-', REPEAT('0', 2 - LENGTH(cp.dia)), cp.dia) >= '" . $datos["Fecha_Inicio"] . "'
		AND CONCAT(REPEAT('0', 4 - LENGTH(cp.ano)), cp.ano, '-', REPEAT('0', 2 - LENGTH(cp.mes)), cp.mes, '-', REPEAT('0', 2 - LENGTH(cp.dia)), cp.dia) <= '" . $datos["Fecha_Final"] . "'";
        
        return count($this->db->query($sql)->result());
    }

    function contar_cliente_campana($datos)
    {
        $sql = "SELECT
			clientes_campanas.fecha_inicial as Fecha
		FROM
			clientes_campanas
		WHERE
			clientes_campanas.id_empresa = '{$this->session->userdata('id_empresa')}' AND
			clientes_campanas.fecha_inicial > '" . $datos["Fecha_Inicio"] . "' AND
			clientes_campanas.fecha_inicial < '" . $datos["Fecha_Final"] . "'";
        
        return count($this->db->query($sql)->result());
    }

    function eliminar_productos($datos)
    {
        $sql = "DELETE
		FROM	clientes_productos
		WHERE clientes_productos.id_empresa = '{$this->session->userdata('id_empresa')}' AND CONCAT(REPEAT('0', 4 - LENGTH(clientes_productos.ano)), clientes_productos.ano, '-', REPEAT('0', 2 - LENGTH(clientes_productos.mes)), clientes_productos.mes, '-', REPEAT('0', 2 - LENGTH(clientes_productos.dia)), clientes_productos.dia) >= '" . $datos["Fecha_Inicio"] . "'
		AND CONCAT(REPEAT('0', 4 - LENGTH(clientes_productos.ano)), clientes_productos.ano, '-', REPEAT('0', 2 - LENGTH(clientes_productos.mes)), clientes_productos.mes, '-', REPEAT('0', 2 - LENGTH(clientes_productos.dia)), clientes_productos.dia) <= '" . $datos["Fecha_Final"] . "'";
        
        return $this->db->query($sql);
    }

    function eliminar_campanas($datos)
    {
        $sql = "DELETE FROM clientes_campanas WHERE
		clientes_campanas.id_empresa = '{$this->session->userdata('id_empresa')}' AND
		clientes_campanas.fecha_inicial > '" . $datos["Fecha_Inicio"] . "' AND
		clientes_campanas.fecha_inicial < '" . $datos["Fecha_Final"] . "'";
        
        return $this->db->query($sql);
    }
}
/* Fin del archivo importacion_model_model.php */
/* Ubicación: ./application/models/importacion_model_model.php */