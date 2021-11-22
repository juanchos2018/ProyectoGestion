<?php
require_once('../CapaDatos/ClsLibre.php');
class ClsVersion
{
    public $id_version;
    public $elemntoconfiguracionID; 
	public $version; 
	public $fecha_inicio;  
    public $fecha_termino;  
    public $miembroresponsableID;  
    function Agregar($version)
    {
        $sql = new tablalibre();
        $consulta="INSERT INTO  version (elemntoconfiguracionID,version,fecha_inicio,fecha_termino,miembroresponsableID)
        values ('$version->elemntoconfiguracionID', '$version->version','$version->fecha_inicio','$version->fecha_termino','$version->miembroresponsableID')";
        $rs=$sql->consulta($consulta);
        return $rs;
    }
   
    public function Listar($id_elemento){
        $sql = new tablalibre();
        $consulta="SELECT v.miembroresponsableID, v.id_version,v.elemntoconfiguracionID,v.version,v.fecha_inicio,v.fecha_termino, usu.nombre FROM version AS v
        INNER JOIN miembroproyecto AS  mi 
        ON v.miembroresponsableID=mi.id
        INNER  JOIN usuario AS usu
        ON mi.usuario_miembroid= usu.id_usuario        
        WHERE v.elemntoconfiguracionID =".$id_elemento;
        $rs=$sql->consulta($consulta);
        $vector = array();
        while($datos = $rs->recordset->fetch(PDO::FETCH_ASSOC)){
              $temp = new ClsVersion;
              $temp->id_version              = $datos["id_version"];
              $temp->miembroresponsableID    = $datos["miembroresponsableID"];
              $temp->nombre                  = $datos["nombre"];
              $temp->elemntoconfiguracionID  = $datos["elemntoconfiguracionID"];             	
              $temp->version                 = $datos["version"];   
              $temp->fecha_inicio            = $datos["fecha_inicio"];   
              $temp->fecha_termino           = $datos["fecha_termino"];             
              array_push($vector,$temp);
        }
        return $vector;
    } 
  

}

