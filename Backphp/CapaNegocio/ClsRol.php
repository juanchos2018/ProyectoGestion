<?php
require_once('../CapaDatos/ClsLibre.php');
class ClsRol
{
    public $id_rol; 
	public $nombre;     

    function Agregar($rol)
    {
        $sql = new tablalibre();
        $consulta =" INSERT INTO  rol (nombre) 
        values ('$rol->nombre')";
        $rs=$sql->consulta($consulta);
        return $rs;
    }
    public function Listar(){
        $sql = new tablalibre();   
        $consulta ="SELECT * FROM  rol";
        $rs=$sql->consulta($consulta);
        $vector = array();
        while($datos = $rs->recordset->fetch(PDO::FETCH_ASSOC)){
              $temp = new ClsRol;
              $temp->id_rol = $datos["id_rol"];
              $temp->nombre = $datos["nombre"];                    	
              array_push($vector,$temp);
        }
        return $vector;
    } 
   

}

