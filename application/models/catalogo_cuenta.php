<?php

/**
 * Modelo encargado de gestionar toda la informacion relacionada al cliente
 *
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
class catalogo_cuenta extends CI_Model
{

    private $dimensionesSituacionFinanciera;

    public function __construct()
    {
        $this->load->database();
        $this->load->model('balance_model');
        $this->dimensionesSituacionFinanciera = [
            'A. Activo',
            'B. Pasivo',
            'C. Patrimonio',
            'D. Ingresos',
            'E. Gastos',
            'F. Costo De Ventas',
            'G. Costos De Producción O De Operación',
            'H. Cuentas de Revelación de Información Financiera - Deudoras',
            'I. Cuentas de Revelación de Información Financiera - Acreedoras'
        ];
    }

    public function validate_situacion_finaciera_exist($idBalance, $mes, $cuenta = '3. SITUACION FINANCIERA')
    {
        $situacionFinciera = $this->getEstructuras($idBalance, $cuenta);
        foreach ($situacionFinciera as $estructura) {
            $id_categoria = $estructura['intCodigo'];
            // Se consultan y se recorren todas las dimensiones existentes de la categoría seleciconada
            foreach ($this->balance_model->cargar_dimensiones($id_categoria) as $dimension) {
                // Se borran todas las structuras de esa dimensión
                $this->balance_model->eliminar("estructuras", $dimension->intCodigo);
            }
            // Se eliminan las dimensiones de la categoria
            $this->balance_model->eliminar("estructuras", $id_categoria);
            // Por último, se elimina la categoría
            $this->balance_model->eliminar('categoria', $id_categoria);
        }
        // Crear de nuevo la estructura.
        $this->create_situacion_finciera($idBalance, $mes);
    }

    private function create_situacion_finciera($idBalance, $mes)
    {
        $strNombre = '8. SITUACION FINANCIERA';
        $this->add_estructura($strNombre, 0, 'C', $idBalance, 1, $mes);
        $situacionFinciera = $this->getEstructura($idBalance, $strNombre, 'C');
        if (! empty($situacionFinciera)) {
            foreach ($this->dimensionesSituacionFinanciera as $clave => $nombre) {
                $this->add_estructura($nombre, $situacionFinciera['intCodigo'], 'D', $idBalance, 1, $mes);
            }
        }
    }

    private function getIdConector($nombreCuenta, $dimensiones)
    {
        $codigo = 0;
        foreach ($dimensiones as $value) {
            if ($nombreCuenta == $value['strNombre']) {
                $codigo = $value['intCodigo'];
            }
        }
        return $codigo;
    }

    public function add_variables($row, $idBalance, $mes, $año, $dimensiones)
    {
        if (! empty($idBalance) && array_key_exists('CUENTA', $row)) {
            $firstDigitByCode = substr($row['CUENTA'], 0, 1);
            $nombre = $row['CUENTA'] . ' ' . $row['DESCRIPCION_DE_LA_CUENTA'];
            switch ($firstDigitByCode) {
                case 1:
                    $idConector = $this->getIdConector($this->dimensionesSituacionFinanciera[0], $dimensiones);
                    break;
                case 2:
                    $idConector = $this->getIdConector($this->dimensionesSituacionFinanciera[1], $dimensiones);
                    break;
                case 3:
                    $idConector = $this->getIdConector($this->dimensionesSituacionFinanciera[2], $dimensiones);
                    break;
                case 4:
                    $idConector = $this->getIdConector($this->dimensionesSituacionFinanciera[3], $dimensiones);
                    break;
                case 5:
                    $idConector = $this->getIdConector($this->dimensionesSituacionFinanciera[4], $dimensiones);
                    break;
                case 6:
                    $idConector = $this->getIdConector($this->dimensionesSituacionFinanciera[5], $dimensiones);
                    break;
                case 7:
                    $idConector = $this->getIdConector($this->dimensionesSituacionFinanciera[6], $dimensiones);
                    break;
                case 8:
                    $idConector = $this->getIdConector($this->dimensionesSituacionFinanciera[7], $dimensiones);
                    break;
                case 9:
                    $idConector = $this->getIdConector($this->dimensionesSituacionFinanciera[8], $dimensiones);
                    break;
            }
            if ($idConector > 0) {
                $this->add_estructura($nombre, $idConector, 'V', $idBalance, 1, $mes, 0, $row['Saldo']);
            }
        }
    }

    public function add_estructura($nombre, $codigo_conector, $tipo, $idBalance, $modo_ingreso, $mes, $idFiltro = 0, $saldo = 0)
    {
        $structura = new stdClass();
        $structura->strNombre = $nombre;
        $structura->tipo = $tipo;
        $structura->id_conector = $codigo_conector;
        $structura->id_balance = $idBalance;
        $structura->modo_ingreso = $modo_ingreso;
        $structura->peso = 0;
        $structura->fuente = $idFiltro;
        $structura->modo_ingreso_ = 1;
        $structura->id_variable_comparacion = 0;
        $structura->es_titulo = 0;
        switch ($mes) {
            case 1:
                $structura->e_r = $saldo;
                break;

            case 2:
                $structura->f_r = $saldo;
                break;
            case 3:
                $structura->mr_r = $saldo;
                break;
            case 4:
                $structura->a_r = $saldo;
                break;
            case 5:
                $structura->m_r = $saldo;
                break;
            case 6:
                $structura->j_r = $saldo;
                break;
            case 7:
                $structura->jl_r = $saldo;
                break;
            case 8:
                $structura->a_r = $saldo;
                break;
            case 9:
                $structura->s_r = $saldo;
                break;
            case 10:
                $structura->o_r = $saldo;
                break;
            case 11:
                $structura->n_r = $saldo;
                break;
            case 12:
                $structura->d_r = $saldo;
                break;
            default:
                $saldo = 0;
                break;
        }
        return $this->balance_model->guardar($structura);
    }

    public function getEstructura($idBalance, $strNombre, $tipo)
    {
        $this->db->select('*');
        $this->db->from('estructuras');
        $this->db->where('strNombre', $strNombre);
        $this->db->where('id_balance', $idBalance);
        $this->db->where('tipo', $tipo);
        return $this->db->get()->row_array();
    }

    public function getEstructuras($idBalance, $validateText)
    {
        $this->db->select('*');
        $this->db->from('estructuras');
        $this->db->where('strNombre', $validateText);
        $this->db->where('id_balance', $idBalance);
        $this->db->where('tipo', 'C');
        return $this->db->get()->result_array();
    }

    public function get_codes_by_dimension($idBalance)
    {
        $this->db->select('intCodigo, strNombre');
        $this->db->from('estructuras');
        $this->db->where('id_balance', $idBalance);
        $this->db->where('modo_ingreso', 1);
        $this->db->where_in('strNombre', $this->dimensionesSituacionFinanciera);
        return $this->db->get()->result_array();
    }
}