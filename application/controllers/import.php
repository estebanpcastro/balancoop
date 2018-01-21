<?php
//Zona horaria

//Ejecucion
//php index.php importdata import_mysql asociados 2
//php index.php importdata import_mysql aportes 2

date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Cliente
 *
 * @author              John Arley Cano Salinas
 */
Class Import extends CI_Controller{

    function __construct() {
        parent::__construct();

        //Si no ha iniciado sesión o es usuario responsable
        if(!$this->session->userdata('id_usuario') || $this->session->userdata('tipo') == '2'){
            //Se cierra la sesion obligatoriamente
            redirect('inicio/cerrar_sesion');
        }
        $this->load->model(array('import_model','catalogo_cuenta', 'producto', 'cliente_producto', 'asociado'));
        $this->load->library(array('csvimport'));
    }

    function import_oracle($tablaDb, $idEmpresa = 0) {
        $this->load->library('importfromoracle');
        $this->importfromoracle->connect_db('balancoop', '1234', 'XE', 'localhost');
        $query = 'SELECT * FROM '.$tablaDb;
        $rows = $this->importfromoracle->execute_query($query);
        $this->importfromoracle->disconnect_db();
        $this->validateIfCleanTable($tablaDb, $idEmpresa);
        $this->importRows($rows, $tablaDb, $idEmpresa);
    }

    function import_mysql($tablaDb, $idEmpresa = 0) {
        $this->load->library('importfrommysql');
        $this->importfrommysql->connect_db('root', '', 'balancoop_cliente', 'localhost');
        $query = "SELECT * FROM {$tablaDb} limit 300";
        $rows = $this->importfrommysql->execute_query($query);
        $this->importfrommysql->disconnect_db();
        $this->validateIfCleanTable($tablaDb, $idEmpresa);
        $this->importRows($rows, $tablaDb, $idEmpresa);

    }

    function index() {
        // Se establece el titulo de la pagina.
        $this->data['titulo'] = 'Importacion de información hacia balancoop';
        // Se carga la pagina del formulario
        $this->data['contenido_principal'] = 'importacion/cargar-datos-para-balancoop';

        //Se carga la plantilla con las demas variables.
        $this->load->view('plantillas/template', $this->data);

    }

    function importcsv() {
        if(!$this->input->is_ajax_request()){
            //Se recibe la tabla por post
            print json_encode(FALSE);
        }
        else{
            $categoria = $this->input->post('category');
            if($categoria) {
                $idEmpresa = $this->session->userdata('id_empresa');
                $mes = $this->input->post('mes');
                $ano = $this->input->post('anio');
                $codigoAgencia = $this->session->userdata('codigo_agencia');
                $idUsuario = $this->session->userdata('id_usuario');
                $tablasPesadas = ['aportes', 'cliente_producto_credito', 'cliente_producto_captacion', 'cliente_producto_social', 'revalorizacion_aportes'];
                if (in_array($categoria, $tablasPesadas)) {
                    $this->importCsvHuge($_FILES["file"]["tmp_name"], $categoria, $idEmpresa, $codigoAgencia, $idUsuario, $mes, $ano);
                }
                else {
                    $rows = $this->csvimport->get_array($_FILES["file"]["tmp_name"], FALSE, TRUE, 3, ';');
                    $this->validateIfCleanTable($categoria, $idEmpresa);
                    $this->importRows($rows, $categoria, $idEmpresa, $codigoAgencia, $idUsuario, $ano, $mes);
                }
                print json_encode(TRUE);
            }
        }
    }

    protected function importCsvHuge($file, $tablaDb, $idEmpresa, $codigoAgencia, $idUsuario, $mes, $ano) {
        $initalLine = 3;
        $columnHeaders = FALSE;
        $this->csvimport->initialze_conection($file, $columnHeaders, TRUE, $initalLine, ';');
        // Open the CSV for reading.
        $handle = $this->csvimport->get_handle();

        $row = 0;
        $clienteCreados = [];
        if ($tablaDb == 'aportes') {
            $productoAporte = $this->import_model->get_productoId('aportes', $idEmpresa, 'APORTES');
        }
        while (($data = fgetcsv($handle, 0, $this->csvimport->_get_delimiter())) !== FALSE)
        {
            if ($data[0] != NULL)
            {
                if($row < $initalLine)
                {
                    $row++;
                    continue;
                }
                // If first row, parse for column_headers
                if($row == $initalLine)
                {
                    // If column_headers already provided, use them
                    if($columnHeaders)
                    {
                        foreach ($columnHeaders as $key => $value)
                        {
                            $columnHeaders[$key] = trim($value);
                        }
                    }
                    else // Parse first row for column_headers to use
                    {
                        foreach ($data as $key => $value)
                        {
                            $key_value = str_replace(' ', '_', $value);
                            $key_final = $this->csvimport->eliminar_tildes($key_value);
                            $columnHeaders[$key] = trim($key_final);
                        }
                    }
                }
                else
                {   $result = [];
                    foreach($columnHeaders as $key => $value) // assumes there are as many columns as their are title columns
                    {
                        if (array_key_exists($key, $data)) {
                            $result[$value] = utf8_encode(trim($data[$key]));
                        }

                    }
                    switch ($tablaDb) {
                        case 'aportes':
                            if (!empty($productoAporte)) {
                                $clienteCreados = $this->cliente_producto->add_aporte($clienteCreados, $result, $idEmpresa, $codigoAgencia, $productoAporte, $idUsuario);
                            }
                            break;
                        case 'cliente_producto_credito':
                            $clienteCreados = $this->cliente_producto->add_cliente_producto_credito($clienteCreados, $result, $idEmpresa, $mes, $ano, $codigoAgencia, $idUsuario);
                            break;
                        case 'cliente_producto_captacion':
                            $clienteCreados = $this->cliente_producto->add_cliente_producto_captacion($clienteCreados, $result, $idEmpresa, $mes, $ano, $codigoAgencia, $idUsuario);
                            break;
                        case 'cliente_producto_social':
                            $clienteCreados = $this->cliente_producto->add_cliente_producto_social($clienteCreados, $result, $idEmpresa, $codigoAgencia, $idUsuario);
                            break;
                        case 'revalorizacion_aportes':
                            $clienteCreados = $this->cliente_producto->add_cliente_producto_revalorizacion($clienteCreados, $result, $idEmpresa, $codigoAgencia, $idUsuario, $ano);
                            break;
                        default:
                            null;
                            break;
                    }
                }
                unset($data);
                $row++;
            }
        }
        $this->csvimport->_close_csv();
    }

    protected function validateIfCleanTable($tablaDb, $idEmpresa) {
        $this->import_model->load_model($tablaDb);
        // Eliminar aosciados relacionados a la empresa.
        $tablesToDelete = ['asociados',
            'asociados_beneficiarios',
            'asociados_conocidos',
            'asociados_hijos',
            'asociados_conyuge',
            'asociados_motivo_retiro',
            'asociados_otros_datos',
            'directivos',
            'usuarios_sistema',
            'clave_transferencia',
        ];
        // Borrar data de las tablas por id_empresa
        if (in_array($tablaDb, $tablesToDelete) && $idEmpresa) {
            $condition = ['id_Empresa' => $idEmpresa];
            $this->import_model->delete($condition);
        }
    }


    protected function importRows($rows, $tablaDb, $idEmpresa, $codigoAgencia, $idUsuario, $ano, $mes) {
        if ($tablaDb == 'catalogo_cuentas' && $rows) {
            $balance = $this->import_model->get_balance_id($idEmpresa, $ano);
            if (!empty($balance)) {
                $this->catalogo_cuenta->validate_situacion_finaciera_exist($balance['id_balance'], $mes, '8. SITUACION FINANCIERA');
                $dimensiones = $this->catalogo_cuenta->get_codes_by_dimension($balance['id_balance']);
            }
        }

        if ($tablaDb == 'productos' && $rows) {
            $balance = $this->import_model->get_balance_id($idEmpresa, $ano);
            if (!empty($balance)) {
                $estructurasProductos = [];
                $estructurasProductos[] = $this->catalogo_cuenta->getEstructura($balance['id_balance'], '5. UTILIZACION DE SERVICIOS FINANCIEROS', 'D');
                $estructurasProductos[] = $this->catalogo_cuenta->getEstructura($balance['id_balance'], '6. UTILIZACION DE SERVICIOS DE AREA SOCIAL (NO FINANCIEROS)', 'D');
            }
        }

        foreach ($rows as $key => $row) {
            switch ($tablaDb) {
                case 'asociados':
                    $this->asociado->add_asociado($row, $idEmpresa, $codigoAgencia);
                    break;
                case 'asociados_habiles':
                    $this->asociado->add_asociado_habil($row, $idEmpresa);
                    break;
                case 'asociados_beneficiarios':
                    $this->asociado->add_asociado_beneficiario($row, $idEmpresa);
                    break;
                case 'asociados_conocidos':
                    $this->asociado->add_asociado_conocido($row, $idEmpresa);
                    break;
                case 'asociados_hijos':
                    $this->asociado->add_asociado_hijo($row, $idEmpresa);
                    break;
                case 'asociados_conyuge':
                    $this->asociado->add_asociado_conyuge($row, $idEmpresa);
                    break;
                case 'asociados_motivo_retiro':
                    $this->asociado->add_asociados_motivo_retiro($row, $idEmpresa);
                    break;
                case 'asociados_otros_datos':
                    $this->asociado->add_asociados_otros_datos($row, $idEmpresa);
                    break;
                case 'directivos':
                    $this->import_model->add_directivo($row, $idEmpresa);
                    break;
                case 'productos':
                    if (!empty($balance)) {
                        $this->producto->add_producto($row, $idEmpresa, $balance['id_balance'], $estructurasProductos, $idUsuario, $ano);
                    }
                    break;
                case 'usuarios_sistema':
                    $this->import_model->add_usuario_sistema($row, $idEmpresa);
                    break;
                case 'clave_transferencia':
                    $this->import_model->add_clave_transferecia($row, $idEmpresa);
                    break;
                case 'tasa_mercado':
                    $this->import_model->add_tasa_mercado($row, $idEmpresa);
                    break;
                case 'catalogo_cuentas':
                    if (!empty($dimensiones)) {
                        $this->catalogo_cuenta->add_variables($row, $balance['id_balance'], $mes, $ano, $dimensiones);
                    }
                    break;
                default:
                    null;
                    break;
            }
            unset($rows[$key]);
        }
    }

}

