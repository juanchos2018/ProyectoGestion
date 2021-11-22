<?php
require_once('conectar.php');
//require_once('../CapaDatos/conectar.php');
class clase
{
      
    function nombre($data)
    {       
   
        return  "nombre : ".$data;
    } 
    public function Listar(){
        $vector=array();
        $options =array();  
        $series=[];
        $contador=0;
        $datos= array("Nuevo", "Proceso", "Terminado");  
        $conexion=new Conexion();
        $db=$conexion->getConexion();
        $sql="SELECT p.id_proyecto,p.codigo_proyecto,p.nombre_proyecto,p.fecha_inicio,p.fecha_termino,p.descripcion,p.estado ,
        m.nombre FROM proyecto AS p
        INNER JOIN metodologia AS m
        ON p.metodologiaId=m.id_metodologia";
        $consulta=$db->prepare($sql);
        $consulta->execute();
        while($fila=$consulta->fetch()){
              $vector[]=array(
                "id_proyecto"=>$fila['id_proyecto'],
                "codigo_proyecto"=>$fila['codigo_proyecto'],
                "nombre_proyecto"=>$fila['nombre_proyecto'],
                "fecha_inicio"=>$fila['fecha_inicio'],
                "fecha_termino"=>$fila['fecha_termino'],
                "descripcion"=>$fila['descripcion'],
                "estado"=>$fila['estado'],
                "nombre_metodologia"=>$fila['nombre'],
                "labels"=>$options, 
                "series"=>$series,
                "index"=>$contador,
                );  
                $contador++;              
        }
        return $vector;
    } 
}

