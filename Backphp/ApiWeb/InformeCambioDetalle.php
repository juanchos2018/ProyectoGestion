<?php
require_once('../includes/cors.php');
require_once('../CapaNegocio/ClsInformeCambioDetalle.php');

$method=$_SERVER['REQUEST_METHOD'];



if ($method=="POST"){  
    $json=null;
    $data=json_decode(file_get_contents("php://input"),true);  
    $id_informecambio=$data['id_informecambio'];    
    $cronogramaelemetoId=$data['cronogramaelemetoId']; 
    $descripcion=$data['descripcion'];
    $fechainicio=$data['fechainicio'];
    $fechatermino=$data['fechatermino'];
    $porcentajeavance=$data['porcentajeavance'];
   

    $api=new ClsInformeCambioDetalle();
    $obj=$api->Agregar($id_informecambio,$cronogramaelemetoId,$descripcion,$fechainicio,$fechatermino,$porcentajeavance);
     $json=json_encode($obj);      
    echo $json;
}



   
?>
