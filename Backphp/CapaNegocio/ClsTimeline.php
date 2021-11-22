<?php
//require_once('../CapaDatos/ClsLibre.php');
require_once('../CapaDatos/conectar.php');
require_once('ClsHistorial.php');
class ClsTimeline
{    
 
    public function Agregar($miembroresponsableID,$fecha,$hora,$estado,$id_tarea,$porcentajeavance,$urlevidencia,$descripcion_avance){
      
        $conexion=new Conexion();   
        $historial=new ClsHistorial();
        $db=$conexion->getConexion();
        $sql="INSERT  INTO timeline (miembroresponsableID,fecha,hora,estado,id_tarea)  VALUES (:miembroresponsableID,:fecha,:hora,:estado,:id_tarea)";
      
        $consulta=$db->prepare($sql);
        $consulta->bindParam(':miembroresponsableID',$miembroresponsableID);
        $consulta->bindParam(':fecha',$fecha);
        $consulta->bindParam(':hora',$hora);
        $consulta->bindParam(':estado',$estado);
        $consulta->bindParam(':id_tarea',$id_tarea);
        $consulta->execute();      
        $idtemiline = $db->lastInsertId();
        $historial->Agregar($idtemiline,$miembroresponsableID, $id_tarea,$fecha,$porcentajeavance,$urlevidencia,$descripcion_avance);   
        return '{"msg":"Agreado"}';       
      			
    }

    public function Listar($id_tarea){
        $vector=array();
        $conexion=new Conexion();
        $db=$conexion->getConexion();
        $sql =" SELECT   timel.id_timeline ,timel.id_tarea, timel.fecha ,timel.hora,usu.nombre,tarea.descripcion FROM timeline AS timel
        INNER JOIN miembroproyecto AS miem
        ON timel.miembroresponsableID = miem.id
        INNER JOIN usuario AS usu 
        ON miem.usuario_miembroid =usu.id_usuario
        INNER JOIN tarea_ecs AS tarea
        ON tarea.id_tarea = timel.id_tarea
        WHERE timel.id_tarea=".$id_tarea." ORDER BY  timel.id_timeline DESC";
        $consulta=$db->prepare($sql);
        $consulta->execute();        
         while($fila=$consulta->fetch()){
            $vector[]=array(
              "id_timeline"     =>$fila['id_timeline'],
              "id_tarea"        =>$fila['id_tarea'],
              "fecha"           =>$fila['fecha'],
              "hora"            =>$fila['hora'],
              "nombre"          =>$fila['nombre'],
              "descripcion"     =>$fila['descripcion']);           
        }
        return $vector;
    } 
     
   

}

