<?php

/**
 * Modelo encargado de gestionar toda la informacion relacionada al balance social
 * 
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
class Balance_model extends CI_Model
{

    function actualizar($datos, $id_variable)
    {
        $this->db->where('intCodigo', $id_variable);
        if ($this->db->update('estructuras', $datos)) {
            // Retorna verdadero
            return true;
        }
    }

    function actualizar_peso($id, $datos)
    {
        $this->db->where('intCodigo', $id);
        if ($this->db->update('estructuras', $datos)) {
            // Retorna verdadero
            return true;
        }
    }

    function borrar_valores_reales($id_balance, $datos)
    {
        $this->db->where('id_balance', $id_balance);
        
        if ($this->db->update('estructuras', $datos)) {
            // Retorna verdadero
            return 'true';
        }
    }

    function cargar($tipo, $anio, $id_conector, $id_oficina)
    {
        // Id de oficina cuando se seleccionan todas
        $oficina = "";
        
        // Si
        if ($id_oficina != "0") {
            $oficina = " AND balances.id_agencia = {$id_oficina} ";
        }
        
        // Si tiene conector
        if ($id_conector) {
            $conector = " AND estructuras.id_conector = {$id_conector}";
        } else {
            $conector = "";
        }
        
        $sql = "SELECT
        *
        FROM
        balances
        INNER JOIN estructuras ON estructuras.id_balance = balances.id_balance
        WHERE
        balances.Estado = 1 AND
        estructuras.tipo = '{$tipo}' AND
        balances.id_empresa = {$this->session->userdata('id_empresa')}
        AND balances.ano = {$anio}
        {$conector}
        {$oficina}
        ORDER BY strNombre";
        
        return $this->db->query($sql)->result();
    }

    /**
     * [cargar_estructuras description]
     * 
     * @param [type] $tipo
     *            [description]
     * @param [type] $id_balance
     *            [description]
     * @param [type] $id_conector
     *            [description]
     * @param [type] $id_oficina
     *            [description]
     * @return [type] [description]
     */
    function cargar_estructuras($tipo, $id_balance, $id_conector, $id_oficina)
    {
        // Id de oficina cuando se seleccionan todas
        $oficina = "";
        
        // Si trae oficina
        if ($id_oficina != "0") {
            $oficina = " AND balances.id_agencia = {$id_oficina} ";
        }
        
        // Si tiene conector
        if ($id_conector) {
            $conector = " AND estructuras.id_conector = {$id_conector}";
        } else {
            $conector = "";
        }
        
        $sql = "SELECT
        *
        FROM
        estructuras
        INNER JOIN balances ON estructuras.id_balance = balances.id_balance
        WHERE
        estructuras.tipo = '{$tipo}' 
        AND balances.id_balance = {$id_balance} 
        {$oficina} 
        {$conector}";
        
        return $this->db->query($sql)->result();
    }

    function cargar_balances($anio)
    {
        $sql = "SELECT
        balances.id_balance,
        balances.ano,
        din_agencias.strNombre,
        din_agencias.intCodigo AS id_oficina
        FROM
        balances
        INNER JOIN din_agencias ON balances.id_agencia = din_agencias.intCodigo
        WHERE
        balances.ano = {$anio} AND
        balances.id_empresa = {$this->session->userdata('id_empresa')}";
        
        return $this->db->query($sql)->result();
    }

    function cargar_categorias($id_balance)
    {
        $sql = "SELECT
        *
        FROM
        balances
        INNER JOIN estructuras ON estructuras.id_balance = balances.id_balance
        WHERE
        balances.Estado = 1 AND
        estructuras.tipo = 'C' AND
        balances.id_empresa = {$this->session->userdata('id_empresa')} AND
        balances.id_balance = {$id_balance}";
        
        return $this->db->query($sql)->result();
    }

    function cargar_dimensiones($id_categoria)
    {
        $this->db->select('*');
        $this->db->where('tipo', 'D');
        $this->db->where('id_conector', $id_categoria);
        
        return $this->db->get('estructuras')->result();
    }

    function cargar_pesos($tipo, $id_balance, $id_conector)
    {
        $sql = "SELECT
        estructuras.intCodigo,
        estructuras.strNombre,
        estructuras.descripcion,
        estructuras.peso
        FROM
        balances
        INNER JOIN estructuras ON estructuras.id_balance = balances.id_balance
        WHERE
        balances.id_balance = {$id_balance} AND
        estructuras.tipo = '{$tipo}' AND estructuras.id_conector = '{$id_conector}'
        ORDER BY estructuras.strNombre";
        
        return $this->db->query($sql)->result();
    }

    function cargar_variables_usuario($anio, $id_oficina, $tipo)
    {
        switch ($tipo) {
            case 'C':
                $tipo = "GROUP BY id_categoria";
                break;
            
            case null:
                $tipo = "";
                break;
        }
        // Id de oficina cuando se seleccionan todas
        $oficina = "";
        
        // Si
        if ($id_oficina != "0") {
            $oficina = " AND balances.id_agencia = {$id_oficina} ";
        }
        
        $sql = "SELECT
        estructuras.intCodigo AS id_variable,
        estructuras.id_conector AS conector,
        (SELECT
        estructuras.intCodigo
        FROM
        estructuras
        WHERE
        estructuras.intCodigo = conector) AS id_dimension,
        (SELECT
        estructuras.id_conector
        FROM
        estructuras
        WHERE
        estructuras.intCodigo =id_dimension) as id_categoria,
        estructuras.strNombre
        FROM
        balances
        INNER JOIN estructuras ON estructuras.id_balance = balances.id_balance
        WHERE
        balances.Estado = 1 AND
        balances.id_empresa = {$this->session->userdata('id_empresa')} AND
        balances.ano = {$anio} AND
        estructuras.modo_ingreso = 1 AND
        estructuras.fuente = {$this->session->userdata('id_usuario')}
        {$oficina}
        {$tipo}";
        
        return $this->db->query($sql)->result();
    }

    function cargar_variables_usuario2($anio, $id_oficina, $tipo)
    {
        $sql = "SELECT
        estructuras.intCodigo AS id_variable,
        estructuras.id_conector AS id_dimension,
        (SELECT
            estructuras.id_conector
            FROM
            estructuras
            WHERE
            estructuras.intCodigo =id_dimension) AS id_categoria,
        estructuras.strNombre
        FROM
        estructuras
        INNER JOIN balances ON estructuras.id_balance = balances.id_balance
        WHERE
        balances.Estado = 1 AND
        balances.ano = {$anio} AND
        estructuras.modo_ingreso = 1 AND
        estructuras.fuente = {$this->session->userdata('id_usuario')} AND
        estructuras.tipo = 'V' AND
        balances.id_agencia = {$id_oficina}
        GROUP BY
        estructuras.id_conector";
        
        return $this->db->query($sql)->result();
    }

    /**
     * [cargar_variable description]
     * 
     * @param [type] $id_variable
     *            [description]
     * @return [type] [description]
     */
    function cargar_variable($id_variable)
    {
        $this->db->where('intCodigo', $id_variable);
        $this->db->select('*');
        return $this->db->get('estructuras')->row();
    }

    function cargar_variable_reporte($id_variable)
    {
        $sql = "SELECT
        estructuras.intCodigo,
        estructuras.id_conector,
        estructuras.strNombre,
        estructuras.descripcion,
        estructuras.tipo,
        estructuras.peso,
        estructuras.id_balance,
        estructuras.modo_ingreso,
        estructuras.fuente,
        estructuras.id_variable_comparacion,
        SUM(e_p + f_p + mr_p + a_p + m_p + j_p + jl_p + ag_p + s_p + o_p + n_p + d_p) AS Presupuestado,
        SUM(e_r + f_r + mr_r + a_r + m_r + j_r + jl_r + ag_r + s_r + o_r + n_r + d_r ) AS Reales
        FROM
        estructuras
        WHERE
        estructuras.intCodigo = {$id_variable}";
        
        return $this->db->query($sql)->row();
    }

    function cargar_filtros()
    {
        $sql_ = "SELECT
        filtros_creados.intCodigo,
        filtros_creados.strNombre
        FROM
        filtros_creados
        INNER JOIN usuarios_sistema ON filtros_creados.id_asociado = usuarios_sistema.intCodigo
        WHERE
        usuarios_sistema.id_empresa = {$this->session->userdata('id_empresa')}
        ORDER BY filtros_creados.strNombre";
        
        $sql = "SELECT
            filtros_creados.intCodigo,
            filtros_creados.strNombre
        FROM
            filtros_creados
            INNER JOIN usuarios_sistema ON filtros_creados.id_usuario = usuarios_sistema.intCodigo
        WHERE
            filtros_creados.es_sistema = 1 OR
            usuarios_sistema.id_empresa = {$this->session->userdata('id_empresa')}
        ORDER BY filtros_creados.strNombre";
        
        return $this->db->query($sql)->result();
    }

    function consultar($id_variable)
    {
        $this->db->where('intCodigo', $id_variable);
        $this->db->select('*');
        $resultado = $this->db->get('estructuras')->row();
        
        return $resultado->id_conector;
    }

    function consultar_balance($anio, $id_oficina)
    {
        $this->db->where('ano', $anio);
        $this->db->where('id_agencia', $id_oficina);
        $this->db->select('*');
        
        return $this->db->get('balances')->row();
    }

    function consultar_datos_balance($id_estructura)
    {
        $sql = "SELECT
        balances.id_balance,
        balances.ano,
        balances.id_agencia
        FROM
        balances
        WHERE
        balances.id_balance = 
        (SELECT
        estructuras.id_balance
        FROM
        estructuras
        WHERE
        estructuras.intCodigo = {$id_estructura})";
        
        return $this->db->query($sql)->row();
    }

    function consultar_estructuras($tipo, $id_balance, $id_conector)
    {
        $this->db->where('id_balance', $id_balance);
        $this->db->where('id_conector', $id_conector);
        $this->db->where('tipo', $tipo);
        $this->db->order_by('strNombre');
        return $this->db->get('estructuras')->result();
    }

    function consultar_balanceo($tipo, $id_balance, $id_conector)
    {
        $sql = "SELECT
        SUM(estructuras.peso) AS Peso
        FROM
        estructuras
        WHERE
        estructuras.tipo = '{$tipo}' AND
        estructuras.id_balance = {$id_balance} AND
        estructuras.id_conector = {$id_conector}";
        
        $resultado = $this->db->query($sql)->row();
        
        return $resultado->Peso;
    }

    function crear($tipo, $datos)
    {
        switch ($tipo) {
            case 'balance':
                // Se ejecuta el modelo que guarda los datos
                $guardar = $this->db->insert('balances', $datos);
                break;
            
            default:
                // code...
                break;
        } // suiche
          
        // Si el registro es exitoso
        if ($guardar) {
            // Retorna verdadero
            return 'true';
        }
    }

    function eliminar($tipo, $id)
    {
        // Suiche
        switch ($tipo) {
            case 'balance':
                // Si Se borra
                if ($this->db->delete('balances', array(
                    'id_balance' => $id
                ))) {
                    // se retorna verdadero
                    return true;
                } else {
                    return 'error';
                }
                break;
            
            case 'estructuras':
                // Si Se borra
                if ($this->db->delete('estructuras', array(
                    'id_balance' => $id
                ))) {
                    // se retorna verdadero
                    return true;
                }
                break;
            
            case 'categoria':
                // Si Se borra
                if ($this->db->delete('estructuras', array(
                    'intCodigo' => $id
                ))) {
                    // se retorna verdadero
                    return true;
                }
                break;
            
            case 'variables':
                // Si Se borra
                if ($this->db->delete('estructuras', array(
                    'id_conector' => $id
                ))) {
                    // se retorna verdadero
                    return true;
                }
                break;
        }
    }

    function guardar($datos)
    {
        // Se ejecuta el modelo que guarda los datos
        $guardar = $this->db->insert('estructuras', $datos);
        
        // Si el registro es exitoso
        if ($guardar) {
            // Retorna verdadero
            return true;
        }
    }

    function listar_anios()
    {
        $sql = "SELECT
        id_balance,
        ano
        FROM
        balances
        WHERE
        balances.ano > 1 AND
        balances.id_empresa = {$this->session->userdata('id_empresa')}
        GROUP BY
        balances.ano";
        
        return $this->db->query($sql)->result();
    }

    function metas_porcentajes()
    {
        $this->db->select("*");
        $this->db->where("id_empresa", $this->session->userdata('id_empresa'));
        return $this->db->get('metas')->row();
    }

    function validar($datos)
    {
        $this->db->where($datos);
        
        $resultado = $this->db->get('balances')->row();
        
        // Si retorna un registro
        if (count($resultado) == 1) {
            return $resultado->id_balance;
        } else {
            return 'false';
        }
    }
}
/* Fin del archivo balance_model.php */
/* Ubicación: ./application/models/balance_model.php */