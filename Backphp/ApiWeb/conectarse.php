<?php   

class Conexion{

    public function getConexion(){
        $hostname="localhost";
        $database="edsyscom_bdmoviles";
        $username="edsyscom";
        $password="HxhCyVR9k7;5(5";
   

    //  $hostname="localhost";
    //  $database="sistemagc";
    //  $username="root";
     // $password="";
        $db=new PDO("mysql:host=$hostname;dbname=$database;charset=utf8",$username,$password);
        return $db;
    }
    public function getProyectos(){
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
                "index"=>$contador
                );  
                $contador++;              
        }
        return $vector;
    } 
}


$api =new Conexion();
$obj=$api->getProyectos();
$json=json_encode($obj);
echo $json;
?>