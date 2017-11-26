<?php
/**
 * Modelo encargado de gestionar toda la informacion relacionada al cliente
 *
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
Class Import_model extends CI_Model{

	protected $tablaDB;

	public function __construct()
	{
		$this->load->database();
	}

	public function load_model($tblName) {
		$this->tablaDB = $tblName;
	}

	public function get_data($idEmpresa = FALSE)
	{
		if (!$idEmpresa)
		{
			$query = $this->db->get($this->tablaDb);
			return $query->result_array();
		}

		$query = $this->db->get_where($this->tablaDb, array('id_empresa' => $idEmpresa));
		return $query->row_array();
	}

	public function get_row_by_id($id = FALSE)
	{
		if (!$id)
		{
			return false;
		}

		$query = $this->db->get_where($this->tablaDB, array('id_Asociado' => $id));
		return $query->row_array();
	}

	public function insert_row($row)
	{
		if ($row) {
			return $this->db->insert($this->tablaDB, $row);
		}

		return false;
	}

	public function insert_multiple_rows($rows) {
		if (!empty($rows)) {
			return  $this->db->insert_batch($this->tablaDB, $rows);
		}

		return false;
	}

	public function delete($conditions){
		return $this->db->delete($this->tablaDB, $conditions);
	}

	public function execute_query($query) {
		return $this->db->query($query);
	}


	public function add_asociado($asociado_value, $idEmpresa, $codigoAgencia) {

		$asociado = [];
		if (is_array($asociado_value) && $idEmpresa) {
			$asociado['id_TipodeIdentificacion'] = $asociado_value['Tipo_de_identificacion'];
			$asociado['id_Asociado'] = $idEmpresa . '-' . $asociado_value['Numero_de_identificacion'];
			$asociado['Identificacion'] = $asociado_value['Numero_de_identificacion'];
			$asociado['PrimerApellido'] = $asociado_value['Primer_apellido'];
			$asociado['SegundoApellido'] = $asociado_value['Segundo_apellido'];
			$asociado['Nombre'] = $asociado_value['Nombres'];
			$asociado['FechadeIngresoalaCooperativa'] = date('Y/m/d', strtotime($asociado_value['Fecha_de_ingreso']));
			$asociado['TelefonoCasa'] = $asociado_value['Telefono'];
			$asociado['Direccion'] = $asociado_value['Direccion'];
			$asociado['Id_tipo'] = $asociado_value['Asociado'];
			$asociado['id_EstadoactualEntidad'] = $asociado_value['Activo'];
			$asociado['Departamento_Cliente'] = $asociado_value['Codigo_Municipio'];
			$asociado['CorreoElectronico'] = $asociado_value['EMail'];
			$asociado['id_Genero_cliente'] = $asociado_value['Genero'];
			$asociado['Estado_Empleado'] = $asociado_value['Empleado'];
			$asociado['id_tipoempleado'] = $asociado_value['TipoContrato'];
			$asociado['id_Escolaridad'] = $asociado_value['NivelEscolaridad'];
			$asociado['Id_Estrato'] = $asociado_value['Estrato'];
			$asociado['id_RangodeIngresomensual'] = $asociado_value['NivelIngresos'];
			$asociado['FechaNacimiento'] = date('Y/m/d', strtotime($asociado_value['FechaNacimiento']));
			$asociado['Edad_Cliente'] = $this->get_edad($asociado_value['FechaNacimiento']);
			$asociado['id_EstadoCivil'] = $asociado_value['EstadoCivil'];
			$asociado['id_CabezadeFamilia'] = $asociado_value['MujerCabezaFamilia'];
			$asociado['id_Profesion'] = $asociado_value['Ocupacion'];
			$asociado['id_Industria'] = $asociado_value['Sector_Economico'];
			$asociado['FechadeRetiro']= empty($asociado_value['Fecha_de_Retiro_(ExAsociado)']) ? '0000-00-00' : date('Y/m/d', strtotime($asociado_value['Fecha_de_Retiro_(ExAsociado)']));
			$anoIngreso = date('Y',strtotime($asociado_value['Fecha_de_ingreso']));
			$mesIngreso = date('m',strtotime($asociado_value['Fecha_de_ingreso']));
			$asociado['Ano_ing'] = $anoIngreso;
			$asociado['Mes_ing'] = $mesIngreso;
			$asociado['FechaCreacion'] = date('Y/m/d');
			$asociado['id_Empresa'] = $idEmpresa;
			$asociado['id_Oficina'] = $codigoAgencia;
			$this->insert_row($asociado);
		}
		return false;
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
		$codeProduct = $this->get_productoId($idEmpresa, 'APORTES');
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
		$asociado = $this->get_asociado($aporte_value['Numero_de_identificacion'], $idEmpresa);
		if ($asociado) {
    		$clienteProducto = $this->setClienteProductoFromAsociado($asociado, $clienteProducto);
            // Create new cliente producto.
    		$this->add_cliente_producto($clienteProducto);
		}
	}

	public function add_cliente_producto_credito($value, $idEmpresa, $mes, $ano, $codigoAgencia, $idCreador) {
	    $asociado = $this->get_asociado($value['Numero_identificacion'], $idEmpresa);
	    $producto = $this->get_productoId($idEmpresa, $value['LineaCredEntidad']);
	    if (!empty($asociado)) {
	        if (!empty($producto)) {
	            $this->create_cliente_producto_values($asociado, $value['Saldo_de_capital'], $value['Tasa_de_interes_nominal_cobrada'], $producto['intCodigo'], $codigoAgencia, $idCreador, $ano, $mes);
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
	    $asociado = $this->get_asociado($value['NIT'], $idEmpresa);
	    $producto = $this->get_productoId($idEmpresa, $value['NombreDeposito']);
	    if (!empty($asociado)) {
	        if (!empty($producto)) {
	            $this->create_cliente_producto_values($asociado, $value['Saldo'], $value['TasaInteresNominal'], $producto['intCodigo'], $codigoAgencia, $idCreador, $ano, $mes);
	        }
	        else {
	            //TODO: mirara que hacer para informar.
	        }
	    }
	    else {
	        //TODO: mirar que hacer para notificar al cliente.
	    }
	}
	public function add_cliente_producto_social() {

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

	public function create_cliente_producto_values($asociado, $saldo, $tasaInteres, $codigoProducto, $codigoAgencia, $idCreador, $ano, $mes, $fechaUltima = '') {
	    $clienteProducto = new stdClass();
	    $clienteProducto = $this->setClienteProductoFromAsociado($asociado, $clienteProducto);
	    $clienteProducto->cantidad = 1;
	    $clienteProducto->id_empresa = $asociado['id_Empresa'];
	    $clienteProducto->id_producto = $codigoProducto;
	    $clienteProducto->id_cliente = $asociado['Identificacion'];
	    $tasaMercado = $this->get_tasa_mercado($codigoProducto, $ano, $mes, $asociado['id_Empresa']);
	    if (!empty($tasaMercado)) {
	        $saldo = ($tasaInteres * $saldo) - ($tasaMercado['Tasa'] * $saldo);
	        $clienteProducto->transferencia = $saldo;
	        $fecha = str_replace('/', '-', $fechaUltima);
	        $fecha = empty($fechaUltima) ? $fechaUltima : date('Y-m-d', strtotime($fecha));
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

    //TODO: validate response in method.
    public function get_productoId($idEmpresa, $conditionText = '', $codigo = 0) {
        $this->db->select('intCodigo');
        $this->db->from('productos');
        $this->db->where('Id_Empresa', $idEmpresa);
        if (!empty($conditionText)) {
            $this->db->like('strNombre', $conditionText, 'simple');
        }

        if ($codigo) {
            $this->db->like('intCodigo', $codigo);
        }
        return $this->db->limit(1)->get()->row_array();
    }

    public function add_cliente_producto($clienteProducto) {
        $tableBefore = $this->tablaDB;
        $this->tablaDB = 'clientes_productos';
        if (empty($this->get_cliente_producto($clienteProducto))) {
            $this->insert_row($clienteProducto);
        } else {
            $this->db->set($clienteProducto);
            $this->db->where('id_cliente', $clienteProducto->id_cliente);
            $this->db->where('id_empresa', $clienteProducto->id_empresa);
            $this->db->update('clientes_productos');
        }

        $this->tablaDB = $tableBefore;
    }

    public function get_cliente_producto($clienteProducto){
        $this->db->select('*');
        $this->db->from('clientes_productos');
        $this->db->where('id_empresa', $clienteProducto->id_empresa);
        $this->db->where('id_cliente', $clienteProducto->id_cliente);
        return $this->db->limit(1)->get()->row_array();
    }

	// La validacion para actualizar habil debe ser por id_empresa e identificacion
	public function add_asociado_habil($asociado_value, $idEmpresa) {
		$this->db->select('*');
		$this->db->from($this->tablaDB);
		$this->db->where('Num_identificacion', $asociado_value['Num_identificacion']);
		$this->db->where('Ano', $asociado_value['Ano']);
		$this->db->where('Id_empresa', $idEmpresa);

		if ($this->db->count_all_results() == 0) {
			$asociado = new stdClass();
			$asociado->Num_identificacion = $asociado_value['Num_identificacion'];
			$asociado->Ano = $asociado_value['Ano'];
			$asociado->Id_empresa = $idEmpresa;
			$this->insert_row($asociado);
		}

		$this->db->set('Habil', 1);
		$this->db->where('Identificacion', $asociado_value['Num_identificacion']);
		$this->db->where('Id_Empresa', $idEmpresa);
		$this->db->update('asociados');

	}
	// TODO: validar cuando se debe actualizar un asociado ya que no tiene sentido
	// TODO: hacer esto
	public function add_directivo($directivo_value, $idEmpresa) {

		$this->db->select('*');
		$this->db->from($this->tablaDB);
		$this->db->where('Nit', $directivo_value['Nit']);
		$this->db->where('Id_empresa', $idEmpresa);
		if ($this->db->count_all_results() == 0) {
			$directivo = new stdClass();
			$directivo->Id_empresa = $idEmpresa;
			$directivo->Id_TipoDirectivo = $directivo_value['Id_TipoDirectivo'];
			$directivo->TipoIden = $directivo_value['TipoIden'];
			$directivo->Nit = $directivo_value['Nit'];
// 			$directivo->Calidad = $directivo_value['Calidad'];
			$fechaNombramiento = str_ireplace('/', '-', $directivo_value['FechaNombra']);
			$directivo->FechaNombra = date('Y/m/d', strtotime($fechaNombramiento));
			$directivo->EmpresaRevisorFiscal = $directivo_value['EmpresaRevisorFiscal'];
			$directivo->TarjetaProfRevisorFiscal = $directivo_value['TarjetaProfRevisorFiscal'];
			$fechaPosesion = $directivo_value['FechaPosesion'] ? $directivo_value['FechaPosesion'] : $directivo_value['FechaNombra'];
			$fechaPosesion = str_ireplace('/', '-', $fechaPosesion);
			$directivo->FechaPosesion = date('Y/m/d', strtotime($fechaPosesion));
			$directivo->PeriodoVigencia = $directivo_value['PeriodoVigencia'];
			$directivo->Parentescos = $directivo_value['Parentescos'];
			$directivo->Vinculadas = $directivo_value['Vinculadas'];
			$this->insert_row($directivo);

			// Se busca que si esta en la tabla asociados por el id.
			//TODO: validar con los otros codigos que se debe hacer
			$conditionsUpdate = [];
			$tipoDirectivoJunta = [2, 10, 12];
			$tipoDirectivoConsejero = [7, 1, 9];
			$tipoDirectivoComites = [8, 11];
			//Get Fechas nombramiento y vigencia.
			$vigencia = '+'.$directivo_value['PeriodoVigencia'].' year';
			$nuevafecha = strtotime ($vigencia , strtotime($fechaPosesion)); //Se añade un año mas
			$fechaFin = date ('Y/m/d',$nuevafecha);
			$fechaPosesion = date('Y/m/d', strtotime($fechaPosesion));
			if (in_array($directivo_value['Id_TipoDirectivo'],$tipoDirectivoConsejero)) {
			    $conditionsUpdate['EstadocomoConsejero'] = 1;
			    $conditionsUpdate['Fecha_Inicio_Consejero'] = $fechaPosesion;
			    $conditionsUpdate['Fecha_fin_Consejero'] = $fechaFin;
			}
			else if (in_array($directivo_value['Id_TipoDirectivo'], $tipoDirectivoJunta)) {
			    $conditionsUpdate['EstadocomoJuntadeVigilancia'] = 1;
			    $conditionsUpdate['Fecha_Inicio_Junta'] = $fechaPosesion;
			    $conditionsUpdate['Fecha_fin_Junta'] = $fechaFin;
			}
			else if (in_array($directivo_value['Id_TipoDirectivo'], $tipoDirectivoComites)) {
			    $conditionsUpdate['EstadoenComites'] = 1;
			    $conditionsUpdate['Fecha_Inicio_Comites'] = $fechaPosesion;
			    $conditionsUpdate['Fecha_fin_Comites'] = $fechaFin;
			}
			if (!empty($conditionsUpdate)) {
			    $this->db->where('Identificacion', $directivo_value['Nit']);
			    $this->db->where('Id_Empresa', $idEmpresa);
			    $this->db->update('asociados', $conditionsUpdate);
			}
		}
	}

	public function add_asociado_beneficiario($asociado_value, $idEmpresa) {
		$asociado = new stdClass();
		$asociado->id_Asociado = $idEmpresa.'-'.$asociado_value['Identificacion']; // activar autoicrement este codigo no deberia ir sino el secuence.
		$asociado->Id_empresa = $idEmpresa;
		$asociado->strNombre = $asociado_value['strNombre'];
		$asociado->TelefonoCasa = $asociado_value['Telefono'];
		$asociado->Identificacion = $asociado_value['Identificacion'];
		$asociado->Email = $asociado_value['Email'];
		return $this->insert_row($asociado);
	}

	public function add_asociado_conocido($asociado_value, $idEmpresa) {
		$asociado = new stdClass();
		$asociado->id_Asociado = $asociado_value['id_Asociado'];
		$asociado->Id_empresa = $idEmpresa;
		$asociado->strNombre = $asociado_value['StrNombre'];
		$asociado->TelefonoCasa = $asociado_value['TelefonoCasa'];
		$asociado->TelefonoOficina = $asociado_value['TelefonoOficina'];
		$asociado->Email = $asociado_value['Email'];
		$asociado->FechaNacimiento = $asociado_value['FechaNacimiento'];
		$asociado->Edad = $asociado_value['Edad'];
		$asociado->id_Genero = $asociado_value['id_Genero'];
		$asociado->id_Parentesco = $asociado_value['id_Parentesco'];
		return $this->insert_row($asociado);
	}
	// TODO: Validar esta importacion con el campo Id_asociados.
	public function add_asociado_hijo($asociado_value, $idEmpresa) {
		$asociado = new stdClass();
		$asociado->id_Asociado = $asociado_value['id_Asociado'];
		$asociado->Id_empresa = $idEmpresa;
		$asociado->strNombre = $asociado_value['StrNombre'];
		$asociado->TelefonoCasa = $asociado_value['TelefonoCasa'];
		$asociado->TelefonoOficina = $asociado_value['TelefonoOficina'];
		$asociado->Email = $asociado_value['Email'];
		$asociado->FechaNacimiento = $asociado_value['FechaNacimiento'];
		$asociado->Edad = $asociado_value['Edad'];
		$asociado->id_Genero = $asociado_value['id_Genero'];
		return $this->insert_row($asociado);
	}

	public function add_asociado_conyuge($asociado_value, $idEmpresa) {
		$asociado = new stdClass();
		$asociado->Identificacion = $asociado_value['Identificacion'];
		$asociado->Id_empresa = $idEmpresa;
		$asociado->Identificacion_Conyuge = $asociado_value['Identificacion_Conyuge'];
		$asociado->NombredelConyuge = $asociado_value['NombredelConyuge'];
		$asociado->TelefonoCasa_Conyuge = $asociado_value['TelefonoCasa_Conyuge'];
		$asociado->TelefonoOficina_Conyuge = $asociado_value['TelefonoOficina_Conyuge'];
		$asociado->OtroTelefono_Conyuge = $asociado_value['OtroTelefono_Conyuge'];
		$asociado->Email_Conyuge = $asociado_value['Email_Conyuge'];
		$asociado->FechaNacimiento_Conyugue = $asociado_value['FechaNacimiento_Conyugue'];
		$asociado->Direccion_Conyuge = $asociado_value['Direccion_Conyuge'];
		$asociado->Celular_Conyuge = $asociado_value['Celular_Conyuge'];
		$asociado->id_Genero_Conyugue = $asociado_value['id_Genero_Conyugue'];
		return $this->insert_row($asociado);
	}
	//TODO: no encuentro en la tabla asociados para actualizar
	//TODO: esta informacion se puede manejar en la misma tabla asociados
	public function add_asociados_motivo_retiro($asociado_value, $idEmpresa) {
		$asociado = new stdClass();
		$asociado->Identificacion = $asociado_value['Identificacion'];
		$asociado->Id_empresa = $idEmpresa;
		$asociado->Identificacion_Conyuge = $asociado_value['Id_motivo_retiro'];
		$this->insert_row($asociado);
	}
	//TODO: esta informacion se puede manejar en la misma tabla asociados
	public function add_asociados_otros_datos($asociado_value, $idEmpresa) {
		$asociado = new stdClass();
		$asociado->Identificacion = $asociado_value['Identificacion'];
		$asociado->Id_empresa = $idEmpresa;
		$asociado->Id_conocimiento_cooperativismo = $asociado_value['Id_conocimiento_cooperativismo'];
		$asociado->Id_GrupoFamiliarid_grupo_familiar = $asociado_value['Id_GrupoFamiliarid_grupo_familiar'];
		$asociado->Id_oficina = $asociado_value['Id_oficina'];
		$asociado->Ingresoreal = $asociado_value['Ingresoreal'];
		$asociado->Celular_cliente = $asociado_value['Celular_cliente'];
		$asociado->Id_ciudad_cliente = $asociado_value['Id_ciudad_cliente'];
		$asociado->Td_pais_cliente = $asociado_value['Td_pais_cliente'];
		$asociado->Telefono_oficina_cliente = $asociado_value['Telefono_oficina_cliente'];

		$this->insert_row($asociado);

		$data = [];
		$data['Id_conocimiento_cooperativismo'] = $asociado_value['Id_conocimiento_cooperativismo'];
		$data['Id_GrupoFamiliar'] = $asociado_value['Id_GrupoFamiliarid_grupo_familiar'];
		$data['Id_oficina'] = $asociado_value['Id_oficina'];
		$data['Ingresoreal'] = $asociado_value['Ingresoreal'];
		$data['Celular_cliente'] = $asociado_value['Celular_cliente'];
		$data['Ciudad_cliente'] = $asociado_value['Id_ciudad_cliente'];
		$data['Pais_cliente'] = $asociado_value['Td_pais_cliente'];
		$this->db->where('Identificacion', $asociado_value['Identificacion']);
		$this->db->where('Id_Empresa', $idEmpresa);
		$this->db->update('asociados', $data);
	}

	public function add_producto($producto_value, $idEmpresa) {
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
	    $producto->id_empresa = $producto_value['id_empresa'];
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

	    $this->insert_row($producto);
	}

	public function add_usuario_sistema($usuario_value, $idEmpresa) {
	    $usuario = new stdClass();
	    $usuario->Identificacion = $usuario_value['Identificacion'];
	    $usuario->Id_empresa = $idEmpresa;
	    $usuario->Estado = $usuario_value['Estado'];
	    $usuario->id_filtro_por_defecto = $usuario_value['id_filtro_por_defecto'];
	    $usuario->id_tipo_usuario = $usuario_value['id_tipo_usuario'];
	    $usuario->login = $usuario_value['login'];
	    //TODO: encriptar pass.
	    $usuario->password = $usuario_value['password'];
	    $usuario->strNombre = $usuario_value['strNombre'];
	    $this->insert_row($usuario);
	}

	public function add_clave_transferecia($clave_value, $idEmpresa) {
	    $usuario = new stdClass();
	    $usuario->identificacion = $clave_value['Identificacion'];
	    $usuario->Id_empresa = $idEmpresa;
	    //TODO: encriptar clave.
	    $usuario->Clave_transferencia = $idEmpresa.'-'.$clave_value['Identificacion'];
	    $this->insert_row($usuario);
	    $data = ['Clave_transferencia' => $usuario->Clave_transferencia];
	    $this->db->where('Identificacion', $clave_value['Identificacion']);
	    $this->db->where('Id_Empresa', $idEmpresa);
	    $this->db->update('asociados', $data);
	}

	public function add_tasa_mercado($tasa_value, $idEmpresa) {

	    $this->db->select('*');
	    $this->db->from($this->tablaDB);
	    $this->db->where('Mes', $tasa_value['Mes']);
	    $this->db->where('Ano', $tasa_value['Ano']);
	    $this->db->where('Id_empresa', $idEmpresa);
	    if ($this->db->count_all_results() == 0) {
	        $tasa = new stdClass();
	        $tasa->Tasa = $tasa_value['Tasa'];
	        $tasa->Id_empresa = $idEmpresa;
	        $tasa->Mes = $tasa_value['Mes'];
	        $tasa->Ano = $tasa_value['Ano'];
	        if ($this->get_productoId($idEmpresa,'',$tasa_value['Id_Producto'])) {
	            $tasa->Id_Producto = $tasa_value['Id_Producto'];
	            $this->insert_row($tasa);
	        }
	    }
	}

	public function get_tasa_mercado($idProducto, $ano, $mes, $idEmpresa){
	    $this->db->select('Tasa');
	    $this->db->from('tasa_mercado');
	    $this->db->where('Id_Producto', $idProducto);
	    $this->db->where('id_Empresa', $idEmpresa);
	    return $this->db->limit(1)->get()->row_array();
	}

	//TODO: validate response in method.
	public function get_asociado($identificacion, $idEmpresa) {
	    $this->db->select('*');
	    $this->db->from('asociados');
	    $this->db->where('Id_Empresa', $idEmpresa);
	    $this->db->where('Identificacion', $identificacion);
	    $result = $this->db->get()->row_array();
	    if (count($result) > 0) {
	        return $result;
	    }
	    return false;
	}

	public function get_edad($fecha){
	    $fecha = str_replace("/","-",$fecha);
	    $fecha = date('Y/m/d',strtotime($fecha));
	    $hoy = date('Y/m/d');
	    $edad = $hoy - $fecha;
	    return $edad;
	}

}