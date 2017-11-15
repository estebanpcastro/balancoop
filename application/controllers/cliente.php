<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Cliente
 * 
 * @author              John Arley Cano Salinas
 */
Class Cliente extends CI_Controller{
	function __construct() {
        parent::__construct();

        /*//Si no ha iniciado sesión
        if(!$this->session->userdata('id_usuario')){
            //Se cierra la sesion obligatoriamente
            redirect('inicio/cerrar_sesion');
        }//Fin if*/

        //Carga de modelos
        $this->load->model(array('cliente_model'));
    }

    function index(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Cliente';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'cliente/buscar_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }

    function actualizados(){
    	//se establece el titulo de la pagina
        $this->data['titulo'] = 'Actualización de datos';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'cliente/actualizados/index_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }

    function detalles(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Detalles';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'cliente/detalle/index_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }

    function actualizar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe el arreglo de datos que viene por POST y el tipo de guardado
            $datos = $this->input->post('datos');
            $tipo = $this->input->post('tipo');
            $id_asociado = $this->input->post('id_asociado');
            $actualizar = false;

            //Suiche
            switch ($tipo) {
                case 'asociado':
                    // Si trae contraseña de transferencia
                    if ($datos["Clave_Transferencia"]) {
                        $datos["Clave_Transferencia"] = sha1($datos["Clave_Transferencia"]);
                    }
                    //Se envían los datos al modelo que los guardará
                    $actualizar = $this->cliente_model->actualizar($datos, $id_asociado);
                    break;
                case 'beneficiario':                   
                    //Se envían los datos al modelo que los guardará
                    $actualizar = $this->cliente_model->guardar_beneficiario($datos);
                    break;
                case 'cargo':
                    //Se envían los datos al modelo que los guardará
                    $actualizar = $this->cliente_model->guardar_cargos($datos);
                    break;
                case 'campana':                   
                    //Se envían los datos al modelo que los guardará (el id de asociado es id de campaña)
                    $actualizar = $this->cliente_model->actualizar_campana($id_asociado, $datos);
                    break;
                case 'comentario':                   
                    //Se envían los datos al modelo que los guardará (el id de asociado es id de comentario)
                    $actualizar = $this->cliente_model->actualizar_campana($id_asociado, $datos);
                    break;
                case 'conocido':
                    //Se envían los datos al modelo que los guardará
                    $actualizar = $this->cliente_model->guardar_conocido($datos);
                    break;
                case 'hijo':
                    //Se envían los datos al modelo que los guardará
                    $actualizar = $this->cliente_model->guardar_hijo($datos);
                    break;
                case 'oportunidad':                   
                    //Se envían los datos al modelo que los guardará (el id de asociado es id de comentario)
                    $actualizar = $this->cliente_model->actualizar_oportunidad($id_asociado, $datos);
            }// Switch

            //Si se guarda
            if($actualizar) {
                //Se toma el último id
                //$resultado = mssql_fetch_assoc(mssql_query("select @@IDENTITY as id"));
                // $resultado = $this->db->insert_id();

                //Se retorna como respuesta el id del asociado
                // print json_encode(array("id_asociado" => $resultado));
                echo $actualizar;
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function actualizar_usuario_sistema(){
        // Se recibe los datos por post
        $datos = $this->input->post('datos');

        //Modificamos la contraseña para encriptarla
        $datos["password"] = sha1($datos["password"]);

        // Si no se modifica la contraseña
        if($this->input->post('usar_password') == '0'){
            // Se elimina el campo de contraseña
            unset($datos['password']);
        }

        echo $this->cliente_model->actualizar_usuario_sistema($this->input->post('id_usuario'), $datos);
        // echo 'ok';
    }

    function agregar_beneficiarios(){
        //Se captura el número del beneficiario
        $this->data['numero'] = $this->input->post('numero'); 

        //Se carga la vista
        $this->load->view('cliente/beneficiario_view', $this->data);
    }

    function agregar_hijos(){
        //Se captura el número del hijo
        $this->data['numero'] = $this->input->post('numero'); 

        //Se carga la vista
        $this->load->view('cliente/hijo_view', $this->data);
    }

    function agregar_conocidos(){
        //Se captura el número del conocido
        $this->data['numero'] = $this->input->post('numero'); 

        //Se carga la vista
        $this->load->view('cliente/conocido_view', $this->data);
    }

    function agregar_cargos(){
        //Se captura el número de cargos
        $this->data['numero'] = $this->input->post('numero'); 

        //Se carga la vista
        $this->load->view('cliente/cargos_view', $this->data);
    }

    function agregar_productos(){
        //Se captura el número del beneficiario
        $this->data['numero'] = $this->input->post('numero'); 

        //Se carga la vista
        $this->load->view('cliente/producto_view', $this->data);
    }

    function actualizar_datos_cliente_producto(){
        // Se toma el id cliente (cédula) que viene por post 
        $id_cliente = $this->input->post('id_cliente');
        // $id_cliente = "70566989";
        
        // Se ejecuta el modelo que toma los datos
        $datos = $this->cliente_model->cargar_datos_cliente_producto($id_cliente);
        print_r($datos);

        // Se actualizan los datos de ese cliente
        echo $actualizar = $this->cliente_model->actualizar_datos_cliente_producto($id_cliente, $datos);
    }

    function borrar(){
        switch ($this->input->post('tipo')) {
            case 'beneficiarios':
                // Se borra
                $this->cliente_model->borrar('beneficiarios', $this->input->post('id_asociado'));
                break;
            
            case 'cargos':
                // Se borra
                $this->cliente_model->borrar('cargos', $this->input->post('id_asociado'));
                break;


            case 'conocidos':
                // Se borra
                $this->cliente_model->borrar('conocidos', $this->input->post('id_asociado'));
                break;

            case 'hijos':
                // Se borra
                $this->cliente_model->borrar('hijos', $this->input->post('id_asociado'));
                break;
        }
    }

    function buscar(){
        //Se ejecuta el modelo
        $busqueda = $this->cliente_model->buscar($this->input->post('documento'), $this->input->post('id_empresa'));

        // Se envía
        print json_encode($busqueda);
    }

    function cargar(){
        //Se recibe el id de asociado por post
        $id_asociado = $this->input->post('id_asociado');

        // suiche
        switch ($this->input->post('tipo')) {
            case 'beneficiario':
                //Se consultan los beneficiarios que pueda tener ese asociado
                $beneficiarios = $this->cliente_model->cargar_beneficiarios($id_asociado);

                //Si se recibe algo
                if ($beneficiarios) {
                    print json_encode($beneficiarios);
                }else{
                    echo "false";
                }
                break;

            case 'cargo':
                //Se consultan los cargos que pueda tener ese asociado
                $cargos = $this->cliente_model->cargar_cargos($id_asociado);

                //Si se recibe algo
                if ($cargos) {
                    print json_encode($cargos);
                }else{
                    echo "false";
                }
                break;

            case 'hijo':
                //Se consultan los hijos que pueda tener ese asociado
                $hijos = $this->cliente_model->cargar_hijos($id_asociado);

                //Si se recibe algo
                if ($hijos) {
                    print json_encode($hijos);
                }else{
                    echo "false";
                }
                break;

            case 'conocido':
                //Se consultan los hijos que pueda tener ese asociado
                $hijos = $this->cliente_model->cargar_conocidos($id_asociado);

                //Si se recibe algo
                if ($hijos) {
                    print json_encode($hijos);
                }else{
                    echo "false";
                }
                break;

            case 'producto':
                //Se consultan los productos que pueda tener ese asociado
                $cargos = $this->cliente_model->cargar_productos_matriculados($id_asociado);

                //Si se recibe algo
                if ($cargos) {
                    print json_encode($cargos);
                }else{
                    echo "false";
                }
                break;

            case 'usuario_sistema':
                print json_encode($this->cliente_model->listar_usuarios_sistema($this->input->post('id_usuario')));
                break;
        }
    }

    function consultar_usuario(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            echo $this->cliente_model->validar_usuario($this->input->post('login'));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function consultar_habilidad(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe variablespor post
            $id_asociado = $this->input->post('id_asociado');
            $numero = $this->input->post('numero');
            $fecha_inicio = $this->input->post('fecha_inicio');

            //Suiche
            switch ($numero) {
                case '1':
                    // Se consulta 
                    print json_encode($this->cliente_model->consultar_habilidad($numero, $id_asociado, $fecha_inicio, null));
                    break;

                /*case '2':
                    // Se consulta 
                    print json_encode($this->cliente_model->consultar_habilidad($numero, $id_asociado, $fecha_inicio, null));
                    break;*/

                case '3':
                    // Se consulta 
                    print json_encode($this->cliente_model->consultar_habilidad($numero, $id_asociado, $fecha_inicio, $this->input->post("id_producto")));
                    break;

                case '4':
                    // Se consulta 
                    print json_encode($this->cliente_model->consultar_habilidad($numero, $id_asociado, $fecha_inicio, $this->input->post("id_producto")));
                    break;

                case '5':
                    // Se consulta 
                    print json_encode($this->cliente_model->consultar_habilidad($numero, $id_asociado, $fecha_inicio, $this->input->post("id_producto")));
                    break;

                case '6':
                    // Se consulta 
                    print json_encode($this->cliente_model->consultar_habilidad($numero, $id_asociado, null, null));
                    break;
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function consultar_habilidad_producto(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se consulta en el modelo y se retorna
            print json_encode($this->cliente_model->consultar_habilidad_producto($this->input->post('id_producto')));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function eliminar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Se reciben los datos
            $id = $this->input->post('id');
            $tipo = $this->input->post('tipo');

            //Suiche
            switch ($tipo) {
                case 'campos':
                    //Se borran todos los campos anteriores de la empresa
                    $this->cliente_model->borrar("actualizacion_campos_empresa", $this->session->userdata('id_empresa'));
                    break;
                    
                case 'campana':
                    //Se envían los datos al modelo que lo eliminará
                    $this->cliente_model->borrar('campana', $id);
                    break;

                case 'comentario':
                    //Se envían los datos al modelo que lo eliminará
                    $this->cliente_model->borrar('comentario', $id);
                    break;

                case 'oportunidad':
                    //Se envían los datos al modelo que lo eliminará
                    $this->cliente_model->borrar('oportunidad', $id);
                    break;

                case 'producto':
                    //Se envían los datos al modelo que lo eliminará
                    $this->cliente_model->borrar('producto', $id);
                    break;
            } // suiche
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe el arreglo de datos que viene por POST y el tipo de guardado
            $datos = $this->input->post('datos');
            $tipo = $this->input->post('tipo');
            $guardar = false;

            //Suiche
            switch ($tipo) {
                case 'asociado':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->cliente_model->guardar($datos);
                    break;
                case 'beneficiario':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->cliente_model->guardar_beneficiario($datos);
                    break;
                case 'campana':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->cliente_model->guardar_campana($datos);
                    break;
                case 'comentario':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->cliente_model->guardar_comentario($datos);
                    break;
                case 'hijo':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->cliente_model->guardar_hijo($datos);
                    break;
                case 'campos':                    
                    //Se envían los datos al modelo que los guardará
                    echo $guardar = $this->cliente_model->guardar_campos($datos);
                    break;
                case 'conocido':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->cliente_model->guardar_conocido($datos);
                    break;
                case 'cargo':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->cliente_model->guardar_cargos($datos);
                    break;
                case 'oportunidad':
                    //Se envían los datos al modelo que los guardará
                    $actualizar = $this->cliente_model->guardar_oportunidad($datos);
                    break;
                case 'producto':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->cliente_model->guardar_producto($datos);
                    break;
                case 'usuario_sistema':
                    //Modificamos la contraseña para encriptarla
                    $datos["password"] = sha1($datos["password"]);

                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->cliente_model->guardar_usuario($datos);
                    break;
            }// Switch

            //Si se guarda
            if($guardar) {
                //Se toma el último id
                //$resultado = mssql_fetch_assoc(mssql_query("select @@IDENTITY as id"));
                $resultado = $this->db->insert_id();

                //Se retorna como respuesta el id del asociado
                print json_encode(array("id_asociado" => $resultado));
            } else {
                echo "false";
            }//If
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_gustos(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe el arreglo de datos que viene por POST y el id del asociado
            $datos_gustos = $this->input->post('datos');
            $id_asociado = $this->input->post('id_asociado');

            $array_gustos = array();

            //Se borran todos los gustos anteriores
            $this->cliente_model->borrar("gustos", $id_asociado);

            //Se procede recorrer los gustos
            foreach ($datos_gustos as $gusto) {
                //Se inserta el gusto
                $this->cliente_model->guardar_gustos(array('int_IdAsociado' => $id_asociado, 'int_IdGusto' => $gusto));
            }// if
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function listar_documentos(){
        //Se carga la plantilla
        $this->load->view('cliente/detalle/documento_lista_view');
    }

    function subir_documento(){
        //Se declara la variable que contiene la ruta predeterminada para la subida de los documentos del cliente
        $ruta = "./documentos_cliente/";

        // //Almacenamos el id de cliente que usaremos
        $id_asociado = $this->input->post('id_asociado');

        // //Obtenemos el nombre
        // $nombre = $this->input->post('nombre');
        $nombre_recibido = 'Archivo de prueba '.str_pad(rand(0, 1000), 3, 0, STR_PAD_LEFT);

        //Se asigna el nombre del archivo
        $nombre = $nombre_recibido.'.'.$extension = end(explode(".", $_FILES['userfile']['name']));

        // //Se establece el directorio
        $directorio = $ruta.$id_asociado.'/';

        //Valida que el directorio exista. Si no existe,lo crea con el id obtenido
        if(!is_dir($directorio)){
            //Asigna los permisos correspondientes
            @mkdir($directorio, 0777);
        }//Fin if

        //Si se sube el archivo exitosamente
        // if (move_uploaded_file($_FILES['userfile']['tmp_name'], $directorio.$_FILES['userfile']['name'])) {
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $directorio.$nombre)) {
            echo "true";
        } else {
            echo "false";
        } // if
    }

    function validar_carne(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            echo $this->cliente_model->validar_carne($this->input->post('numero'), $this->input->post('identificacion'));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }
}
/* Fin del archivo cliente.php */
/* Ubicación: ./application/controllers/cliente.php */