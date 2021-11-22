<?php
require_once('../includes/encabezado.php');
require_once('../CapaNegocio/ClsFase.php');
$method=$_SERVER['REQUEST_METHOD'];

if ($method=="POST"){  
    $datos = json_decode(file_get_contents("php://input"));  
    $fase = new ClsFase();
    if(empty($datos->nombre_fase) &&  empty($datos->metodologiaId) ){
        http_response_code(503);
        $msg->mensaje = "Error al registrar fase";
        $msg->error = true;
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    }else{
        $fase->nombre_fase = $datos->nombre_fase;
        $fase->metodologiaId = $datos->metodologiaId; 

        $existe=$fase->Existe($fase);
        if($existe>0){
                http_response_code(200);
                $msg->mensaje = "Existe";
                $msg->error = false;
                echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        }else{
            $resul=$fase->Agregar($fase);
            if($resul->nroregistros>0){
                http_response_code(200);
                $msg->mensaje = "Registrado";
                $msg->error = false;
                echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
            }else{
                http_response_code(500);
                $msg->mensaje = "Error al registrar fase";
                $msg->error = true;
                echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
            }   
        }

       
    }
}
if($method=="GET"){
    if(!empty($_GET['metodologiaId'])){
        if(!empty($_GET['metodologiaId'])){
            $metodologiaId=$_GET['metodologiaId'];
            $api=new ClsFase();
            $obj=$api->Listar($metodologiaId);
            $json=json_encode($obj);
            echo $json;
        }
    }
  
} 

if($method=="PUT"){  
    $data = json_decode(file_get_contents("php://input")); 
    $fase = new ClsFase();
    if(empty($data->id_fase)){
        http_response_code(503);
        $msg->mensaje = "Error al Editar fase ";
        $msg->error = true;   
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    }else{
        $fase->id_fase = $data->id_fase;
        $fase->nombre_fase = $data->nombre_fase;             
        $resul=$fase->Editar($fase);
        if($resul->nroregistros>0){
            http_response_code(200);
            $msg->mensaje = "fase Editado";
            $msg->error = false;
            echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        }else{
            http_response_code(500);
            $msg->mensaje = "Error al Editar fase";
            $msg->error = true;
            echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        }
    }
}   
?>
