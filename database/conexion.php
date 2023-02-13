<?php 
class conexion{

	var $hostname;
	var $user;
	var $password;
	var $db;

	public function __construct($hostname,$user,$password,$db){
		$this->hostname=$hostname;
		$this->user=$user;
		$this->password=$password;
		$this->db=$db;
	}

	public function DB(){

		$conexion=new mysqli($this->hostname,$this->user,$this->password,$this->db);
		if($conexion->connect_errno){
			$error=array(false,"error de conexion:".$conexion->connect_error);
			return $error;
		}else{
			return $conexion;
		}
	}

	
}	
?>