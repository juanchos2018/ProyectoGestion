<?php
//require_once('../CapaDatos/ClsLibre.php');
require_once('../CapaDatos/conectar.php');
require_once('ClsInformeCambioDetalle.php');

class ClsInformeCambio
{   
    public $id_informe;
    public $codigo;
    public $solicitudcambioId; 
	public $descripcion; 
    public $tiempo;  
    public $costo; 
    public $impactoproblema;
    public $fecha; 
    public $miembrojefeId;
    public $estado;


    public function Agregar($codigo,$solicitudcambioId,$descripcion,$tiempo,$costo,$impactoproblema,$fecha,$miembrojefeId,$estado,$detalle){
      
        $conexion=new Conexion();         
        $vector=array(); 
        $db=$conexion->getConexion();
        $sql="INSERT INTO informecambio (codigo,solicitudcambioId,descripcion,tiempo,costo,impactoproblema,fecha,miembrojefeId,estado) 
        VALUES (:codigo,:solicitudcambioId,:descripcion,:tiempo,:costo,:impactoproblema,:fecha,:miembrojefeId,:estado)";
       
        $consulta=$db->prepare($sql);
        $consulta->bindParam(':codigo',$codigo);
        $consulta->bindParam(':solicitudcambioId',$solicitudcambioId);
        $consulta->bindParam(':impactoproblema',$impactoproblema);
        $consulta->bindParam(':descripcion',$descripcion);
        $consulta->bindParam(':tiempo',$tiempo);
        $consulta->bindParam(':costo',$costo);
        $consulta->bindParam(':fecha',$fecha);
        $consulta->bindParam(':miembrojefeId',$miembrojefeId);
        $consulta->bindParam(':estado',$estado);
        $consulta->execute();
        
        $id_informecambio = $db->lastInsertId();  
        foreach ($detalle as $item){   
            $obj=new ClsInformeCambioDetalle();            
           // $obj->Agregar($id_informecambio,$item['cronogramaelemetoId'],$item['descripcion'],$item['fechainicio'],$item['fechatermino'],$item['porcentajeavance']);   
            $obj->Agregar2($id_informecambio,$item['cronogramaelemetoId'],$item['descripcion'],$item['fechainicio'],$item['fechatermino'],$item['porcentajeavance'],$item['ecs'],$item['tiempo'],$item['costo']);   

        }  
        return "{msg:Agrregado}";    			
    }
    
    public function Listar(){
        $vector=array();  
        $contador=0;    
        $conexion=new Conexion();
        $db=$conexion->getConexion();
        $sql="SELECT  info.id_informe,info.codigo,info.descripcion,info.tiempo,info.costo,info.impactoproblema,info.fecha
        ,info.estado , usu.nombre FROM informecambio  AS info
        INNER JOIN miembroproyecto AS mi 
        ON info.miembrojefeId=mi.id
        INNER JOIN usuario AS usu
        ON mi.usuario_miembroid=usu.id_usuario";
        $consulta=$db->prepare($sql);
        $consulta->execute();
        while($fila=$consulta->fetch()){
              $vector[]=array(
                "index"       =>$contador,  
                "id_informe"  =>$fila['id_informe'],
                "codigo"      =>$fila['codigo'],
                "descripcion" =>$fila['descripcion'],
                "tiempo"      =>$fila['tiempo'],
                "costo"       =>$fila['costo'],
                "impactoproblema"=>$fila['impactoproblema'],
                "fecha"       =>$fila['fecha'],
                "estado"      =>$fila['estado'],
                "nombre"      =>$fila['nombre']);  
                $contador++;              
        }
        return $vector;
    } 

    public function InforrmeCAmbio($id_informe){
        $vector=array();  
        $contador=0;    
        $conexion=new Conexion();
        $db=$conexion->getConexion();
        $sql="SELECT * FRO informecambio
        WHERE id_informe ='$id_informe'";
        $consulta=$db->prepare($sql);
        $consulta->execute();
        $informe = new ClsInformeCambio;

        $detalleInforme=array();

        if($rs->consulta<>0){
            $datos=$rs->recordset->fetch(PDO::FETCH_ASSOC);
             $informe->id_informe   = $datos["id_informe"];
             $informe->codigo     = $datos["codigo"];
             $informe->solicitudcambioId    = $datos["solicitudcambioId"];
             $informe->descripcion    = $datos["descripcion"];
             $informe->tiempo  = $datos["tiempo"];
          
       }
       $objeto= new ArrayObject([], ArrayObject::ARRAY_AS_PROPS);                
       $objeto['rotate'] =  -45; 
     //  $tarea->objeto=

       return $informe;     
    }

    public function EditarInformeCAmbioEStado($id_informe, $estado){
      
        $conexion=new Conexion();
        $db=$conexion->getConexion();         
        $sql = "UPDATE informecambio SET estado=:estado WHERE id_informe=:id_informe";
        $consulta=$db->prepare($sql); 
        $consulta->bindParam(':id_informe',$id_informe);      
        $consulta->bindParam(':estado', $estado);           
        $consulta->execute();      
        return '{"msg":"Editado "}';
        
     }
}

