<?php
//require_once('../CapaDatos/ClsLibre.php');
require_once('../CapaDatos/conectar.php');


class ClsInformeCambioDetalle
{
       
    public function Agregar($id_informecambio,$cronogramaelemetoId,$descripcion,$fechainicio,$fechatermino,$porcentajeavance){
      
        $conexion=new Conexion();        
       
        $db=$conexion->getConexion();
        $sql="INSERT INTO informecambiodetalle (id_informecambio,cronogramaelemetoId,descripcion,fechainicio,fechatermino,porcentajeavance) 
         VALUES (:id_informecambio,:cronogramaelemetoId,:descripcion,:fechainicio,:fechatermino,:porcentajeavance)";
        $avance=0;
        $consulta=$db->prepare($sql);
        $consulta->bindParam(':id_informecambio',$id_informecambio);
        $consulta->bindParam(':cronogramaelemetoId',$cronogramaelemetoId);     
        $consulta->bindParam(':descripcion',$descripcion);
        $consulta->bindParam(':fechainicio',$fechainicio);
        $consulta->bindParam(':fechatermino',$fechatermino);
        $consulta->bindParam(':porcentajeavance',$porcentajeavance);  
        $consulta->execute();     
       
        return "Agregado ";    			
    }

    public function Agregar2($id_informecambio,$cronogramaelemetoId,$descripcion,$fechainicio,$fechatermino,$porcentajeavance,$nombreelemento,$tiempo,$costo){
      
        $conexion=new Conexion();        
       
        $db=$conexion->getConexion();
        $sql="INSERT INTO informecambiodetalle (id_informecambio,cronogramaelemetoId,descripcion,fechainicio,fechatermino,porcentajeavance,nombreelemento,tiempo,costo) 
         VALUES (:id_informecambio,:cronogramaelemetoId,:descripcion,:fechainicio,:fechatermino,:porcentajeavance,:nombreelemento,:tiempo,:costo)";
        $avance=0;
        $consulta=$db->prepare($sql);
        $consulta->bindParam(':id_informecambio',$id_informecambio);
        $consulta->bindParam(':cronogramaelemetoId',$cronogramaelemetoId);     
        $consulta->bindParam(':descripcion',$descripcion);
        $consulta->bindParam(':fechainicio',$fechainicio);
        $consulta->bindParam(':fechatermino',$fechatermino);
        $consulta->bindParam(':porcentajeavance',$porcentajeavance);  


        $consulta->bindParam(':nombreelemento',$nombreelemento);
        $consulta->bindParam(':tiempo',$tiempo);
        $consulta->bindParam(':costo',$costo);  


        $consulta->execute();     
       
        return "Agregado ";    			
    }

}

