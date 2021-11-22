<?php
require_once('../includes/encabezado.php');
require_once('../CapaNegocio/ClsRol.php');
$method=$_SERVER['REQUEST_METHOD'];

if ($method=="POST"){  
    $datos = json_decode(file_get_contents("php://input"));  
    $rol = new ClsRol();
    if( empty($datos->nombre) ){
        http_response_code(503);
        $msg->mensaje = "Error al registrar rol";
        $msg->error = true;
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    }else{
        $rol->nombre = $datos->nombre;     
        $resul=$rol->Agregar($rol);
        if($resul->nroregistros>0){
            http_response_code(200);
            $msg->mensaje = "rol Registrada";
            $msg->error = false;
            echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        }else{
            http_response_code(500);
            $msg->mensaje = "Error al registrar rol";
            $msg->error = true;
            echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        }
    }
}
if($method=="GET"){
    if(!empty($_GET['id'])){
      //  $id=$_GET['id'];
     //   $api=new ClsElemento();
    // //   $obj=$api->getElemento();
     //   $json=json_encode($obj);
     //   echo $json;
    }
    else{
        $rol = new ClsRol();           
        $resul=$rol->Listar();
        if(count($resul)>0){
                http_response_code(200);
                $msg->mensaje = "Listar rol";
                $msg->cantidad = count($resul);
                $msg->error = false;
                $msg->data = $resul; 
                echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
            }else{
                http_response_code(200);
                $msg->mensaje = "No se encontraron Resultados";
                $msg->cantidad = count($resul);
                $msg->error = true;                
                $msg->data = $resul; 
                echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
            }
    
    }
}
  
?>
