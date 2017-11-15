<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

get_instance()->load->iface('BdInterface');

class ImportFromMysql extends CI_Model implements BdInterface{

	protected $ci;

	protected $config;

	protected $connect;

	function __construct() {
		// Assign the CodeIgniter super-object
		$this->ci =& get_instance();
		$this->config = [];
	}

	public function execute_query($sqlQuery) {
		try {

			if($this->connect) {
				$stmt = $this->connect->prepare($sqlQuery);
				$stmt->execute();
				$response = $stmt->fetchAll();
				return $response;
			}
		} catch(PDOException $e) {
			echo 'ERROR: ' . $e->getMessage();
			return false;
		}
	}

	public function connect_db($username, $password, $database, $hostname) {
		try {
			$stringContection = 'mysql:host='.$hostname.';dbname='.$database;
			$this->connect = new PDO($stringContection, $username, $password);
			$this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e) {
			echo 'ERROR: ' . $e->getMessage();
		}
	}

	public function disconnect_db() {
		mysqli_close($this->connect);;
	}

	public function delete() {
	}
	public function execute_query_list_data($sqlQuery) {
		try {

			if($this->connect) {
				$stmt = $this->connect->prepare($sqlQuery);
				$stmt->execute();
				$rows = $stmt->fetchAll();
				return $rows;
			}
		} catch(PDOException $e) {
			echo 'ERROR: ' . $e->getMessage();
			return false;
		}
	}

}