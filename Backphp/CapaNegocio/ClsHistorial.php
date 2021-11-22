<?php
//require_once('../CapaDatos/ClsLibre.php');
require_once('../CapaDatos/conectar.php');
class ClsHistorial{

   // public $id;
   // public $usuario_miembroid; 
	//public $rolId; 
   // public $proyectoId;  
   
 
    public function Agregar($id_timeline,$miembroresponsableID,$id_tarea,$fecha,$porcentajeavance,$urlevidencia,$descripcion){      
        $conexion=new Conexion();
        $db=$conexion->getConexion();
        $sql="INSERT INTO  historial_tarea_ecs ( id_timeline,miembroresponsableID,id_tarea,fecha,porcentajeavance,urlevidencia,descripcion)
         VALUES (:id_timeline,:miembroresponsableID,:id_tarea,:fecha,:porcentajeavance,:urlevidencia,:descripcion)";
        $consulta=$db->prepare($sql);      
        $consulta->bindParam(':id_timeline',$id_timeline);    
        $consulta->bindParam(':miembroresponsableID',$miembroresponsableID); 
        $consulta->bindParam(':id_tarea',$id_tarea); 
        $consulta->bindParam(':fecha',$fecha); 
        $consulta->bindParam(':porcentajeavance',$porcentajeavance); 
        $consulta->bindParam(':urlevidencia',$urlevidencia); 
        $consulta->bindParam(':descripcion',$descripcion); 
        $consulta->execute();      
        return '{"msg":"Agreado "}';
    }
   
    public function BuscarHistorial($id_timeline){
        $vector=array();
        $conexion=new Conexion();
        $db=$conexion->getConexion();
        $sql="SELECT * FROM historial_tarea_ecs AS his
        WHERE his.id_timeline=".$id_timeline ;
        $consulta=$db->prepare($sql);
        $consulta->execute();
        while($fila=$consulta->fetch()){
            $vector[]=array(   
                "fecha"=>$fila['fecha'],       
                "porcentajeavance"=>$fila['porcentajeavance'],               
                "urlevidencia"=>$fila['urlevidencia'],
                "descripcion"=>$fila['descripcion']);           
        }
        return $vector;
    }
  
    public function Editar($id_tarea, $estado,$estado1,$estado2,$respuesta){
      
        if($estado2=="Aprobado"){
            $conexion=new Conexion();
            $db=$conexion->getConexion();     
            $sql = "UPDATE tarea_ecs SET estado=:estado , estado1=:estado1 , estado2=:estado2 , respuesta=:respuesta   WHERE id_tarea=:id_tarea";
            $consulta=$db->prepare($sql);      
            $consulta->bindParam(':id_tarea',$id_tarea);   
            $consulta->bindParam(':estado',$estado); 
            $consulta->bindParam(':estado1',$estado1);   
            $consulta->bindParam(':estado2',$estado2);  
            $consulta->bindParam(':respuesta',$respuesta);                
            $consulta->execute(); 
        }  
        else if($estado2=="Observado"){
            $conexion=new Conexion();
            $db=$conexion->getConexion();     
            $sql = "UPDATE tarea_ecs SET estado=:estado , estado2=:estado2, respuesta=:respuesta     WHERE id_tarea=:id_tarea";
            $consulta=$db->prepare($sql);      
            $consulta->bindParam(':id_tarea',$id_tarea);   
            $consulta->bindParam(':estado',$estado);            
            $consulta->bindParam(':estado2',$estado2);    
            $consulta->bindParam(':respuesta',$respuesta);         
            $consulta->execute(); 
        }
       

        return '{"msg":"editado "}';
    }
    

}