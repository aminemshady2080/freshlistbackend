<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
class Db_connect {

	function __construct() {
	}

	public function connect_toDb() {
		require_once 'freshlist_config.php';
		// connecting to mysql server
		$connection = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		// select which db
		mysql_select_db("freshlist_db");
		
		return $connection;
	}

	// now close db connection
	public function close() {
		mysql_close();
	}

}
?>