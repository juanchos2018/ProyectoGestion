<?php
require_once('../CapaDatos/ClsLibre.php');
class ClsElemento
{
    public $id_elemento; 
	public $codigo_elemento; 
	public $nombre;  

    function Agregar($elemento)
    {
        $sql = new tablalibre();
        $consulta ="INSERT INTO elementoconfiguracion (codigo_elemento,nombre) 
        values ('$elemento->codigo_elemento', '$elemento->nombre')";
        $rs=$sql->consulta($consulta);
        return $rs;
    }
    public function Listar(){
        $sql = new tablalibre();
        $consulta ="SELECT * FROM elementoconfiguracion";
        $rs=$sql->consulta($consulta);
        $vector = array();
        while($datos = $rs->recordset->fetch(PDO::FETCH_ASSOC)){
              $temp = new ClsElemento;
              $temp->id_elemento =      $datos["id_elemento"];
              $temp->codigo_elemento =  $datos["codigo_elemento"];
              $temp->nombre =           $datos["nombre"];             	
              array_push($vector,$temp);
        }
        return $vector;
    } 
    function Editar($data)
    {
        $sql = new tablalibre();
        $consulta ="update elementoconfiguracion set codigo_elemento='$data->codigo_elemento', nombre='$data->nombre' 
        where id_elemento='$data->id_elemento'";
        $rs=$sql->consulta($consulta);
        return $rs;
    } 
    function Eliminar($id_elemento)
    {
        $sql = new tablalibre();
        $consulta ="delete from elementoconfiguracion where id_elemento=".$id_elemento;
        $rs=$sql->consulta($consulta);
        return $rs;
    }
    function Existe($elemento)
    {
       $buscar= new tablalibre();
       $consulta ="SELECT * from elementoconfiguracion  where  nombre ='$elemento->nombre' "; 
       $rs=$buscar->consulta($consulta);
       return $rs->nroregistros;   
    
    }
}

