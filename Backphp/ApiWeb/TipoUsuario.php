<?php
require_once('../includes/encabezado.php');
require_once('../CapaNegocio/ClsTipoUsuario.php');
$method=$_SERVER['REQUEST_METHOD'];


if($method=="GET"){
    if(!empty($_GET['id'])){
      //  $id=$_GET['id'];
     //   $api=new ClsElemento();
    // //   $obj=$api->getElemento();
     //   $json=json_encode($obj);
     //   echo $json;
    }
    else{
        $consulta = new ClsTipoUsuario();           
        $resul=$consulta->Lista();
        if(count($resul)>0){
                http_response_code(200);
                $msg->mensaje = "Listar consulta";
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
