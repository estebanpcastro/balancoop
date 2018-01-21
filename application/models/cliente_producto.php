<?php

/**
 * Modelo Cliente producto
 *
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
class Cliente_producto extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
        $this->load->model(array(
            'import_model'
        ));
    }

    // Toca validar porque al actualizar el aporte en la tabla asociado una cedula puede estar repetida
    public function add_aporte($clientesCreados, $aporte_value, $idEmpresa, $codigoAgencia, $producto, $idCreador = 1)
    {
        if (! array_key_exists('Numero_de_identificacion', $aporte_value)) {
            return FALSE;
        }
        $clienteProducto = new stdClass();
        if ($aporte_value['UltimaFecha']) {
            $fecha = explode("/", $aporte_value['UltimaFecha']);
            $fechaFinal = $fecha[2] . '/' . $fecha[1] . '/' . $fecha[0];
        }
        if (! empty($producto)) {
            $clienteProducto->id_cliente = $aporte_value['Numero_de_identificacion'];
            $clienteProducto->transferencia = $aporte_value['Saldo_a_fecha'];
            $clienteProducto->id_empresa = $idEmpresa;
            $clienteProducto->cantidad = 1;
            $clienteProducto->id_producto = $producto['intCodigo'];
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
            if (! empty($asociado)) {
                // update aporte in table asociados.
                if ($aporte_value['Numero_de_identificacion']) {
                    $this->db->set('AporteSocial', $aporte_value['Saldo_a_fecha']);
                    $this->db->where('Identificacion', $aporte_value['Numero_de_identificacion']);
                    $this->db->where('Id_Empresa', $idEmpresa);
                    $this->db->update('asociados');
                }
                //$clienteProducto = $this->setClienteProductoFromAsociado($asociado, $clienteProducto);
                // Create new cliente producto.
                //$clientesCreados = $this->add_cliente_producto($clienteProducto, $clientesCreados);
            }
        }
        return $clientesCreados;
    }

    public function add_cliente_producto_credito($clientesCreados, $value, $idEmpresa, $mes, $ano, $codigoAgencia, $idCreador)
    {
        if (! array_key_exists('Numero_identificacion', $value)) {
            return FALSE;
        }
        $asociado = $this->import_model->get_asociado($value['Numero_identificacion'], $idEmpresa);
        if (is_numeric($value['LineaCredEntidad'])) {
            // Se busca por el codigo el cual se arma con el id empresa y el codigo entero.
            $codeProduct = $idEmpresa . '-' . $value['LineaCredEntidad'];
            $producto = $this->import_model->get_productoId('credito', $idEmpresa, '', $codeProduct);
        } else {
            // Se busca por un nombre en formato string.
            $producto = $this->import_model->get_productoId('credito', $idEmpresa, $value['LineaCredEntidad']);
        }
        if (! empty($asociado)) {
            if (! empty($producto)) {
                $clientesCreados = $this->create_cliente_producto_values($clientesCreados, 'credito', $asociado, $value['Saldo_de_capital'], // Valor_cuota_fija.
                $value['Tasa_de_interes_nominal_cobrada'], $producto['intCodigo'], $codigoAgencia, $idCreador, $ano, $mes, $value['Fecha_de_desembolso_inicial']);
            } else {
                // TODO: mirara que hacer para informar.
            }
        } else {
            // TODO: mirar que hacer para notificar al cliente.
        }
        return $clientesCreados;
    }

    public function add_cliente_producto_captacion($clientesCreados, $value, $idEmpresa, $mes, $ano, $codigoAgencia, $idCreador)
    {
        if (array_key_exists('NIT', $value)) {
            $asociado = $this->import_model->get_asociado($value['NIT'], $idEmpresa);
        } else {
            return FALSE;
        }

        if (array_key_exists('NombreDeposito', $value)) {
            $producto = $this->import_model->get_productoId('captacion', $idEmpresa, $value['NombreDeposito']);
        }
        if (! empty($asociado)) {
            if (! empty($producto)) {
                $clientesCreados = $this->create_cliente_producto_values($clientesCreados, 'captacion', $asociado, $value['Saldo'], $value['TasaInteresNominal'], $producto['intCodigo'], $codigoAgencia, $idCreador, $ano, $mes, $value['FechaApertura']);
            } else {
                // TODO: mirara que hacer para informar.
            }
        } else {
            // TODO: mirar que hacer para notificar al cliente.
        }
        return $clientesCreados;
    }

    public function add_cliente_producto_social($clientesCreados, $clienteProducto, $idEmpresa, $codigoAgencia, $idUsuario)
    {
        if (! array_key_exists('id_cliente', $clienteProducto)) {
            return FALSE;
        }
        $asociado = $this->import_model->get_asociado($clienteProducto['id_cliente'], $idEmpresa);
        $producto = $this->import_model->get_productoId('social', $idEmpresa, '', $clienteProducto['id_producto']);
        if (! empty($asociado)) {
            if (! empty($producto)) {
                $fecha = $clienteProducto['ano'] . '/' . $clienteProducto['mes'] . '/' . $clienteProducto['dia'];
                $clientesCreados = $this->create_cliente_producto_values($clientesCreados, 'social', $asociado, $clienteProducto['transferencia'], 0, // Interes.
$producto['intCodigo'], $codigoAgencia, $idUsuario, $clienteProducto['ano'], $clienteProducto['mes'], $fecha, $clienteProducto['valor']);
            } else {
                // TODO: mirara que hacer para informar.
            }
        } else {
            // TODO: mirar que hacer para notificar al cliente.
        }
        return $clientesCreados;
    }

    public function add_cliente_producto_revalorizacion($clientesCreados, $clienteProducto, $idEmpresa, $codigoAgencia, $idUsuario, $año)
    {
        if (! array_key_exists('id_cliente', $clienteProducto)) {
            return FALSE;
        }
        $asociado = $this->import_model->get_asociado($clienteProducto['id_cliente'], $idEmpresa);
        $producto = $this->import_model->get_productoId('social', $idEmpresa, '', $clienteProducto['id_producto']);
        if (! empty($asociado)) {
            if (! empty($producto)) {
                $clientesCreados = $this->create_cliente_producto_values($clientesCreados, 'social', $asociado, $clienteProducto['revalorizacion'], 0, $producto['intCodigo'], $codigoAgencia, $idUsuario, $año, 5);
            } else {
                // TODO: mirara que hacer para informar.
            }
        } else {
            // TODO: mirar que hacer para notificar al cliente.
        }
        return $clientesCreados;
    }

    public function setClienteProductoFromAsociado($asociado, $clienteProducto)
    {
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

    public function create_cliente_producto_values($clientesCreados, $tipo, $asociado, $saldo, $tasaInteres, $codigoProducto, $codigoAgencia, $idCreador, $ano, $mes, $fechaUltima = '', $valor = 0)
    {
        $clienteProducto = new stdClass();
        $clienteProducto = $this->setClienteProductoFromAsociado($asociado, $clienteProducto);
        $clienteProducto->cantidad = 1;
        $clienteProducto->id_empresa = $asociado['id_Empresa'];
        $clienteProducto->id_producto = $codigoProducto;
        $clienteProducto->id_cliente = $asociado['Identificacion'];
        $tasaMercado = $this->import_model->get_tasa_mercado($codigoProducto, $ano, $mes, $asociado['id_Empresa']);
        if (! empty($tasaMercado)) {
            $tasaInteres = str_replace(',', '.', $tasaInteres);
            $tasaMercadoValor = ($tasaMercado['Tasa'] / 12 / 100);
            $tasaInteresValor = ((float) $tasaInteres / 12 / 100);
            $saldo = str_replace(',', '.', $saldo);
            if ($tipo == 'captacion') {
                $saldo = ($tasaInteresValor * (float) $saldo) - ($tasaMercadoValor * (float) $saldo);
                $valor = ($tasaInteresValor * (float) $saldo);
            } else if ($tipo == 'credito') {
                $saldo = $tasaInteresValor > 0 ? ($tasaMercadoValor * (float) $saldo) - ($tasaInteresValor * (float) $saldo) : 0;
            }
        }
        $clienteProducto->transferencia = $saldo;
        $clienteProducto->valor = $valor;
        $fecha = str_replace('/', '-', $fechaUltima);
        $fecha = empty($fechaUltima) ? date('Y-m-d', strtotime($ano . '-' . $mes . '-30')) : date('Y-m-d', strtotime($fecha));
        $fechaFinal = date('Y-m-d', strtotime($ano . '-12-31'));
        $clienteProducto->fecha_inicial = $fecha;
        $clienteProducto->fecha_final = $fechaFinal;
        $clienteProducto->id_agencia = $codigoAgencia;
        $clienteProducto->ano = empty($ano) ? date('Y', strtotime($fecha)) : $ano;
        $clienteProducto->mes = empty($mes) ? date('m', strtotime($fecha)) : $mes;
        $clienteProducto->dia = ! empty($fechaUltima) ? date('d', strtotime($fecha)) : $fechaUltima;
        $clienteProducto->id_usuario_creador = $idCreador;
        $clienteProducto->agencia = $codigoAgencia;
        // Create new cliente producto.
        if (! empty($tasaMercado) || $tipo == 'social') {
            $clientesCreados = $this->add_cliente_producto($clienteProducto, $clientesCreados);
        }
        return $clientesCreados;
    }

    public function add_cliente_producto($clienteProducto, $clientesCreados)
    {
        $tableBefore = $this->import_model->tablaDB;
        $this->import_model->tablaDB = 'clientes_productos';
        $clienteToUpdate = $this->get($clienteProducto);
        if ($clienteToUpdate && in_array($clienteProducto->id_cliente, $clientesCreados)) {
            $clienteProducto->transferencia = $clienteToUpdate['transferencia'] + $clienteProducto->transferencia;
            $clienteProducto->valor = $clienteToUpdate['valor'] + $clienteProducto->valor;
            $this->update($clienteProducto);
        } elseif ($clienteToUpdate && ! in_array($clienteProducto->id_cliente, $clientesCreados)) {
            $this->delete($clienteProducto);
            $this->import_model->insert_row($clienteProducto);
            $clientesCreados[] = $clienteProducto->id_cliente;
        } else {
            $this->import_model->insert_row($clienteProducto);
            $clientesCreados[] = $clienteProducto->id_cliente;
        }
        $this->import_model->tablaDB = $tableBefore;
        return $clientesCreados;
    }

    public function delete($clienteProducto)
    {
        $this->db->where('id_cliente', $clienteProducto->id_cliente);
        $this->db->where('id_empresa', $clienteProducto->id_empresa);
        $this->db->where('id_producto', $clienteProducto->id_producto);
        $this->db->where('ano', $clienteProducto->ano);
        $this->db->where('mes', $clienteProducto->mes);
        $this->db->where('dia', $clienteProducto->dia);
        // Se borra el cliente producto por id_producto, empresa, cedula, año y mes.
        $this->db->delete('clientes_productos');
    }

    public function get($clienteProducto)
    {
        $this->db->select('*');
        $this->db->from('clientes_productos');
        $this->db->where('id_empresa', $clienteProducto->id_empresa);
        $this->db->where('id_cliente', $clienteProducto->id_cliente);
        $this->db->where('id_producto', $clienteProducto->id_producto);
        $this->db->where('ano', $clienteProducto->ano);
        $this->db->where('mes', $clienteProducto->mes);
        $this->db->where('dia', $clienteProducto->dia);
        return $this->db->get()->row_array();
    }

    public function update($clienteProducto)
    {
        $updates = [
            'transferencia' => $clienteProducto->transferencia,
            'valor' => $clienteProducto->valor
        ];
        $this->db->set($updates);
        $this->db->where('id_cliente', $clienteProducto->id_cliente);
        $this->db->where('id_empresa', $clienteProducto->id_empresa);
        $this->db->where('id_producto', $clienteProducto->id_producto);
        $this->db->where('ano', $clienteProducto->ano);
        $this->db->where('mes', $clienteProducto->mes);
        $this->db->where('dia', $clienteProducto->dia);
        // Se borra el cliente producto por id_producto, empresa, cedula, año y mes.
        $this->db->update('clientes_productos');
    }
}