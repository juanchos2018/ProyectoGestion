<?php
require_once('../includes/encabezado.php');
require_once('../CapaNegocio/ClsMetodologia.php');
$method=$_SERVER['REQUEST_METHOD'];

if ($method=="POST"){  
    $datos = json_decode(file_get_contents("php://input"));  
    $metodologia = new ClsMetodologia();
    if(empty($datos->nombre) ){
        http_response_code(503);
        $msg->mensaje = "Error al registrar metodologia";
        $msg->error = true;
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    }else{    
        $metodologia->nombre = $datos->nombre; 
        $resul=$metodologia->Agregar($metodologia);
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
if($method=="GET"){
    if(!empty($_GET['id'])){
      //  $id=$_GET['id'];
     //   $api=new ClsElemento();
    // //   $obj=$api->getElemento();
     //   $json=json_encode($obj);
     //   echo $json;
    }
    else if (!empty($_GET['id_meto'])){
        $id=$_GET['id_meto'];
        $api=new ClsMetodologia();
        $obj=$api->ListaFaseMetodologia($id);
        $json=json_encode($obj);
        echo $json;
    }
    else{
        $metodologia = new ClsMetodologia();           
        $resul=$metodologia->Listar();
        if(count($resul)>0){
                http_response_code(200);
                $msg->mensaje = "Listar Metodologia";
                $msg->cantidad = count($resul);
                $msg->error = false;
                $msg->data = $resul; 
                echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
            }else{
                http_response_code(200);
                $msg->mensaje = "Lista VAcia";
                $msg->cantidad = count($resul);
                $msg->error = true;                
                $msg->data = $resul; 
                echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
            }
    
    }
}
if($method=="PUT"){  
    $data = json_decode(file_get_contents("php://input")); 
    $metodologia = new ClsMetodologia();
    if(empty($data->id_metodologia)){
        http_response_code(503);
        $msg->mensaje = "Error al Editar elemento ";
        $msg->error = true;   
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    }else{
        $metodologia->id_metodologia = $data->id_metodologia;      
        $metodologia->nombre = $data->nombre;          
        $resul=$metodologia->Editar($metodologia);
        if($resul->nroregistros>0){
            http_response_code(200);
            $msg->mensaje = "metodologia Editado";
            $msg->error = false;
            echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        }else{
            http_response_code(500);
            $msg->mensaje = "Error al Editar metodologia";
            $msg->error = true;
            echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        }
    }
}   
?>
