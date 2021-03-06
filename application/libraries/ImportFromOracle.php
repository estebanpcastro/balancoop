<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

get_instance()->load->iface('BdInterface');

class ImportFromOracle implements BdInterface {
	private $connect;
	private $username;
	private $password;
	private $database;

	function __construct() {
		$this->ci = & get_instance ();
	}

	public function execute_query_list_data($sqlQuery) {
		if(!$this->connect) {
		  return false;
		}
		$statement = oci_parse($this->connect, $sqlQuery);// Preparar la sentencia
		$response   = oci_execute( $statement );			// Ejecutar la sentencia
		oci_free_statement($statement);// Liberar los recursos asociados a una sentencia o cursor

		return $response;
	}
	public function execute_query($sqlQuery) {
	  if(!$this->connect) {
	  	return false;
	  }
	  $statement = oci_parse($this->connect, $sqlQuery);// Preparar la sentencia
 	  oci_execute( $statement );			// Ejecutar la sentencia
 	  $rows = [];

 	  while (($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
		$rows[] = $row;
 	  }
 	  oci_free_statement($statement);// Liberar los recursos asociados a una sentencia o cursor
	  return $rows;

	}

	public function connect_db($username, $password, $database, $hostname, $port = 1521) {
	  $tns = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)
			(HOST = "' . $hostname . '")(PORT = "'.$port.'")))
    		(CONNECT_DATA = (SID = "' . $database . '")))';
	  try {
	  	$this->connect = oci_connect($username, $password, $tns);
	  } catch (Exception $e) {
	  	die ("Error al conectar : ".oci_error());
	  }

	  return $this->connect;
	}

	public function disconnect_db() {
	  oci_close($this->connect);
	}

	public function delete() {
	}
}
