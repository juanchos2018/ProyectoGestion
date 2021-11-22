<?php
//require_once('../CapaDatos/ClsLibre.php');
require_once('../CapaDatos/conectar.php');
class ClsMiembro{

    public $id;
    public $usuario_miembroid; 
	public $rolId; 
    public $proyectoId;  
   
 
    public function Agregar($usuario_miembroid,$rolId,$proyectoId){      
        $conexion=new Conexion();
        $db=$conexion->getConexion();    
    
        $nRows = $db->query("SELECT count(*) from miembroproyecto where usuario_miembroid=".$usuario_miembroid." AND proyectoId =".$proyectoId)->fetchColumn(); 
     
        if  ($nRows>0){
            return '{"msg":"Existe"}';
        }else{
            $sql="INSERT INTO  miembroproyecto (usuario_miembroid,rolId,proyectoId) VALUES (:usuario_miembroid,:rolId,:proyectoId)";
            $consulta=$db->prepare($sql);         
            $consulta->bindParam(':usuario_miembroid',$usuario_miembroid); 
            $consulta->bindParam(':rolId',$rolId); 
            $consulta->bindParam(':proyectoId',$proyectoId); 
            $consulta->execute();    
            return '{"msg":"Agreado"}';
        }
      
       
    }
    public function ObtenerDatos($miemdro_id){
        $vector=array();
        $conexion=new Conexion();
        $db=$conexion->getConexion();
        $sql="SELECT  mi.usuario_miembroid,  u.nombre,u.apellido,r.nombre AS nombre_rol, u.id_usuario  FROM miembroproyecto AS mi
        INNER JOIN usuario AS u
        ON mi.usuario_miembroid =u.id_usuario
        INNER JOIN rol AS r
        ON mi.rolId=r.id_rol WHERE mi.usuario_miembroid=".$miemdro_id;
        $consulta=$db->prepare($sql);
        $consulta->execute();
        while($fila=$consulta->fetch()){
            $vector[]=array(
                "usuario_miembroid"=>   $fila['usuario_miembroid'],
                "apellido"=>            $fila['apellido'],
                "nombre"=>              $fila['nombre'],
                "nombre_rol"=>          $fila['nombre_rol'],
                "id_usuario"=>          $fila['id_usuario'] );           
        }
        return $vector;
    }
   
    public function ListaMiembrosProyecto($id_proyecto){
        $vector=array();
        $conexion=new Conexion();
        $db=$conexion->getConexion();
        $sql="SELECT   mi.id,u.nombre,u.apellido,u.correo,r.nombre  as nombre_rol,mi.proyectoId,mi.usuario_miembroid FROM miembroproyecto  AS mi
        INNER JOIN proyecto AS p
        ON mi.proyectoId =p.id_proyecto
        INNER JOIN usuario AS u
        ON mi.usuario_miembroid=u.id_usuario
        INNER JOIN rol AS r
        ON mi.rolId =r.id_rol
        WHERE p.id_proyecto=".$id_proyecto;
        $consulta=$db->prepare($sql);
        $consulta->execute();
        while($fila=$consulta->fetch()){
            $vector[]=array(
                "id"                =>$fila['id'],
                "nombre"            =>$fila['nombre'],
                "apellido"          =>$fila['apellido'],
                "correo"            =>$fila['correo'],
                "nombre_rol"        =>$fila['nombre_rol'],
                "proyectoId"        =>$fila['proyectoId'],
                "usuario_miembroid" =>$fila['usuario_miembroid']);           
        }
        return $vector;
    }

    public function ListaTareasMiembro($miembroresponsableID){
        $vector=array();
        $conexion=new Conexion();
        $db=$conexion->getConexion();
        $sql="SELECT  usu.nombre ,t.id_tarea,t.verionID, t.fecha_inicio,t.fecha_termino,t.descripcion,t.porcentajeavance,t.urlevidencia,t.estado ,t.estado1,t.estado2 ,t.respuesta FROM tarea_ecs AS t
        inner JOIN  miembroproyecto AS mi 
        ON t.miembroresponsableID =mi.id
        INNER JOIN usuario AS  usu
        on usu.id_usuario=mi.usuario_miembroid
        WHERE t.miembroresponsableID =".$miembroresponsableID;
        $consulta=$db->prepare($sql);
        $consulta->execute();
        while($fila=$consulta->fetch()){
            $vector[]=array(
                "id_tarea"          =>$fila['id_tarea'],
                "fecha_inicio"      =>$fila['fecha_inicio'],
                "fecha_termino"     =>$fila['fecha_termino'],
                "descripcion"       =>$fila['descripcion'],
                "urlevidencia"      =>$fila['urlevidencia'],
                "porcentajeavance"  =>$fila['porcentajeavance'],
                "estado"            =>$fila['estado'],
                "estado1"           =>$fila["estado1"],
                "estado2"           =>$fila["estado2"],
                "respuesta"         =>$fila["respuesta"]);           
        }
        return $vector;
    }

    public function EditarRol($id, $rolId){
      
        $conexion=new Conexion();
        $db=$conexion->getConexion();     
        $sql = "UPDATE miembroproyecto SET rolId=:rolId WHERE id=:id";
        $consulta=$db->prepare($sql); 
        $consulta->bindParam(':id',$id);      
        $consulta->bindParam(':rolId',$rolId);           
        $consulta->execute();      
        return '{"msg":"editado Fase"}';
     }
  
  public function ListarMiembros(){
      
    $vector=array();
    $conexion=new Conexion();
    $db=$conexion->getConexion();
    $sql=" SELECT  pro.id_proyecto,  usu.nombre  FROM  miembroproyecto AS mi 
    INNER  JOIN  proyecto AS pro
    ON pro.id_proyecto=mi.proyectoId
    INNER JOIN usuario AS usu
    ON  usu.id_usuario=mi.usuario_miembroid";
    $consulta=$db->prepare($sql);
    $consulta->execute();
    while($fila=$consulta->fetch()){
        $inicial="";
        $inicial = $fila['nombre'];
        
        $vector[]=array(
            "id_proyecto"   =>$fila['id_proyecto'],
            "nombre"        =>$fila['nombre'],
            "inicial"       =>$inicial[0]);           
    }
    return $vector;
    }
    

}