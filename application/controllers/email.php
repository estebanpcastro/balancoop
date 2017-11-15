<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Cliente
 * 
 * @author              John Arley Cano Salinas
 */
Class Email extends CI_Controller{
	function __construct() {
        parent::__construct();

        //Si no ha iniciado sesión
        if(!$this->session->userdata('id_usuario')){
            //Se cierra la sesion obligatoriamente
            // redirect('inicio/cerrar_sesion');
        }//Fin if

        //Se cargan los modelos, librerias y helpers
    	$this->load->library(array('email'));
        $this->load->model(array('listas_model'));
    }

    function index(){
        echo $this->listas_model->guardar(array("descripcion" => "Prueba de cron"), "preguntas");
    }

    function otra(){

    	$hostname = 'cooacueducto.ip-zone.com';
        $apiKey = 'P32D7ypNsNysDjfD8dDCQnBQ1QXL2FEI97L7w0Kf';


        $curl = curl_init('http://' . $hostname . '/ccm/admin/api/version/2/&type=json');
         
        $postData = array(
        'function' => 'addCampaign',
        'apiKey' => $apiKey,
        'subject' => 'Mi newsletter enviada desde el API',
        'mailboxFromId' => 1,
        'mailboxReplyId' => 1,
        'mailboxReportId' => 1,
        'emailReport' => true,
        'groups' => array( 11 ), // Grupos de suscriptores
        'text' => 'Nuevas promociones en Email Marketing',
        'html' => '<strong>Nuevas promociones en Email Marketing</strong>',
        'packageId' => 6,
        'campaignFolderId' => 1,
        );
         
        $post = http_build_query($postData);
         
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
         
        $json = curl_exec($curl);
        $result = json_decode($json);
         
        if ($result->status == 0) {
        throw new Exception('Bad status returned. Something went wrong.');
        }
         
        echo '
        <pre>'; 
        echo $result->data;
            // var_dump($result->data);
            echo '</pre>
        ';





        $postData = array(
        'function' => 'sendCampaign',
        'apiKey' => $apiKey,
        'id' => $result->data,
        );

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
         
        $json = curl_exec($curl);
        $result = json_decode($json);
         
        if ($result->status == 0) {
        throw new Exception('Bad status returned. Something went wrong.');
        }
         
        var_dump($result->data);


    }

    function obtener_suscriptores(){
        $hostname = 'cooacueducto.ip-zone.com';
        $apiKey = 'P32D7ypNsNysDjfD8dDCQnBQ1QXL2FEI97L7w0Kf';


        $curl = curl_init('http://' . $hostname . '/ccm/admin/api/version/2/&type=json');
         
        $postData = array(
            'function' => 'getSubscribers',
            'apiKey' => $apiKey,
            'offset' => 0,
            'activated' => true,
            // 'count' => 2
        );
         
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
         
        $json = curl_exec($curl);
        if ($json === false) {
            die('Request failed with error: '. curl_error($curl));
        }
         
        $result = json_decode($json);
        if ($result->status == 0) {
            die('Bad status returned. Error: '. $result->error);
        }

        echo count($result->data);

         
    }

    function crear_grupo_suscriptores(){
        $hostname = 'cooacueducto.ip-zone.com';
        $apiKey = 'P32D7ypNsNysDjfD8dDCQnBQ1QXL2FEI97L7w0Kf';


        $curl = curl_init('http://' . $hostname . '/ccm/admin/api/version/2/&type=json');
 
        $postData = array(
            'function' => 'addGroup',
            'apiKey' => $apiKey,
            'name' => 'Grupo de suscriptores 1',
            'description' => 'Grupo de prueba',
            'position' => 1,
            'enable' => true,
            'visible' => true,
        );
         
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
         
        $json = curl_exec($curl);
        if ($json === false) {
            die('Request failed with error: '. curl_error($curl));
        }
         
        $result = json_decode($json);
        if ($result->status == 0) {
            die('Bad status returned. Error: '. $result->error);
        }
         
        var_dump($result->data);
    }
 }
/* Fin del archivo email.php */
/* Ubicación: ./application/controllers/email.php */