<?php

/**
 * Modelo encargado de gestionar toda la informacion relacionada al cliente
 *
 * @author 		       Esteban Palomino
 */
class Import_model extends CI_Model
{

    public $tablaDB;

    public function __construct()
    {
        $this->load->database();
    }

    public function load_model($tblName)
    {
        $this->tablaDB = $tblName;
    }

    public function get_data($idEmpresa = FALSE)
    {
        if (! $idEmpresa) {
            $query = $this->db->get($this->tablaDb);
            return $query->result_array();
        }

        $query = $this->db->get_where($this->tablaDb, array(
            'id_empresa' => $idEmpresa
        ));
        return $query->row_array();
    }

    public function get_row_by_id($id = FALSE)
    {
        if (! $id) {
            return false;
        }

        $query = $this->db->get_where($this->tablaDB, array(
            'id_Asociado' => $id
        ));
        return $query->row_array();
    }

    public function insert_row($row)
    {
        if ($row) {
            return $this->db->insert($this->tablaDB, $row);
        }

        return false;
    }

    public function insert_multiple_rows($rows)
    {
        if (! empty($rows)) {
            return $this->db->insert_batch($this->tablaDB, $rows);
        }

        return false;
    }

    public function delete($conditions)
    {
        return $this->db->delete($this->tablaDB, $conditions);
    }

    public function execute_query($query)
    {
        return $this->db->query($query);
    }

    public function get_productoId($tipo, $idEmpresa, $conditionText = '', $codigo = '')
    {
        $this->db->select('intCodigo');
        $this->db->from('productos');
        $this->db->where('Id_Empresa', $idEmpresa);
        if (! empty($conditionText)) {
            $this->db->where('strNombre', $conditionText);
        }

        if ($codigo) {
            $this->db->where('intCodigo', $codigo);
        }

        return $this->db->limit(1)
            ->get()
            ->row_array();
    }

    // TODO: validar cuando se debe actualizar un asociado ya que no tiene sentido
    // TODO: hacer esto
    public function add_directivo($directivo_value, $idEmpresa)
    {
        $this->db->select('*');
        $this->db->from($this->tablaDB);
        $this->db->where('Nit', $directivo_value['Nit']);
        $this->db->where('Id_empresa', $idEmpresa);
        if ($this->db->count_all_results() == 0) {
            $directivo = new stdClass();
            $directivo->Id_empresa = $idEmpresa;
            $directivo->Id_TipoDirectivo = $directivo_value['Id_TipoDirectivo'];
            $directivo->TipoIden = $directivo_value['TipoIden'];
            $directivo->Nit = $directivo_value['Nit'];
            $fechaNombramiento = str_ireplace('/', '-', $directivo_value['FechaNombra']);
            $directivo->FechaNombra = date('Y-m-d', strtotime($fechaNombramiento));
            $directivo->EmpresaRevisorFiscal = $directivo_value['EmpresaRevisorFiscal'];
            $directivo->TarjetaProfRevisorFiscal = $directivo_value['TarjetaProfRevisorFiscal'];
            $fechaPosesion = $directivo_value['FechaPosesion'] ? $directivo_value['FechaPosesion'] : $directivo_value['FechaNombra'];
            $fechaPosesion = str_ireplace('/', '-', $fechaPosesion);
            $directivo->FechaPosesion = date('Y-m-d', strtotime($fechaPosesion));
            $directivo->PeriodoVigencia = $directivo_value['PeriodoVigencia'];
            $directivo->Parentescos = $directivo_value['Parentescos'];
            $directivo->Vinculadas = $directivo_value['Vinculadas'];
            $this->insert_row($directivo);
            // Se busca que si esta en la tabla asociados por el id.
            $conditionsUpdate = [];
            $tipoDirectivoJunta = [
                2,
                10,
                12
            ];
            $tipoDirectivoConsejero = [
                7,
                1,
                9
            ];
            $tipoDirectivoComites = [
                8,
                11
            ];
            // Get Fechas nombramiento y vigencia.
            $vigencia = '+' . $directivo_value['PeriodoVigencia'] . ' year';
            $nuevafecha = strtotime($vigencia, strtotime($fechaPosesion)); // Se añade un año mas
            $fechaFin = date('Y-m-d', $nuevafecha);
            $fechaPosesion = date('Y-m-d', strtotime($fechaPosesion));
            if (in_array($directivo_value['Id_TipoDirectivo'], $tipoDirectivoConsejero)) {
                $conditionsUpdate['EstadocomoConsejero'] = 1;
                $conditionsUpdate['Fecha_Inicio_Consejero'] = $fechaPosesion;
                $conditionsUpdate['Fecha_fin_Consejero'] = $fechaFin;
            } else if (in_array($directivo_value['Id_TipoDirectivo'], $tipoDirectivoJunta)) {
                $conditionsUpdate['EstadocomoJuntadeVigilancia'] = 1;
                $conditionsUpdate['Fecha_Inicio_Junta'] = $fechaPosesion;
                $conditionsUpdate['Fecha_fin_Junta'] = $fechaFin;
            } else if (in_array($directivo_value['Id_TipoDirectivo'], $tipoDirectivoComites)) {
                $conditionsUpdate['EstadoenComites'] = 1;
                $conditionsUpdate['Fecha_Inicio_Comites'] = $fechaPosesion;
                $conditionsUpdate['Fecha_fin_Comites'] = $fechaFin;
            }
            if (! empty($conditionsUpdate)) {
                $this->db->where('Identificacion', $directivo_value['Nit']);
                $this->db->where('Id_Empresa', $idEmpresa);
                $this->db->update('asociados', $conditionsUpdate);
            }
        }
    }

    public function add_usuario_sistema($usuario_value, $idEmpresa)
    {
        $usuario = new stdClass();
        $usuario->Identificacion = $usuario_value['Identificacion'];
        $usuario->Id_empresa = $idEmpresa;
        $usuario->Estado = $usuario_value['Estado'];
        $usuario->id_filtro_por_defecto = $usuario_value['id_filtro_por_defecto'];
        $usuario->id_tipo_usuario = $usuario_value['id_tipo_usuario'];
        $usuario->login = $usuario_value['login'];
        $usuario->password = sha1('12345_feval');
        $usuario->strNombre = $usuario_value['strNombre'];
        $this->insert_row($usuario);
    }

    public function get_balance_id($idEmpresa, $año)
    {
        $this->db->select('id_balance');
        $this->db->from('balances');
        $this->db->where('id_empresa', $idEmpresa);
        $this->db->where('ano', $año);
        return $this->db->limit(1)
            ->get()
            ->row_array();
    }

    public function add_clave_transferecia($clave_value, $idEmpresa)
    {
        $usuario = new stdClass();
        $usuario->identificacion = $idEmpresa . '-' . $clave_value['Identificacion'];
        $usuario->Id_empresa = $idEmpresa;
        $usuario->clave_transferencia = sha1($idEmpresa . '-' . $clave_value['Identificacion']);
        $this->insert_row($usuario);
        $data = [
            'Clave_Transferencia' => $usuario->clave_transferencia,
            'Fecha_Cambio_Clave' => date('Y-m-d')
        ];
        $this->db->where('Identificacion', $clave_value['Identificacion']);
        $this->db->where('Id_Empresa', $idEmpresa);
        $this->db->update('asociados', $data);
    }

    public function add_tasa_mercado($tasa_value, $idEmpresa)
    {
        $this->db->select('*');
        $this->db->from($this->tablaDB);
        $this->db->where('Mes', $tasa_value['Mes']);
        $this->db->where('Ano', $tasa_value['Ano']);
        $this->db->where('id_empresa', $idEmpresa);
        $this->db->where('Id_Producto', $tasa_value['Id_Producto']);
        if ($this->db->count_all_results() == 0) {
            $tasa = new stdClass();
            $tasa->Tasa = str_replace(',', '.', $tasa_value['Tasa']);
            $tasa->Id_empresa = $idEmpresa;
            $tasa->Mes = $tasa_value['Mes'];
            $tasa->Ano = $tasa_value['Ano'];
            $producto = $this->get_productoId('tasa', $idEmpresa, '', $tasa_value['Id_Producto']);
            if ($producto > 0) {
                $tasa->Id_Producto = $tasa_value['Id_Producto'];
                $this->insert_row($tasa);
            }
        }
    }

    public function get_tasa_mercado($idProducto, $ano, $mes, $idEmpresa)
    {
        $this->db->select('Tasa');
        $this->db->from('tasa_mercado');
        $this->db->where('Id_Producto', $idProducto);
        $this->db->where('id_Empresa', $idEmpresa);
        return $this->db->limit(1)
            ->get()
            ->row_array();
    }

    public function get_asociado($identificacion, $idEmpresa)
    {
        $this->db->select('*');
        $this->db->from('asociados');
        $this->db->where('Id_Empresa', $idEmpresa);
        $this->db->where('Identificacion', $identificacion);
        $result = $this->db->get()->row_array();
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

    public function get_edad($fecha)
    {
        $fecha = str_replace("/", "-", $fecha);
        $fecha = date('Y/m/d', strtotime($fecha));
        $hoy = date('Y/m/d');
        $edad = $hoy - $fecha;
        return $edad;
    }
}