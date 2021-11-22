<?php
require_once('../includes/encabezado.php');
require_once('../CapaNegocio/ClsPlantillaElemento.php');
$method=$_SERVER['REQUEST_METHOD'];

if ($method=="POST"){  
    $datos = json_decode(file_get_contents("php://input"));  
    $plantilla = new ClsPlantillaElemento();
    if(empty($datos->faseId) &&  empty($datos->elementoId) ){
        http_response_code(503);
        $msg->mensaje = "Error al registrar plantilla";
        $msg->error = true;
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    }else{
        $plantilla->faseId = $datos->faseId;
        $plantilla->elementoId = $datos->elementoId; 
        $existe=$plantilla->Existe($plantilla);
        if($existe>0){
            http_response_code(200);
            $msg->mensaje = "Existe";
            $msg->error = false;
            echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        }else{
            $resul=$plantilla->Agregar($plantilla);
            if($resul->nroregistros>0){
                http_response_code(200);
                $msg->mensaje = "Registrado";
                $msg->error = false;
                echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
            }else{
                http_response_code(500);
                $msg->mensaje = "Error al registrar plantilla";
                $msg->error = true;
                echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
            }
        }
        
    }
}
if($method=="GET"){
    if(!empty($_GET['faseId'])){
     
            $faseId=$_GET['faseId'];
            $api=new ClsPlantillaElemento();
            $obj=$api->ListaElementosFase($faseId);
            $json=json_encode($obj);
            echo $json;
        
    }
 else   if(!empty($_GET['id_plantilla'])){
     
        $id_plantilla=$_GET['id_plantilla'];
        $api=new ClsPlantillaElemento();
        $obj=$api->Eliminar($id_plantilla);
        $json=json_encode($obj);
        echo $json;
    
    }
    else{
        $vector=array();
        $api=new ClsPlantillaElemento();
        $vector=$api->Lista();
        $json=json_encode($vector);
        echo $json;
    }
  
} 
if($method=="DELETE"){
    $datos = json_decode(file_get_contents("php://input"));
    //echo json_encode($datos);
    $plantilla = new ClsPlantillaElemento();
    if( empty($datos->id_plantilla) ){
        http_response_code(503);
        $msg->mensaje = "Error al Eliminar Empresa";
        $msg->error = true;
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    }else{
        $resul=$plantilla->Eliminar($datos->id_plantilla);
        if($resul->nroregistros>0){
            http_response_code(200);
            $msg->mensaje = "Empresa Eliminado";
            $msg->error = false;
            echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        }else{
            http_response_code(500);
            $msg->mensaje = "Error al Eliminar Empresa";
            $msg->error = true;
            echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        }
    }
    
  
} 

?>
