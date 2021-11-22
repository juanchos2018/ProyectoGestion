<?php
require_once('../includes/encabezado.php');
require_once('../CapaNegocio/ClsSolicitudCambio.php');
$method=$_SERVER['REQUEST_METHOD'];

if ($method=="POST"){  
    $datos = json_decode(file_get_contents("php://input"));  
    $solicitud = new ClsSolicitudCambio();
    if( empty($datos->id_proyecto) &&  empty($datos->miembrojefeId) ){
        http_response_code(503);
        $msg->mensaje = "falta datos ";
        $msg->error = true;
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    }else{
        $solicitud->codigo = $datos->codigo;
        $solicitud->id_proyecto = $datos->id_proyecto; 
        $solicitud->miembrojefeId = $datos->miembrojefeId;
        $solicitud->miembrosolicitanteId = $datos->miembrosolicitanteId; 
        $solicitud->fecha = $datos->fecha;
        $solicitud->objetivo = $datos->objetivo; 
        $solicitud->descripcion = $datos->descripcion;
        $solicitud->respuesta = $datos->respuesta; 
        $solicitud->estado = $datos->estado; 
        $solicitud->documento = $datos->documento; 
        $solicitud->elemento = $datos->elemento; 
        $resul=$solicitud->Agregar($solicitud);
        if($resul->nroregistros>0){
            http_response_code(200);
            $msg->mensaje = "Registrado";
            $msg->error = false;
            echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        }else{
            http_response_code(500);
            $msg->mensaje = "Error al registrar ";
            $msg->objeto = $solicitud;
            $msg->error = true;
            echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
        }
    }
}
if($method=="GET"){
    if(!empty($_GET['cantidad'])){
        $cantidad=$_GET['cantidad'];
        $api=new ClsSolicitudCambio();
        $obj=$api->NumeroSolicitud($cantidad);
        $json=json_encode($obj);
        echo $json;
    }
    else{
        $solicutd = new ClsSolicitudCambio();           
        $resul=$solicutd->Listar();
        if(count($resul)>0){
                http_response_code(200);
                $msg->mensaje = "Lista";
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
