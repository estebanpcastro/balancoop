<?php
/**
 * Modelo Cliente producto
 *
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
Class Cliente_producto extends CI_Model{

    public function __construct()
    {
        $this->load->database();
        $this->load->model(array('import_model'));

    }

    // Toca validar porque al actualizar el aporte en la tabla asociado una cedula puede estar repetida
    public function add_aporte($aporte_value, $idEmpresa, $codigoAgencia, $idCreador = 1) {

        $clienteProducto = new stdClass();
        if($aporte_value['UltimaFecha']) {
            $fecha = explode("/", $aporte_value['UltimaFecha']);
            $fechaFinal = $fecha[2].'/'.$fecha[1].'/'.$fecha[0];
        }

        // update aporte in table asociados.
        if($aporte_value['Numero_de_identificacion']) {
            $this->db->set('AporteSocial', $aporte_value['Saldo_a_fecha']);
            $this->db->where('Identificacion', $aporte_value['Numero_de_identificacion']);
            $this->db->where('Id_Empresa', $idEmpresa);
            $this->db->update('asociados');
        }

        $clienteProducto->id_cliente = $aporte_value['Numero_de_identificacion'];
        $clienteProducto->transferencia = $aporte_value['Saldo_a_fecha'];
        $clienteProducto->id_empresa = $idEmpresa;
        $clienteProducto->cantidad = 1;
        // get codigo producto
        $codeProduct = $this->import_model->get_productoId('aportes', $idEmpresa, 'APORTES');
        $clienteProducto->id_producto = empty($codeProduct) ? 0 : $codeProduct['intCodigo'];
        $clienteProducto->fecha_inicial = $fechaFinal;
        $clienteProducto->fecha_final = $fechaFinal;
        $clienteProducto->id_agencia = $codigoAgencia;
        $clienteProducto->ano = $fecha[2];
        $clienteProducto->mes = $fecha[1];
        $clienteProducto->dia = $fecha[0];
        $clienteProducto->id_usuario_creador = $idCreador;
        $clienteProducto->agencia = $codigoAgencia;
        // Get asociado.
        $asociado = $this->import_model->get_asociado($aporte_value['Numero_de_identificacion'], $idEmpresa);
        if ($asociado) {
            $clienteProducto = $this->setClienteProductoFromAsociado($asociado, $clienteProducto);
            // Create new cliente producto.
            $this->add_cliente_producto($clienteProducto);
        }
    }

    public function add_cliente_producto_credito($value, $idEmpresa, $mes, $ano, $codigoAgencia, $idCreador) {
        $asociado = $this->import_model->get_asociado($value['Numero_identificacion'], $idEmpresa);
        $producto = $this->import_model->get_productoId('credito', $idEmpresa, $value['LineaCredEntidad']);
        if (!empty($asociado)) {
            if (!empty($producto)) {
                $this->create_cliente_producto_values(
                    'credito',
                    $asociado,
                    $value['Valor_cuota_fija'],
                    $value['Tasa_de_interes_nominal_cobrada'],
                    $producto['intCodigo'],
                    $codigoAgencia,
                    $idCreador,
                    $ano,
                    $mes,
                    $value['Fecha_ultimo_pago']);
            }
            else {
                //TODO: mirara que hacer para informar.
            }
        }
        else {
            //TODO: mirar que hacer para notificar al cliente.
        }
    }

    public function add_cliente_producto_captacion($value, $idEmpresa, $mes, $ano, $codigoAgencia, $idCreador) {
        $asociado = $this->import_model->get_asociado($value['NIT'], $idEmpresa);
        $producto = $this->import_model->get_productoId('captacion', $idEmpresa, $value['NombreDeposito']);
        if (!empty($asociado)) {
            if (!empty($producto)) {
                $this->create_cliente_producto_values(
                    'captacion',
                    $asociado,
                    $value['Saldo'],
                    $value['TasaInteresNominal'],
                    $producto['intCodigo'],
                    $codigoAgencia,
                    $idCreador,
                    $ano,
                    $mes
                    );
            }
            else {
                //TODO: mirara que hacer para informar.
            }
        }
        else {
            //TODO: mirar que hacer para notificar al cliente.
        }
    }
    public function add_cliente_producto_social($clienteProducto, $idEmpresa, $codigoAgencia, $idUsuario) {
        $asociado = $this->import_model->get_asociado($clienteProducto['id_cliente'], $idEmpresa);
        $producto = $this->import_model->get_productoId('social', $idEmpresa, $clienteProducto['id_producto']);
        if (!empty($asociado)) {
            if (!empty($producto)) {
                $this->create_cliente_producto_values(
                    'social',
                    $asociado,
                    $clienteProducto['transferencia'],
                    0, // Interes.
                    $producto['intCodigo'],
                    $codigoAgencia,
                    $idUsuario,
                    $clienteProducto['ano'],
                    $clienteProducto['mes'],
                    $clienteProducto['fecha_inicial'],
                    $clienteProducto['valor']
                    );
            }
            else {
                //TODO: mirara que hacer para informar.
            }
        }
        else {
            //TODO: mirar que hacer para notificar al cliente.
        }
    }

    public function setClienteProductoFromAsociado($asociado, $clienteProducto){
        $clienteProducto->Nombre = $asociado['Nombre'];
        $clienteProducto->Celular_cliente = $asociado['Celular_cliente'];
        $clienteProducto->PrimerApellido = $asociado['PrimerApellido'];
        $clienteProducto->SegundoApellido = $asociado['SegundoApellido'];
        $clienteProducto->CorreoElectronico = $asociado['CorreoElectronico'];
        $clienteProducto->TelefonoCasa = $asociado['TelefonoCasa'];
        $clienteProducto->TelefonoOficina = $asociado['TelefonoOficina'];
        $clienteProducto->id_Genero_cliente = $asociado['id_Genero_cliente'];
        return $clienteProducto;
    }

    public function create_cliente_producto_values($tipo, $asociado, $saldo, $tasaInteres, $codigoProducto, $codigoAgencia, $idCreador, $ano, $mes, $fechaUltima = '', $valor = 0) {
        $clienteProducto = new stdClass();
        $clienteProducto = $this->setClienteProductoFromAsociado($asociado, $clienteProducto);
        $clienteProducto->cantidad = 1;
        $clienteProducto->id_empresa = $asociado['id_Empresa'];
        $clienteProducto->id_producto = $codigoProducto;
        $clienteProducto->id_cliente = $asociado['Identificacion'];
        $tasaMercado = $this->import_model->get_tasa_mercado($codigoProducto, $ano, $mes, $asociado['id_Empresa']);
        if (!empty($tasaMercado)) {
            if ($tipo == 'captacion') {
                $saldo = (($tasaInteres / 12) * $saldo) - (($tasaMercado['Tasa'] / 12) * $saldo);
            }
            else if ($tipo == 'credito') {
                $saldo = (($tasaMercado['Tasa'] / 12) * $saldo) / ($tasaInteres / 12);
            }

            $clienteProducto->transferencia = $saldo;
            $clienteProducto->valor = $valor;
            $fecha = str_replace('/', '-', $fechaUltima);
            $fecha = empty($fechaUltima) ? date('Y-m-d', strtotime($ano.'-'.$mes.'-31')) : date('Y-m-d', strtotime($fecha));
            $clienteProducto->fecha_inicial = $fecha;
            $clienteProducto->fecha_final = $fecha;
            $clienteProducto->id_agencia = $codigoAgencia;
            $clienteProducto->ano = $ano;
            $clienteProducto->mes = $mes;
            $clienteProducto->dia = empty($fechaUltima) ? $fechaUltima : date('d', strtotime($fecha));
            $clienteProducto->id_usuario_creador = $idCreador;
            $clienteProducto->agencia = $codigoAgencia;
            // Create new cliente producto.
            $this->add_cliente_producto($clienteProducto);
        }
    }

    public function add_cliente_producto($clienteProducto) {
        $tableBefore = $this->tablaDB;
        $this->import_model->tablaDB = 'clientes_productos';
        $result = FALSE;
        if (empty($this->get_cliente_producto($clienteProducto))) {
            $result = $this->import_model->insert_row($clienteProducto);
        } else {
            $this->db->set($clienteProducto);
            $this->db->where('id_cliente', $clienteProducto->id_cliente);
            $this->db->where('id_empresa', $clienteProducto->id_empresa);
            $result = $this->db->update('clientes_productos');
        }

        $this->import_model->tablaDB = $tableBefore;
        return $result;
    }

    public function get_cliente_producto($clienteProducto){
        $this->db->select('*');
        $this->db->from('clientes_productos');
        $this->db->where('id_empresa', $clienteProducto->id_empresa);
        $this->db->where('id_cliente', $clienteProducto->id_cliente);
        $this->db->where('id_producto', $clienteProducto->id_producto);
        return $this->db->limit(1)->get()->row_array();
    }

}