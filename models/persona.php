<?php 
include dirname(__DIR__).'/database/dataquery.php';

class Persona extends Dataquery{
	
	private $table="personas";
	private $campos=['nombre','apellido','cedula'];
	private $id='id';
	public function __construct()
	{	
		parent::__construct($this->table,$this->campos,$this->id);
	}
}

$persona=new persona();

/*$persona->select(['nombre','apellido']);
$persona->where('apellido','<>','leopoldo');
var_dump($persona->get());*/


var_dump($persona->update(['nombre'=>'leopoldo','apellido'=>'pinedo','cedula'=>'26250938'],1));

//$persona->create(['nombre'=>'jizmel','apellido'=>'ataeza','cedula'=>26250925]);



?>