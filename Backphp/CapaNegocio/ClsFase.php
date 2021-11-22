<?php
require_once('../CapaDatos/ClsLibre.php');
class ClsFase
{
    public $id_fase; 
	public $nombre_fase; 
	public $metodologiaId;  

    function Agregar($fase)
    {
        $sql = new tablalibre();
        $consulta ="INSERT INTO fase (nombre_fase,metodologiaId) 
        values ('$fase->nombre_fase', '$fase->metodologiaId')";
        $rs=$sql->consulta($consulta);
        return $rs;
    }
    public function Listar($metodologiaId){
        $sql = new tablalibre();
        $page="page1";
        $consulta ="SELECT * FROM fase where metodologiaId= '$metodologiaId'";
        $rs=$sql->consulta($consulta);
        $vector = array();
        while($datos = $rs->recordset->fetch(PDO::FETCH_ASSOC)){
              $temp = new ClsFase;
              $temp->id_fase        = $datos["id_fase"];
              $temp->nombre_fase    = $datos["nombre_fase"];
              $temp->metodologiaId  = $datos["metodologiaId"];   
              $temp->slot           = $page;    
              $temp->label          = $datos["nombre_fase"];            	
              array_push($vector,$temp);
        }
        return $vector;
    } 
    function Editar($data)
    {
        $sql = new tablalibre();
        $consulta ="update fase set nombre_fase='$data->nombre_fase'  
        where id_fase='$data->id_fase'";
        $rs=$sql->consulta($consulta);
        return $rs;
    } 
    function Existe($fase)
    {
       $buscar= new tablalibre();
       $consulta ="SELECT * from fase where  nombre_fase ='$fase->nombre_fase' and metodologiaId = '$fase->metodologiaId'"; 
       $rs=$buscar->consulta($consulta);
       return $rs->nroregistros;   
    
    }
}

