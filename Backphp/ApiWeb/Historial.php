<?php
require_once('../includes/cors.php');
require_once('../CapaNegocio/ClsHistorial.php');

$method=$_SERVER['REQUEST_METHOD'];

if($method=="GET"){
    if(!empty($_GET['id_timeline'])){
        $id=$_GET['id_timeline'];
        $api=new ClsHistorial();
        $obj=$api->BuscarHistorial($id);
        $json=json_encode($obj);
        echo $json;
    }  
    else{      
        echo "sin Datos";
    }
}

if ($method=="PUT"){
    $json=null;
    $data=json_decode(file_get_contents("php://input"),true);  
    $id_tarea=$data['id_tarea'];    
    $estado=$data['estado'];   
    $estado1=$data['estado1'];
    $estado2=$data['estado2'];  
    $respuesta=$data['respuesta']; 
    $api=new ClsHistorial();
    $json=$api->Editar($id_tarea,$estado,$estado1,$estado2,$respuesta);
    echo $json;
}   

   
?>
