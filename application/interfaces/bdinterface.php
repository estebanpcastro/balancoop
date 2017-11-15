<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

interface bdinterface
{
	public function connect_db($username, $password, $database, $hostname);
	public function disconnect_db();
	public function execute_query($sqlQuery);
	public function execute_query_list_data($sqlQuery);
	public function delete();
}

/* End of file bdinterface.php */
/* Location: ./application/interfaces/bdinterface.php */