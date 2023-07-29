<?php

class DataqueryValidation{

    public function validar_data_formato($data) : bool{
		//validamos que la data sea un array y este a su vez sea associativo
		if(!$this->is_array($data) && !$this->is_array_assoc($data)){
			return false;
		}
		return true;
	}

	public function is_array($data): bool{
		//validamos que la data pasada por parametros sea un array
		if(!is_array($data)){
			return false;
		}
		return true;
	}

	private function is_array_assoc($data): bool{	
		//validamos que la data pasada por parametros sea un array asociativo	
		if(!(is_array($data) && array_diff_key($data,array_keys(array_keys($data))))){
			return false;
		}		
		return true;
	}

	public function validar_campos($data,$camposModelo) : bool{	
		//validamos que los campos de la tabla corresponda en cantidad Y con los nombre de la tabla en base de datos
		if(!$this->coincidencia_campos_cantidad_estricto($data,$camposModelo) && !$this->coincidencia_campos_nombres($data,$camposModelo)){
			return false;
		}	
		return true;		
	}

	public function coincidencia_campos_cantidad_estricto($data,$camposModelo) : bool{
		//validamos que los campos de la data sean iguales en cantidad que los campos declarados en el modelo
		if(count($camposModelo) != count($data)){
			return false;
		}
		return true;
	}

	public function coincidencia_campos_nombres($data,$camposModelo) : bool{

		if($this->is_array_assoc($data)){
			//validamos que los indices o claves del array asociativo coincida con los nombres declarados en el modelo
			foreach($data as $key => $value){
				if(!in_array($key,$camposModelo)){					
					return false;
				}
			}
			
		}else if($this->is_array($data)){
			//validamos que los valores del array coincida con los nombres declarados en el modelo
			foreach($data as $campo){
				if(!in_array($campo,$camposModelo)){
					
					return false;
				}
			}
		}else{
			//validamos que el string pertenezca coincida con alguno delos nombres declarados en el modelo
			if(!in_array(trim($data),$camposModelo)){
					
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

	
	public function validar_sql_operador($operador) : bool{
		switch(strtoupper(trim($operador))){
			case "=":
				$vl=true;
				break;
			case "<":
				$vl=true;
				break;
			case ">":
				$vl=true;
				break;
			case ">=":
				$vl=true;
				break;
			case "<=":
				$vl=true;
				break;
			case "<>":
				$vl=true;
				break;
			case "LIKE":
				$vl=true;
				break;
			default:
				$vl=false;
		}		
		return $vl;
	}
}
?>