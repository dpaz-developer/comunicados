<?php
	require_once ('../conf/constants.inc');
	abstract class Transactional {
	
	private static $dbHost = DB_HOST;
	private static $dbUser = DB_USER;
	private static $dbPass = DB_PASS;
	protected $dbName = DB_NAME;
	protected $query ;
	protected $rows = array();
	private $conn;
	public $message = 'OK';

	# metodos abstractos de la clase para heredar
	abstract protected function get();
	abstract protected function set();
	abstract protected function edit();
	abstract protected function delete();

	# metodos de la conexion 

	private function openConnection(){
		$this->conn = new mysqli(self::$dbHost, self::$dbUser, 
			self::$dbPass, $this->dbName);
	}

	private function closeConnection(){
		$this->conn->close();
	}

	protected function executeSingleQuery(){
		if($_POST){
			$this->openConnection();
			$this->conn->query($this->$query);
			$this->closeConnection();
		}else{
			$this->message = 'Método no permitido';
		}
	}

	protected function getResultFromQuery(){
		$this->openConnection();
		$result = $this->conn->query($this->query);
		while ($this->rows[] = $result->fetch_assoc());
		$result->close();
		$this->closeConnection();
		array_pop($this->rows);
	}

}
?>
