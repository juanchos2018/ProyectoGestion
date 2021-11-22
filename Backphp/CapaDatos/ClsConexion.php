<?php

class conexion{

	var $user;
	var $pass;
	var $host;
	var $database;
	var $identificador;

	function __construct($parametros=""){
		if($parametros==""){
		//	$proveedor = "mysql";		
		//	$user="edsyscom";			
		//	$pass="HxhCyVR9k7;5(5";
		//	$database="edsyscom_bdmoviles";
		//	$host="localhost";

			$proveedor = "mysql";		
			$user="root";			
			$pass="";
			$database="sistemagc";
			$host="localhost";

		}else{

			$arrayParametros = explode(",",$parametros);
			$user = trim($arrayParametros[0]);
			$pass = trim($arrayParametros[1]);
			$database = trim($arrayParametros[2]);
			$host = trim($arrayParametros[3]);

		}
		$this->proveedor = $proveedor;		
		$this->user = $user;
		$this->pass = $pass;
		$this->host = $host;
		$this->database = $database;
		$this->conectar();

	}
  /* Conecta al servidor */

		function conectar(){
		try {
		    $this->identificador =new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->user, $this->pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		} catch (PDOException $e){
		    echo $e->getMessage();
		}
	}
  /* Desconecta del servidor */
		function desconectar(){
		$this->identificador = null;
	}


}

?>
