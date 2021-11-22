<?php

$destino="jcarlossenati@gmail.com";
$nombre=$_POST["nombre"];
$correo=$_POST["correo"];
$telefeno=$_POST["telefono"];
$mensaje=$_POST["mensaje"];
$contenido="Nombre ". $nombre ."\nCorreo:  ". $correo ."\ntelefono " . $telefono . "\nMensaje :" . $mensaje;

mail($destino,"contacto",$contenido);
header("Location.gracias.html");
