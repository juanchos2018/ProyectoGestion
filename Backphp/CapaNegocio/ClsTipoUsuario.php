<?php
require_once('../CapaDatos/ClsLibre.php');
class ClsTipoUsuario
{
    public $id_tipo; 
	
	public $nombre;  

    function Agregar($tipo)
    {
        $sql = new tablalibre();
        $consulta ="INSERT INTO tipousuario (nombre) 
        values ($tipo->nombre')";
        $rs=$sql->consulta($consulta);
        return $rs;
    }
    public function Lista(){
        $sql = new tablalibre();
        $consulta ="SELECT * FROM tipousuario";
        $rs=$sql->consulta($consulta);
        $vector = array();
        while($datos = $rs->recordset->fetch(PDO::FETCH_ASSOC)){
              $temp = new ClsTipoUsuario;
              $temp->id_tipo = $datos["id_tipo"];            
              $temp->nombre = $datos["nombre"];             	
              array_push($vector,$temp);
        }
        return $vector;
    } 
    
}

