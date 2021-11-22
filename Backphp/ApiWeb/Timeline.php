<?php
//require_once('../includes/encabezado.php');
require_once('../includes/cors.php');
require_once('../CapaNegocio/ClsTimeline.php');
$method=$_SERVER['REQUEST_METHOD'];

if ($method=="POST"){  
    $json=null;
    $data=json_decode(file_get_contents("php://input"),true);  
    $miembroresponsableID=$data['miembroresponsableID'];      
    $fecha=$data['fecha'];
    $hora=$data['hora'];
    $estado=$data['estado'];
    $id_tarea=$data['id_tarea'];

    $porcentajeavance=$data['porcentajeavance'];  
    $urlevidencia=$data['urlevidencia'];  
    $descripcion_avance=$data['descripcion_avance'];   
    $api=new ClsTimeline();
    $obj=$api->Agregar($miembroresponsableID,$fecha,$hora,$estado,$id_tarea,$porcentajeavance,$urlevidencia,$descripcion_avance);
    $json=json_encode($obj);      
    echo $json;   
    
}
if($method=="GET"){
    if(!empty($_GET['id_tarea'])){
        $id_tarea=$_GET['id_tarea'];      
        $vector=array();
        $api=new ClsTimeline();
        $vector=$api->Listar($id_tarea);
        $json=json_encode($vector);
        echo $json;
     
    
    }

}

?>
