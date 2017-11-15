<?php
/**
 * Modelo encargado de gestionar toda la informacion que pueda ser usada en
 * cualquier parte de la aplicación
 * 
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
Class Listas_model extends CI_Model{
    function cargar($tabla){
        //Columnas a retornar
        $this->db->select('*');
        $this->db->order_by('strNombre');
        $this->db->where('Estado', '1');

        if ($this->session->userdata("tipo") != 3 & $tabla == "tipo_usuario") {
            $this->db->where('Privilegio_Superadministrador', 1);
        }
        
        //Se ejecuta y retorna la consulta
        return $this->db->get($tabla)->result();
    }

    function cargar_activos($tabla){
		//Columnas a retornar
        $this->db->where('Estado', '1');
        $this->db->select('*');
        $this->db->order_by('strNombre');
        
        //Se ejecuta y retorna la consulta
        return $this->db->get($tabla)->result();
	}

    function cargar_campana($id_campana){
        //Columnas a retornar
        $this->db->select('*');
        $this->db->where('intCodigo', $id_campana);
        
        //Se ejecuta y retorna la consulta
        return $this->db->get('campanas')->row();
    }

    function cargar_campana_cliente($id_campana_cliente){
        //Columnas a retornar
        $this->db->select('*');
        $this->db->where('intCodigo', $id_campana_cliente);
        
        //Se ejecuta y retorna la consulta
        return $this->db->get('clientes_campanas')->row();
    }

    function cargar_comentario_cliente($id_comentario_cliente){
        //Columnas a retornar
        $this->db->select('*');
        $this->db->where('intCodigo', $id_comentario_cliente);
        
        //Se ejecuta y retorna la consulta
        return $this->db->get('cliente_comentarios')->row();
    }

    function cargar_oportunidad_cliente($id_oportunidad_cliente){
        //Columnas a retornar
        $this->db->select('*');
        $this->db->where('intCodigo', $id_oportunidad_cliente);
        
        //Se ejecuta y retorna la consulta
        return $this->db->get('oportunidad_x_cliente')->row();
    }

    function cargar_campana_empresa(){
        //Columnas a retornar
        $sql =
        "SELECT
        campanas.intCodigo,
        campanas.strNombre
        FROM
        campanas
        WHERE
        campanas.id_empresa = '{$this->session->userdata('id_empresa')}'
        ORDER BY campanas.strNombre";
        
        //Se ejecuta y retorna la consulta
        return $this->db->query($sql)->result();
    }

    function cargar_campanas($id_empresa){
        //Columnas a retornar
        $this->db->where('id_empresa', $id_empresa);
        $this->db->select('*');
        $this->db->order_by('strNombre');
        
        //Se ejecuta y retorna la consulta
        return $this->db->get('campanas')->result();
    }

    function cargar_campanas_activas(){
        $sql =
        "SELECT
        campanas.intCodigo,
        campanas.strNombre
        FROM
        campanas
        WHERE
        campanas.fecha_finaliza >= CURDATE()
        AND campanas.id_empresa = '{$this->session->userdata('id_empresa')}'
        ORDER BY strNombre";

        return $this->db->query($sql)->result();
    }

    function cargar_datos_usuario($id_usuario){
         //Columnas a retornar
         $this->db->select('*');
         $this->db->where('intCodigo', $id_usuario);


        //Se ejecuta y retorna la consulta
        return $this->db->get('usuarios_sistema')->row();
    }

    function cargar_empresa($tabla, $id_empresa){
        //Columnas a retornar
        $this->db->where('id_empresa', $id_empresa);
        $this->db->select('*');
        $this->db->order_by('strNombre');
        
        //Se ejecuta y retorna la consulta
        return $this->db->get($tabla)->result();
    }

    function cargar_empresas_usuarias(){
        //Columnas a retornar
        $this->db->select('*');
        $this->db->order_by('strNombre');
        
        //Se ejecuta y retorna la consulta
        return $this->db->get('empresas_usuarias')->result();
    }

    function cargar_campos_asociados(){
        //Columnas a retornar
        $this->db->select('*');
        $this->db->order_by('strNombre');
        $this->db->where('Aplica_Filtro_Asociado', '1');

        //Se ejecuta y retorna la consulta
        return $this->db->get('filtro_campos')->result();
    }

	function cargar_paises(){
        //Columnas a retornar
        $this->db->select('*');
        $this->db->order_by('strNombre');
        $this->db->where('strTipo', 'P');

        // Si no es administrador, se ocultan los inactivos
        if ($this->session->userdata('tipo') != "3") {
            $this->db->where('Estado', '1');
        }

        //Se ejecuta y retorna la consulta
        return $this->db->get('regiones')->result();
	}

    function cargar_departamentos($codigo_pais){
        $codigo_paisc= substr($codigo_pais, 0, 4);
        $activos = "";

        // Si no es administrador, se ocultan los inactivos
        if ($this->session->userdata('tipo') != "3") {
            $activos = " AND regiones.Estado = '1' ";
        }

        // Consulta SQL
        $sql =
        "SELECT
            *
        FROM
            regiones
        WHERE
            regiones.strTipo = 'D' AND
            regiones.strCodigo LIKE '{$codigo_paisc}%'
            {$activos}
        ORDER BY
            regiones.strNombre ASC";

        // Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }

    function cargar_ciudades($codigo_departamento){
        $codigo_departamentoc= substr($codigo_departamento, 0, 6);
        $activos = "";

        // Si no es administrador, se ocultan los inactivos
        if ($this->session->userdata('tipo') != "3") {
            $activos = " AND regiones.Estado = '1' ";
        }

        // Consulta SQL
        $sql =
        "SELECT
            *
        FROM
            regiones
        WHERE
            regiones.strTipo = 'C' AND
            regiones.strCodigo LIKE '{$codigo_departamentoc}%'
            {$activos}
        ORDER BY
            regiones.strNombre ASC";

        // Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }

    function cargar_barrios($codigo_ciudad){
        $codigo_ciudadc= substr($codigo_ciudad, 0, 9);
        $activos = "";

        // Si no es administrador, se ocultan los inactivos
        if ($this->session->userdata('tipo') != "3") {
            $activos = " AND regiones.Estado = '1' ";
        }

        // Consulta SQL
        $sql =
        "SELECT
            *
        FROM
            regiones
        WHERE
            regiones.strTipo = 'B' AND
            regiones.strCodigo LIKE '{$codigo_ciudadc}%'
            {$activos}
        ORDER BY
            regiones.strNombre ASC";

        // Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }

    function cargar_productos(){
        $sql =
        "SELECT
            pr.intCodigo,
            pr.strNombre,
            pr.valor,
            pr.id_proveedor,
            pr.Tipo,
            pr.id_linea,
            pr.id_categoria,
            pr.Estado,
            pr.id_empresa,
            p.strNombre AS Proveedor,
            pr.transferencia AS Transferencia,
            c.strNombre AS Categoria,
            l.strNombre AS Linea
        FROM
            productos AS pr
        LEFT JOIN proveedores AS p ON pr.id_proveedor = p.intCodigo
        LEFT JOIN productos_categorias AS c ON pr.id_categoria = c.intCodigo
        LEFT JOIN productos_lineas AS l ON pr.id_linea = l.intCodigo
        WHERE
            pr.id_empresa = {$this->session->userdata('id_empresa')}
        ORDER BY
            strNombre ASC";

        // Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }

    function cargar_producto($id_producto){
        $this->db->select('*');
        $this->db->where('intCodigo', $id_producto);
        return $this->db->get('productos')->row();
    }

    function cargar_productos_categorias($id_empresa){
        $sql =
        "SELECT
            c.intCodigo,
            c.strNombre
        FROM
            productos_categorias AS c
        INNER JOIN productos AS p ON p.id_categoria = c.intCodigo
        WHERE
            p.id_empresa = $id_empresa
        GROUP BY
            p.id_categoria
        ORDER BY
            c.strNombre ASC";

        return $this->db->query($sql)->result();
    }

    function cargar_periodicidades(){
        $this->db->order_by('strNombre');
        return $this->db->get('periodicidades')->result();
    }

    function cargar_proveedores(){
        $sql =
        "SELECT
        *
        FROM
        proveedores
        WHERE
        proveedores.id_empresa = '{$this->session->userdata('id_empresa')}'
        ORDER BY strNombre ASC";
        
        //Se ejecuta y retorna la consulta
        return $this->db->query($sql)->result();
    }

    function cargar_destinatarios($id_producto)
    {
        $sql =
        "SELECT
            cp.CorreoElectronico,
            cp.Nombre,
            cp.PrimerApellido,
            cp.SegundoApellido
        FROM
            clientes_productos AS cp
        WHERE
            cp.id_empresa = {$this->session->userdata('id_empresa')}
        AND cp.fecha_final >= '".date('Y-m-d')."'
        AND cp.CorreoElectronico <> ''
        AND cp.id_producto = {$id_producto}
        GROUP BY
            cp.CorreoElectronico";

        return $this->db->query($sql)->result();
    } // cargar_destinatarios

    function cargar_encuestas(){
        $sql = 
        "SELECT
            encuestas.intCodigo,
            encuestas.Estado,
            preguntas.descripcion AS pregunta,
            productos.strNombre AS producto,
            periodicidades.strNombre AS periodicidad
        FROM
            encuestas
        LEFT JOIN productos ON encuestas.id_producto = productos.intCodigo
        LEFT JOIN preguntas ON encuestas.id_pregunta = preguntas.intCodigo
        LEFT JOIN periodicidades ON encuestas.id_periodicidad = periodicidades.intCodigo
        WHERE
            encuestas.id_empresa = {$this->session->userdata('id_empresa')}";

        return $this->db->query($sql)->result();
    }

    function cargar_encuesta($id){
        $this->db->where('intCodigo', $id);
        return $this->db->get('encuestas')->row();
    }

    function cargar_pregunta($id){
        $this->db->where('intCodigo', $id);
        return $this->db->get('preguntas')->row();
    }

    function cargar_preguntas(){
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->order_by('descripcion');
        return $this->db->get('preguntas')->result();
    }

    function cargar_usuarios_sistema(){
        $sql =
        "SELECT
        usuarios_sistema.intCodigo,
        usuarios_sistema.strNombre
        FROM
        usuarios_sistema
        WHERE
        usuarios_sistema.id_empresa = '{$this->session->userdata('id_empresa')}'
        ORDER BY strNombre ASC";
        
        //Se ejecuta y retorna la consulta
        return $this->db->query($sql)->result();
    }

    function guardar($datos, $tabla){
        //Se ejecuta el modelo que guarda los datos
        $guardar = $this->db->insert($tabla, $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return mysql_insert_id();
        }else{
            //Retorna falso
            return false;
        }
    }

    function actualizar($datos, $tabla, $campo, $id_campo){
        //Se ejecuta el modelo que guarda los datos
        $this->db->where($campo, $id_campo);
        $guardar = $this->db->update($tabla, $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    }

    //No utilizada aun
    function listar_campos($tabla){
        // Consulta SQL
        $sql = 
        "SELECT /*SO.NAME,*/ SC.NAME as Nombre
        FROM sys.objects SO INNER JOIN sys.columns SC
        ON SO.OBJECT_ID = SC.OBJECT_ID
        WHERE SO.TYPE = 'U' AND SO.NAME = '{$tabla}'
        ORDER BY SC.NAME";

        // Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }

    function listar_dias(){
        //Se crea un arreglo
        $dias = array();

        for ($dia = 1; $dia < 32; $dia++) { 
            array_push($dias, str_pad($dia, 2 , "0", STR_PAD_LEFT));
        }//Fin for

        //Se retorna el arreglo
        return $dias;
    }//Fin listar_dias

    function listar_horas(){
        //Se crea un arreglo
        $horas = array();

        for ($hora = 0; $hora < 24; $hora++) { 
            array_push($horas, str_pad($hora, 2 , "0", STR_PAD_LEFT));
        }//Fin for

        //Se retorna el arreglo
        return $horas;
    }//Fin listar_horas

    /**
     * Lista los meses del año
     * @return [array] [meses con número y nombre, además del número de columna
     * para efectos del reporte]
     */
    function listar_meses(){
        //Se crea un arreglo de dos dimensiones con la informacion de cada mes
        $meses = array(
            array('Numero' => "01", 'Nombre' => 'Enero', 'Columna' => 'B'),
            array('Numero' => "02", 'Nombre' => 'Febrero', 'Columna' => 'C'),
            array('Numero' => "03", 'Nombre' => 'Marzo', 'Columna' => 'D'),
            array('Numero' => "04", 'Nombre' => 'Abril', 'Columna' => 'E'),
            array('Numero' => "05", 'Nombre' => 'Mayo', 'Columna' => 'F'),
            array('Numero' => "06", 'Nombre' => 'Junio', 'Columna' => 'G'),
            array('Numero' => "07", 'Nombre' => 'Julio', 'Columna' => 'H'),
            array('Numero' => "08", 'Nombre' => 'Agosto','Columna' => 'I'),
            array('Numero' => "09", 'Nombre' => 'Septiembre', 'Columna' => 'J'),
            array('Numero' => "10", 'Nombre' => 'Octubre', 'Columna' => 'K'),
            array('Numero' => "11", 'Nombre' => 'Noviembre', 'Columna' => 'L'),
            array('Numero' => "12", 'Nombre' => 'Diciembre', 'Columna' => 'M')
        );

        //Se retorna el arreglo
        return $meses;
    }//Fin listar_meses


    function listar_anios(){
        //Se crea un arreglo
        $anios = array();

        //Se declaran los rangos de años
        $anio_actual = date ("Y") + 10;
        $anio_inicial = $anio_actual - 100;
        

        //Recorrido por años
        for ($anio = $anio_inicial; $anio < $anio_actual; $anio++) { 
            //Se agrega el año al arreglo
            array_push($anios, $anio);
        }//Fin for

        //Se retorna el arreglo
        return $anios;

        //Se crea un array con los años
        $anios = array( '2010', '2011', '2012', '2013', '2014');

        //Se retorna el array
        return $anios;
    }

    function obtener_nombre_oficina($id_oficina){
        $this->db->select('strNombre');
        $this->db->where('intCodigo', $id_oficina);
        return $this->db->get('din_agencias')->row()->strNombre;

    }

    function obtener_nombre_campo($tabla, $id){
        //Columna a retornar
        $this->db->select('strNombre');
        
        //Condición de id
        $this->db->where('intCodigo', $id);
        
        //Se ejecuta  
        $resultado = $this->db->get($tabla)->row();
        
        //Se retorna el nombre del campo
        return $resultado->strNombre;
    }
}
/* Fin del archivo listas_model.php */
/* Ubicación: ./application/models/listas_model.php */