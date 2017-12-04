<?php
/**
 * Modelo encargado de gestionar toda la informacion relacionada al cliente
 *
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
Class Producto extends CI_Model{

    public function __construct()
    {
        $this->load->database();
        $this->load->model(array('import_model', 'catalogo_cuenta'));

    }

    public function add_producto($producto_value, $idEmpresa, $idBalance, $categories, $idUsuario) {
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
        $this->db->insert('productos', $producto);
        $idProducto = $this->db->insert_id();
        // Create filtros.
        $variablesNombres = [
            1 => 'Hombres' ,
            2 => 'Mujeres'
        ];
        foreach ($categories as $category) {
            if (!empty($category)) {

                foreach ($variablesNombres as $genero => $nombre) {
                    $nombreEstructra = 'Asociados con el producto '.$producto->strNombre.'- '.$nombre;
                    if ($idProducto) {
                        $filtroCreado = $this->add_filtro($nombreEstructra, $idUsuario, $idEmpresa);
                    }
                    if ($filtroCreado) {
                        $this->add_filtro_producto($filtroCreado, $idEmpresa, $producto->intCodigo, $genero);
                        $this->catalogo_cuenta->add_estructura($nombreEstructra, $category['intCodigo'], 'V', $idBalance, 2, $filtroCreado);
                    }
                }
            }
        }


    }

    public function add_filtro($nombre, $idUsuario, $idEmpresa) {
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

    public function add_filtro_producto($filtroCreado, $idEmpresa, $idProducto, $idGenero) {
        $filtro = new stdClass();
        $filtro->id_filtro = $filtroCreado;
        $filtro->contiene = 1;
        $filtro->id_producto = $idProducto;
        $filtro->id_genero = $idGenero;
        $filtro->id_empresa = $idEmpresa;
        $filtro->anio = 0;
        return $this->db->insert('filtros_creados_productos', $filtro);
    }

}