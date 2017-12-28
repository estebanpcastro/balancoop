<?php

/**
 * Modelo encargado de gestionar toda la informacion que pueda ser usada en
 * el inicio de la aplicación
 * 
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
class Inicio_model extends CI_Model
{

    function actualizar_estados($tipo)
    {
        // Tipo
        switch ($tipo) {
            // Consejero
            case "consejero":
                $sql = "UPDATE asociados SET EstadocomoConsejero = '0' 
                WHERE asociados.EstadocomoConsejero IS NOT NULL 
                AND asociados.Fecha_Fin_Consejero <= DATE_FORMAT(now(), '%Y-%m-%d')";
                break;
            
            // Delegado
            case "delegado":
                $sql = "UPDATE asociados SET EstadocomoDelegado = '0'
                WHERE
                asociados.EstadocomoDelegado IS NOT NULL AND
                asociados.Fecha_Fin_Delegado <= DATE_FORMAT(now(), '%Y-%m-%d')";
                break;
            
            // Junta de Vigilancia
            case "junta":
                $sql = "UPDATE asociados SET EstadocomoJuntadeVigilancia = '0'
                WHERE
                asociados.EstadocomoJuntadeVigilancia IS NOT NULL AND
                asociados.Fecha_Fin_Junta <= DATE_FORMAT(now(), '%Y-%m-%d')";
                break;
            
            // Comités
            case "comites":
                $sql = "UPDATE asociados SET EstadoenComites = '0'
                WHERE
                asociados.EstadoenComites IS NOT NULL AND
                asociados.Fecha_Fin_Comites <= DATE_FORMAT(now(), '%Y-%m-%d')";
                break;
        }
        
        // Se ejecuta
        $this->db->query($sql);
        
        // Se retorna
        return $this->db->affected_rows();
    }

    function obtener_id_empresa($documento)
    {
        // Columnas a retornar
        $this->db->select('*');
        $this->db->where('nit', $documento);
        
        // Se ejecuta y retorna la consulta
        $resultado = $this->db->get('empresas_usuarias')->row();
        
        // Si existe el usuario
        if (count($resultado) == 1) {
            // se retorna verdadero
            return $resultado;
        } else {
            // se retorna falso
            return false;
        }
    }

    function validar_sesion($usuario, $password, $id_empresa)
    {
        $this->db->select('*');
        
        // Se validan el usuario, el password y la empresa
        $this->db->where('login', $usuario);
        $this->db->where('password', $password);
        $this->db->where('id_Empresa', $id_empresa);
        $this->db->where('Estado', '1');
        
        $resultado = $this->db->get('usuarios_sistema')->row();
        
        // Si existe el usuario
        if (count($resultado) == 1) {
            // se retorna verdadero
            return $resultado;
        } else {
            // se retorna falso
            return false;
        }
    }

    /**
     * Valida que la clave ingresada por el usuario corresponda a la que está
     * guardada en la tabla de asociados
     * 
     * @param int $documento
     *            Número de documento
     * @param int $id_empresa
     *            Id de la empresa a la que pertenece el asociado
     * @param string $password
     *            Contraseña en sha1
     * @return boolean Exito
     */
    function validar_clave_transferencia($documento, $id_empresa, $password)
    {
        $this->db->where('Clave_Transferencia', $password);
        $this->db->where('id_Empresa', $id_empresa);
        $this->db->where('Identificacion', $documento);
        
        // Si la clave es correcta
        if ($this->db->get('asociados')->row()) {
            // se retorna verdadero
            return true;
        }
    } // validar_clave_transferencia
}
/* Fin del archivo inicio_model.php */
/* Ubicación: ./application/models/inicio_model.php */