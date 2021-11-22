<?php
require_once('../includes/encabezado.php');
require_once('../CapaNegocio/ClsUsuario.php');
$method=$_SERVER['REQUEST_METHOD'];

if ($method=="POST"){  
    $datos = json_decode(file_get_contents("php://input"));  
    $usuario = new ClsUsuario();
    if( empty($datos->nombre) &&  empty($datos->apellido) ){
        http_response_code(503);
        $msg->mensaje = "Error al registrar usuario";
        $msg->error = true;
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    }else{
        $usuario->nombre         = $datos->nombre;
        $usuario->apellido       = $datos->apellido; 
        $usuario->correo         = $datos->correo; 
        $usuario->password       = $datos->password; 
        $usuario->tiposusuarioId = $datos->tiposusuarioId;   

        $cantidad=$usuario->Buscar($usuario->correo);
        if ($cantidad>0){
            http_response_code(200);
            $msg->mensaje = "Existe";
            $msg->error = false;
            echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        } else{
            $resul=$usuario->Agregar($usuario);
            if($resul->nroregistros>0){
                http_response_code(200);
                $msg->mensaje = "Registrado";
                $msg->error = false;
                echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
            }else{
               http_response_code(500);
                $msg->mensaje = "Error al registrar usuario";
                $msg->error = true;
                $msg->can = $resul->nroregistros;
                echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
            }
        }
        
    }
}
if($method=="GET"){
    if(!empty($_GET['proyectoId'] )){
      
       $proyectoId=$_GET['proyectoId'];
       $usuario_miembroid=$_GET['usuario_miembroid'];
       $api=new ClsUsuario();
       $obj=$api->ObtenerIdMiembro($usuario_miembroid,$proyectoId);
       $json=json_encode($obj);
       echo $json;
    }
  else  if(!empty($_GET['usuario_miembroid'])){
        $id=$_GET['usuario_miembroid'];
        $api=new ClsUsuario();
        $obj=$api->get_proyectosusuario($id);
        $json=json_encode($obj);
        echo $json;
    }
    else  if(!empty($_GET['correo'])){
        $correo=$_GET['correo'];
        $api=new ClsUsuario();
        $obj=$api->buscar($correo);
        $json=json_encode($obj);
        echo $json;
    }
  else{
        $usuario = new ClsUsuario();           
        $resul=$usuario->Listar();
        if(count($resul)>0){
                http_response_code(200);
                $msg->mensaje = "Listar usuario";
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
