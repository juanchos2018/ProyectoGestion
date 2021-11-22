<?php
require_once('../CapaDatos/ClsLibre.php');
class ClsPlantillaElemento
{
    public $id_plantilla; 
	public $faseId; 
	public $elementoId;  

    function Agregar($plantilla)
    {
        $sql = new tablalibre();
        $consulta ="INSERT INTO plantillaelementoconfiguracion (faseId,elementoId) 
        values ('$plantilla->faseId', '$plantilla->elementoId')";
        $rs=$sql->consulta($consulta);
        return $rs;
    }
    public function ListaElementosFase($faseId){
        $sql = new tablalibre();
        $consulta ="SELECT   pla.id_plantilla, fa.id_fase,fa.nombre_fase,el.id_elemento,el.nombre  FROM  plantillaelementoconfiguracion AS pla
        INNER JOIN fase AS fa 
        ON pla.faseId=fa.id_fase
        INNER JOIN elementoconfiguracion AS el
        ON pla.elementoId=el.id_elemento
        WHERE fa.id_fase=".$faseId;
        $rs=$sql->consulta($consulta);
        $vector = array();
        while($datos = $rs->recordset->fetch(PDO::FETCH_ASSOC)){
              $temp = new ClsPlantillaElemento;
              $temp->id_plantilla = $datos["id_plantilla"]; 
              $temp->id_fase      = $datos["id_fase"];              
              $temp->nombre_fase  = $datos["nombre_fase"];   
              $temp->id_elemento  = $datos["id_elemento"];      
              $temp->nombre       = $datos["nombre"];       	
              array_push($vector,$temp);
        }
        return $vector;
    } 
    public function Lista(){
        $sql = new tablalibre();
        $consulta ="SELECT pla.id_plantilla, ele.id_elemento, ele.nombre,fa.id_fase,fa.nombre_fase  FROM plantillaelementoconfiguracion AS pla
        INNER JOIN elementoconfiguracion AS ele
        ON pla.elementoId=ele.id_elemento
        INNER JOIN fase AS fa
        ON pla.faseId=fa.id_fase";
        $rs=$sql->consulta($consulta);
        $vector = array();
        while($datos = $rs->recordset->fetch(PDO::FETCH_ASSOC)){
              $temp = new ClsPlantillaElemento;
              $temp->id_plantilla   = $datos["id_plantilla"]; 
              $temp->id_elemento    = $datos["id_elemento"];              
              $temp->nombre         = $datos["nombre"];   
              $temp->faseId         = $datos["id_fase"];      
              $temp->nombre_fase    = $datos["nombre_fase"];
              $temp->title          = $datos["nombre"];        	
              array_push($vector,$temp);
        }
        return $vector;
    } 
    function Eliminar($id_plantilla)
    {
        $sql = new tablalibre();
        $consulta ="delete from plantillaelementoconfiguracion where id_plantilla=".$id_plantilla;
        $rs=$sql->consulta($consulta);
        return $rs;
    }
    function Existe($plantilla)
    {
       $buscar= new tablalibre();
       $consulta ="SELECT * from plantillaelementoconfiguracion where  faseId ='$plantilla->faseId' and elementoId='$plantilla->elementoId'"; 
       $rs=$buscar->consulta($consulta);
       return $rs->nroregistros;   
    
    }
}

