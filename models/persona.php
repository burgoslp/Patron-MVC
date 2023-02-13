<?php 
include dirname(__DIR__).'/database/dataquery.php';

class Persona extends Dataquery{
	
	public $table="personas";
	public $campos=['nombre','apellido','cedula'];
	public function __construct()
	{	
		parent::__construct($this->table,$this->campos);
	}
}



?>