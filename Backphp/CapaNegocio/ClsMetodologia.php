<?php
require_once('../CapaDatos/ClsLibre.php');

class ClsMetodologia
{
    public $id_metodologia; 
	public $nombre;  

    function Agregar($metodologia)
    {
        $sql = new tablalibre();
        $consulta ="INSERT INTO metodologia (nombre) 
        values ('$metodologia->nombre')";
        $rs=$sql->consulta($consulta);
        return $rs;
    }
    public function Listar(){
        $sql = new tablalibre();
        $consulta ="SELECT * FROM metodologia";
        $rs=$sql->consulta($consulta);
        $vector = array();
        while($datos = $rs->recordset->fetch(PDO::FETCH_ASSOC)){
              $temp = new ClsMetodologia;
              $temp->id_metodologia = $datos["id_metodologia"];              
              $temp->nombre = $datos["nombre"];             	
              array_push($vector,$temp);
        }
        return $vector;
    } 
    function Editar($data)
        {
            $sql = new tablalibre();
            $consulta ="update metodologia set  nombre='$data->nombre' 
            where id_metodologia='$data->id_metodologia'";
            $rs=$sql->consulta($consulta);
            return $rs;
        } 
    public function ListaFaseMetodologia($id_metodologia){
        $sql = new tablalibre();
        $vector=array();    
        $tabla = array();       
        $consulta="SELECT f.id_fase,f.nombre_fase,me.nombre,me.id_metodologia FROM fase AS f
        INNER JOIN metodologia AS me
        ON f.metodologiaId=me.id_metodologia
        WHERE me.id_metodologia=".$id_metodologia;       
        $rs=$sql->consulta($consulta);     
        $contador=0;
        while($datos = $rs->recordset->fetch(PDO::FETCH_ASSOC)){
            $temp = new ClsMetodologia;
            $temp->id_fase            = $datos["id_fase"];             
            $temp->nombre_fase        = $datos["nombre_fase"];    
            $temp->id_metodologia     = $datos["id_metodologia"];   
            $temp->title              = $datos["nombre_fase"];   
            $temp->tabla              = $tabla;   
            $temp->index              = $contador;   	
            array_push($vector,$temp);
            $contador++; 
         }           
        return $vector;
    }

}

