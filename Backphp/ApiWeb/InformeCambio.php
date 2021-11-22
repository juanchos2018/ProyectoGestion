<?php


$method=$_SERVER['REQUEST_METHOD'];
require_once('../includes/cors.php');

if ($method=="POST"){  


    require_once('../includes/cors.php');
    require_once('../CapaNegocio/ClsInformeCambio.php');

    $json=null;
    $data=json_decode(file_get_contents("php://input"),true);  
    $codigo=$data['codigo'];
    $solicitudcambioId=$data['solicitudcambioId'];
    $descripcion=$data['descripcion'];
    $impactoproblema=$data['impactoproblema'];
    $tiempo=$data['tiempo'];
    $costo=$data['costo'];
    $fecha=$data['fecha'];
    $miembrojefeId=$data['miembrojefeId'];
    $estado=$data['estado'];
    $detalle=$data['ListaDetalle'];
    $api=new ClsInformeCambio();
    $obj=$api->Agregar($codigo,$solicitudcambioId,$descripcion,$tiempo,$costo,$impactoproblema,$fecha,$miembrojefeId,$estado,$detalle);
    $json=json_encode($obj);      
    echo $json;
}


if($method=="GET"){
    if(!empty($_GET['id_informe'])){           
        require_once('../includes/cors.php');
        require_once('../CapaNegocio/ClsInforme2.php');
        $id_informe=$_GET['id_informe'];
        $api = new ClsInforme2();
       //  $api->id_informe=$id_informe;
        $obj=$api->InforrmeCAmbio($id_informe);
        $json=json_encode($obj);
        echo $json;

    }    
    else{


        require_once('../includes/cors.php');
        require_once('../CapaNegocio/ClsInformeCambio.php');
        $vector=array();
        $api=new ClsInformeCambio();
        $vector=$api->Listar();
        $json=json_encode($vector);
        echo $json;
    }
}



if ($method=="PUT"){

    require_once('../includes/cors.php');
    require_once('../CapaNegocio/ClsInformeCambio.php');

    $json=null;
    $data=json_decode(file_get_contents("php://input"),true);  
    $id_informe=$data['id_informe'];    
    $estado=$data['estado'];  
    $api=new ClsInformeCambio();
    $json=$api->EditarInformeCAmbioEStado($id_informe,$estado);
    echo $json;
}   


// if($method==""){
//     if(!empty($_GET['id_informe'])){
     
//         $id_informe=$_GET['id_informe'];
//         $api = new ClsInformeCambio();
   
//         $obj=$api->InforrmeCAmbio($id_informe);
//         $json=json_encode($obj);
//         echo $json;

//         }
//     else{
//         http_response_code(200);
//         $msg->mensaje = "No se encontraron Resultados";
//         $msg->cantidad = count($resul);
//         $msg->error = true;                
       
//         echo json_encode($msg, JSON_UNESCAPED_UNICODE); 
    
//     }
// }
   
?>
