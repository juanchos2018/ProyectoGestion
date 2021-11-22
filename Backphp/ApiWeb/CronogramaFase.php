<?php
require_once('../includes/cors.php');
require_once('../CapaNegocio/ClsCronogramaFase.php');

$method=$_SERVER['REQUEST_METHOD'];

if ($method=="PUT"){
    $json=null;
    $data=json_decode(file_get_contents("php://input"),true);  
    $id_cronograma_fase=$data['id_cronograma_fase'];    
    $porcentaje=$data['porcentaje'];     
    $api=new ClsCronogramaFase();
    $json=$api->EditarPorcentaje($id_cronograma_fase,$porcentaje);
    echo $json;
}   
   
?>
