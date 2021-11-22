<?php

require_once('../CapaDatos/conectar.php');
class ClsCronogramaElemento{

   public function setCronogramaElemento($id_elemento,$nombre_elemento,$coronogramaId,$id_cronograma_fase){      
        $conexion=new Conexion();
        $db=$conexion->getConexion();
        $sql="INSERT INTO cronograma_elemento (id_elemento,nombre_elemento,coronogramaId,id_cronograma_fase)  VALUES (:id_elemento,:nombre_elemento,:coronogramaId,:id_cronograma_fase)";       
        $consulta=$db->prepare($sql);
        $consulta->bindParam(':id_elemento',$id_elemento);
        $consulta->bindParam(':nombre_elemento',$nombre_elemento);      
        $consulta->bindParam(':coronogramaId',$coronogramaId);     
        $consulta->bindParam(':id_cronograma_fase',$id_cronograma_fase);    
        $consulta->execute();      
        return '{"msg":"Agreado" }';       
    }
   
    public function RecibirLista($lista){
        foreach($lista as $item){
                 $cronogramaelemento=new ClsCronogramaElemento();        
                $cronogramaelemento->setCronogramaElemento($item['id'],$item['nombre'],$item['id_fase'], $item['id_cronograma_fase']); 
          }  
    }

    public function Get_Elementos($id_proyecto){
      $conexion=new Conexion();
      $db=$conexion->getConexion();
      $sql="SELECT p.id_proyecto , p.nombre_proyecto,cf.nombre, cf.id_cronograma_fase,cf.id_fase,ce.nombre_elemento,ce.id_elemento 
      FROM proyecto AS p 
      INNER  JOIN cronograma AS c
      ON p.id_proyecto= c.id_proyecto
      INNER JOIN cronogramafase AS cf
      ON c.id_cronograma=cf.coronogramaId
      INNER JOIN cronograma_elemento AS ce
      ON ce.coronogramaId = cf.id_fase
      WHERE p.id_proyecto=".$id_proyecto;
       $consulta=$db->prepare($sql);
       $consulta->execute();
       while($fila=$consulta->fetch()){
             $vector[]=array(
               "id_proyecto"=>      $fila['id_proyecto'],
               "id_fase"=>          $fila['id_fase'],
               "nombre_elemento"=>  $fila['nombre_elemento']);           
       }
       return $vector;    
   }
  


}