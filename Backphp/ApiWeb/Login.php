<?php


//require_once('Login.php');
require_once('../CapaNegocio/ClsLogin.php');
require_once('../includes/cors.php');
$method=$_SERVER['REQUEST_METHOD'];

if($method=="GET"){
    if(!empty($_GET['correo'])){
        $correo_usuario=$_GET['correo'];
        $password=$_GET['password'];
        $api=new ClsLogin();
        $obj=$api->Loguear($correo_usuario,$password);
        $json=json_encode($obj);
        echo $json;
    }

}

