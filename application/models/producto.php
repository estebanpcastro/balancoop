<?php

/**
 * Modelo encargado de gestionar toda la informacion relacionada al cliente
 *
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
class Producto extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
        $this->load->model(array(
            'import_model',
            'catalogo_cuenta'
        ));
    }

    public function borrar_dependencias($idFiltroProducto, $idProducto, $idBalance)
    {
        if (! empty($idFiltroProducto)) {
            $conditionsDel = [
                'fuente' => $idFiltroProducto['id_filtro'],
                'id_balance' => $idBalance,
            ];
            $this->db->delete('estructuras', $conditionsDel);
            $this->db->delete('filtros_creados', [
                'intCodigo' => $idFiltroProducto['id_filtro']
            ]);
            $this->db->delete('filtros_creados_productos', [
                'id_producto' => $idProducto
            ]);
            $this->db->delete('productos', [
                'intCodigo' => $idProducto,
//                 'ano' => $año
            ]);
        }
    }

    public function getFiltroProductoCreado($idProducto)
    {
        $this->db->select('intCodigo, id_filtro');
        $this->db->from('filtros_creados_productos');
        $this->db->where('id_producto', $idProducto);
//         $this->db->where('anio', $año);
        return $this->db->get()->result_array();
    }

    public function add_producto($producto_value, $idEmpresa, $idBalance, $categories, $idUsuario, $año)
    {
        $producto = new stdClass();
        $producto->intCodigo = $producto_value['intCodigo'];
        $producto->strNombre = $producto_value['strNombre'];
        $producto->valor = $producto_value['valor'];
        $producto->id_proveedor = $producto_value['id_proveedor'];
        $producto->Tipo = $producto_value['Tipo'];
        $producto->requiere_matricula = $producto_value['requiere_matricula'];
        $producto->id_linea = $producto_value['id_linea'];
        $producto->id_categoria = $producto_value['id_categoria'];
        $producto->Estado = $producto_value['Estado'];
        $producto->id_empresa = $idEmpresa;
        $producto->transferencia = $producto_value['transferencia'];
        $producto->habilidad1_es = $producto_value['habilidad1_es'];
        $producto->habilidad2_es = $producto_value['habilidad2_es'];
        $producto->habilidad3_es = $producto_value['habilidad3_es'];
        $producto->habilidad3 = $producto_value['habilidad3'];
        $producto->habilidad4_es = $producto_value['habilidad4_es'];
        $producto->habilidad4 = $producto_value['habilidad4'];
        $producto->habilidad5_es = $producto_value['habilidad5_es'];
        $producto->habilidad5 = $producto_value['habilidad5'];
        $producto->habilidad6_es = $producto_value['habilidad6_es'];
//         $producto->ano = $año;
        // borrar Filtros creados y filtros productos creados.
//         $filtrosCreados = $this->getFiltroProductoCreado($producto->intCodigo);
//         if (! empty($filtrosCreados)) {
//             foreach ($filtrosCreados as $codigoFiltro) {
//                 $this->borrar_dependencias($codigoFiltro, $producto->intCodigo, $idBalance);
//             }
//         }
        $productoExist = $this->import_model->get_productoId('credito', $idEmpresa, '', $producto_value['intCodigo']);
        if (empty($productoExist)) {
            $this->db->insert('productos', $producto);
            $idProducto = $this->db->insert_id();
        }

        // Create filtros.
        $variablesNombres = [
            1 => 'Hombres',
            2 => 'Mujeres'
        ];
        $codeCategory = $this->getCodeCategoriaByLinea($categories, $producto->id_linea);
        if ($codeCategory > 0) {
            foreach ($variablesNombres as $genero => $nombre) {
                $nombreEstructra = 'Asociados con el producto ' . $producto->strNombre . '- ' . $nombre;
                $filtroCreadoExist = $this->get_filtro_creado($nombreEstructra, $idUsuario, $idEmpresa);
                if (empty($filtroCreadoExist)) {
                    $filtroCreado = $this->add_filtro($nombreEstructra, $idUsuario, $idEmpresa);
                } else {
                    $filtroCreado = $filtroCreadoExist['intCodigo'];
                }
                if (empty($filtroCreadoExist)) {
                    $this->add_filtro_producto($filtroCreado, $idEmpresa, $producto->intCodigo, $genero);
                }
                $estructura = $this->catalogo_cuenta->getEstructura($idBalance, $nombreEstructra, 'V');
                if (empty($estructura)) {
                    $this->catalogo_cuenta->add_estructura($nombreEstructra, $codeCategory, 'V', $idBalance, 2, 0, $filtroCreado);
                }
            }
        }
    }

    public function getCodeCategoriaByLinea($categorias, $idLinea)
    {
        foreach ($categorias as $categoria) {
            if ($idLinea == 1 && array_key_exists('strNombre', $categoria) && $categoria['strNombre'] == '5. UTILIZACION DE SERVICIOS FINANCIEROS') {
                return $categoria['intCodigo'];
            }

            if ($idLinea == 2 && array_key_exists('strNombre', $categoria) && $categoria['strNombre'] == '6. UTILIZACION DE SERVICIOS DE AREA SOCIAL (NO FINANCIEROS)') {
                return $categoria['intCodigo'];
            }
        }
        return 0;
    }

    public function add_filtro($nombre, $idUsuario, $idEmpresa)
    {
        $filtro = new stdClass();
        $filtro->strNombre = $nombre;
        $filtro->es_reporte = 0;
        $filtro->es_sistema = 0;
        $filtro->es_cliente = 1;
        $filtro->busqueda_rapida = 0;
        $filtro->id_asociado = $idUsuario;
        $filtro->privado = 0;
        $filtro->Estado = 1;
        $filtro->id_empresa = $idEmpresa;
        $filtro->id_usuario = $idUsuario;
        $filtro->id_Filtro_balance = 0;
        $filtro->id_campo_balance = 0;
        $this->db->insert('filtros_creados', $filtro);
        $id_filtro = $this->db->insert_id();
        return $id_filtro;
    }

    public function get_filtro_creado($strNombre, $idUsuario, $idEmpresa) {
        $this->db->select('intCodigo');
        $this->db->from('filtros_creados');
        $this->db->where('id_empresa', $idEmpresa);
        $this->db->where('id_usuario', $idUsuario);
        $this->db->where('strNombre', $strNombre);
        return $this->db->limit(1)
        ->get()
        ->row_array();
    }

    public function add_filtro_producto($filtroCreado, $idEmpresa, $idProducto, $idGenero)
    {
        $filtro = new stdClass();
        $filtro->id_filtro = $filtroCreado;
        $filtro->contiene = 1;
        $filtro->id_producto = $idProducto;
        $filtro->id_genero = $idGenero;
        $filtro->id_empresa = $idEmpresa;
        return $this->db->insert('filtros_creados_productos', $filtro);
    }
}