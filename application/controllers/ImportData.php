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

  function import_oracle() {
  	$this->load->library('importfromoracle');
  	$this->importfromoracle->connect_db('balancoop', '1234', 'XE', '127.0.0.1');
  	$query = 'SELECT * FROM EMP';
  	var_dump($this->importfromoracle->execute_query($query));
  }

  function import_mysql($tablaDb, $idEmpresa = 0) {
  	$this->load->library('importfrommysql');
  	$this->importfrommysql->connect_db('root', '', 'balancoop_cliente', 'localhost');
  	$query = "SELECT * FROM {$tablaDb} limit 300";
  	$rows = $this->importfrommysql->execute_query($query);

  	$this->import_model->load_model($tablaDb);
  	// Eliminar aosciados relacionados a la empresa.
  	$tablesToDelete = ['asociados',
		  	'asociados_beneficiarios',
  			'asociados_conocidos',
  			'asociados_hijos',
  			'asociados_conyuge'
  	];
	if (in_array($tablaDb, $tablesToDelete) && $idEmpresa) {
		$query = ['id_Empresa' => $idEmpresa];
		$this->import_model->delete($query);
	}


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
  				$newRow = $this->import_model->add_asociado_habil($row);
  				break;
  			case 'asociados_beneficiarios':
  				$newRow = $this->import_model->add_asociado_beneficiario($row);
  				break;
  			case 'asociados_conocidos':
  				$newRow = $this->import_model->add_asociado_conocido($row);
  				break;
  			case 'asociados_hijos':
  				$newRow = $this->import_model->add_asociado_hijo($row);
  				break;
  			case 'asociados_conyuge':
  				$newRow = $this->import_model->add_asociado_conyuge($row, $idEmpresa);
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

