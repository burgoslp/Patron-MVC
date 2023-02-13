<?php 
include dirname(__DIR__)."/models/persona.php";

function listarPersonas(){
	$personas=new Persona;
	$personaAll=$personas->all();

	return $personaAll;
}

function BusquedaPersona($string){
	$persona=new Persona;	
	$campo='nombre';
	$operador="=";
	$busqueda=$string;
	$persona->where('nombre',$operador,$busqueda);
	$rs=$persona->get();
	if(isset($rs['error'])){return $rs;}
	return $rs;
}

function MostrarPersona($id){
	$persona= new Persona;
	$persona->where('id','=',$id);
	$rs= $persona->get();
	if(isset($rs['error'])){return $rs['msj'];}
	return $rs;
}

function actualizarPersona($data){
	$persona = new Persona;
	$rs=$persona->update($data);
	if($rs['error']){return $rs['msj'];}
	return $rs;
}

function crearPersona($data){
	$persona= new Persona;
	$rs=$persona->create($data);
	return $rs;
}

function eliminarPersona($data){
	$persona= new Persona;
	$rs=$persona->delete($data);

	return $rs;
}

?>