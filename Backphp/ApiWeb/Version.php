<?php
require_once('../includes/encabezado.php');
require_once('../CapaNegocio/ClsVersion.php');
$method=$_SERVER['REQUEST_METHOD'];

if ($method=="POST"){  
    $datos = json_decode(file_get_contents("php://input"));  
    $version = new ClsVersion();
    if( empty($datos->elemntoconfiguracionID) &&  empty($datos->version) ){
        http_response_code(503);
        $msg->mensaje = "Error al registrar Elemento";
        $msg->error = true;
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    }else{
        $version->elemntoconfiguracionID = $datos->elemntoconfiguracionID;
        $version->version = $datos->version; 
        $version->fecha_inicio = $datos->fecha_inicio; 
        $version->fecha_termino = $datos->fecha_termino; 
        $version->miembroresponsableID = $datos->miembroresponsableID; 
        $resul=$version->Agregar($version);
        if($resul->nroregistros>0){
            http_response_code(200);
            $msg->mensaje = "version Registrada";
            $msg->error = false;
            echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        }else{
            http_response_code(500);
            $msg->mensaje = "Error al registrar version";
            $msg->error = true;
            echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        }
    }
}

if($method=="GET"){
    if(!empty($_GET['id_elemento'])){
        $id=$_GET['id_elemento'];
        $api=new ClsVersion();
        $obj=$api->Listar($id);
        $json=json_encode($obj);
        echo $json;
    }
}


   
?>
