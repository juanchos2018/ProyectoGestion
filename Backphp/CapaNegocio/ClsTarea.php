<?php
require_once('../CapaDatos/ClsLibre.php');
class ClsTarea
{
    public $id_tarea;
    public $verionID; 
	public $miembroresponsableID; 
    public $fecha_inicio;  
    public $fecha_termino;  
    public $descripcion;  
    public $porcentajeavance;  
    public $urlevidencia;
    public $estado;
    public $estado1;
    public $estado2;
    public $respuesta;
    
    function Agregar($tarea)
    {
        $sql = new tablalibre();
        $consulta ="INSERT INTO tarea_ecs (verionID,miembroresponsableID,fecha_inicio,fecha_termino,descripcion,porcentajeavance,urlevidencia,estado,estado1) 
        values ('$tarea->verionID', '$tarea->miembroresponsableID', '$tarea->fecha_inicio', '$tarea->fecha_termino', '$tarea->descripcion', '$tarea->porcentajeavance', '$tarea->urlevidencia', '$tarea->estado','$tarea->estado1')";
        $rs=$sql->consulta($consulta);
        return $rs;
    }
    public function ListaTareaVersion($verionID){
        $sql = new tablalibre();
        $consulta ="SELECT t.id_tarea,t.verionID, t.miembroresponsableID,usu.nombre, t.fecha_inicio,t.fecha_termino,t.descripcion,t.porcentajeavance,t.urlevidencia,t.estado ,t.estado1,t.estado2 FROM tarea_ecs AS t
        INNER JOIN miembroproyecto AS  mi 
        ON t.miembroresponsableID=mi.id
        INNER  JOIN usuario AS usu
        ON mi.usuario_miembroid= usu.id_usuario
        WHERE t.verionID=".$verionID;
        $rs=$sql->consulta($consulta);
        $vector = array();
        while($datos = $rs->recordset->fetch(PDO::FETCH_ASSOC)){
              $temp = new ClsTarea;
              $temp->id_tarea            = $datos["id_tarea"];
              $temp->verionID            = $datos["verionID"];
              $temp->nombre              = $datos["nombre"];
              $temp->miembroresponsableID = $datos["miembroresponsableID"];             	
              $temp->fecha_inicio        = $datos["fecha_inicio"];
              $temp->fecha_termino       = $datos["fecha_termino"];
              $temp->descripcion         = $datos["descripcion"];
              $temp->porcentajeavance    = $datos["porcentajeavance"];
              $temp->urlevidencia        = $datos["urlevidencia"];
              $temp->estado              = $datos["estado"];
              $temp->estado1             = $datos["estado1"];
              $temp->estado2             = $datos["estado2"];
              array_push($vector,$temp);
        }
        return $vector;
    } 

    public function BuscarTarea($id_tarea){
        $sql = new tablalibre();
        $consulta ="SELECT t.id_tarea,t.verionID, t.miembroresponsableID,usu.nombre, t.fecha_inicio,t.fecha_termino,t.descripcion,t.porcentajeavance,t.urlevidencia,t.estado,t.estado1,t.estado2, t.respuesta FROM tarea_ecs AS t
        INNER JOIN miembroproyecto AS  mi 
        ON t.miembroresponsableID=mi.id
        INNER  JOIN usuario AS usu
        ON mi.usuario_miembroid= usu.id_usuario
        WHERE t.id_tarea=".$id_tarea;
        $rs=$sql->consulta($consulta);
        $vector = array();
        while($datos = $rs->recordset->fetch(PDO::FETCH_ASSOC)){
              $temp = new ClsTarea;
              $temp->id_tarea                = $datos["id_tarea"];
              $temp->verionID                = $datos["verionID"];
              $temp->nombre                  = $datos["nombre"];
              $temp->miembroresponsableID    = $datos["miembroresponsableID"];             	
              $temp->fecha_inicio            = $datos["fecha_inicio"];
              $temp->fecha_termino           = $datos["fecha_termino"];
              $temp->descripcion             = $datos["descripcion"];
              $temp->porcentajeavance        = $datos["porcentajeavance"];
              $temp->urlevidencia            = $datos["urlevidencia"];
              $temp->estado                  = $datos["estado"];
              $temp->estado1                 = $datos["estado1"];
              $temp->estado2                 = $datos["estado2"];
              $temp->respuesta               = $datos["respuesta"];
              array_push($vector,$temp);
        }
        return $vector;
    } 

    public function BuscarTarea1($id_tarea){
        $sql = new tablalibre();
        $consulta = "SELECT t.id_tarea,t.verionID, t.miembroresponsableID,usu.nombre, t.fecha_inicio,t.fecha_termino,t.descripcion,t.porcentajeavance,t.urlevidencia,t.estado,t.estado1,t.estado2, t.respuesta  FROM tarea_ecs AS t
        INNER JOIN miembroproyecto AS  mi 
        ON t.miembroresponsableID=mi.id
        INNER  JOIN usuario AS usu
        ON mi.usuario_miembroid= usu.id_usuario
        WHERE t.id_tarea=".$id_tarea;
        $rs=$sql->consulta($consulta);
        $tarea = new ClsTarea;
        if($rs->nroregistros<>0){
             $datos=$rs->recordset->fetch(PDO::FETCH_ASSOC);
              $tarea->id_tarea              = $datos["id_tarea"];
              $tarea->verionID              = $datos["verionID"];
              $tarea->nombre                = $datos["nombre"];
              $tarea->miembroresponsableID  = $datos["miembroresponsableID"];             	
              $tarea->fecha_inicio          = $datos["fecha_inicio"];
              $tarea->fecha_termino         = $datos["fecha_termino"];
              $tarea->descripcion           = $datos["descripcion"];
              $tarea->porcentajeavance      = $datos["porcentajeavance"];
              $tarea->urlevidencia          = $datos["urlevidencia"];
              $tarea->estado                = $datos["estado"];
              $tarea->estado1               = $datos["estado1"];
              $tarea->estado2               = $datos["estado2"];
              $tarea->respuesta             = $datos["respuesta"];
        }
       
        return $tarea;
    }
    function VerMensaje($id){
        $sql = new tablalibre();
        $consulta = "SELECT  t.id_tarea,t.estado ,t.estado1,t.estado2,t.respuesta from  tarea_ecs AS t
        WHERE t.id_tarea =".$id;
        $rs=$sql->consulta($consulta);
        $tarea = new ClsTarea;
        if($rs->nroregistros<>0){
             $datos=$rs->recordset->fetch(PDO::FETCH_ASSOC);
              $tarea->id_tarea   = $datos["id_tarea"];
              $tarea->estado     = $datos["estado"];
              $tarea->estado1    = $datos["estado1"];
              $tarea->estado2    = $datos["estado2"];
              $tarea->respuesta  = $datos["respuesta"];
           
        }
       
        return $tarea;
    }
    function Editar($data)
    {
        $sql = new tablalibre();
        $consulta ="update tarea_ecs set porcentajeavance='$data->porcentajeavance', urlevidencia='$data->urlevidencia'  , estado='$data->estado',  estado1='$data->estado1'
        where id_tarea='$data->id_tarea'";
        $rs=$sql->consulta($consulta);
        return $rs;
    } 
    
}

