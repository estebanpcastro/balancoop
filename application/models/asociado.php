<?php
/**
 * Modelo encargado de gestionar toda la informacion relacionada al cliente
 *
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
Class Asociado extends CI_Model{

    public function __construct()
    {
        $this->load->database();
        $this->load->model(array('import_model'));
    }

    public function add_asociados_otros_datos($asociado_value, $idEmpresa) {
        $asociado = new stdClass();
        $asociado->identificacion = $asociado_value['identificacion'];
        $asociado->id_empresa = $idEmpresa;
        $asociado->id_conocimiento_cooperativismo = $asociado_value['id_conocimiento_cooperativismo'];
        $asociado->id_GrupoFamiliar = $asociado_value['id_GrupoFamiliar'];
        $asociado->Ingresoreal = $asociado_value['Ingresoreal'];
        $asociado->Celular_cliente = $asociado_value['Celular_cliente'];
        $asociado->id_ciudad_cliente = $asociado_value['id_ciudad_cliente'];
        $asociado->id_pais_cliente = $asociado_value['id_pais_cliente'];
        $asociado->telefono_oficina_cliente = $asociado_value['telefono_oficina_cliente'];
        // Se actualiza la informacion del asociado en la tabla asociados otros datos.
        if ($this->import_model->insert_row($asociado)) {
            $data = [];
            $data['id_Conocimiento_Cooperativismo'] = $asociado_value['id_conocimiento_cooperativismo'];
            $data['id_GrupoFamiliar'] = $asociado_value['id_GrupoFamiliar'];
            $data['Ingresoreal'] = $asociado_value['Ingresoreal'];
            $data['Celular_cliente'] = $asociado_value['Celular_cliente'];
            $data['ciudad_cliente'] = $asociado_value['id_ciudad_cliente'];
            $data['Pais_Cliente'] = $asociado_value['id_pais_cliente'];
            $data['TelefonoOficina'] = $asociado_value['telefono_oficina_cliente'];
            $this->db->where('Identificacion', $asociado_value['identificacion']);
            $this->db->where('Id_Empresa', $idEmpresa);
            $this->db->update('asociados', $data);
        }
    }

    //TODO: no encuentro en la tabla asociados para actualizar
    //TODO: esta informacion se puede manejar en la misma tabla asociados
    public function add_asociados_motivo_retiro($asociado_value, $idEmpresa) {
        $asociado = new stdClass();
        $asociado->identificacion = $asociado_value['identificacion'];
        $asociado->id_empresa = $idEmpresa;
        $asociado->id_motivo_retiro = $asociado_value['id_motivo_retiro'];
        $this->import_model->insert_row($asociado);
        $data = [];
        $data['id_MotivoRetiro'] = $asociado_value['id_motivo_retiro'];
        $data['id_EstadoactualEntidad'] = 2;
        $this->db->where('id_Asociado', $asociado_value['identificacion']);
        $this->db->where('Id_Empresa', $idEmpresa);
        $this->db->update('asociados', $data);


    }

    public function add_asociado_conyuge($asociado_value, $idEmpresa) {
        $asociado = new stdClass();
        $asociado->identificacion = $asociado_value['identificacion'];
        $asociado->Id_empresa = $idEmpresa;
        $asociado->Identificacion_Conyuge = $asociado_value['Identificacion_Conyuge'];
        $asociado->NombredelConyuge = $asociado_value['NombredelConyuge'];
        $asociado->TelefonoCasa_Conyuge = $asociado_value['TelefonoCasa_Conyuge'];
        $asociado->TelefonoOficina_Conyuge = $asociado_value['TelefonoOficina_Conyuge'];
        $asociado->OtroTelefono_Conyuge = $asociado_value['OtroTelefono_Conyuge'];
        $asociado->Email_Conyuge = $asociado_value['Email_Conyuge'];
        $fechaNacimiento = str_ireplace('/', '-', $asociado_value['FechaNacimiento_Conyugue']);
        $asociado->FechaNacimiento_Conyugue = date('Y-m-d', strtotime($fechaNacimiento));
        $asociado->Direccion_Conyuge = $asociado_value['Direccion_Conyuge'];
        $asociado->Celular_Conyuge = $asociado_value['Celular_Conyuge'];
        $asociado->id_Genero_Conyugue = $asociado_value['id_Genero_Conyugue'];

        if ($this->import_model->insert_row($asociado)) {
            $data = [];
            $data['NombredelConyuge'] = $asociado_value['NombredelConyuge'];
            $data['TelefonoCasa_Conyuge'] = $asociado_value['TelefonoCasa_Conyuge'];
            $data['TelefonoCasa_Conyuge'] = $asociado_value['TelefonoCasa_Conyuge'];
            $data['TelefonoOficina_Conyuge'] = $asociado_value['TelefonoOficina_Conyuge'];
            $data['OtroTelefono_Conyuge'] = $asociado_value['OtroTelefono_Conyuge'];
            $data['Email_Conyuge'] = $asociado_value['Email_Conyuge'];
            $data['Direccion_Conyuge'] = $asociado_value['Direccion_Conyuge'];
            $data['Celular_Conyuge'] = $asociado_value['Celular_Conyuge'];
            $data['id_Genero_Conyugue'] = $asociado_value['id_Genero_Conyugue'];
            $data['Identificacion_Conyuge'] = $asociado_value['Identificacion_Conyuge'];
            $data['FechaNacimiento_Conyugue'] = date('Y-m-d', strtotime($fechaNacimiento));
            $this->db->where('id_Asociado', $idEmpresa.'-'.$asociado_value['identificacion']);
            $this->db->where('Id_Empresa', $idEmpresa);
            $this->db->update('asociados', $data);
        }
    }

    public function add_asociado_beneficiario($asociado_value, $idEmpresa) {
        $asociado = new stdClass();
        $asociado->id_Asociado = $asociado_value['id_Asociado']; // activar autoicrement este codigo no deberia ir sino el secuence.
        $asociado->Id_empresa = $idEmpresa;
        $asociado->strNombre = $asociado_value['strNombre'];
        $asociado->TelefonoCasa = $asociado_value['TelefonoCasa'];
        $asociado->TelefonoOficina = $asociado_value['TelefonoOficina'];
        $asociado->Email = $asociado_value['Email'];
        return $this->import_model->insert_row($asociado);
    }

    public function add_asociado_conocido($asociado_value, $idEmpresa) {
        $asociado = new stdClass();
        $asociado->id_Asociado = $asociado_value['id_Asociado'];
        $asociado->Id_empresa = $idEmpresa;
        $asociado->strNombre = $asociado_value['strNombre'];
        $asociado->TelefonoCasa = $asociado_value['TelefonoCasa'];
        $asociado->TelefonoOficina = $asociado_value['TelefonoOficina'];
        $asociado->Email = $asociado_value['Email'];
        $fechaNacimiento = str_ireplace('/', '-', $asociado_value['FechaNacimiento']);
        $asociado->FechaNacimiento = date('Y-m-d', strtotime($fechaNacimiento));
        $asociado->Edad = $asociado_value['Edad'];
        $asociado->id_Genero = $asociado_value['id_Genero'];
        $asociado->id_Parentesco = $asociado_value['id_Parentesco'];
        return $this->import_model->insert_row($asociado);
    }
    // TODO: Validar esta importacion con el campo Id_asociados.
    public function add_asociado_hijo($asociado_value, $idEmpresa) {
        $asociado = new stdClass();
        $asociado->id_Asociado = $asociado_value['id_Asociado'];
        $asociado->id_empresa = $idEmpresa;
        $asociado->strNombre = $asociado_value['strNombre'];
        $asociado->TelefonoCasa = $asociado_value['TelefonoCasa'];
        $asociado->TelefonoOficina = $asociado_value['TelefonoOficina'];
        $asociado->Email = $asociado_value['Email'];
        $fechaNacimiento = str_ireplace('/', '-', $asociado_value['FechaNacimiento']);
        $asociado->FechaNacimiento = date('Y-m-d', strtotime($fechaNacimiento));
        $asociado->Edad = $asociado_value['Edad'];
        $asociado->id_Genero = $asociado_value['id_Genero'];
        return $this->import_model->insert_row($asociado);
    }

    // La validacion para actualizar habil debe ser por id_empresa e identificacion
    public function add_asociado_habil($asociado_value, $idEmpresa) {
        $this->db->select('*');
        $this->db->from('asociados_habiles');
        $this->db->where('Num_identificacion', $asociado_value['Num_identificacion']);
        $this->db->where('Ano', $asociado_value['Ano']);
        $this->db->where('Id_empresa', $idEmpresa);

        if ($this->db->count_all_results() == 0) {
            $asociado = new stdClass();
            $asociado->Num_identificacion = $asociado_value['Num_identificacion'];
            $asociado->Ano = $asociado_value['Ano'];
            $asociado->Id_empresa = $idEmpresa;
            $this->import_model->insert_row($asociado);
        }
        $this->db->set('Habil', 1);
        $this->db->where('id_Asociado', $asociado_value['Num_identificacion']);
        $this->db->where('Id_Empresa', $idEmpresa);
        $this->db->update('asociados');
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
            $asociado['Edad_Cliente'] = $this->import_model->get_edad($asociado_value['FechaNacimiento']);
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
            if (!$this->import_model->get_asociado($asociado['Identificacion'], $idEmpresa)) {
                $this->import_model->insert_row($asociado);
            }

        }
        return false;
    }

}