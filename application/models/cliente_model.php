<?php
/**
 * Modelo encargado de gestionar toda la informacion relacionada al cliente
 *
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
Class Cliente_model extends CI_Model{
    /**
     * [actualizar description]
     * @param  [type] $datos       [description]
     * @param  [type] $id_asociado [description]
     * @return [type]              [description]
     */
    function actualizar($datos, $id_asociado){
        $this->db->where('id_Asociado', $id_asociado);
        if($this->db->update('asociados', $datos)){
            //Retorna verdadero
            return true;
        } // if
    } // actualizar

    /**
     * [actualizar_datos_cliente_producto description]
     * @param  [type] $id_asociado [description]
     * @param  [type] $datos       [description]
     * @return [type]              [description]
     */
    function actualizar_datos_cliente_producto($id_asociado, $datos){
        $this->db->where('id_cliente', $id_asociado);
        if($this->db->update('clientes_productos', $datos)){
            //Retorna verdadero
            return true;
        }
    }// actualizar_datos_cliente_producto

    /**
     * [actualizar_campana description]
     * @param  [type] $id_campana [description]
     * @param  [type] $datos       [description]
     * @return [type]              [description]
     */
    function actualizar_campana($id_campana, $datos){
        $this->db->where('intCodigo', $id_campana);
        if($this->db->update('clientes_campanas', $datos)){
            //Retorna verdadero
            return true;
        }
    }// actualizar_campana

    /**
     * [actualizar_oportunidad description]
     * @param  [type] $id_oportunidad [description]
     * @param  [type] $datos       [description]
     * @return [type]              [description]
     */
    function actualizar_oportunidad($id_oportunidad, $datos){
        $this->db->where('intCodigo', $id_oportunidad);
        if($this->db->update('oportunidad_x_cliente', $datos)){
            //Retorna verdadero
            return true;
        }
    }// actualizar_oportunidad

    /**
     * [actualizar_comentario description]
     * @param  [type] $id_campana [description]
     * @param  [type] $datos       [description]
     * @return [type]              [description]
     */
    function actualizar_comentario($id_comentario, $datos){
        $this->db->where('intCodigo', $id_comentario);
        if($this->db->update('cliente_comentarios', $datos)){
            //Retorna verdadero
            return true;
        }
    }// actualizar_comentario

    /**
     * [actualizar_usuario_sistema description]
     * @param  [type] $id_usuario [description]
     * @param  [type] $datos      [description]
     * @return [type]             [description]
     */
    function actualizar_usuario_sistema($id_usuario, $datos){
        $this->db->where('intCodigo', $id_usuario);
        if($this->db->update('usuarios_sistema', $datos)){
            //Retorna verdadero
            return true;
        }
    } // actualizar_usuario_sistema

    /**
     * [borrar description]
     * @param  [type] $tipo        [description]
     * @param  [type] $id_asociado [description]
     * @return [type]              [description]
     */
    function borrar($tipo, $id_asociado){
        switch ($tipo) {
            case 'actualizacion_campos_empresa':
                //Si se borran los campos de esa empresa
                if($this->db->delete('actualizacion_campos_empresa', array('id_empresa' => $id_asociado))){
                    //Se retorna true
                    return true;
                }
                break;
            case 'beneficiarios':
                //Si se borran los beneficiarios asociados al usuario
                if($this->db->delete('asociados_beneficiarios', array('id_Asociado' => $id_asociado))){
                    //Se retorna true
                    return true;
                }
                break;

            case 'campana':
                //Si se borran las campañas asociadas al usuario
                if($this->db->delete('clientes_campanas', array('intCodigo' => $id_asociado))){
                    //Se retorna true
                    return true;
                }
                break;

            case 'cargos':
                //Si se borran los cargos asociados al usuario
                if($this->db->delete('asociados_cargos', array('id_Asociado' => $id_asociado))){
                    //Se retorna true
                    return true;
                }
                break;

            case 'conocidos':
                //Si se borran los conocidos asociados al usuario
                if($this->db->delete('asociados_conocidos', array('id_Asociado' => $id_asociado))){
                    //Se retorna true
                    return true;
                }
                break;

            case 'comentario':
                //Si se borran el comentario
                if($this->db->delete('cliente_comentarios', array('intCodigo' => $id_asociado))){
                    //Se retorna true
                    return true;
                }
                break;

            case 'gustos':
                //Si se borran los gustos asociados al usuario
                if($this->db->delete('asociados_gustos', array('int_IdAsociado' => $id_asociado))){
                    //Se retorna true
                    return true;
                }
                break;

            case 'hijos':
                //Si se borran los gustos asociados al usuario
                if($this->db->delete('asociados_hijos', array('id_Asociado' => $id_asociado))){
                    //Se retorna true
                    return true;
                }
                break;

            case 'oportunidad':
                //Si se borran el comentario
                if($this->db->delete('oportunidad_x_cliente', array('intCodigo' => $id_asociado))){
                    //Se retorna true
                    return true;
                }
                break;

            case 'producto':
                //Si se borran el comentario
                if($this->db->delete('clientes_productos', array('intCodigo' => $id_asociado))){
                    //Se retorna true
                    return true;
                }
                break;
        }
    } // borrar

    /**
     * [buscar description]
     * @param  [type] $documento [description]
     * @return [type]            [description]
     */
    function buscar($documento, $id_empresa){
        $sql =
        "SELECT
        *
        FROM
        asociados
        WHERE Identificacion = '{$documento}'
        AND id_Empresa = '{$id_empresa}'";

        $resultado = $this->db->query($sql)->row();

        if(count($resultado) < 1){
            $documento = str_pad($documento, 12 , "0", STR_PAD_LEFT);

            $sql =
            "SELECT
            *
            FROM
            asociados
            WHERE Identificacion = '{$documento}'
            AND id_Empresa = '{$id_empresa}'";

            $resultado = $this->db->query($sql)->row();
        }

        return $resultado;
    } // buscar

    /**
     * [buscar_nombre description]
     * @param  [type] $nombre [description]
     * @return [type]         [description]
     */
    function buscar_nombre($nombre){
        $sql =
        "SELECT
        Identificacion,
        Nombre,
        PrimerApellido,
        SegundoApellido,
        Celular_cliente,
        CorreoElectronico,
        TelefonoCasa,
        TelefonoOficina
        FROM
            asociados
        WHERE
            CONCAT(
                Nombre,
                PrimerApellido,
                SegundoApellido
            ) LIKE '%{$nombre}%'
        AND id_Empresa = '{$this->session->userdata('id_empresa')}'";

        return $this->db->query($sql)->result();
    } //buscar_nombre

    /**
     * [cargar_asociado description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    function cargar_asociado($id){
        $this->db->where('id_Asociado', $id);
        $this->db->select('*');

        return $this->db->get('asociados')->row();
    }// cargar_asociado

    /**
     * Carga de asociados que tienen clave configurada
     */
    function cargar_asociados_con_clave(){
        $idEmpresa = $this->session->userdata('id_empresa');
        $this->db->select('Nombre, PrimerApellido, SegundoApellido, Fecha_Cambio_Clave');
        $this->db->from('asociados');
        $this->db->where('Clave_Transferencia IS NOT NULL');
        $this->db->where('Clave_Transferencia !=', "");
        $this->db->where('id_Empresa', $idEmpresa);
        return $this->db->get()->result();
    } //cargar_hijos

    /**
     * [cargar_beneficiarios description]
     * @param  [type] $id_asociado [description]
     * @return [type]              [description]
     */
    function cargar_beneficiarios($id_asociado){
        $this->db->select('*');
        $this->db->where('id_Asociado', $id_asociado);

        return $this->db->get('asociados_beneficiarios')->result();
    } //cargar_beneficiarios

    /**
     * [cargar_campanas_cliente description]
     * @param  [type] $documento [description]
     * @return [type]            [description]
     */
    function cargar_campanas_cliente($documento){
        $activos = "";

        // Si el usuario es administrador
        if ($this->session->userdata('tipo') != '3') {
            $activos = " AND clientes_campanas.fecha_final >= CURDATE() ";
        }

        $sql =
        "SELECT
            clientes_campanas.intCodigo,
            campanas.strNombre AS Campana,
            clientes_campanas.fecha_inicial,
            clientes_campanas.fecha_final,
            usuarios_sistema.strNombre AS Usuario
        FROM
            clientes_campanas
            INNER JOIN campanas ON clientes_campanas.id_campana = campanas.intCodigo
            INNER JOIN usuarios_sistema ON clientes_campanas.id_usuario_creador = usuarios_sistema.intCodigo
        WHERE
            clientes_campanas.id_cliente = '{$documento}'
            AND clientes_campanas.id_empresa = '{$this->session->userdata('id_empresa')}'
            {$activos}";

        return $this->db->query($sql)->result();
    } // cargar_campanas_cliente

    /**
     * [cargar_cargos description]
     * @param  [type] $id_asociado [description]
     * @return [type]              [description]
     */
    function cargar_cargos($id_asociado){
        $this->db->where('id_Asociado', $id_asociado);
        $this->db->select('*');

        return $this->db->get('asociados_cargos')->result();
    } // cargar_cargos

    /**
     * [cargar_comentarios description]
     * @param  [type] $id_asociado [description]
     * @return [type]              [description]
     */
    function cargar_comentarios($id_asociado){
        $sql =
        "SELECT
        cliente_comentarios.intCodigo,
        cliente_comentarios.id_empresa,
        cliente_comentarios.id_cliente,
        cliente_comentarios.comentario AS Comentario,
        cliente_comentarios.fecha,
        campanas.strNombre AS Campana,
        usuarios_sistema.strNombre AS Usuario
        FROM
        cliente_comentarios
        LEFT JOIN campanas ON cliente_comentarios.id_campana = campanas.intCodigo
        INNER JOIN usuarios_sistema ON cliente_comentarios.id_usuario_creador = usuarios_sistema.intCodigo
        WHERE
        cliente_comentarios.id_empresa = {$this->session->userdata('id_empresa')} AND
        cliente_comentarios.id_cliente = '{$id_asociado}'";

        return $this->db->query($sql)->result();
    } // cargar_comentarios

    /**
     * [cargar_conocidos description]
     * @param  [type] $id_asociado [description]
     * @return [type]              [description]
     */
    function cargar_conocidos($id_asociado){
        $this->db->select('*');
        $this->db->where('id_Asociado', $id_asociado);

        return $this->db->get('asociados_conocidos')->result();
    } // cargar_conocidos

    /**
     * [cargar_datos_cliente_producto description]
     * @param  [type] $id_cliente [description]
     * @return [type]             [description]
     */
    function cargar_datos_cliente_producto($id_cliente){
        $sql =
        "SELECT
            Nombre,
            Celular_cliente,
            PrimerApellido,
            SegundoApellido,
            CorreoElectronico,
            TelefonoCasa,
            TelefonoOficina,
            id_Genero_cliente
        FROM
            asociados
        WHERE Identificacion = {$id_cliente}";

        return $this->db->query($sql)->row();
    } //cargar_datos_cliente_producto

    /**
     * [cargar_gustos description]
     * @param  [type] $id_asociado [description]
     * @return [type]              [description]
     */
    function cargar_gustos($id_asociado){
        $this->db->select('int_IdGusto');
        $this->db->where('int_IdAsociado', $id_asociado);

        return $this->db->get('asociados_gustos')->result();
    } //cargar_gustos

    /**
     * [cargar_hijos description]
     * @param  [type] $id_asociado [description]
     * @return [type]              [description]
     */
    function cargar_hijos($id_asociado){
        $this->db->select('*');
        $this->db->where('id_Asociado', $id_asociado);

        return $this->db->get('asociados_hijos')->result();
    } //cargar_hijos

    /**
     * [cargar_oportunidades_cliente description]
     * @param  [type] $documento [description]
     * @return [type]            [description]
     */
    function cargar_oportunidades_cliente($documento){
        $activos = "";

        // Si el usuario es administrador
        if ($this->session->userdata('tipo') != '3') {
            // $activos = " AND oportunidad_x_cliente.fecha_final >= CURDATE() ";
        }

        $sql =
        "SELECT
        oportunidad_x_cliente.intCodigo,
        productos.strNombre AS Producto,
        oportunidad_estados.strNombre AS Estado,
        oportunidad_fases.strNombre AS Fase,
        oportunidad_x_cliente.fecha_inicial,
        oportunidad_x_cliente.fecha_final,
        oportunidad_x_cliente.id_empresa,
        oportunidad_x_cliente.valor_estimado,
        campanas.strNombre AS Campana,
        din_agencias.strNombre AS Oficina,
        usuarios_sistema.strNombre AS Usuario
        FROM
        oportunidad_x_cliente
        LEFT JOIN productos ON oportunidad_x_cliente.id_producto = productos.intCodigo
        LEFT JOIN oportunidad_estados ON oportunidad_estados.intCodigo = oportunidad_x_cliente.id_estado_oportunidad
        LEFT JOIN oportunidad_fases ON oportunidad_x_cliente.id_fase = oportunidad_fases.intCodigo
        LEFT JOIN campanas ON oportunidad_x_cliente.id_campana = campanas.intCodigo
        LEFT JOIN din_agencias ON oportunidad_x_cliente.id_oficina = din_agencias.intCodigo
        LEFT JOIN usuarios_sistema ON oportunidad_x_cliente.id_usuario_creador = usuarios_sistema.intCodigo
        WHERE
        oportunidad_x_cliente.id_cliente = '{$documento}'
        AND usuarios_sistema.id_empresa = '{$this->session->userdata('id_empresa')}'
        {$activos}";

        return $this->db->query($sql)->result();
    } // cargar_oportunidades_cliente

    /**
     * [cargar_productos_cliente description]
     * @param  [type] $documento [description]
     * @return [type]            [description]
     */
    function cargar_productos_cliente($documento){
        $activos = "";

        // Si el usuario es administrador
        if ($this->session->userdata('tipo') != '3') {
            // $activos = " AND clientes_productos.fecha_final >= CURDATE() ";
            $activos = "  ";
        }

        $sql =
        "SELECT
        clientes_productos.intCodigo,
        productos.strNombre AS Producto,
        clientes_productos.cantidad,
        clientes_productos.valor,
        clientes_productos.transferencia,
        clientes_productos.fecha_inicial,
        clientes_productos.fecha_final,
        campanas.strNombre AS Campana,
        din_agencias.strNombre AS Oficina,
        usuarios_sistema.strNombre AS Usuario
        FROM
        clientes_productos
        LEFT JOIN productos ON clientes_productos.id_producto = productos.intCodigo
        LEFT JOIN din_agencias ON clientes_productos.id_agencia = din_agencias.intCodigo
        LEFT JOIN usuarios_sistema ON clientes_productos.id_usuario_creador = usuarios_sistema.intCodigo
        LEFT JOIN campanas ON clientes_productos.id_campana = campanas.intCodigo
        WHERE
        clientes_productos.id_cliente = '{$documento}'
        AND clientes_productos.id_empresa = '{$this->session->userdata('id_empresa')}'
        {$activos}";

        return $this->db->query($sql)->result();
    } // cargar_productos_cliente

    /**
     * [cargar_productos_matriculados description]
     * @param  [type] $id_asociado [description]
     * @return [type]              [description]
     */
    function cargar_productos_matriculados($id_asociado){
        $this->db->select('*');
        $this->db->where('id_Asociado', $id_asociado);

        return $this->db->get('asociados_beneficiarios')->result();
    } //cargar_productos_matriculados

    /**
     * [consultar_habilidad description]
     * @param  [type] $numero          [description]
     * @param  [type] $id_asociado     [description]
     * @param  [type] $fecha_inicio    [description]
     * @param  [type] $valor_adicional [description]
     * @return [type]                  [description]
     */
    function consultar_habilidad($numero, $id_asociado, $fecha_inicio, $valor_adicional){
        // Año anterior
        $anio = date("Y")-1;
        $anio_actual = date("Y");

        //Suiche
        switch ($numero) {
            case '1':
                $sql =
                "SELECT
                asociados.FechadeIngresoalaCooperativa AS Fecha_Ingreso
                FROM
                asociados
                WHERE
                asociados.Identificacion = '{$id_asociado}'
                AND asociados.id_Empresa = '{$this->session->userdata('id_empresa')}'";

                // Resultado
                $resultado = $this->db->query($sql)->row();

                // Si la fecha de ingreso está entre el 1 de enero y 31 de diciembre del año anterior
                if ($resultado->Fecha_Ingreso > date("Y")."-01-01" && $resultado->Fecha_Ingreso < date("Y")."-12-31"){
                    // Se devuelve un arreglo con los datos
                    return array('aplica' => '1', "Fecha_Ingreso" => $resultado->Fecha_Ingreso);
                }else{
                    // Se devuelve un arreglo con los datos
                    return array('aplica' => '0', "Fecha_Ingreso" => $resultado->Fecha_Ingreso);
                }
                break;

            /*case '2':
                $sql =
                "SELECT
                asociados.FechadeIngresoalaCooperativa AS Fecha_Ingreso,
                DATE_SUB('{$fecha_inicio}',INTERVAL 1 YEAR) AS Fecha_Requerida
                FROM
                asociados
                WHERE
                Identificacion = '{$id_asociado}'
                AND id_Empresa = '{$this->session->userdata('id_empresa')}'";

                // Resultado
                $resultado = $this->db->query($sql)->row();

                // Si la fecha de ingreso es menor a la requerida
                if($resultado->Fecha_Ingreso <= $resultado->Fecha_Requerida){
                    // Se devuelve un arreglo con los datos
                    return array('aplica' => '1', "Fecha_Ingreso" => $resultado->Fecha_Ingreso, "Fecha_Requerida" => $resultado->Fecha_Requerida);
                }else{
                    // Se devuelve un arreglo con los datos
                    return array('aplica' => '0', "Fecha_Ingreso" => $resultado->Fecha_Ingreso, "Fecha_Requerida" => $resultado->Fecha_Requerida);
                }
            break;*/

            case '3':
                $sql_ =
                "SELECT
                (SELECT
                salario_minimo.valor*(SELECT
                productos.habilidad3
                FROM
                productos
                WHERE
                productos.intCodigo = {$valor_adicional})
                FROM
                salario_minimo
                WHERE
                salario_minimo.anio = {$anio_actual}) AS Salario_Requerido,
                asociados.Totalanoanterior AS Compras
                FROM
                asociados
                WHERE Identificacion = '{$id_asociado}'";

                $sql =
                "SELECT
                    (SELECT
                    salario_minimo.valor*(SELECT
                    productos.habilidad3
                    FROM
                    productos
                    WHERE
                    productos.intCodigo = {$valor_adicional})
                    FROM
                    salario_minimo
                    WHERE
                    salario_minimo.anio =  {$anio_actual}) AS Salario_Requerido,
                    SUM(clientes_productos.valor) AS Compras
                FROM
                    clientes_productos
                WHERE
                    clientes_productos.ano = '{$anio}' AND
                    clientes_productos.id_empresa = '{$this->session->userdata('id_empresa')}' AND
                    clientes_productos.id_cliente = '{$id_asociado}'";

                // Resultado
                $resultado = $this->db->query($sql)->row();

                // Si las compras superan el salario requerido
                if($resultado->Compras > $resultado->Salario_Requerido){
                    // Se devuelve un arreglo con los datos
                    return array('aplica' => '1', 'Salario_Requerido' => number_format($resultado->Salario_Requerido, 0, '', '.'), 'Compras' => number_format($resultado->Compras, 0, '', '.'));
                }else{
                    // Se devuelve un arreglo con los datos
                    return array('aplica' => '0', 'Salario_Requerido' => number_format($resultado->Salario_Requerido, 0, '', '.'), 'Compras' => number_format($resultado->Compras, 0, '', '.'));
                }
            break;

            case '4':
                $sql_ =
                "SELECT
                (SELECT
                salario_minimo.valor*(SELECT
                productos.habilidad4
                FROM
                productos
                WHERE
                productos.intCodigo = {$valor_adicional})
                FROM
                salario_minimo
                WHERE
                salario_minimo.anio = {$anio_actual}) AS Salario_Requerido,
                TotalUltimoTrim AS Compras
                FROM
                asociados
                WHERE
                Identificacion = '{$id_asociado}'";

                $sql =
                "SELECT
                (SELECT
                salario_minimo.valor*(SELECT
                productos.habilidad4
                FROM
                productos
                WHERE
                productos.intCodigo = {$valor_adicional})
                FROM
                salario_minimo
                WHERE
                salario_minimo.anio = {$anio_actual}) AS Salario_Requerido,
                    SUM(clientes_productos.valor) AS Compras
                FROM
                    clientes_productos
                WHERE
                    clientes_productos.id_cliente = '{$id_asociado}' AND
                    clientes_productos.id_empresa = '{$this->session->userdata('id_empresa')}' AND
                    CONCAT(clientes_productos.ano, '-', clientes_productos.mes, '-', clientes_productos.dia) <= '{$fecha_inicio}'
                    AND CONCAT(clientes_productos.ano, '-', clientes_productos.mes, '-', clientes_productos.dia) >= DATE_SUB('{$fecha_inicio}', INTERVAL 90 DAY)";

                // Resultado
                $resultado = $this->db->query($sql)->row();

                // Si las compras superan el salario requerido
                if($resultado->Compras > $resultado->Salario_Requerido){
                    // Se devuelve un arreglo con los datos
                    return array('aplica' => '1', 'Salario_Requerido' => number_format($resultado->Salario_Requerido, 0, '', '.'), 'Compras' => number_format($resultado->Compras, 0, '', '.'));
                }else{
                    // Se devuelve un arreglo con los datos
                    return array('aplica' => '0', 'Salario_Requerido' => number_format($resultado->Salario_Requerido, 0, '', '.'), 'Compras' => number_format($resultado->Compras, 0, '', '.'));
                }
            break;

            case '5':
                $sql_ =
                "SELECT
                (SELECT
                salario_minimo.valor*(SELECT
                productos.habilidad5
                FROM
                productos
                WHERE
                productos.intCodigo = {$valor_adicional})
                FROM
                salario_minimo
                WHERE
                salario_minimo.anio = {$anio_actual}) AS Salario_Requerido,
                TotalAnoActual AS Compras
                FROM
                asociados
                WHERE
                Identificacion = '{$id_asociado}'";

                $sql =
                "SELECT
                (SELECT
                salario_minimo.valor*(SELECT
                productos.habilidad5
                FROM
                productos
                WHERE
                productos.intCodigo = {$valor_adicional})
                FROM
                salario_minimo
                WHERE
                salario_minimo.anio = {$anio_actual}) AS Salario_Requerido,
                SUM(clientes_productos.valor) AS Compras
                FROM
                clientes_productos
                WHERE
                clientes_productos.id_cliente = '{$id_asociado}' AND
                clientes_productos.id_empresa = '{$this->session->userdata('id_empresa')}' AND
                CONCAT(
                    clientes_productos.ano, '-',
                    CONCAT(REPEAT('0', 2-LENGTH(clientes_productos.mes)), clientes_productos.mes), '-',
                    CONCAT(REPEAT('0', 2-LENGTH(clientes_productos.dia)), clientes_productos.dia)
                ) >= '".date($anio."-m-d")."'";

                // Resultado
                $resultado = $this->db->query($sql)->row();

                // Si las compras superan el salario requerido
                if($resultado->Compras > $resultado->Salario_Requerido){
                    // Se devuelve un arreglo con los datos
                    return array('aplica' => '1', 'Salario_Requerido' => number_format($resultado->Salario_Requerido, 0, '', '.'), 'Compras' => number_format($resultado->Compras, 0, '', '.'));
                }else{
                    // Se devuelve un arreglo con los datos
                    return array('aplica' => '0', 'Salario_Requerido' => number_format($resultado->Salario_Requerido, 0, '', '.'), 'Compras' => number_format($resultado->Compras, 0, '', '.'));
                }
            break;

            case '6':
                $sql =
                "SELECT
                asociados.id_Tipo AS id_tipo,
                IFNULL(tipo_cliente.strNombre,'No seleccionado') AS Tipo
                FROM
                asociados
                LEFT JOIN tipo_cliente ON asociados.id_Tipo = tipo_cliente.intCodigo
                WHERE id_Empresa = '{$this->session->userdata('id_empresa')}'
                AND Identificacion = '{$id_asociado}'";

                // Resultado
                $resultado = $this->db->query($sql)->row();

                // Si el tipo es 1
                if($resultado->id_tipo == '1'){
                    // Se devuelve un arreglo con los datos
                    return array('aplica' => '1', 'Tipo' => "Si" );
                }else{
                    // Se devuelve un arreglo con los datos
                    return array('aplica' => '0', 'Tipo' => "No ({$resultado->Tipo})");
                }
            break;

        }
    }// consultar_habilidad

    function consultar_habilidad_producto($id_producto){
        $this->db->select('habilidad1_es');
        $this->db->select('habilidad2_es');
        $this->db->select('habilidad3_es');
        $this->db->select('habilidad4_es');
        $this->db->select('habilidad5_es');
        $this->db->select('habilidad6_es');
        $this->db->select('valor');
        $this->db->select('transferencia');

        $this->db->where('intCodigo', $id_producto);

        return $this->db->get('productos')->row();
    }

    /**
     * [guardar description]
     * @param  [type] $datos [description]
     * @return [type]        [description]
     */
    function guardar($datos){
        //Se ejecuta el modelo que guarda los datos
        $guardar = $this->db->insert('asociados', $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    }// guardar

    function guardar_importacion($tipo, $tabla, $sql){
        if($this->db->query($sql)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * [guardar_beneficiario description]
     * @param  [type] $datos [description]
     * @return [type]        [description]
     */
    function guardar_beneficiario($datos){
        //Se ejecuta el modelo que guarda los datos
        $guardar = $this->db->insert('asociados_beneficiarios', $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    } //guardar_beneficiario

    /**
     * [guardar_campana description]
     * @param  [type] $datos [description]
     * @return [type]        [description]
     */
    function guardar_campana($datos){
        //Se ejecuta el modelo que guarda los datos
        $guardar = $this->db->insert('clientes_campanas', $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    }// guardar_campana

    /**
     * [guardar_campos description]
     * @param  [type] $datos [description]
     * @return [type]        [description]
     */
    function guardar_campos($datos){
        //Se ejecuta el modelo que guarda los datos
        $guardar = $this->db->insert('actualizacion_campos_empresa', $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    } // guardar_campos

    /**
     * [guardar_cargos description]
     * @param  [type] $datos [description]
     * @return [type]        [description]
     */
    function guardar_cargos($datos){
        //Se ejecuta el modelo que guarda los datos
        $guardar = $this->db->insert('asociados_cargos', $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    }// guardar_cargos

    /**
     * [guardar_comentario description]
     * @param  [type] $datos [description]
     * @return [type]        [description]
     */
    function guardar_comentario($datos){
        //Se ejecuta el modelo que guarda los datos
        $guardar = $this->db->insert('cliente_comentarios', $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    }//guardar_comentario

    /**
     * [guardar_conocido description]
     * @param  [type] $datos [description]
     * @return [type]        [description]
     */
    function guardar_conocido($datos){
        //Se ejecuta el modelo que guarda los datos
        $guardar = $this->db->insert('asociados_conocidos', $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    } //guardar_conocido

    /**
     * [guardar_gustos description]
     * @param  [type] $datos [description]
     * @return [type]        [description]
     */
    function guardar_gustos($datos){
        //Se ejecuta el modelo que guarda los datos
        $guardar = $this->db->insert('asociados_gustos', $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    }// guardar_gustos

    /**
     * [guardar_hijo description]
     * @param  [type] $datos [description]
     * @return [type]        [description]
     */
    function guardar_hijo($datos){
        //Se ejecuta el modelo que guarda los datos
        $guardar = $this->db->insert('asociados_hijos', $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    } // guardar_hijo

    /**
     * [guardar_oportunidad description]
     * @param  [type] $datos [description]
     * @return [type]        [description]
     */
    function guardar_oportunidad($datos){
        //Se ejecuta el modelo que guarda los datos
        $guardar = $this->db->insert('oportunidad_x_cliente', $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    } // guardar_oportunidad

    /**
     * [guardar_producto description]
     * @param  [type] $datos [description]
     * @return [type]        [description]
     */
    function guardar_producto($datos){
        //Se ejecuta el modelo que guarda los datos
        $guardar = $this->db->insert('clientes_productos', $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    }//guardar_producto

    /**
     * [guardar_usuario description]
     * @param  [type] $datos [description]
     * @return [type]        [description]
     */
    function guardar_usuario($datos){
        //Se ejecuta el modelo que guarda los datos
        $guardar = $this->db->insert('usuarios_sistema', $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    } // guardar_usuario

    function listar_documentos_subidos($id_asociado){
        // Se abre la carpeta
        $directorio = opendir('./documentos_cliente/'.$id_asociado.'/');

        //Se leen las fotos en el directorio
        while ($elemento = readdir($directorio)){
            //Tratamos los elementos . y .. que tienen todas las carpetas
            if( $elemento != "." && $elemento != ".."){
                // Si es una carpeta
                if( is_dir($directorio.$elemento) ){
                    // Muestro la carpeta
                    // echo "<p>CARPETA: ". $elemento ."</p>";
                } else {
                    // echo "<p>CARPETA: ". $elemento ."</p>";
                //Guardo el fichero en un arreglo
                array_push($archivos, $elemento);
                }//Fin if
            }//Fin if
                // $archivo = base_url().'documentos_cliente/'.$id_asociado.'/'.$elemento;
        }//fin while

        //Se devuelve el arreglo
        return $archivo;
    }

    function listar_oficinas_participantes($id_oficina){
        $es_oficina = "";

        // Si viene id de oficina
        if ($id_oficina != "0") {
            $es_oficina = "AND a.id_Oficina = '{$id_oficina}'";
        }

        $sql =
        "SELECT
            id_Oficina AS id_oficina
        FROM
            asociados a
        WHERE
            a.Actualizado = '1' AND
            a.id_Oficina IS NOT NULL
            {$es_oficina}
        GROUP BY id_Oficina";

        return $this->db->query($sql)->result();
    }

    function listar_usuarios_actualizados($id_oficina, $mes, $anio){
        $es_oficina = "AND a.id_Oficina = '{$id_oficina}'";
        $es_mes = "AND MONTH(a.Fecha_Actualizacion) = '{$mes}'";
        $es_anio = "AND YEAR(a.Fecha_Actualizacion) = '{$anio}'";

        // Condiciones
        if($id_oficina == '0'){ $es_oficina = ''; }
        if($mes == '0'){ $es_mes = ''; }
        if($anio == '0'){ $es_anio = ''; }

        // Consulta
        $sql =
        "SELECT
            CONCAT(Nombre, ' ', PrimerApellido,  ' ', SegundoApellido) AS Nombres,
            a.Identificacion,
            din_agencias.strNombre AS Oficina,
            a.Fecha_Actualizacion AS Fecha
        FROM
            asociados AS a
            LEFT JOIN estado_asociado AS e ON a.id_EstadoactualEntidad = e.intCodigo
            LEFT JOIN din_agencias ON a.id_Oficina = din_agencias.intCodigo
        WHERE
            a.id_Asociado IS NOT NULL AND
            a.Actualizado = '1' AND
            a.id_EstadoactualEntidad = '1'
            {$es_mes}
            {$es_anio}
            {$es_oficina}
        ORDER BY
            a.Nombre ASC";

        return $this->db->query($sql)->result();
    } // listar_usuarios_actualizados

    /**
     * [listar_usuarios_sistema description]
     * @param  [type] $id_usuario [description]
     * @return [type]             [description]
     */
    function listar_usuarios_sistema($id_usuario){
        //Se realiza la consulta
        $this->db->select('*');
        $this->db->order_by('strNombre');

        // Si es un usuario específico
        if ($id_usuario) {
            $this->db->where('intCodigo', $id_usuario);
            return $this->db->get('usuarios_sistema')->row();
        }else{
            return $this->db->get('usuarios_sistema')->result();
        }
    } // listar_usuarios_sistema

    /**
     * [listar_usuarios_sistema description]
     * @param  [type] $id_usuario [description]
     * @return [type]             [description]
     */
    function listar_usuarios_sistema_empresa(){
        //Se realiza la consulta
        $this->db->select('*');
        $this->db->order_by('strNombre');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));

        return $this->db->get('usuarios_sistema')->result();
    } // listar_usuarios_sistema_empresa

    function usuario_ganador($id_oficina, $mes, $anio){
        $es_mes = "AND MONTH(a.Fecha_Actualizacion) = '{$mes}'";
        $es_anio = "AND YEAR(a.Fecha_Actualizacion) = '{$anio}'";

        // Condiciones
        if($mes == '0'){ $es_mes = ''; }
        if($anio == '0'){ $es_anio = ''; }

        $sql =
        "SELECT
            a.Nombre,
            a.PrimerApellido,
            a.SegundoApellido,
            a.Identificacion,
            a.Celular_cliente,
            a.CorreoElectronico,
            din_agencias.strNombre AS Oficina
        FROM
            asociados AS a
            INNER JOIN din_agencias ON a.id_Oficina = din_agencias.intCodigo
        WHERE
            a.Actualizado = '1' AND
            a.id_EstadoactualEntidad = '1' AND
            a.id_Oficina = '{$id_oficina}' AND
            a.id_Oficina IS NOT NULL
            {$es_mes}
            {$es_anio}
        ORDER BY rand()
        LIMIT 0, 1";

        return $this->db->query($sql)->row();
    } // usuario_ganador

    /**
     * [validar_usuario description]
     * @param  [type] $nombre_usuario [description]
     * @return [type]                 [description]
     */
    function validar_usuario($nombre_usuario){
        //Se realiza la consulta
        $this->db->where('login', $nombre_usuario);
        $query = $this->db->get('usuarios_sistema');

        //Si devuelve una celda
        if($query->num_rows() == 1){
            //El usuario existe. Retorna verdadero
            return "true";
        }else{
            //El usuario no existe. Retorna falso
            return "false";
        }
    }//Fin validar_usuario()

    function validar_carne($numero, $identificacion){
        //Se realiza la consulta
        $sql =
        "SELECT
        asociados.id_Asociado
        FROM
        asociados
        WHERE NumerodeCarne = '{$numero}'
        AND Identificacion <> '{$identificacion}'";

        $resultado = $this->db->query($sql)->result();

        //Si devuelve una celda
        if(count($resultado) > 0){
            //El usuario existe. Retorna verdadero
            return "true";
        }else{
            //El usuario no existe. Retorna falso
            return "false";
        }
    }//Fin validar_carne()
}
/* Fin del archivo cliente_model.php */
/* Ubicación: ./application/models/cliente_model.php */