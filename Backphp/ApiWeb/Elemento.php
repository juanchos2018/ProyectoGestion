<?php
require_once('../includes/encabezado.php');
require_once('../CapaNegocio/ClsElemento.php');
$method=$_SERVER['REQUEST_METHOD'];

if ($method=="POST"){  
    $datos = json_decode(file_get_contents("php://input"));  
    $elemento = new ClsElemento();
    if( empty($datos->codigo_elemento) &&  empty($datos->nombre) ){
        http_response_code(503);
        $msg->mensaje = "Error al registrar Elemento";
        $msg->error = true;
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    }else{
        $elemento->codigo_elemento = $datos->codigo_elemento;
        $elemento->nombre = $datos->nombre; 
        $existe=$elemento->Existe($elemento);
        if($existe>0){
            http_response_code(200);
            $msg->mensaje = "Existe";
            $msg->error = false;
            echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        }else{
            $resul=$elemento->Agregar($elemento);
            if($resul->nroregistros>0){
                http_response_code(200);
                $msg->mensaje = "elemento Registrada";
                $msg->error = false;
                echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
            }else{
                http_response_code(500);
                $msg->mensaje = "Error al registrar Empresa";
                $msg->error = true;
                echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        }
        }
        
    }
}
if($method=="GET"){
    if(!empty($_GET['id_elemento'])){
        $id_elemento=$_GET['id_elemento'];
        $api=new ClsElemento();
        $obj=$api->Eliminar($id_elemento);
        $json=json_encode($obj);
        echo $json;
    }
    else{
        $elemento = new ClsElemento();           
        $resul=$elemento->Listar();
        if(count($resul)>0){
                http_response_code(200);
                $msg->mensaje = "Listar elemento";
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
if($method=="PUT"){  
    $data = json_decode(file_get_contents("php://input")); 
    $elemento = new ClsElemento();
    if(empty($data->id_elemento)){
        http_response_code(503);
        $msg->mensaje = "Error al Editar elemento ";
        $msg->error = true;   
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    }else{
        $elemento->id_elemento = $data->id_elemento;
        $elemento->codigo_elemento = $data->codigo_elemento;
        $elemento->nombre = $data->nombre;          
        $resul=$elemento->Editar($elemento);
        if($resul->nroregistros>0){
            http_response_code(200);
            $msg->mensaje = "Elemento Editado";
            $msg->error = false;
            echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        }else{
            http_response_code(500);
            $msg->mensaje = "Error al Editar Elemento";
            $msg->error = true;
            echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        }
    }
}   
?>
