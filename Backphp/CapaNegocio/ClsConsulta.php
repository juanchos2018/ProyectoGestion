<?php
require_once('../CapaDatos/ClsLibre.php');
class ClsConsulta
{
    public $id_proyecto; 
	public $estado_tarea; 
	public $cantidad;  
    public $index; 
    public $estado;
    public $descripcion;
 
    public function ListaTotalTareas(){
        $sql = new tablalibre();
        $consulta ="SELECT pro.id_proyecto, pro.nombre_proyecto,  ta.estado ,COUNT(ta.estado) AS cantidad FROM tarea_ecs AS ta
        INNER JOIN version AS ve
        ON ta.verionID =ve.id_version
        INNER JOIN cronograma_elemento AS cro
        ON ve.elemntoconfiguracionID=cro.id_cronograma_elemento
        INNER JOIN cronogramafase AS cro1
        ON cro.id_cronograma_fase =cro1.id_cronograma_fase
        INNER JOIN cronograma AS cro2 
        ON cro1.coronogramaId=cro2.id_cronograma          
        INNER JOIN proyecto AS pro
        on cro2.id_proyecto=pro.id_proyecto
        GROUP BY pro.id_proyecto ,ta.estado
        ORDER BY ta.estado";
        $rs=$sql->consulta($consulta);
        $vector = array();
        while($datos = $rs->recordset->fetch(PDO::FETCH_ASSOC)){
              $temp = new ClsConsulta;
              $temp->id_proyecto    = $datos["id_proyecto"];
              $temp->estado_tarea   = $datos["estado"];
              $temp->cantidad       = $datos["cantidad"];             	
              array_push($vector,$temp);
        }
        return $vector;
    } 
    public function BuscarTotalTareas($id_proyecto){
        $sql = new tablalibre();
        $consulta = "SELECT pro.id_proyecto, pro.nombre_proyecto,  ta.estado ,COUNT(ta.estado) AS cantidad FROM tarea_ecs AS ta
        INNER JOIN version AS ve
        ON ta.verionID =ve.id_version
        INNER JOIN cronograma_elemento AS cro
        ON ve.elemntoconfiguracionID=cro.id_cronograma_elemento
        INNER JOIN cronogramafase AS cro1
        ON cro.id_cronograma_fase =cro1.id_cronograma_fase
        INNER JOIN cronograma AS cro2 
        ON cro1.coronogramaId=cro2.id_cronograma          
        INNER JOIN proyecto AS pro
        on cro2.id_proyecto=pro.id_proyecto
        WHERE pro.id_proyecto=".$id_proyecto."
        GROUP BY pro.id_proyecto ,ta.estado
        ORDER BY ta.estado";
        $rs=$sql->consulta($consulta);
        $vector = array();
        while($datos = $rs->recordset->fetch(PDO::FETCH_ASSOC)){
            $temp = new ClsConsulta;
            $temp->id_proyecto      = $datos["id_proyecto"];
            $temp->estado_tarea     = $datos["estado"];
            $temp->cantidad         = $datos["cantidad"];             	
            array_push($vector,$temp);
      }
       
        return $vector;
    }
    public function BuscarTototalTareasFase($id_proyecto){
        $sql = new tablalibre();
        $contador=0;
        $lista=array();
        $consulta = "SELECT  pro.id_proyecto,pro.nombre_proyecto,cro1.id_fase, cro1.nombre, ta.estado ,COUNT(ta.estado) AS cantidad FROM tarea_ecs AS ta
        INNER JOIN version AS ve
        ON ta.verionID =ve.id_version
        INNER JOIN cronograma_elemento AS cro
        ON ve.elemntoconfiguracionID=cro.id_cronograma_elemento
        INNER JOIN cronogramafase AS cro1
        ON cro.id_cronograma_fase =cro1.id_cronograma_fase
        INNER JOIN cronograma AS cro2 
        ON cro1.coronogramaId=cro2.id_cronograma 
        INNER JOIN proyecto AS pro
        on cro2.id_proyecto=pro.id_proyecto
        WHERE pro.id_proyecto=".$id_proyecto."
        GROUP BY cro1.nombre ,ta.estado
        ORDER BY cro1.nombre";
        $rs=$sql->consulta($consulta);
        $vector = array();
        while($datos = $rs->recordset->fetch(PDO::FETCH_ASSOC)){
            $temp = new ClsConsulta;
            $temp->nombre_proyecto      = $datos["nombre_proyecto"];
            $temp->id_fase              = $datos["id_fase"];
            $temp->nombre               = $datos["nombre"];  
            $temp->estado               = $datos["estado"];     
            $temp->cantidad             = $datos["cantidad"]; 
            $temp->index                = $contador;   
            $temp->lista                = $lista;         	
            array_push($vector,$temp);

            $contador++;
      }
       
        return $vector;
    }

    public function ListarTareaEstado($tarea){
        $sql = new tablalibre();
        $contador=0;
        $lista=array();
        $consulta = " SELECT  pro.id_proyecto,pro.nombre_proyecto,cro1.id_fase, cro1.nombre, ta.estado,ta.descripcion  FROM tarea_ecs AS ta
        INNER JOIN version AS ve
        ON ta.verionID =ve.id_version
        INNER JOIN cronograma_elemento AS cro
        ON ve.elemntoconfiguracionID=cro.id_cronograma_elemento
        INNER JOIN cronogramafase AS cro1
        ON cro.id_cronograma_fase =cro1.id_cronograma_fase
        INNER JOIN cronograma AS cro2 
        ON cro1.coronogramaId=cro2.id_cronograma 
        INNER JOIN proyecto AS pro
        on cro2.id_proyecto=pro.id_proyecto
        WHERE pro.id_proyecto='$tarea->id_proyecto' AND ta.estado='$tarea->estado'
        ORDER BY cro1.nombre"; 
        $rs=$sql->consulta($consulta);
        $vector = array();
        while($datos = $rs->recordset->fetch(PDO::FETCH_ASSOC)){
            $temp = new ClsConsulta;           
            $temp->nombre               = $datos["nombre"];  
            $temp->estado               = $datos["estado"];     
            $temp->descripcion          = $datos["descripcion"];    
            array_push($vector,$temp);
            $contador++;
          }
       
        return $vector;
    }


    public function Grafico1(){
        $vector=array();
        $sql = new tablalibre();
      
     //   $conexion=new Conexion();
      //  $db=$conexion->getConexion();
        $consulta="SELECT p.id_proyecto,p.codigo_proyecto,p.nombre_proyecto,p.fecha_inicio,p.fecha_termino,p.descripcion,p.estado ,
        m.nombre,p.porcentaje   FROM proyecto AS p
        INNER JOIN metodologia AS m
        ON p.metodologiaId=m.id_metodologia";


        $rs=$sql->consulta($consulta);
        
        // $consulta=$db->prepare($sql);
        // $consulta->execute();

        $temp = new ArrayObject([], ArrayObject::ARRAY_AS_PROPS); 


        $vector1 = array();              
        $series=array();
        $data=array();
        $categories=array();
        $categories1=array();
        $objetoserie = new ArrayObject([], ArrayObject::ARRAY_AS_PROPS);   
        $objetoserie['name'] =  "Inflation";  
        $lista =array();

        while($fila = $rs->recordset->fetch(PDO::FETCH_ASSOC)){
            array_push($data,(int)$fila['porcentaje']);   
            array_push($categories,$fila["nombre_proyecto"]);                 
            $objetoserie['data'] =  $data;               
        }
        array_push($lista,$objetoserie);   

        $chart = new ArrayObject([], ArrayObject::ARRAY_AS_PROPS);                
        $chart['height'] =  350;   
        $chart['type'] =  "bar";  


       

        $bar = new ArrayObject([], ArrayObject::ARRAY_AS_PROPS);                
        $bar['borderRadius'] =  10;   
        $bar['columnWidth'] = '50%';   
      
        $plotOptions = new ArrayObject([], ArrayObject::ARRAY_AS_PROPS);                
        $plotOptions['bar'] =  $bar;  



        $dataLabels= new ArrayObject([], ArrayObject::ARRAY_AS_PROPS);                
        $dataLabels['enabled'] =  false;   
     
        $stroke= new ArrayObject([], ArrayObject::ARRAY_AS_PROPS);                
        $stroke['width'] =  2; 

        $colors =array();
        array_push($colors,'#fff');   
        array_push($colors,'#f2f2f2');   
        $row= new ArrayObject([], ArrayObject::ARRAY_AS_PROPS);                
        $row['colors'] =  $colors; 

        $grid= new ArrayObject([], ArrayObject::ARRAY_AS_PROPS);                
        $grid['row'] =  $row; 

        $labels= new ArrayObject([], ArrayObject::ARRAY_AS_PROPS);                
        $labels['rotate'] =  -45; 

        $xaxis = new ArrayObject([], ArrayObject::ARRAY_AS_PROPS);  
        $xaxis['categories'] =  $categories;
        $xaxis['labels'] =  $labels;
                  


        $chartOptions1['chart'] =  $chart;                     
        $chartOptions1['plotOptions']    = $plotOptions;    
        $chartOptions1['dataLabels']    = $dataLabels;
        $chartOptions1['stroke']    = $stroke;
        $chartOptions1['grid']    = $grid;
        $chartOptions1['xaxis']    = $xaxis;

        $temp['series']     = $lista;                     
        $temp['chartOptions']     = $chartOptions1;                     
       // array_push($vector,$temp);


        return $temp;
    } 
}

