<?php
require_once('../CapaDatos/ClsLibre.php');
class ClsInforme2
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
   
    public function InforrmeCAmbio($id_informe){
        
        $sql = new tablalibre();
        $sql2 = new tablalibre();
        $consulta = "SELECT   inf.id_informe  ,
        inf.codigo  ,
        inf.solicitudcambioId  ,
        inf.descripcion  ,
        inf.tiempo ,
        inf.costo ,
        inf.impactoproblema ,
        inf.fecha  ,
        inf.miembrojefeId ,
        inf.estado,sol.id_proyecto   FROM informecambio AS inf
        INNER JOIN solicitudcambio AS sol
        ON inf.solicitudcambioId =sol.id_solicitud
        WHERE  inf.id_informe ='$id_informe'";
        $rs=$sql->consulta($consulta);
        $informe = new ClsInforme2;

        if($rs->nroregistros<>0){
             $datos=$rs->recordset->fetch(PDO::FETCH_ASSOC);
             $informe->id_informe   = $datos["id_informe"];
             $informe->fecha     = $datos["fecha"];
             $informe->costo     = $datos["costo"];
             $informe->codigo     = $datos["codigo"];
             $informe->solicitudcambioId    = $datos["solicitudcambioId"];
             $informe->impactoproblema    = $datos["impactoproblema"];
             $informe->descripcion    = $datos["descripcion"];
             $informe->id_proyecto    = $datos["id_proyecto"];
             $informe->tiempo  = $datos["tiempo"];             

             $detalle=array();
             $consulta2 ="SELECT * FROM  informecambiodetalle 
             WHERE id_informecambio='$informe->id_informe'";
             $rs2=$sql2->consulta($consulta2);      
             $contador2=1;

             while($datos2 = $rs2->recordset->fetch(PDO::FETCH_ASSOC)){
                $objeto= new ArrayObject([], ArrayObject::ARRAY_AS_PROPS); 
                $objeto['index'] =  $contador2;                
                $objeto['nombreelemento'] =  $datos2["nombreelemento"]; 
                $objeto['tiempo'] =  $datos2["tiempo"]; 
                $objeto['costo'] =  $datos2["costo"];   
                array_push($detalle,$objeto);
                $contador2++;
          }            
        }  
        $objeto= new ArrayObject([], ArrayObject::ARRAY_AS_PROPS);                
        $objeto['informe'] =  $informe; 
        $objeto['detalle'] =  $detalle; 
        return $objeto;
    }  

}

