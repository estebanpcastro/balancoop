<?php
//Zona horaria

//Ejecucion
//php index.php importdata import_mysql asociados 2
//php index.php importdata import_mysql aportes 2

date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Cliente
 *
 * @author              John Arley Cano Salinas
 */
Class ImportData extends CI_Controller{

  function __construct() {
    parent::__construct();
    $this->load->model(array('import_model'));
  }

  function import_oracle($tablaDb, $idEmpresa = 0) {
  	$this->load->library('importfromoracle');
  	$this->importfromoracle->connect_db('balancoop', '1234', 'XE', 'localhost');
  	$query = 'SELECT * FROM '.$tablaDb;
  	$rows = $this->importfromoracle->execute_query($query);
  	$this->importfromoracle->disconnect_db();
  	$this->validateIfCleanTable($tablaDb, $idEmpresa);
  	$this->importRows($rows, $tablaDb, $idEmpresa);
  }

  function import_mysql($tablaDb, $idEmpresa = 0) {
  	$this->load->library('importfrommysql');
  	$this->importfrommysql->connect_db('root', '', 'balancoop_cliente', 'localhost');
  	$query = "SELECT * FROM {$tablaDb} limit 300";
  	$rows = $this->importfrommysql->execute_query($query);
  	$this->importfrommysql->disconnect_db();
  	$this->validateIfCleanTable($tablaDb, $idEmpresa);
  	$this->importRows($rows, $tablaDb, $idEmpresa);

  }
  protected function validateIfCleanTable($tablaDb, $idEmpresa) {
  	$this->import_model->load_model($tablaDb);
  	// Eliminar aosciados relacionados a la empresa.
  	$tablesToDelete = ['asociados',
  			'asociados_beneficiarios',
  			'asociados_conocidos',
  			'asociados_hijos',
  			'asociados_conyuge',
  			'asociados_motivo_retiro',

  	];
  	// Borrar data de las tablas por id_empresa
  	if (in_array($tablaDb, $tablesToDelete) && $idEmpresa) {
  		$condition = ['id_Empresa' => $idEmpresa];
  		$this->import_model->delete($condition);
  	}
  }


  protected function importRows($rows, $tablaDb, $idEmpresa) {
  	foreach ($rows as $row) {
  		switch ($tablaDb) {
  			case 'asociados':

  				$asociado = $this->import_model->add_asociado($row, $idEmpresa);
  				if (is_array($asociado)) {
  					$newRows[] = $asociado;
  				}
  				break;
  			case 'aportes':
  				$newRow = $this->import_model->add_aporte($row, $idEmpresa);
  				break;
  			case 'asociados_habiles':
  				$newRow = $this->import_model->add_asociado_habil($row, $idEmpresa);
  				break;
  			case 'asociados_beneficiarios':
  				$newRow = $this->import_model->add_asociado_beneficiario($row, $idEmpresa);
  				break;
  			case 'asociados_conocidos':
  				$newRow = $this->import_model->add_asociado_conocido($row, $idEmpresa);
  				break;
  			case 'asociados_hijos':
  				$newRow = $this->import_model->add_asociado_hijo($row, $idEmpresa);
  				break;
  			case 'asociados_conyuge':
  				$newRow = $this->import_model->add_asociado_conyuge($row, $idEmpresa);
  				break;
  			case 'asociados_motivo_retiro':
  				$newRow = $this->import_model->add_asociado_conyuge($row, $idEmpresa);
  				break;
  			case 'asociados_otros_datos':
  				$newRow = $this->import_model->add_asociados_motivo_retiro($row, $idEmpresa);
  				break;
  			case 'directivos':
  				$newRow = $this->import_model->add_directivo($row, $idEmpresa);
  				break;


  			default:
  				$newRow = null;
  				break;
  		}
  	}
	// Insert multiples rows is more efficient.
  	if ($tablaDb == 'asociados') {
  		$this->import_model->insert_multiple_rows($newRows);
  	}
  }

}

