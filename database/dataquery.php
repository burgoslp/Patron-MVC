<?php 
include dirname(__DIR__).'/database/conexion.php';
include dirname(__DIR__).'/config/config.php';
include dirname(__DIR__).'/database/dataqueryValidation.php';
class Dataquery extends Conexion{
    public $table;
	public $campos;
	public $id;

	private $select="SELECT *";
	private $from="FROM ";
	private $where;
	private $sql;
	private $msj;
	private $error;

    public function __construct($table,$campos,$id)
	{
        parent::__construct(LOCALHOST,ROOT,PASSWORD,BASEDATOS);
		$this->table=$table;
		$this->campos=$campos;
		$this->id=$id;
		
	}	
	///////////////////////////////////////////
	///////////////////////////////////////////
	//metodos que deberían ser estaticas
	public function all() : array {//retorna un all de todos los datos de esa tabla
		$conexion=$this->DB();
		$query=$conexion->query(sprintf("SELECT * FROM %s",$this->table));
		if(!$query){return array('error'=>true,'msj'=>$conexion->error);}
		$respuesta=array();
		$x=0;
		while($fila=$query->fetch_assoc()){
			$respuesta[$x]=$fila;
			$x++;
		}	
		$conexion->close();
		return $respuesta;
	}
	public function create($data) : array{
		$validation= new DataqueryValidation();
		$rs=$validation->validarData($data);
		if(!$rs){return array('error'=>$rs,'msj'=>'La data no tiene el formato correcto');}
		$rs=$validation->validarCampos($data,$this->campos);
		if(!$rs){return array('error'=>$rs,'msj'=>sprintf('la cantidad de campos o algunos de los nombres de los campos no concuerdan con los del modelo (%s)',$this->table));}
	

		$datosFormato="";
		foreach($data as $value){
			$datosFormato.="'".$value."',";
		}
		$datosFormato=rtrim($datosFormato,',');

		$camposFormato="";
		foreach($data as $key => $value){
			$camposFormato.="`".$key."`,";
		}
		$camposFormato=rtrim($camposFormato,',');

		$conexion=$this->DB();
		$sql=sprintf("INSERT INTO %s (%s) VALUES (%s)",$this->table,$camposFormato,$datosFormato);
		$query=$conexion->query($sql);
		if(!$query){return array('error'=>true,'msj'=>$conexion->error,'sql'=>$sql);}
		$id=$conexion->insert_id;
		$conexion->close();
		return array('error'=>false,'msj'=>$sql,$id);
	}

	public function update($data,$id=null) : array{
		$validation= new DataqueryValidation();
		$rs=$validation->validarData($data);
		if(!$rs){return array('error'=>$rs,'msj'=>'La data no tiene el formato correcto');}
		$rs=$validation->validarCampo($data,$this->campos);
		if(!$rs){return array('error'=>$rs,'msj'=>sprintf('los campos en la data no concuerdan con los del modelo (%s)',$this->table));}

		



		


		/*
		$valores="";
		$id="";
		foreach($data as $key => $value){
			if($key != 'id'){
				$valores.="`".$key."`"."="."'".$value."'".",";
			}else{
				$id=sprintf("`%s`='%s'",$key,$value);
			}
		}
		$valores=rtrim($valores,',');
		$conexion=$this->DB();
		$sql=sprintf("UPDATE %s SET %s WHERE %s",$this->table,$valores,$id);
		$query=$conexion->query($sql);
		if(!$query){return array('error'=>true,'msj'=>$conexion->error,'sql'=>$sql);}
		$conexion->close();
		return array('error'=>false,'msj'=>sprintf('Registro Actualizado exitosamente')); */
		return array('error'=>false, 'msj'=>'todo bien');
	}

	public function delete($data) : array{
		//verificación del tipo de dato que pasamos por parametros
		if(!is_array($data)){return array('error'=>true,'msj'=>'El parametro pasado no es de tipo array');}
		if(!$this->is_assoc($data)){return array('error'=>true,'msj'=>'El parametro pasado no es de tipo array asociativo');}
		
		if(empty($this->id)){			
			$id= "id";
			$value= $data['id'];
		}else{
			$id=$this->id;
			$value=$value= $data["$this->id"];
		}
		$sql=sprintf("DELETE FROM %s WHERE %s = %s", $this->table, $id,$value);
		$conexion=$this->DB();
		$query=$conexion->query($sql);
		if(!$query){return array('error'=>true,'msj'=>$conexion->error,'sql'=>$sql);}
		$conexion->close();

		return array('error'=>false,'msj'=>'Registro eliminado exitosamente'); 
	}
	///////////////////////////////////////////
	///////////////////////////////////////////
	//medotos para la construcción de consultas
	public function select($campos){
		//verificación de parametros y campos
		if(!is_array($campos)){$this->error=true; return $this->msj=sprintf("El parametro pasado no es de tipo array");}
		/*foreach($campos as $campo){
			$error=$this->validarCampos($campo);
			if($error){return $this->msj=sprintf("No existe un campo (%s) con ese nombre",$campo);}
		}*/
		//fin verificación de parametros y campos

		$select=""	;
		$select.="SELECT";
		foreach($campos as $campo){
			$select.=sprintf(" %s,",$campo);
		}
		$selectFormato=trim($select,',');
		$this->select=$selectFormato;
		$this->from=sprintf("FROM %s",$this->table);
		$sql=sprintf("%s %s",$this->select,$this->from);

		$this->sql=$sql;
	}
	public function where($campo, $operador, $criterio) : string{
		//formato de los valores
		$campoFormato=trim($campo);
		$operadorFormato=strtoupper(trim($operador));
		//fin del formato de los valores

		//verificación de campos, operadores o errores
		if($this->error){return $this->msj;}
		$error=$this->validarCampos($campoFormato);
		if($error){return $this->msj=sprintf("No existe un campo (%s) con ese nombre",$campoFormato);}
		$error=$this->validarOperador($operadorFormato);
		if($error){return $this->msj=sprintf("No existe ese tipo de operador (%s) de comparación",$operadorFormato);}
		//fin verificación de campos y operadores


		if(strlen($this->where) > 0){
			$this->where.=sprintf("AND %s %s'%s'",$campo,$operador,$criterio);
		}else{
			$this->where=sprintf("WHERE %s %s'%s'",$campo,$operador,$criterio);
		}	
		$this->from="FROM ";
		$this->sql=sprintf("%s %s %s %s",$this->select,$this->from,$this->table,$this->where);

		return $this->sql;
	}
	public function get() : array{
		//verifica que no exista algun error activo por algun where o select
		if($this->error){return array('error'=>true,'msj'=>$this->msj);}
		//fin de verificación de error

		$conexion= $this->DB();
		$sql=$this->sql;
		$query=$conexion->query($sql);
		if(!$query){return array('error'=>true,'msj'=>$conexion->error);}
		$rs=array();
		$x=0;
		while($row=$query->fetch_assoc()){
			$rs[$x]=$row;
			$x++;
		}
		$conexion->close();
		return $rs;		
	}


	
}	


?>