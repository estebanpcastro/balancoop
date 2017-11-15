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


	public function add_asociado($asociado_value, $idEmpresa) {

		$asociado = [];

// 		$asociado->id_TipodeIdentificacion = $asociado_value['Tipo_de_identificacion'];
// 		$asociado->id_Asociado = $asociado_value['Numero_de_identificacion'];
// 		$asociado->Identificacion = $asociado_value['Numero_de_identificacion'];
// 		$asociado->PrimerApellido = $asociado_value['Primer_apellido'];
// 		$asociado->SegundoApellido = $asociado_value['Segundo_apellido'];
// 		$asociado->Nombre = $asociado_value['Nombres'];
// 		$asociado->FechadeIngresoalaCooperativa = $asociado_value['Fecha_de_ingreso'];
// 		$asociado->TelefonoCasa = $asociado_value['Telefono'];
// 		$asociado->Direccion = $asociado_value['Direccion'];
// 		$asociado->Id_tipo = $asociado_value['Asociado'];
// 		$asociado->id_EstadoactualEntidad = $asociado_value['Activo'];
// 		$asociado->Departamento_Cliente = $asociado_value['Codigo_municipio'];
// 		$asociado->CorreoElectronico = $asociado_value['Email'];
// 		$asociado->id_Genero_cliente = $asociado_value['Genero'];
// 		$asociado->Estado_Empleado = $asociado_value['Empleado'];
// 		$asociado->id_tipoempleado = $asociado_value['TipoContrato'];
// 		$asociado->id_Escolaridad = $asociado_value['NivelEscolaridad'];
// 		$asociado->Id_Estrato = $asociado_value['Estrato'];
// 		$asociado->id_RangodeIngresomensual = $asociado_value['NivelIngresos'];
// 		$asociado->FechaNacimiento = $asociado_value['FechaNacimiento'];
// 		$asociado->id_EstadoCivil = $asociado_value['EstadoCivil'];
// 		$asociado->id_CabezadeFamilia = $asociado_value['MujerCabezaFamilia'];
// 		$asociado->id_Profesion = $asociado_value['Ocupacion'];
// 		$asociado->id_Industria = $asociado_value['Sector_economico'];
// 		$asociado->FechadeRetiro = $asociado_value['Fecha_de_retiro'];
// 		$asociado->id_Empresa = $idEmpresa;
		//   		$asociado_value['AsistioUltAsamblea'];
		if (is_array($asociado_value) && $idEmpresa) {
			$asociado['id_TipodeIdentificacion'] = $asociado_value['Tipo_de_identificacion'];
			// 		$asociado->id_Asociado = $asociado_value['Numero_de_identificacion'];
			$asociado['Identificacion'] = $asociado_value['Numero_de_identificacion'];
			$asociado['PrimerApellido'] = $asociado_value['Primer_apellido'];
			$asociado['SegundoApellido'] = $asociado_value['Segundo_apellido'];
			$asociado['Nombre'] = $asociado_value['Nombres'];
			$asociado['FechadeIngresoalaCooperativa'] = $asociado_value['Fecha_de_ingreso'];
			$asociado['TelefonoCasa'] = $asociado_value['Telefono'];
			$asociado['Direccion'] = $asociado_value['Direccion'];
			$asociado['Id_tipo'] = $asociado_value['Asociado'];
			$asociado['id_EstadoactualEntidad'] = $asociado_value['Activo'];
			$asociado['Departamento_Cliente'] = $asociado_value['Codigo_municipio'];
			$asociado['CorreoElectronico'] = $asociado_value['Email'];
			$asociado['id_Genero_cliente'] = $asociado_value['Genero'];
			$asociado['Estado_Empleado'] = $asociado_value['Empleado'];
			$asociado['id_tipoempleado'] = $asociado_value['TipoContrato'];
			$asociado['id_Escolaridad'] = $asociado_value['NivelEscolaridad'];
			$asociado['Id_Estrato'] = $asociado_value['Estrato'];
			$asociado['id_RangodeIngresomensual'] = $asociado_value['NivelIngresos'];
			$asociado['FechaNacimiento'] = $asociado_value['FechaNacimiento'];
			$asociado['id_EstadoCivil'] = $asociado_value['EstadoCivil'];
			$asociado['id_CabezadeFamilia'] = $asociado_value['MujerCabezaFamilia'];
			$asociado['id_Profesion'] = $asociado_value['Ocupacion'];
			$asociado['id_Industria'] = $asociado_value['Sector_economico'];
			$asociado['FechadeRetiro']= $asociado_value['Fecha_de_retiro'];
			$asociado['id_Empresa'] = $idEmpresa;
			return $asociado;
		}

		return false;



// 		return $this->insert_row($asociado);
	}

	// Toca validar porque al actualizar el aporte en la tabla asociado una cedula puede estar repetida
	public function add_aporte($aporte_value, $idEmpresa) {

		$aporte = new stdClass();

		$aporte->Identificacion = $aporte_value['Identificacion'];
		$aporte->Saldo = $aporte_value['Saldo'];
		$aporte->Fecha_ultimo_aporte = $aporte_value['Fecha_ultimo_aporte'];
		$aporte->Id_empresa = $idEmpresa;

		// TODO: validate if exist by date id_empresa, identificacion
		$this->db->select('*');
		$this->db->from($this->tablaDB);
		$this->db->where('Identificacion', $aporte->Identificacion);
		$this->db->where('Id_empresa', $idEmpresa);
		$this->db->where('Fecha_ultimo_aporte', $aporte->Fecha_ultimo_aporte);
		if ($this->db->count_all_results() == 0) {
			$this->insert_row($aporte);
		}

		// update aporte
		$this->db->set('AporteSocial',$aporte->Saldo);
		$this->db->where('Identificacion', $aporte->Identificacion);
		$this->db->where('Id_Empresa', $idEmpresa);
// 		$data = ['AporteSocial' => $aporte->Saldo];
		$this->db->update('asociados');
	}


	// La validacion para actualizar habil debe ser por id_empresa e identificacion
	public function add_asociado_habil($asociado_value) {
		$this->db->select('*');
		$this->db->from($this->tablaDB);
		$this->db->where('Num_identificacion', $asociado_value['Num_identificacion']);
		$this->db->where('Ano', $asociado_value['Ano']);
		$this->db->where('Id_empresa', $asociado_value['Id_empresa']);

		if ($this->db->count_all_results() == 0 && $asociado_value['Num_identificacion'] != NULL) {
			$asociado = new stdClass();
			$asociado->Num_identificacion = $asociado_value['Num_identificacion'];
			$asociado->Ano = $asociado_value['Ano'];
			$asociado->Id_empresa = $asociado_value['Id_empresa'];
			$this->insert_row($asociado);
		}

		$this->db->set('Habil', 1);
		$this->db->where('Identificacion', $asociado_value['Num_identificacion']);
		$this->db->where('Id_Empresa', $asociado_value['Id_empresa']);
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
			$directivo->Calidad = $directivo_value['Calidad'];
			$directivo->FechaNombra = $directivo_value['FechaNombra'];
			$directivo->EmpresaRevisorFiscal = $directivo_value['EmpresaRevisorFiscal'];
			$directivo->TarjetaProfRevisorFiscal = $directivo_value['TarjetaProfRevisorFiscal'];
			$directivo->FechaPosesion = $directivo_value['FechaPosesion'];
			$directivo->PeriodoVigencia = $directivo_value['PeriodoVigencia'];
			$directivo->Parentescos = $directivo_value['Parentescos'];
			$directivo->Vinculadas = $directivo_value['Vinculadas'];
			$this->insert_row($directivo);
		}

		// Se busca que si esta en la tabla asociados por el id
		//TODO: validar con los otros codigos que se debe hacer
		$conditionsUpdate = [];
		$tipoDirectivoJunta = [2, 10, 12];
		$tipoDirectivoConsejero = [7, 1, 9];
		$tipoDirectivoComites = [8, 11];
		if (in_array($directivo_value['Id_TipoDirectivo'],$tipoDirectivoConsejero)) {
			$conditionsUpdate['EstadocomoConsejero'] = 1;
			$conditionsUpdate['Fecha_Inicio_Consejero'] = $directivo_value['FechaPosesion'];
			$fechaFin = $directivo_value['FechaPosesion'] + $directivo_value['PeriodoVigencia'];
			$conditionsUpdate['Fecha_fin_Consejero'] = $fechaFin;
		}
		else if (in_array($directivo_value['Id_TipoDirectivo'], $tipoDirectivoJunta)) {
			$conditionsUpdate['EstadocomoJuntadeVigilancia'] = 1;
			$conditionsUpdate['Fecha_Inicio_Junta'] = $directivo_value['FechaPosesion'];
			$fechaFin = $directivo_value['FechaPosesion'] + $directivo_value['PeriodoVigencia'];
			$conditionsUpdate['Fecha_fin_Junta'] = $fechaFin;
		}
		else if (in_array($directivo_value['Id_TipoDirectivo'], $tipoDirectivoComites)) {
			$conditionsUpdate['EstadoenComites'] = 1;
			$conditionsUpdate['Fecha_Inicio_Comites'] = $directivo_value['FechaPosesion'];
			$fechaFin = $directivo_value['FechaPosesion'] + $directivo_value['PeriodoVigencia'];
			$conditionsUpdate['Fecha_fin_Comites'] = $fechaFin;
		}
		// TODO: validar si el update en asociados se hace por el nit
		if (!empty($conditionsUpdate)) {
			$this->db->where('Identificacion', $directivo_value['Nit']);
			$this->db->where('Id_Empresa', $idEmpresa);
			$this->db->update('asociados', $conditionsUpdate);
		}



	}

	public function add_asociado_beneficiario($asociado_value) {
		$asociado = new stdClass();
// 		$asociado->intCodigo = $asociado_value['']; // activar autoicrement este codigo no deberia ir sino el secuence.
		$asociado->Id_empresa = $asociado_value['Id_empresa'];
		$asociado->strNombre = $asociado_value['strNombre'];
		$asociado->TelefonoCasa = $asociado_value['Telefono'];
		$asociado->Identificacion = $asociado_value['Identificacion'];
		$asociado->Email = $asociado_value['Email'];
		return $this->insert_row($asociado);
	}
	// TODO: Validar esta importacion con el campo Id_asociados.
	public function add_asociado_conocido($asociado_value, $idEmpresa) {
		$asociado = new stdClass();
		$asociado->id_Asociado = $asociado_value['']; // este codigo no deberia ir sino el secuence.
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
		$asociado->id_Asociado = $asociado_value['']; // este codigo no deberia ir sino el secuence.
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
}