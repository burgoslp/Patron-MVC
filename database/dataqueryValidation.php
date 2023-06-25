<?php

class DataqueryValidation{

    public function validarData($data) : bool{
		//validamos que el tipo de dato sea un array y este a su vez sea associativo
		if(!$this->is_array($data) && !$this->is_array_assoc($data)){
			return false;
		}
		return true;
	}

	private function is_array($data): bool{
		if(!is_array($data)){
			return false;
		}
		return true;
	}

	private function is_array_assoc($data): bool{		
		if(!(is_array($data) && array_diff_key($data,array_keys(array_keys($data))))){
			return false;
		}		
		return true;
	}

	public function validarCampos($data,$camposModelo) : bool{		
		if(!$this->coincidence_cant_campos($data,$camposModelo) && !$this->coincidence_campos($data,$camposModelo)){
			return false;
		}	
		return true;		
	}

	private function coincidence_cant_campos($data,$camposModelo) : bool{
		//validamos que los campos de la data sean iguales en cantidad que los campos declarados en el modelo
		if(count($camposModelo) != count($data)){
			return false;
		}
		return true;
	}

	private function coincidence_campos($data,$camposModelo) : bool{
		//validamos que los indices o claves del array asociativo coincida con los nombres declarados en el modelo
		foreach($camposModelo as $campo){
			if(!array_key_exists($campo,$data)){
				
				return false;
			}
		}
		return true;
	}

	public function validarCampo($data,$camposModelo) : bool{
		$keyArray=array();
		foreach($data as $key => $value){
			 array_push($keyArray,$key);
		}
		
		for($x=0 ; $x < count($data); $x++){
			if(!in_array($keyArray[$x],$camposModelo)){
				
				return false;
			}
		}
		return true;
	}

	
	public function validarOperador($operador){
		$error=true;		
		switch($operador){
			case "=":
				$error=false;
				break;
			case "<":
				$error=false;
				break;
			case ">":
				$error=false;
				break;
			case ">=":
				$error=false;
				break;
			case "<=":
				$error=false;
				break;
			case "<>":
				$error=false;
				break;
			case "LIKE":
				$error=false;
				break;
		}
		$this->error=$error;
	}
}
?>