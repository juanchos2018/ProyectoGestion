<?php
require_once('../includes/cors.php');
require_once('../CapaNegocio/ClsCronogramaElemento.php');

$method=$_SERVER['REQUEST_METHOD'];

if ($method=="POST"){  
    $json=null;
    $data=json_decode(file_get_contents("php://input"),true);     
    $listacronogramaelemento=$data['listacronogramaelemento']; 
    $api=new ClsCronogramaElemento();
    $obj=$api->RecibirLista($listacronogramaelemento);
    $json=json_encode($obj);      
    echo $json;
}


   
?>
