<?php

class ClsCronograma{

  
    public function setCronograma($id_proyecto,$fechaincio,$fechatermino){      
        $conexion=new Conexion();
        $db=$conexion->getConexion();
        $sql="INSERT INTO cronograma (fecha_inicio,fecha_termino,id_proyecto)  VALUES (:fechaincio,:fechatermino,:id_proyecto)";       
        $consulta=$db->prepare($sql);
        $consulta->bindParam(':fechaincio',$fechaincio);
        $consulta->bindParam(':fechatermino',$fechatermino);   
        $consulta->bindParam(':id_proyecto',$id_proyecto);  
        $consulta->execute();
        $id_deveulve = $db->lastInsertId();
        return   $id_deveulve;      
			
    }
   
    


}