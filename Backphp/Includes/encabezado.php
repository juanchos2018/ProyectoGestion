<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header("Allow: GET,POST,OPTIONS,PUT,DELETE");
    header('content-type: application/json; charset=utf-8');
    $msg = new stdClass();
?>