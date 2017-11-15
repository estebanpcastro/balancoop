<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * CRM
 * 
 * @author              John Arley Cano Salinas
 */
Class Crm extends CI_Controller{
	function __construct() {
        parent::__construct();

        //Si no ha iniciado sesión
        if(!$this->session->userdata('id_usuario')){
            //Se cierra la sesion obligatoriamente
            redirect('inicio/cerrar_sesion');
        }//Fin if

        //Carga de modelos
        $this->load->model(array('crm_model', 'cliente_model'));
    }

    function index(){
    	//se establece el titulo de la pagina
        $this->data['titulo'] = 'CRM';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'crm/index_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }

     function actualizar(){
        //Se recibe el arreglo de datos que viene por POST y el tipo de guardado
        $tipo = $this->input->post('tipo');        
        $guardar = false;

        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se envían los datos al modelo que los guardará
            $guardar = $this->crm_model->Actualizar_edades();                   
            //print_r($guardar);
            //Si se guarda
            if($guardar) {
                echo "true ejecutado";
            } else {
                echo "false";
            }//If
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function buscar_asociado(){
        //Se recibe el número de documento por post
        $documento = $this->input->post('documento');

        //Se ejecuta el modelo
        $busqueda = $this->cliente_model->buscar($documento, $this->session->userdata('id_empresa'));

        // Si lo encuentra
        if (count($busqueda) == 1) {
            print json_encode($busqueda);
        }else{
            print json_encode(array('id_asociado' => 0));
        }
    }

    function buscar_asociado_nombre(){
        //Se recibe el nombre por post
        $nombre = $this->input->post('nombre');

        //Se ejecuta el modelo
        $busqueda = $this->cliente_model->buscar_nombre($nombre);

        print json_encode($busqueda);

        // Si lo encuentra
        /*if (count($busqueda) == 1) {
            print json_encode($busqueda);
        }else{
            echo "false";
        }*/
    }
    
    function consultar_productos_asociado(){
        //Se recibe el número de documento por post
        $documento = $this->input->post('documento');

        //Se ejecuta el modelo
        $productos = $this->crm_model->consultar_productos_asociado($documento);

        // Se retornan los productos
        print json_encode($productos);
    }

    function consultar_asociados_producto(){
        //Se recibe el producto por post
        $producto = $this->input->post('producto');

        //Se ejecuta el modelo
        $asociados = $this->crm_model->consultar_asociados_producto($producto);

        // Se retornan los asociados
        print json_encode($asociados);
    }

    function importar_archivo()
    {
        //$IdEvento = $this->input->post('IdEvento');
        $IdEvento = $this->input->get('certificado');

        echo($IdEvento);
        $carpeta = 'archivos';
        //echo $carpeta."<br>";
        $nombre_archivo=$IdEvento;
        //se verifica que exista la ruta de donde se van a guardar los archivos
        if (! is_dir($carpeta."/".$nombre_archivo)) {            
            //sino entonces se crea la ruta con todos los permisos
            @mkdir($carpeta."/".$nombre_archivo,0777);
            //echo "se creo la carpeta carpeta_nueva";
        }
        $carpeta = $carpeta."/".$nombre_archivo;
        //echo $carpeta."<br>";
        $resultado = "correcto";  
        //print_r($_FILES['certificado']);
        if(isset($_FILES['certificado'])) {
            foreach ($_FILES['certificado'] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES['certificado']['tmp_name'];
                    $name = trim($_FILES['certificado']['name']);
                    //echo $_FILES['certificado']."<br>";
                    //echo $tmp_name;
                    //echo "Valor '".$name."' <br>";
                    if($_FILES['certificado']['error']==0){
                        //Se inserta nombre certificado en base de datos
                        $Certificado = $this->evento_model->guardarCertificado($IdEvento, $name);                                        
                    }
                    if( ! move_uploaded_file($tmp_name, $carpeta.'/'.$name))
                    {
                        $resultado = "Ocurri&oacute; un error al importar el archivo, verifique por favor.";
                    }
                }
            }

            echo $resultado;
        }else {
            echo "Debe seleccionar al menos un archivo a importar";
        }        
        
    }//fin  subir_imagenes($IdEvento)   
}
/* Fin del archivo crm.php */
/* Ubicación: ./application/controllers/crm.php */