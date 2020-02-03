<?php 


class Database {

	private $connection;

	private $host = 'localhost';
	private $db_user = 'root';
	private $db_password = '';
	private $db_name = 'jwt_test';


	function getConnection() {

		$this->connection = mysqli_connect($this->host, $this->db_user, $this->db_password, $this->db_name);

		if (!($this->connection)) {

			die('CANNOT CONNECT' . mysqli_error($this->connection));

		} else {
			//echo "connected";
			return $this->connection;
		}
	}



}







 ?>