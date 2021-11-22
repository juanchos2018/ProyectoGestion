<?php
require_once('../includes/cors.php');
require_once('../CapaNegocio/ClsProyecto.php');

$method=$_SERVER['REQUEST_METHOD'];

if($method=="GET"){
    if(!empty($_GET['id_proyecto'])){
            $id_proyecto=$_GET['id_proyecto'];
            $api=new ClsProyecto();
          //  $obj=$api->getFaseMetodologiaProyecto($id_proyecto);
         //  $obj=$api->ListaFasesProyecto($id_proyecto);
            $obj=$api->ListaFasesProyecto($id_proyecto);
            $json=json_encode($obj);
            echo $json;
    }
    else if(!empty($_GET['id_proyect'])){
            $id_proyecto=$_GET['id_proyect'];
            $api=new ClsProyecto();
            $obj=$api->BuscarProyecto($id_proyecto);
            $json=json_encode($obj);
            echo $json;
     }    
    else if(!empty($_GET['parametro1'])){
            $id_proyecto=$_GET['parametro1'];
            $id_fase=$_GET['id_fase'];
            $api=new ClsProyecto();
            //getFaseMetodologiaProyecto
            $obj=$api->ListaElementosFaseProyecto($id_proyecto,$id_fase);
            $json=json_encode($obj);
            echo $json;
     }
     else if(!empty($_GET['prueba'])){
        $id_proyecto=$_GET['prueba'];     
        $api=new ClsProyecto();      
        $obj=$api->ObtenerPorcentajeProyecto($id_proyecto);
        $json=json_encode($obj);
        echo $json;
    }
    else{
        $vector=array();
        $api=new ClsProyecto();
        $obj=$api->Listar();
        $json=json_encode($obj);
        echo $json;
    }
}

if ($method=="POST"){  
    $json=null;
    $data=json_decode(file_get_contents("php://input"),true);  
    $codigo=$data['codigo'];    
    $nombre=$data['nombre']; 
    $fechaini=$data['fechaini'];
    $fechater=$data['fechater'];
    $descripcion=$data['descripcion'];
    $estado=$data['estado'];
    $metodologia=$data['metodologia'];  
    $usuariojefeId=$data['usuariojefeId'];  

   $ListaFases=$data['lista'];
    $ListaElementos=$data['ListaElementos'];  

    // $ListaFases=array();
    // $ListaElementos=array(); 
    
    $porcentaje=$data['porcentaje'];  
    $api=new ClsProyecto();
    $obj=$api->Agregar($codigo,$nombre,$fechaini,$fechater,$descripcion,$estado,$metodologia,$usuariojefeId,$ListaFases,$ListaElementos,$porcentaje);
     $json=json_encode($obj);      
    echo $json;
}

if ($method=="PUT"){
    $json=null;
    $data=json_decode(file_get_contents("php://input"),true);  
    $id_proyecto=$data['id_proyecto'];    
    $porcentaje=$data['porcentaje'];     
    $api=new ClsProyecto();
    $json=$api->EditarPorcentaje($id_proyecto,$porcentaje);
    echo $json;
}
   
?>
