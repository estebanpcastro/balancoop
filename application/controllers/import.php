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
        $this->load->library('csvimport');
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
                $rows = $this->csvimport->get_array($_FILES["file"]["tmp_name"], FALSE, TRUE, 3, ';');
                $idEmpresa = $this->session->userdata('id_empresa');
                $this->validateIfCleanTable($categoria, $idEmpresa);
                $this->importRows($rows, $categoria, $idEmpresa);
                print json_encode(TRUE);
            }
        }
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
            'productos',
            'directivos',
            'usuarios_sistema',
            'clave_transferencia',
            'filtros_creados',
            'filtros_creados_productos',
        ];
        // Borrar data de las tablas por id_empresa
        if (in_array($tablaDb, $tablesToDelete) && $idEmpresa) {
            $condition = ['id_Empresa' => $idEmpresa];
            $this->import_model->delete($condition);
        }
    }


    protected function importRows($rows, $tablaDb, $idEmpresa) {
        if ($tablaDb == 'catalogo_cuentas' && $rows) {
            $balance = $this->import_model->get_balance_id($idEmpresa, 2017);
            if (!empty($balance)) {
                $this->catalogo_cuenta->validate_situacion_finaciera_exist($balance['id_balance']);
                $dimensiones = $this->catalogo_cuenta->get_codes_by_dimension($balance['id_balance'], 2017);
            }
        }

        if ($tablaDb == 'productos' && $rows) {
            $conditionsDel = ['id_empresa' => $idEmpresa];
            $this->db->delete('filtros_creados', $conditionsDel);
            $this->db->delete('filtros_creados_productos', $conditionsDel);
            $balance = $this->import_model->get_balance_id($idEmpresa, 2017);
            if (!empty($balance)) {
                $estructurasProductos = [];
                $estructurasProductos[] = $this->catalogo_cuenta->getEstructura($balance['id_balance'], '5. UTILIZACION DE SERVICIOS FINANCIEROS', 'D');
                $estructurasProductos[] = $this->catalogo_cuenta->getEstructura($balance['id_balance'], ' 6. UTILIZACION DE SERVICIOS DE AREA SOCIAL (NO FINANCIEROS)', 'D');
            }
        }

        $codigoAgencia = $this->session->userdata('codigo_agencia');
        $idUsuario = $this->session->userdata('id_usuario');
        $mes = $this->session->userdata('mes');
        $ano = $this->session->userdata('anio');
        foreach ($rows as $row) {
            switch ($tablaDb) {
                case 'asociados':
                    $this->asociado->add_asociado($row, $idEmpresa, $codigoAgencia);
                    break;
                case 'aportes':
                    $this->cliente_producto->add_aporte($row, $idEmpresa, $codigoAgencia, $idUsuario);
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
                    $this->producto->add_producto($row, $idEmpresa, $balance['id_balance'], $estructurasProductos,$idUsuario);
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
                case 'cliente_producto_credito':
                    $this->cliente_producto->add_cliente_producto_credito($row, $idEmpresa, $mes, $ano, $codigoAgencia, $idUsuario);
                    break;
                case 'cliente_producto_captacion':
                    $this->cliente_producto->add_cliente_producto_captacion($row, $idEmpresa, $mes, $ano, $codigoAgencia, $idUsuario);
                    break;
                case 'cliente_producto_social':
                    $this->cliente_producto->add_cliente_producto_social($row, $idEmpresa, $codigoAgencia, $idUsuario);
                    break;
                case 'catalogo_cuentas':
                    if (!empty($dimensiones)) {
                        $this->catalogo_cuenta->add_variables($row, $balance['id_balance'], $ano, $dimensiones);
                    }
                    break;
                default:
                    null;
                    break;
            }
        }
    }

}

