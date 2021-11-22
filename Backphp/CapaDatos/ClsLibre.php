<?php

require_once('ClsConexion.php');

class tablalibre{
	var $conex;
	var $nroregistros;
	var $recordset;
	var $query;
	var $identificador;

  /* Constructor */

	public function __construct($parametros=""){

		if(trim($parametros)<>""){ $this->conex = $parametros; }

		else{ $this->conex = ""; }

	}

 // Ejecucion de la Consulta
	function consulta($consul){
		$objconexion = new conexion($this->conex);
		
		$this->query = $consul;
		$this->identificador = $objconexion->identificador;
		$this->recordset = $this->identificador->prepare($this->query);
		$this->recordset->execute();
		if($this->recordset) {
			$this->nroregistros =  $this->recordset->rowCount();
		}else{
			$this->nroregistros = 0;
		}
		//echo $this->nroregistros ." es rowcunt()";
		$objconexion->desconectar();
		return $this;
	}
	function consulta1($consul){
		$objconexion = new conexion($this->conex);
		
		$this->query = $consul;
		$this->identificador = $objconexion->identificador;
		$this->recordset = $this->identificador->prepare($this->query);
		$this->recordset->execute();
	//	$retunidproyecto = $recordset->lastInsertId();
		if($this->recordset) {
			$this->nroregistros =  $this->recordset->rowCount();
		}else{
			$this->nroregistros = 0;
		}
		//echo $this->nroregistros ." es rowcunt()";
		$objconexion->desconectar();
		return $this;
	}

	function ProcSqlServ($name,$values,$n){

		$objconexion = new conexion($this->conex);
		$this->query = "exec ".$name." ";
		for($i=1;$i<=$n;$i++){
			if($i==$n) {
				//$this->query =$this->query."'". $values[$i]."'";
				$this->query = $this->query."?";
			}else{
				$this->query = $this->query."?,";
				//$this->query =$this->query."'". $values[$i]."',";
			}

		}
		//echo 	$this->query;
		$this->identificador = $objconexion->identificador;
		$stmt = $this->identificador->prepare($this->query);
		for($i=1;$i<=$n;$i++){
			$stmt->bindParam($i, $values[$i]);
		}
		$this->recordset=$stmt->execute();
		if($this->recordset) {
			$this->nroregistros =  $this->recordset->rowCount();
		}else{
			$this->nroregistros = 0;
		}
		//echo $this->nroregistros ." es rowcunt()";
		$objconexion->desconectar();

		return $this;

	}




}

?>
