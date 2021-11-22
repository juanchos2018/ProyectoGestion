<?php
//require_once('../CapaDatos/ClsLibre.php');
require_once('../CapaDatos/conectar.php');
require_once('ClsCronograma.php');
require_once('ClsMiembro.php');
require_once('ClsCronogramaFase.php');
require_once('ClsCronogramaElemento.php');
require_once('ClsLabel.php');
class ClsProyecto
{
 
    public function Listar(){
        $vector=array();
        $options =array();  
        $series=[];
        $contador=0;
        $listaMiembro=array();
      //  $datos= array("Nuevo", "Proceso", "Terminado");
        $datos= array();
        $charOptions= new Foo();
        $charOptions->labels=$datos; 
        $conexion=new Conexion();
        $db=$conexion->getConexion();
        $sql="SELECT p.id_proyecto,p.codigo_proyecto,p.nombre_proyecto,p.fecha_inicio,p.fecha_termino,p.descripcion,p.estado ,
        m.nombre,p.porcentaje   FROM proyecto AS p
        INNER JOIN metodologia AS m
        ON p.metodologiaId=m.id_metodologia";
        $consulta=$db->prepare($sql);
        $consulta->execute();
        while($fila=$consulta->fetch()){
              $vector[]=array(
                "id_proyecto"       =>$fila['id_proyecto'],
                "codigo_proyecto"   =>$fila['codigo_proyecto'],
                "nombre_proyecto"   =>$fila['nombre_proyecto'],
                "fecha_inicio"      =>$fila['fecha_inicio'],
                "fecha_termino"     =>$fila['fecha_termino'],
                "descripcion"       =>$fila['descripcion'],
                "estado"            =>$fila['estado'],
                "nombre_metodologia"=>$fila['nombre'], 
                "porcentaje"        =>$fila['porcentaje'],             
                "series"            =>$series,
                "index"             =>$contador,
                "charOptions"       =>$charOptions,
                "listaMiembro"      =>$listaMiembro );  
                $contador++;              
        }
        return $vector;
    }  
    public function BuscarProyecto($id_proyecto){
        $vector=array();
        $conexion=new Conexion();
        $db=$conexion->getConexion();
        $sql="SELECT p.id_proyecto,p.codigo_proyecto,p.nombre_proyecto,p.fecha_inicio,p.fecha_termino,p.descripcion,p.estado ,
        m.nombre,p.porcentaje  FROM proyecto AS p
        INNER JOIN metodologia AS m
        ON p.metodologiaId=m.id_metodologia
        WHERE p.id_proyecto=".$id_proyecto;
        $consulta=$db->prepare($sql);
        $consulta->execute();
        while($fila=$consulta->fetch()){
              $vector[]=array(
                "id_proyecto"       =>$fila['id_proyecto'],
                "codigo_proyecto"   =>$fila['codigo_proyecto'],
                "nombre_proyecto"   =>$fila['nombre_proyecto'],
                "fecha_inicio"      =>$fila['fecha_inicio'],
                "fecha_termino"     =>$fila['fecha_termino'],
                "descripcion"       =>$fila['descripcion'],
                "estado"            =>$fila['estado'],
                "nombre_metodologia"=>$fila['nombre'],
                "porcentaje"        =>$fila['porcentaje']);           
        }
        return $vector;
    }   
    public function getFaseMetodologiaProyecto($id_proyecto){
        /// ya no se usa borrar
        $vector=array();
        $conexion=new Conexion();
        $db=$conexion->getConexion();
        $sql="SELECT f.id_fase,f.nombre_fase,m.nombre,m.id_metodologia FROM proyecto AS p
        INNER JOIN metodologia AS m
        ON m.id_metodologia=p.metodologiaId
        INNER JOIN fase AS f
        ON f.metodologiaId=m.id_metodologia
        WHERE p.id_proyecto =".$id_proyecto;
        $consulta=$db->prepare($sql);
        $consulta->execute();
        while($fila=$consulta->fetch()){
            $vector[]=array(   
                "id_fase"       =>$fila['id_fase'],       
                "nombre_fase"   =>$fila['nombre_fase'],
                "metodologiaId" =>$fila['id_metodologia'],
                "title"         =>$fila['nombre_fase']);           
        }
        return $vector;
    }
    public function ListaFasesProyectono($id_proyecto){
        $vector=array();
        $conexion=new Conexion();
        $db=$conexion->getConexion();
        $series=array();
        $sql="SELECT  pro.id_proyecto,crono.id_fase,crono.nombre, crono.porcentaje FROM  cronogramafase AS crono 
        INNER JOIN cronograma AS cr
        ON crono.coronogramaId  =cr.id_cronograma
        INNER JOIN proyecto AS pro
        ON pro.id_proyecto=cr.id_proyecto   
        WHERE pro.id_proyecto=".$id_proyecto;
        $consulta=$db->prepare($sql);
        $consulta->execute();
        while($fila=$consulta->fetch()){
            $vector[]=array(   
                "id_fase"       =>$fila['id_fase'],       
                "nombre_fase"   =>$fila['nombre'],               
                "title"         =>$fila['nombre'],
                "series"        =>$series,
               );           
        }
        return $vector;
    }
    public function ListaFasesProyecto($id_proyecto){
        $vector=array();
        $conexion=new Conexion();
        $db=$conexion->getConexion();
        $series1=array();
        $categories=array();
        $contador=0;      
        $lista=array();
        $data=array();
        $series[]=array("data"=>$data);    
        $fruits =array("series" => array());     
        $xaxis        = (object) [ 'categories' => $categories ];
        $chartOptions = (object) ['xaxis' =>  $xaxis  ];     
        $sql="SELECT  crono.id_cronograma_fase,pro.id_proyecto,crono.id_fase,crono.nombre , crono.porcentaje,crono.porcentaje_avance FROM  cronogramafase AS crono 
        INNER JOIN cronograma AS cr
        ON crono.coronogramaId  =cr.id_cronograma
        INNER JOIN proyecto AS pro
        ON pro.id_proyecto=cr.id_proyecto   
        WHERE pro.id_proyecto=".$id_proyecto;
        $consulta=$db->prepare($sql);
        $consulta->execute();
        while($fila=$consulta->fetch()){
            $vector[]=array(   
                "id_cronograma_fase" =>$fila['id_cronograma_fase'],
                "id_fase"            =>$fila['id_fase'],       
                "nombre_fase"        =>$fila['nombre'],               
                "title"              =>$fila['nombre'], 
                "index"              =>$contador,
                "series"             =>$series,
                "porcentaje"         =>$fila['porcentaje'],
                "porcentaje_avance"  =>$fila['porcentaje_avance'],
                "chartOptions"       =>$chartOptions);  
                $contador++;           
        }
        return $vector;
    }
    
    public function Agregar($codigo,$nombre,$fechaini,$fechater,$descripcion,$estado,$metodologia,$usuariojefeId,$ListaFases,$ListaElementos,$porcentaje){
      
        $conexion=new Conexion();
        $cronograma=new ClsCronograma();        
        $miembro=new ClsMiembro();      
        $vector=array(); 
        $db=$conexion->getConexion();
        $porcentajeproyecto=0;
        $sql="INSERT INTO proyecto (codigo_proyecto,nombre_proyecto,fecha_inicio,fecha_termino,descripcion,estado,metodologiaId,usuariojefeId,porcentaje)  VALUES (:codigo,:nombre,:fechaini,:fechater,:descripcion,:estado,:metodologia,:usuariojefeId,:porcentajeproyecto)";
       
        $consulta=$db->prepare($sql);
        $consulta->bindParam(':codigo',$codigo);
        $consulta->bindParam(':nombre',$nombre);
        $consulta->bindParam(':fechaini',$fechaini);
        $consulta->bindParam(':fechater',$fechater);
        $consulta->bindParam(':descripcion',$descripcion);
        $consulta->bindParam(':estado',$estado);
        $consulta->bindParam(':metodologia',$metodologia);
        $consulta->bindParam(':usuariojefeId',$usuariojefeId);
        $consulta->bindParam(':porcentajeproyecto',$porcentajeproyecto);
        $consulta->execute();
        $retunidproyecto = $db->lastInsertId();

        $vector=array();
        $id_cronograma=$cronograma->setCronograma($retunidproyecto,$fechaini,$fechater);   
        $rolId=1;

        $porcentaje_fase=0;

        $dato=$miembro->Agregar($usuariojefeId,$rolId,$retunidproyecto);
        foreach ($ListaFases as $item)    {   
           $cronogramafase=new ClsCronogramaFase();            
           $id_cronograma_fase= $cronogramafase->setCronogramaFase($id_cronograma,$item['nombre'],$item['id_fase'],$porcentaje,$porcentaje_fase);   
           $vector[]=array(
            "id_cronograma_fase"=>$id_cronograma_fase,
            "nombre"            =>$item['nombre'],
            "id_fase"           =>$item['id_fase']);
           }  
      //  return $vector;
        
        return $vector;
    }

    public function ListaElementosFaseProyecto($id_proyecto,$id_fase){
        $vector=array();
        $conexion=new Conexion();
        $db=$conexion->getConexion();
        $sql=" SELECT p.id_proyecto , p.nombre_proyecto,cf.nombre, cf.id_cronograma_fase,cf.id_fase,ce.id_cronograma_elemento,ce.nombre_elemento,ce.id_elemento 
        FROM proyecto AS p 
        INNER  JOIN cronograma AS c
        ON p.id_proyecto= c.id_proyecto
        INNER JOIN cronogramafase AS cf
        ON c.id_cronograma=cf.coronogramaId
        INNER JOIN cronograma_elemento AS ce
        ON ce.id_cronograma_fase = cf.id_cronograma_fase
        WHERE p.id_proyecto=".$id_proyecto." AND cf.id_fase =".$id_fase;          
        $consulta=$db->prepare($sql);
        $consulta->execute();
        while($fila=$consulta->fetch()){
            $vector[]=array(   
                "id_cronograma_elemento"    =>$fila["id_cronograma_elemento"],
                "id_elemento"               =>$fila['id_elemento'],       
                "nombre_elemento"           =>$fila['nombre_elemento']);            
        }
        return $vector;
    }
    public function ObtenerPorcentajeProyecto($id_proyecto){
        $vector=array();
        $conexion=new Conexion();
        $db=$conexion->getConexion();
        $sql=" SELECT  pro.porcentaje FROM proyecto AS pro
        WHERE pro.id_proyecto=".$id_proyecto;
        $consulta=$db->prepare($sql);
        $consulta->execute();   
        $porcentaje =    $consulta->fetch()['porcentaje'];
        return $porcentaje;

    }   
    public function EditarPorcentaje($id_proyecto, $porcentaje){
      
        $conexion=new Conexion();
        $db=$conexion->getConexion();     
        $porcentajeProyecto=self::ObtenerPorcentajeProyecto($id_proyecto);       
        $totalporcentaje =$porcentajeProyecto + $porcentaje;
        $sql = "UPDATE proyecto SET porcentaje=:porcentaje WHERE id_proyecto=:id_proyecto";
        $consulta=$db->prepare($sql); 
        $consulta->bindParam(':id_proyecto',$id_proyecto);      
        $consulta->bindParam(':porcentaje', $totalporcentaje);           
        $consulta->execute();      
        return '{"msg":"Editado "}';
     }
}

