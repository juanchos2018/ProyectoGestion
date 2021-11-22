<?php
require_once('../includes/encabezado.php');
require_once('../CapaNegocio/ClsTarea.php');
$method=$_SERVER['REQUEST_METHOD'];

if ($method=="POST"){  
    $datos = json_decode(file_get_contents("php://input"));  
    $tarea = new ClsTarea();
    if( empty($datos->verionID) &&  empty($datos->miembroresponsableID) ){
        http_response_code(503);
        $msg->mensaje = "Error al registrar Elemento";
        $msg->error = true;
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    }else{

        $tarea->verionID = $datos->verionID;
        $tarea->miembroresponsableID = $datos->miembroresponsableID; 
        $tarea->fecha_inicio = $datos->fecha_inicio; 
        $tarea->fecha_termino = $datos->fecha_termino; 
        $tarea->descripcion = $datos->descripcion; 
        $tarea->porcentajeavance = $datos->porcentajeavance;
        $tarea->urlevidencia = $datos->urlevidencia; 
        $tarea->estado = $datos->estado;  
        $tarea->estado1 = $datos->estado1;  
        $resul=$tarea->Agregar($tarea);
        if($resul->nroregistros>0){
            http_response_code(200);
            $msg->mensaje = "tarea Registrada";
            $msg->error = false;
            echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        }else{
            http_response_code(500);
            $msg->mensaje = "Error al registrar tarea";
            $msg->error = true;
            $msg->data = $tarea;
            echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        }
    }
}

if($method=="GET"){
    if(!empty($_GET['id_tarea'])){
        $id=$_GET['id_tarea'];
        $api=new ClsTarea();
        $obj=$api->ListaTareaVersion($id);
        $json=json_encode($obj);
        echo $json;
    }
   else if(!empty($_GET['id_tarea1'])){
        $id=$_GET['id_tarea1'];
        $api=new ClsTarea();
        $obj=$api->BuscarTarea1($id);
        $json=json_encode($obj);
        echo $json;
    }
  else  if(!empty($_GET['id'])){
        $id=$_GET['id'];
        $api=new ClsTarea();
        $obj=$api->VerMensaje($id);
        $json=json_encode($obj);
        echo $json;
    }else{
        
    }

}
if($method=="PUT"){
    $data = json_decode(file_get_contents("php://input")); 
    $tarea = new ClsTarea();
    if(empty($data->id_tarea)){
        http_response_code(503);
        $msg->mensaje = "Error al Editar tarea ";
        $msg->error = true;   
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    }else{
        $tarea->id_tarea = $data->id_tarea;
        $tarea->urlevidencia = $data->urlevidencia;
        $tarea->porcentajeavance = $data->porcentajeavance;     
        $tarea->estado = $data->estado;    
        $tarea->estado1 = $data->estado1;        
        $resul=$tarea->Editar($tarea);
        if($resul->nroregistros>0){
            http_response_code(200);
            $msg->mensaje = "tarea Editado";
            $msg->error = false;
            echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        }else{
            http_response_code(500);
            $msg->mensaje = "Error al Editar tarea";
            $msg->error = true;
            echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        }
    }
}

?>
