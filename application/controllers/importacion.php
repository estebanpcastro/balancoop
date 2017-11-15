<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Importación
 * 
 * @author              John Arley Cano Salinas
 */
Class Importacion extends CI_Controller{
	function __construct() {
        parent::__construct();

        ///Si no ha iniciado sesión o es usuario responsable
        if(!$this->session->userdata('id_usuario') || $this->session->userdata('tipo') == '2'){
            //Se cierra la sesion obligatoriamente
            redirect('inicio/cerrar_sesion');
        }//Fin if

        //Carga de modelos
        $this->load->model(array('cliente_model', 'importacion_model'));
    }

    function index(){
    	//se establece el titulo de la pagina
        $this->data['titulo'] = 'Importación';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'importacion/index_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    } // index

    function contar(){
        $datos = $this->input->post("datos");

        switch ($this->input->post("tipo")) {
            // Tabla clientes_productos
            case 'clientes_productos':
                // Se consulta la cantidad de registros
                echo $this->importacion_model->contar_cliente_producto($datos);
                // echo "Conectado";
                break;

            // Tabla clientes_campanas
            case 'clientes_campanas':
                // Se consulta la cantidad de registros
                echo $this->importacion_model->contar_cliente_campana($datos);
                break;
        }
    }

    function eliminar(){
        $datos = $this->input->post("datos");

        switch ($this->input->post("tipo")) {
            // Tabla clientes_productos
            case 'clientes_productos':
                // Se consulta la cantidad de registros
                echo $this->importacion_model->eliminar_productos($datos);
                break;

            // Tabla clientes_campanas
            case 'clientes_campanas':
                // Se consulta la cantidad de registros
                echo $this->importacion_model->eliminar_campanas($datos);
                break;
        }
    }


    function subir(){
        // Se incluye el archivo de PHPExcel para la importación
        include 'system/libraries/PHPExcel/IOFactory.php';

        ini_set("memory_limit","128M");

        // Se toma el archivo
        $archivo =  $_FILES['archivo']['tmp_name'];

        //  Se lee el libro de excel
        try {
            $tipo_archivo = PHPExcel_IOFactory::identify($archivo);
            $objReader = PHPExcel_IOFactory::createReader($tipo_archivo);
            $objPHPExcel = $objReader->load($archivo);
        } catch(Exception $e) {
            die('Error cargando el archivo "'.pathinfo($archivo,PATHINFO_BASENAME).'": '.$e->getMessage());
        }

        // Se recibe el nombre de la tabla
        $tabla = $this->uri->segment(3);

        // Acción por defecto
        $accion = "INSERT";

        // Se obtienen las dimensiones de la hoja de cálculo
        $hoja = $objPHPExcel->getSheet(0); 
        $celda_mayor = $hoja->getHighestRow(); 
        $columna_mayor = $hoja->getHighestColumn();

        // Si la tabla es de asociados
        if ($tabla == "asociados") {
            $accion = "REPLACE";
        }

        // $datos = array('campo1' => 'valor1', 'campo2' => 'valor2');

        // Recorrido de cada fila
        for ($fila = 1; $fila <= $celda_mayor; $fila++){
            if ($fila == 1) {
                $cabecera = $hoja->rangeToArray(
                    'A' . $fila . ':' . $columna_mayor . $fila,
                    NULL,
                    TRUE,
                    FALSE
                );

                // print_r($cabecera[0]);
            }
            // Si la fila es a partir de 4 (1, 2 y 3 son encabezado, comentarios y tipo)
            if ($fila >= 4) {
                 // Leer una fila de datos en una matriz
                $datos_fila = $hoja->rangeToArray(
                    'A' . $fila . ':' . $columna_mayor . $fila,
                    NULL,
                    TRUE,
                    FALSE
                );

                // print_r($datos_fila[0]);
                // echo "<br>";

                // Se recorre cada fila encontrada
                foreach ($datos_fila as $dato) {
                    // Se declara y arma la consulta
                    $sql = "{$accion} INTO ".$this->uri->segment(3)." (";
                    
                    // Contador
                    $cont = 0;


                    /*foreach($dato as $key => $value)
                    {
                    $sql .= "{$cabecera[0][$cont++]}, ";
                    // $sql .="'$key',";
                    }*/

                    // Construcción de la consulta
                    $sql = substr($sql, 0, -1);
                    
                    // Construcción de la consulta
                    $sql .=" VALUES (";
                    // $sql .=") VALUES (";


                    // Construcción de la consulta
                    foreach($dato as $key => $value)
                    {
                        $sql .="'$value',";
                    }
                    
                    // Construcción de la consulta
                    $sql = substr($sql, 0, -1);
                    
                    // Construcción de la consulta
                    $sql .= ");";
                    
                    // return $sql;
                    
                    // Impresión de la consulta
                    // echo $sql;

                    $guardados = 0;
                    $errores = 0;

                    if ($this->cliente_model->guardar_importacion(null, null, $sql)) {
                        $guardados++;
                    }else{
                        $errores++;
                    }
                }
            }
            
        }
        
        // Mensaje
        echo "Se ha ejecutado la consulta correctamente. Registros afectados exitosamente: " .$guardados.", errados: ".$errores;
        
        echo "<br><br><a href='".site_url('importacion')."'>Volver</a>";
    }//subir
}
/* Fin del archivo importacion.php */
/* Ubicación: ./application/controllers/importacion.php */