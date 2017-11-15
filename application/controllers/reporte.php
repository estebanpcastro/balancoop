<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

//Se carga la librer&iacute;a de PDF y la libreria de impresion rapida
require('system/libraries/Fpdf.php');

//Definir la ruta de las fuentes
define('FPDF_FONTPATH','system/fonts/');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Balance
 * 
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
Class Reporte extends CI_Controller{
	function __construct() {
        parent::__construct();

        //Si no ha iniciado sesión o es usuario responsable
        if(!$this->session->userdata('id_usuario') || $this->session->userdata('tipo') == '2'){
            //Se cierra la sesion obligatoriamente
            redirect('inicio/cerrar_sesion');
        }//Fin if
        
        // Carga de modelos y librerías
        $this->load->model(array('balance_model', 'listas_model', 'crm_model', 'reporte_model', 'filtro_model', 'transferencia_model'));
        $this->load->library(array('PHPExcel'));

        //Carga de listas desplegables del formulario        
        // $this->data['oficinas'] =  $this->listas_model->cargar_empresa('din_agencias', $this->session->userdata('id_empresa'));               
    }

    function index(){
        /*//se establece el titulo de la pagina
        $this->data['titulo'] = 'Reportes';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'reporte/index_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);*/
    }

    function balance_social(){
    	//Se carga la vista que contiene el reporte
        $this->load->view('reporte/pdf/balance_social');
    }

    function campana(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Reporte de campaña';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'reporte/campana/index_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }

    function crm_productos(){
        $producto = $this->uri->segment(3);

        $this->data['producto'] = str_replace('_', ' ', $producto);

        $this->data['asociados'] = $this->crm_model->consultar_asociados_producto($this->uri->segment(3));

        $this->load->view('reporte/excel/crm_productos', $this->data);
    }

    function formato_importacion(){
        $this->data['tabla'] = $this->uri->segment(3);

        $this->load->view('reporte/excel/formato_importacion', $this->data);
    }

    function producto(){
        // $this->data['id_asociado']
        //Se carga la vista que contiene el reporte
        $this->load->view('reporte/pdf/producto');
    }

    function transferencia_solidaria(/*$id_empresa, $id_oficina, $identificacion, $anio*/){
        $this->load->view('reporte/pdf/transferencia_solidaria');
    }
}
/* Fin del archivo reporte.php */
/* Ubicación: ./application/controllers/reporte.php */