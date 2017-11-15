<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Transferencia solidaria
 * 
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
Class Transferencia extends CI_Controller{
	function __construct() {
        parent::__construct();

        /*//Si no ha iniciado sesión o es usuario responsable
        if(!$this->session->userdata('id_usuario') || $this->session->userdata('tipo') == '2'){
            //Se cierra la sesion obligatoriamente
            redirect('inicio/cerrar_sesion');
        }//Fin if
        */
        
        //Carga de modelos
        $this->load->model(array('transferencia_model'));
    }

    /**
	 * [index description]
	 * @return [type] [description]
	 */
	function index(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Transferencia solidaria';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'transferencia/index_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
	}

    function buscar_asociado(){
        //Se recibe el número de documento por post
        $documento = $this->input->post('documento');
        $id_empresa = $this->input->post('id_empresa');

        //Se ejecuta el modelo
        $busqueda = $this->transferencia_model->buscar_asociado($documento, $id_empresa);

        // Si lo encuentra
        if (count($busqueda) != 0) {
            print json_encode($busqueda);
        }else{
            echo "false";
        }
    }

    function calcular_compras(){
        //Se reciben los datos por post
        $datos = $this->input->post('datos');

        //Suiche
        switch ($this->input->post('tipo')) {
            // Si son las compras del año seleccionado
            case 'anio_seleccionado':
                //Se ejecuta el modelo
                $total = $this->transferencia_model->compras_anio_seleccionado($datos);

                //Si se recibe un valor
                if($total != "false"){
                    //Lo retorna
                    print json_encode($total);
                }else{
                    //Devuelve vacío
                    print json_encode(array("Total_Compras" => 0));
                }
                break;

            // Si son las compras del año actual
            case 'anio_actual':
                //Se ejecuta el modelo
                $total = $this->transferencia_model->compras_anio_actual($datos);

                //Si se recibe un valor
                if($total != "false"){
                    //Lo retorna
                    print json_encode($total);
                }else{
                    //Devuelve vacío
                    print json_encode(array("Total_Compras" => 0));
                }
                break; 

            // Si son las compras del año actual
            case 'ultimos_meses':
                //Se ejecuta el modelo
                $total = $this->transferencia_model->compras_ultimos_meses($datos);

                //Si se recibe un valor
                if($total != "false"){
                    //Lo retorna
                    print json_encode($total);
                }else{
                    //Devuelve vacío
                    print json_encode(array("Total_Compras" => 0));
                }
                break;
        }

        
    }
}
/* Fin del archivo transferencia.php */
/* Ubicación: ./application/controllers/transferencia.php */