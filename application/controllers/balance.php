<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Balance
 * 
 * @author 		       John Arley Cano Salinas
 */
Class Balance extends CI_Controller{
	function __construct() {
        parent::__construct();

        //Si no ha iniciado sesión
        if(!$this->session->userdata('id_usuario')){
            //Se cierra la sesion obligatoriamente
            redirect('inicio/cerrar_sesion');
        }//Fin if
        
        //Carga de modelos
        $this->load->model(array('balance_model', 'transferencia_model'));

        //Carga de listas desplegables del formulario        
        // $this->data['oficinas'] =  $this->listas_model->cargar_empresa('din_agencias', $this->session->userdata('id_empresa'));               
    }

	/**
	 * [index description]
	 * @return [type] [description]
	 */
	function index(){
		//se establece el titulo de la pagina
        $this->data['titulo'] = 'Balance social';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'balance/index_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
	}

    function eliminar_estructura(){
        // Se carga la vista
        $this->load->view('balance/eliminar_view');
    }

    function pesos(){
        // Se carga la vista
        $this->load->view('balance/pesos_view');
    }

    function actualizar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post
            $datos = $this->input->post('datos');
            $id_variable = $this->input->post('anio');
            $id_variable = $this->input->post('id_variable');

            //Si se guarda
            if ($this->balance_model->actualizar($datos, $id_variable)) {
                echo 'true';
            } else {
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function actualizar_peso(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Recibo las variables por POST
            $id_estructura = $this->input->post('id_estructura');
            $datos = $this->input->post('datos');
           

            //Si se guarda
            if ($this->balance_model->actualizar_peso($id_estructura, $datos)) {
                echo 'true';
            } else {
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function borrar_valores_reales(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se ejecuta el modelo que 
            echo $this->balance_model->borrar_valores_reales($this->input->post('id_balance'), $this->input->post('datos'));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function cargar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post
            $tipo = $this->input->post('tipo');
            $anio = $this->input->post('anio');
            $id_conector = $this->input->post('id_variable');
            $id_oficina = $this->input->post('id_oficina');
            
            //Se listan las categorías

            //Se listan las dimensiones
            print json_encode($this->balance_model->cargar($tipo, $anio, $id_conector, $id_oficina));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function cargar_estructuras(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post
            $tipo = $this->input->post('tipo');
            $id_balance = $this->input->post('id_balance');
            $id_variable = $this->input->post('id_variable');
            
            //Se listan las categorías

            //Se listan las dimensiones
            print json_encode($this->balance_model->cargar_estructuras($tipo, $id_balance, $id_variable, '0'));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function cargar_balances_comparacion(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por POST
            $anio_anterior = $this->input->post('anio')-1;

            //Se ejecuta el modelo que actualiza
            print json_encode($this->balance_model->cargar_balances($anio_anterior));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function cargar_filtros(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se ejecuta el modelo que actualiza
            print json_encode($this->balance_model->cargar_filtros());
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function consultar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se ejecuta el modelo que actualiza
            echo $this->balance_model->consultar($this->input->post('id_estructura'));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function consultar_balance(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se ejecuta el modelo que actualiza
            print json_encode($this->balance_model->consultar_datos_balance($this->input->post('id_estructura')));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function crear(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post
            $guardar = false;
            $tipo = $this->input->post('tipo');
            $datos = $this->input->post('datos');

            // suiche
            switch ($tipo) {
                case 'estructura':
                    // Se ejecuta para guardar
                    $guardar = $this->balance_model->guardar($datos);
                    break;

                case 'balance':
                    // Se ejecuta para guardar
                    $guardar = $this->balance_model->guardar($datos);
                    break;
            } // swith

            //Si se guarda
            if($guardar) {
                //Retorna verdadero
                echo 'true';
            } else {
                echo "false";
            }//If
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function crear_balance(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post
            $guardar = false;
            $datos = $this->input->post('datos');

            // Se ejecuta para guardar
            $guardar = $this->balance_model->crear('balance', $datos);

            //Si se guarda
            if($guardar == 'true') {
                //Retorna el id
                print json_encode(array('id_balance' => mysql_insert_id()));
            } else {
                echo "false";
            }//If
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function crear_estructuras(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post
            $guardar = false;
            $id_balance_copia = $this->input->post('id_balance_copia');
            $id_balance_nuevo = $this->input->post('id_balance_nuevo');

            /**
             * Consultamos todas las categorías del balance existente
             */
            foreach ($this->balance_model->consultar_estructuras("C", $id_balance_copia, "0") as $categoria) {
                echo "\n"."Categoría ".$categoria->strNombre."(".$categoria->intCodigo.")"."\n";

                //Almacenamos el id de categoría existente antes de eliminarlo, para poder hallar las dimensiones
                $id_categoria_existente = $categoria->intCodigo;

                // Le quitamos el id de la categoría
                unset($categoria->intCodigo);

                // Se quita el id de balance existente y se pone el nuevo
                $categoria->id_balance = $id_balance_nuevo;

                //Guardamos la nueva categoría
                $this->balance_model->guardar($categoria);

                //El id resultante será el nuevo id de categoría
                $categoria->intCodigo = mysql_insert_id();

                /**
                 * Consultamos todas las dimensiones de la categoria
                 */
                foreach ($this->balance_model->consultar_estructuras("D", $id_balance_copia, $id_categoria_existente) as $dimension) {
                    echo "- Dimensión ".$dimension->strNombre."\n";

                    //Almacenamos el id de dimensión existente antes de eliminarlo, para poder hallar las dimensiones
                    $id_dimension_existente = $dimension->intCodigo;

                    // Le quitamos el id de la dimensión
                    unset($dimension->intCodigo);

                    // Se quita el id de balance existente y se pone el nuevo
                    $dimension->id_balance = $id_balance_nuevo;

                    //Se quita el conector existente y se pone el nuevo
                    $dimension->id_conector = $categoria->intCodigo;

                    //Guardamos la nueva dimensión
                    $this->balance_model->guardar($dimension);

                    //El id resultante será el nuevo id de la dimensión
                    $dimension->intCodigo = mysql_insert_id();

                    /**
                     * Consultamos todas las variables de la dimensión
                     */
                    foreach ($this->balance_model->consultar_estructuras("V", $id_balance_copia, $id_dimension_existente) as $variable) {
                        echo "- Variable ".$variable->strNombre."\n";

                        // Le quitamos el id de la variable para que cree una nueva automáticamente
                        unset($variable->intCodigo);

                        // Se quita el id de balance existente y se pone el nuevo
                        $variable->id_balance = $id_balance_nuevo;

                        //Se quita el conector existente y se pone el nuevo
                        $variable->id_conector = $dimension->intCodigo;

                        //Guardamos la nueva variable
                        $this->balance_model->guardar($variable);

                        //El id resultante será el nuevo id de la variable
                        $variable->intCodigo = mysql_insert_id();
                    }// foreach variables
                } // foreach dimensiones
            }// foreach categorias
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function eliminar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post
            $tipo = $this->input->post('tipo');
            
            // suiche
            switch ($tipo) {
                case 'balance':
                    // Se consulta el balance
                    $balance = $this->balance_model->consultar_balance($this->input->post('anio'), $this->input->post('id_oficina'));

                    // Si se borran las estructuras asociadas al id del balance hallado
                    if($this->balance_model->eliminar('estructuras', $balance->id_balance)){
                        //Se procede a borrar registro del balance
                        if($this->balance_model->eliminar('balance', $balance->id_balance)){
                            echo 'true';
                        } // if
                    }
                    break;
                
                case 'C':
                    // Se reciben los datos por POST
                    $id_categoria = $this->input->post('id_estructura');

                    //Se consultan y se recorren todas las dimensiones existentes de la categoría seleciconada
                    foreach ($this->balance_model->cargar_dimensiones($id_categoria) as $dimension) {
                        // Se borran todas las variables de esa dimensión
                        $this->balance_model->eliminar("variables", $dimension->intCodigo);
                    }// foreach

                    // Se eliminan las dimensiones de la categoria
                    $this->balance_model->eliminar("variables", $id_categoria);
                    
                    // Por último, se elimina la categoría
                    if($this->balance_model->eliminar('categoria', $this->input->post('id_estructura'))){
                        echo 'true';
                    } // if
                    break;
                
                case 'D':
                    // Se reciben los datos por POST
                    $id_dimension = $this->input->post('id_estructura');

                    // Se borran todas las variables de la dimensión
                    $this->balance_model->eliminar("variables", $id_dimension);

                    // Por último, se elimina la dimensión
                    if($this->balance_model->eliminar('categoria', $id_dimension)){
                        echo 'true';
                    } // if
                    break;

                case 'V':
                    // Se elimina la variable
                    if($this->balance_model->eliminar('categoria', $this->input->post('id_estructura'))){
                        echo 'true';
                    } // if
                    break;
            }

        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function validar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se ejecuta el modelo que valida la existencia del balance y se retorna el resultado
            echo $this->balance_model->validar($this->input->post('datos'));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }
}
/* Fin del archivo balance.php */
/* Ubicación: ./application/controllers/balance.php */