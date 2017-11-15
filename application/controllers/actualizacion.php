<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Cliente
 * 
 * @author              John Arley Cano Salinas
 */
Class Actualizacion extends CI_Controller{
	function __construct() {
        parent::__construct();

        //Carga de modelos
        $this->load->model(array('cliente_model'));
    }

	function index(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Actualizar datos';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'cliente/actualizacion_datos/cliente_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }

    function nueva_sesion_empresa(){
        $this->session->set_userdata("id_empresa", $this->input->post("id_empresa"));
    }
}
/* Fin del archivo actualizacion.php */
/* Ubicación: ./application/controllers/actualizacion.php */
?>