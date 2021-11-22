<?php

require_once('../CapaDatos/conectar.php');
class ClsCronogramaFase{

   public function setCronogramaFase($cronogramaId,$nombre,$id_fase,$porcentajeFase,$porcentaje_avance){      
        $conexion=new Conexion();
        $db=$conexion->getConexion();
        $sql="INSERT INTO cronogramafase (coronogramaId,nombre,id_fase,porcentaje,porcentaje_avance)  VALUES (:cronogramaId,:nombre,:id_fase,:porcentajeFase,:porcentaje_avance)";       
        $consulta=$db->prepare($sql);
        $consulta->bindParam(':cronogramaId',$cronogramaId);
        $consulta->bindParam(':nombre',$nombre);      
        $consulta->bindParam(':id_fase',$id_fase);      
        $consulta->bindParam(':porcentajeFase',$porcentajeFase);   
        $consulta->bindParam(':porcentaje_avance',$porcentaje_avance);
        $consulta->execute();
        $id_deveulve = $db->lastInsertId();
        return   $id_deveulve;
      
    }
    public function EditarPorcentaje($id_cronograma_fase, $porcentaje){
      
        $conexion=new Conexion();
        $db=$conexion->getConexion();     
        $sql = "UPDATE cronogramafase SET porcentaje_avance=:porcentaje_avance WHERE id_cronograma_fase=:id_cronograma_fase";
        $consulta=$db->prepare($sql); 
        $consulta->bindParam(':id_cronograma_fase',$id_cronograma_fase);      
        $consulta->bindParam(':porcentaje_avance', $porcentaje);           
        $consulta->execute();      
        return '{"msg":"Editado "}';
     }
}