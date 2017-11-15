<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Genérico
 * 
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
Class Listas extends CI_Controller{
	function __construct() {
        parent::__construct();

        //Carga de modelos
        $this->load->model(array('crm_model', 'filtro_model', 'cliente_model', 'transferencia_model', 'balance_model', 'reporte_model'));

        $this->data['anios'] = $this->listas_model->listar_anios();
        $this->data['cargos'] = $this->listas_model->cargar('cargos');
        $this->data['conocimientos'] = $this->listas_model->cargar('conocimiento_cooperativismo');
        $this->data['escolaridades'] = $this->listas_model->cargar('escolaridad');
        $this->data['estados_civiles'] = $this->listas_model->cargar('estado_civil');
        $this->data['designaciones'] = $this->listas_model->cargar('designacion');
        $this->data['dias'] = $this->listas_model->listar_dias();
        $this->data['estados_usuario'] = $this->listas_model->cargar('estado_asociado');
        $this->data['estratos'] = $this->listas_model->cargar('estratos');
        $this->data['generos'] = $this->listas_model->cargar('generos');
        $this->data['gustos'] = $this->listas_model->cargar('gustos');
        $this->data['grupos_familiares'] = $this->listas_model->cargar('grupo_familiar');
        $this->data['industrias'] = $this->listas_model->cargar('industrias');
        $this->data['meses'] = $this->listas_model->listar_meses();
        $this->data['motivos_retiro'] = $this->listas_model->cargar('motivo_retiro');
        $this->data['oficinas'] = $this->listas_model->cargar_empresa('din_agencias', $this->session->userdata('id_empresa'));
        $this->data['origenes_cliente'] = $this->listas_model->cargar('origen_cliente');
        $this->data['paises'] = $this->listas_model->cargar_paises();
        $this->data['parentescos'] = $this->listas_model->cargar('parentescos');
        $this->data['profesiones'] = $this->listas_model->cargar('profesiones');
        $this->data['rangos_salario'] = $this->listas_model->cargar('rango_de_salario');
        $this->data['tipos_cliente'] = $this->listas_model->cargar('tipo_cliente');
        $this->data['tipos_documento'] = $this->listas_model->cargar('tipo_documento');
        $this->data['zonas'] = $this->listas_model->cargar('zonas');
        $this->data['tipo_empleados'] = $this->listas_model->cargar('tipo_empleado');
        $this->data['ubicacion_empleados'] = $this->listas_model->cargar('ubicacion_empleado');

        //Carga de listas desplegables del formulario
        $this->data['campanas'] = $this->listas_model->cargar('campanas');        
        $this->data['productos'] = $this->listas_model->cargar('productos');
        $this->data['busquedas_rapidas'] = $this->crm_model->cargar_busquedas_rapidas('busqueda_rapida');
        $this->data['filtros_cliente'] = $this->crm_model->cargar_busquedas_rapidas('es_cliente');
        $this->data['filtros_sistema'] = $this->crm_model->cargar_busquedas_rapidas('es_sistema');
        $this->data['usuarios'] = $this->cliente_model->listar_usuarios_sistema_empresa();
    }

    function index(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Gestión de datos';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'listas/index_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }

	function calcular_edad(){
		//Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
        	//Se recibe la fecha
        	$fecha_nacimiento = $this->input->post('fecha_nacimiento');

        	list($Y,$m,$d) = explode("-",$fecha_nacimiento);
			
			echo date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y;
		}else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
	}//calcular_edad

    function cargar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe la tabla por post
            $tabla = $this->input->post("tabla");

            //Se hace la consulta en el modelo y se retorna como array JSON
            print json_encode($this->listas_model->cargar($tabla));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } //if
    }

    function cargar_usuarios_sistema(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se hace la consulta en el modelo y se retorna como array JSON
            print json_encode($this->cliente_model->listar_usuarios_sistema_empresa());
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } //cargar_usuarios_sistema
    }

    function cargar_barrios(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe el código de la ciudad por post
            $codigo_ciudad = $this->input->post("codigo_ciudad");

            //Se hace la consulta en el modelo y se retorna como array JSON
            print json_encode($this->listas_model->cargar_barrios($codigo_ciudad));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } //if
    }

    function cargar_campana(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se hace la consulta en el modelo y se retorna como array JSON
            print json_encode($this->listas_model->cargar_campana($this->input->post('id_campana')));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } //if
    }

    function cargar_campana_cliente(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se hace la consulta en el modelo y se retorna como array JSON
            print json_encode($this->listas_model->cargar_campana_cliente($this->input->post('id_campana_cliente')));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } //if
    }

    function cargar_comentario_cliente(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se hace la consulta en el modelo y se retorna como array JSON
            print json_encode($this->listas_model->cargar_comentario_cliente($this->input->post('id_comentario_cliente')));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } //if
    }

    function cargar_oportunidad_cliente(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se hace la consulta en el modelo y se retorna como array JSON
            print json_encode($this->listas_model->cargar_oportunidad_cliente($this->input->post('id_oportunidad_cliente')));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } //if
    }

    function cargar_ciudades(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe el código del departamento por post
            $codigo_departamento = $this->input->post("codigo_departamento");

            //Se hace la consulta en el modelo y se retorna como array JSON
            print json_encode($this->listas_model->cargar_ciudades($codigo_departamento));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } //if
    }

	function cargar_departamentos(){
		//Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
        	//Se recibe el código del país por post
        	$codigo_pais = $this->input->post("codigo_pais");

        	//Se hace la consulta en el modelo y se retorna como array JSON
        	print json_encode($this->listas_model->cargar_departamentos($codigo_pais));
    	}else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } //if
	}

    function cargar_interfaz(){
        //Suiche
        switch ($this->input->post('tipo')) {
            //Si es categoría de un balance
            case 'balance_categorias':
                //Cargamos la vista
                $this->load->view('balance/categorias_view');
                break;

            //Si es creación de un balance
            case 'balance_creacion':
                //Cargamos la vista
                $this->load->view('balance/crear_view');
                break;

            //Si es dimensión de un balance
            case 'balance_dimensiones':
                //Cargamos la vista
                $this->load->view('balance/dimensiones_view');
                break;

            //Si es variables de un balance
            case 'balance_variables':
                //Cargamos la vista
                $this->load->view('balance/variables_view');
                break;

            //Si creará una estructura de un balance
            case 'balance_configuracion':
                //Cargamos la vista
                $this->load->view('balance/configuracion_view');
                break;

            //Si es creación de un balance
            case 'balance_creacion':
                //Cargamos la vista
                $this->load->view('balance/crear_view');
                break;

            //Si es el peso de un balance
            case 'balance_pesos':
                //Cargamos la vista
                $this->load->view('balance/pesos_view');
                break;
                
            //Si es barrio
            case 'barrio':
                //Se recibe el código del departamento por post
                $this->data['codigo_ciudad'] = $this->input->post('codigo_ciudad');

                //Cargamos la vista
                $this->load->view('listas/regiones/barrios_view', $this->data);
                break;

            //Si es campaña
            case 'campana':
                //Cargamos la vista
                $this->load->view('listas/campana_view');
                break;

            //Si es encuesta
            case 'encuesta':
                //Cargamos la vista
                $this->load->view('listas/encuestas/index');
            break;

            //Si es creación de encuesta
            case 'encuestas_crear':
                // Se recibe por post la variable que define si es un registro nuevo o editado
                $this->data["id"] = $this->input->post("id");
            
                //Cargamos la vista
                $this->load->view('listas/encuestas/crear', $this->data);
            break;

            // Listado de encuestas
            case 'encuestas_lista':
                // Se cargan los filtros
                $this->data['id_producto'] = $this->input->post("id_producto");

                //Cargamos la vista
                $this->load->view('listas/encuestas/listar', $this->data);
            break;

            // Claves
            case 'claves':
                //Cargamos la vista
                $this->load->view('listas/claves_view');
            break; // Claves

            //Datos personales del cliente
            case 'cliente':
                //Se recibe el código del departamento por post
                $this->data['id_asociado'] = $this->input->post('id_asociado');

                //Cargamos la vista
                $this->load->view('cliente/index_view', $this->data);
                break;

            // Formulario de actualización. Clientes actualizados y por actualizarse
            case 'cliente_actualizados':
                //Se reciben los datos por post
                $this->data['id_oficina'] = $this->input->post('id_oficina');
                $this->data['mes'] = $this->input->post('mes');
                $this->data['anio'] = $this->input->post('anio');

                //Cargamos la vista
                $this->load->view('cliente/actualizados/listado_view', $this->data);
                break;

            // Formulario de asociado ganador
            case 'cliente_ganador':
                //Se reciben los datos por post
                $this->data['id_oficina'] = $this->input->post('id_oficina');
                $this->data['mes'] = $this->input->post('mes');
                $this->data['anio'] = $this->input->post('anio');
                
                //Cargamos la vista
                $this->load->view('cliente/actualizados/ganador_view', $this->data);
                break;

            //Si es creación de una campaña de cliente
            case 'cliente_campana':
                //Se recibe el código del departamento por post
                $this->data['id_asociado'] = $this->input->post('id_asociado');
                
                //Cargamos la vista
                $this->load->view('cliente/detalle/campana_view', $this->data);
                break;

            //Si es creación de un documento de cliente
            case 'cliente_documento':
                //Se recibe el código del departamento por post
                $this->data['id_asociado'] = $this->input->post('id_asociado');
                
                //Cargamos la vista
                $this->load->view('cliente/detalle/documento_view', $this->data);
                break;

            //Si es creación de una oportunidad de cliente
            case 'cliente_oportunidad':
                //Se recibe el código del departamento por post
                $this->data['id_asociado'] = $this->input->post('id_asociado');
                
                //Cargamos la vista
                $this->load->view('cliente/detalle/oportunidad_view', $this->data);
                break;

            //Si es creación de un producto de cliente
            case 'cliente_producto':
                //Se recibe el código del departamento por post
                $this->data['id_asociado'] = $this->input->post('id_asociado');
                
                //Cargamos la vista
                $this->load->view('cliente/detalle/producto_view', $this->data);
                break;

            //Si es creación de un comentario de cliente
            case 'cliente_comentario':
                //Se recibe el código del departamento por post
                $this->data['id_asociado'] = $this->input->post('id_asociado');
                
                //Cargamos la vista
                $this->load->view('cliente/detalle/comentario_view', $this->data);
                break;

            //Si es ciudad
            case 'ciudad':
                //Se recibe el código del departamento por post
                $this->data['codigo_departamento'] = $this->input->post('codigo_departamento');

                //Cargamos la vista
                $this->load->view('listas/regiones/ciudades_view', $this->data);
                break;

            //Si es búsqueda por cédula
            case 'crm_cedula':
                //Cargamos la vista
                $this->load->view('crm/buscar_cedula_view', $this->data);
                break;

            //Si es búsqueda por nombres
            case 'crm_nombres':
                //Cargamos la vista
                $this->load->view('crm/buscar_nombre_view', $this->data);
                break;

            //Si es búsqueda por producto
            case 'crm_producto':
                //Cargamos la vista
                $this->load->view('crm/buscar_producto_view', $this->data);
                break;

            //Si es filtros
            case 'crm_filtro':
                //Se recibe la tabla por post
                //$this->data['asociados'] = $this->input->post('asociados');

                //Cargamos la vista
                $this->load->view('crm/filtros_view', $this->data);
                break;

            //Si es tabla de productos
            case 'crm_tabla_productos':
                //Se recibe la tabla por post
                $this->data['documento'] = $this->input->post('documento');
                $this->data['asociado'] = $this->input->post('asociado');
                $this->data['encontrado'] = $this->input->post('encontrado');

                //Cargamos la vista
                $this->load->view('crm/tabla_productos_view', $this->data);
                break;

            //Si es tabla de asociados
            case 'crm_tabla_asociados':
                // Variable de producto
                $this->data['producto'] = $this->input->post('producto');
                $this->data['id_producto'] = $this->input->post('id_producto');

                //Cargamos la vista
                $this->load->view('crm/tabla_asociados_view', $this->data);
                break;

            //Si es tabla de asociados
            case 'crm_tabla_asociados_productos':
                // Variables
                $this->data['id_filtro'] = $this->input->post('id_filtro');
                $this->data['id_oficina'] = $this->input->post('id_oficina');
                $this->data['anio'] = $this->input->post('anio');

                //Cargamos la vista
                $this->load->view('crm/tabla_asociados_productos_view', $this->data);
                break;

            //Si es tabla de nombres
            case 'crm_tabla_nombres':
                // Variable de producto
                $this->data['nombre'] = $this->input->post('nombre');

                //Cargamos la vista
                $this->load->view('crm/tabla_nombres_view', $this->data);
                break;

            //Si es departamento
            case 'departamento':
                //Se recibe el código del país por post
                $this->data['codigo_pais'] = $this->input->post('codigo_pais');

                //Cargamos la vista
                $this->load->view('listas/regiones/departamentos_view', $this->data);
                break;

            //Si es empresa u oficina
            case 'empresa_oficina':
                //Se recibe la variable que define si es empresa u oficina por post
                $this->data['empresa'] = $this->input->post('empresa');

                //Cargamos la vista
                $this->load->view('listas/empresa_oficina_view', $this->data);
                break;

            //Si es filtro asociados
            case 'filtro_asociados':
                //Cargamos la vista
                $this->load->view('filtros/asociados/index');
            break;

            //Si es filtro asociados
            case 'filtro_asociados_crear':
                // Se recibe por post la variable que define si es un registro nuevo o editado
                $this->data["id"] = $this->input->post("id");
            
                //Cargamos la vista
                $this->load->view('filtros/asociados/crear', $this->data);
            break;

            //Si es tabla de filstros de asociados (1: asociados)
            case 'filtros_asociados_lista':
                // Se cargan los filtros
                $this->data['filtros'] = $this->filtro_model->cargar_filtros_asociados('1');

                //Cargamos la vista
                $this->load->view('filtros/asociados/listar', $this->data);
            break;

            // Daros básicos (para filtros de asociados y productos)
            case 'filtro_datos_basicos':
                // Se cargan los filtros
                $this->data['filtros'] = $this->filtro_model->cargar_filtros_asociados('1');
                $this->data['id'] = $this->input->post('id');
                
                //Cargamos la vista
                $this->load->view('filtros/datos_basicos', $this->data);
            break;

                // //Si es tabla de filtros de productos
                // case 'tabla_filtros_productos':
                //     // Se cargan los filtros de productos (0: no asociados)
                //     $this->data['filtros'] = $this->filtro_model->cargar_filtros_productos();

                //     //Cargamos la vista
                //     $this->load->view('filtros/productos/tabla_view', $this->data);
                //     break;

            //Si es filtro de productos
            case 'filtro_productos':
                //Cargamos la vista
                $this->load->view('filtros/productos/index');
                break;

            //Si es filtro de productos
            case 'filtro_productos_crear':
                // Se recibe por post la variable que define si es un registro nuevo o editado
                $this->data["id"] = $this->input->post("id");
            
                //Cargamos la vista
                $this->load->view('filtros/productos/crear', $this->data);
            break;

            //Si es tabla de filstros de productos
            case 'filtros_productos_lista':
                // Se cargan los filtros
                $this->data['filtros'] = $this->filtro_model->cargar_filtros_productos();

                //Cargamos la vista
                $this->load->view('filtros/productos/listar', $this->data);
            break;

            //Si es actualización de registros
            case 'importacion_actualizacion':
                //Cargamos la vista con los datos
                $this->load->view('importacion/actualizacion_view');
                break;

            //Si es eliminación de registros
            case 'importacion_eliminacion':
                //Cargamos la vista con los datos
                $this->load->view('importacion/eliminacion_view');
                break;

            //Si es importación de registros nuevos
            case 'importacion_insercion':
                //Cargamos la vista con los datos
                $this->load->view('importacion/insercion_view');
                break;

            //Si es lista
            case 'lista':
                //Cargamos la vista
                $this->load->view('listas/listas_desplegables/index_view');
                break;

            //Si es region
            case 'lista_desplegable':
                //Se recibe la tabla por post
                $this->data['tabla'] = $this->input->post('tabla');

                //Cargamos la vista
                $this->load->view('listas/listas_desplegables/listas_view', $this->data);
                break;

            //Si es oportunidad
            case 'oportunidad':
                //Cargamos la vista
                $this->load->view('listas/oportunidad_view');
                break;

            //Si es país
            case 'pais':
                //Cargamos la vista
                $this->load->view('listas/regiones/paises_view');
                break;

            //Si es producto
            case 'producto':
                //Cargamos la vista
                $this->load->view('listas/producto_view');
                break;

            //Si es preguntas
            case 'preguntas':
                //Cargamos la vista
                $this->load->view('listas/preguntas/index');
                break;

            //Si es creación de pregunta
            case 'preguntas_crear':
                // Se recibe por post la variable que define si es un registro nuevo o editado
                $this->data["id"] = $this->input->post("id");
            
                //Cargamos la vista
                $this->load->view('listas/preguntas/crear', $this->data);
            break;

            //Si es preguntas
            case 'preguntas_lista':
                //Cargamos la vista
                $this->load->view('listas/preguntas/listar');
                break;

            //Si es proveedor
            case 'proveedor':
                //Cargamos la vista
                $this->load->view('listas/proveedor_view');
                break;

            //Si es region
            case 'region':
                //Cargamos la vista
                $this->load->view('listas/regiones/index_view');
                break;

            //Si es reporte de campaña
            case 'reporte_campana_listado':
                //Cargamos la vista
                $this->load->view('reporte/campana/listado');
                break;

            //Si es tabla
            case 'tabla':
                //Se recibe la tabla por post
                $this->data['id_filtro'] = $this->input->post('id_filtro');

                //Cargamos la vista
                $this->load->view('crm/tabla_view', $this->data);
                break;

            //Si es campaña
            case 'transferencia_vista':
                //Cargamos la vista
                $this->load->view('transferencia/transferencia_view');
                break;

            //Si es usuario
            case 'usuario':
                //Cargamos la vista
                $this->load->view('listas/usuarios_view');
                break;

            //Si es usuario
            case 'usuario_modificar':
                $this->data['id_usuario'] = $this->input->post('id_usuario');
                //Cargamos la vista
                $this->load->view('inicio/modificar_usuario_view', $this->data);
                break;
        }
    }

    function cargar_producto(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se retorna el resultado de la inserción 
            print json_encode($this->listas_model->cargar_producto($this->input->post('id_producto')));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }
    
    function guardar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe el arreglo de datos que viene por POST
            $datos = $this->input->post('datos');
            $tabla = $this->input->post('tabla');

            //Se retorna el resultado de la inserción 
            echo $guardar = $this->listas_model->guardar($datos, $tabla);
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function actualizar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe el arreglo de datos que viene por POST
            $datos = $this->input->post('datos');
            $tabla = $this->input->post('tabla');
            $campo = $this->input->post('campo');
            $id_campo = $this->input->post('id_campo');

            //Se retorna el resultado de la inserción 
            echo $guardar = $this->listas_model->actualizar($datos, $tabla, $campo, $id_campo);
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function subir(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Almacenamos la ruta de los logos
            $ruta_logos = base_url()."img/logos/";
            echo $ruta_logos;
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }
}
/* Fin del archivo listas.php */
/* Ubicación: ./application/controllers/listas.php */