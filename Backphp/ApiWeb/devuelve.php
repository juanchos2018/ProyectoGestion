<?php
require_once('clase.php');
$method=$_SERVER['REQUEST_METHOD'];


if($method=="GET"){
    if(!empty($_GET['id'])){
     
        $id=$_GET['id'];
        $api = new clase();
        $obj=$api->nombre($id);
        $json=json_encode($obj);
        echo $json;
        }
    else{
        echo "ESte metodo es Get Sin parametros ";
        $api = new clase();
        $obj=$api->Listar();
        $json=json_encode($obj);
        echo $json;
    
    }
}
  
?>
