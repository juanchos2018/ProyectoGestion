<?php
require_once('../includes/cors.php');
require_once('../CapaNegocio/ClsConsulta.php');

$method=$_SERVER['REQUEST_METHOD'];

if($method=="GET"){
    if(!empty($_GET['tipo'])){
        $tipo=$_GET['tipo'];

        if ($tipo=="grafico1") {
            $api=new ClsConsulta();
        
            $obj=$api->Grafico1();
            $json=json_encode($obj);
            echo $json;
        }
            
    }
   
}

   
?>
