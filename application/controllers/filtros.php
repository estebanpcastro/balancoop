<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Administracion
 * 
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
Class Filtros extends CI_Controller{
	function __construct() {
        parent::__construct();

        //Si no ha iniciado sesión o es usuario responsable
        if(!$this->session->userdata('id_usuario') || $this->session->userdata('tipo') == '2'){
            //Se cierra la sesion obligatoriamente
            redirect('inicio/cerrar_sesion');
        }//Fin if
        
        //Carga de modelos
        $this->load->model(array('filtro_model'));

        //Carga de listas desplegables del formulario
        $this->data['tipos_filtro'] = $this->listas_model->cargar('filtro_tipos');

    }

    function index(){
		//se establece el titulo de la pagina
        $this->data['titulo'] = 'Filtros';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'filtros/index';
        // $this->data['contenido_principal'] = 'filtros/index_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
	}

    function agregar($tipo){
        //Se captura el número del conocido
        $this->data['numero'] = $this->input->post('numero');           
        $this->data['datos'] = $this->input->post('datos');  
        $this->data['tipo'] = $this->input->post('tipo');  

        //Suiche
        switch ($tipo) {
            case 'campo':
                //Se carga la vista
                $this->load->view('filtros/asociados/campos', $this->data);
                break;
                
            case 'condicional':
                //Se carga la vista
                $this->load->view('filtros/asociados/condicional_view', $this->data);
                break; 

            case 'condicional_producto':
                //Se carga la vista
                $this->load->view('filtros/productos/constructor_view', $this->data);
                break; 
        } //suiche
    }

    function cambiar_filtro_por_defecto(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe el id del filtro
            $id_filtro = $this->input->post('id_filtro');

            //Se ejecuta el modelo que actualiza el filtro por defecto
            $this->filtro_model->cambiar_filtro_por_defecto($id_filtro);
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

     function actualizar_estado(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe el id del filtro
            $codigo_filtro = $this->input->post('codigo_filtro');
            $estado = $this->input->post('estado');

            //Se ejecuta el modelo que actualiza el filtro por defecto
            $this->filtro_model->actualizar_estado($codigo_filtro, $estado);
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function cargar(){
        //Suiche
        switch ($this->input->post('tipo')) {
            //Si es condiciones
            case 'condiciones':
                //Ejecutamos y retornamos el array con las condiciones
                // echo $this->filtro_model->listar_condiciones($this->input->post('id_campo'));
                echo json_encode($this->filtro_model->listar_condiciones($this->input->post('id_campo')));
                break;

        }
    }

    function cargar_filtros(){
        //Se recibe el id de filtro por post
        $id_filtro = $this->input->post('codigo_filtro');

        // suiche
        switch ($this->input->post('tipo')) {
            case 'filtros':
                //Se consultan los datos del filtro
                $filtros = $this->filtro_model->cargar_filtros_actualizar($id_filtro);

                //Si se recibe algo
                if ($filtros) {
                    print json_encode($filtros);
                }else{
                    echo "false";
                }
                break;
            
            case 'condiciones':
                //Se valida que la peticion venga mediante ajax y no mediante el navegador
                $condicionesf = $this->filtro_model->cargar_condiciones_actualizar($id_filtro);
                //Si se recibe algo
                if ($condicionesf) {
                    print json_encode($condicionesf);
                }else{
                    echo "false";
                }                
                break;
            
            case 'condiciones_producto':
                //Se valida que la peticion venga mediante ajax y no mediante el navegador
                $condicionesf = $this->filtro_model->cargar_condiciones_productos_actualizar($id_filtro);
                //Si se recibe algo
                if ($condicionesf) {
                    print json_encode($condicionesf);
                }else{
                    echo "false";
                }                
                break;
            
            case 'campos':
                //Se consultan los campos que pueda tener ese filtro
                $campos = $this->filtro_model->cargar_campos_actualizar($id_filtro);

                //Si se recibe algo
                if ($campos) {
                    print json_encode($campos);
                }else{
                    echo "false";
                }
                break;
        }
    }

    function guardar(){
        //Se recibe el arreglo de datos que viene por POST y el tipo de guardado
        $datos = $this->input->post('datos');
        $tipo = $this->input->post('tipo');
        $guardar = false;

        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            switch ($tipo) {
                case 'filtro':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->filtro_model->guardar($datos);
                    break;

                case 'condicional':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->filtro_model->guardar_condicional($datos);
                    break;

                case 'producto':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->filtro_model->guardar_producto($datos);
                    break;

                case 'campo':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->filtro_model->guardar_campos($datos);
                    break;
            }//switch

            //Si se guarda
            if($guardar) {
                //Se toma el último id
                //$resultado = mssql_fetch_assoc(mssql_query("select @@IDENTITY as id"));
                $resultado = $this->db->insert_id();
                
                //Se retorna como respuesta el id del asociado
                print json_encode(array("id_filtro" => $resultado));
            } else {
                echo "false";
            }//If
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function actualizar(){
        //Se recibe el arreglo de datos que viene por POST y el tipo de guardado
        $datos = $this->input->post('datos');
        $tipo = $this->input->post('tipo');
        $id = $this->input->post('id');
        $guardar = false;

        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            switch ($tipo) {
                case 'filtro':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->filtro_model->actualizar($datos,$id);
                    break;

                case 'condicional':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->filtro_model->actualizar_condicional($datos);
                    break;

                case 'condicional_producto':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->filtro_model->borrar_datos_filtro_producto($id);
                    break;

                case 'condicional_producto_guardar':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->filtro_model->guardar_condicional_producto($datos);
                    break;

                case 'campo':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->filtro_model->actualizar_campos($datos);
                    break;

                case 'borrar':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->filtro_model->borrar_datos($id);
                    break;
            }//switch

            //Si se guarda
            if($guardar) {
                //Se toma el último id
                //$resultado = mssql_fetch_assoc(mssql_query("select @@IDENTITY as id"));
                $resultado = $this->db->insert_id();
                
                //Se retorna como respuesta el id del asociado
                print json_encode(array("id_filtro" => $resultado));
            } else {
                echo "false";
            }//If
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function borrar_datos_filtro_producto(){
        //Se envían los datos al modelo que los guardará
        $guardar = $this->filtro_model->borrar_datos_filtro_producto($this->input->post('id'));
    }

}
/* Fin del archivo filtros.php */
/* Ubicación: ./application/controllers/filtros.php */