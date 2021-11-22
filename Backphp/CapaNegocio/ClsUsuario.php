<?php
require_once('../CapaDatos/ClsLibre.php');
class ClsUsuario
{
    public $id_usuario; 
	public $nombre; 
    public $apellido;  
    public $correo;  
    public $password; 
    public $tiposusuarioId;  

    function Agregar($usuario)
    {
       
        $sql = new tablalibre();
        $consulta ="INSERT INTO  usuario (nombre,apellido,correo,password,tiposusuarioId) 
        values ('$usuario->nombre', '$usuario->apellido','$usuario->correo','$usuario->password','$usuario->tiposusuarioId')";
        $rs=$sql->consulta($consulta);
        return $rs;
      
    
    }
    function Buscar($correo)
    {
       $buscar= new tablalibre();
       $consulta ="SELECT * from usuario where  correo ='$correo'"; 
       $rs=$buscar->consulta($consulta);
       return $rs->nroregistros;   
    
    }
    public function Listar(){
        $sql = new tablalibre();   
        $consulta ="  SELECT usu.id_usuario,usu.nombre,usu.apellido,usu.correo,tipo.nombre as tipousuario  FROM  usuario AS usu 
        INNER  JOIN tipousuario AS tipo
        ON usu.tiposusuarioId =tipo.id_tipo";
        $rs=$sql->consulta($consulta);
        $vector = array();
        while($datos = $rs->recordset->fetch(PDO::FETCH_ASSOC)){
              $temp = new ClsUsuario;
              $temp->id_usuario = $datos["id_usuario"];
              $temp->nombre     = $datos["nombre"];
              $temp->apellido   = $datos["apellido"]; 
              $temp->correo     = $datos["correo"];     
              $temp->tipo       = $datos["tipousuario"];         	
              array_push($vector,$temp);
        }
        return $vector;
    } 
    public function get_proyectosusuario($usuario_miembroid){
        $sql = new tablalibre();         
        $listaMiembro=array();
        $vector=array();      
        $contador=0;
        $consulta="SELECT  mi.id ,ro.nombre,pro.id_proyecto, pro.nombre_proyecto,pro.estado, pro.fecha_inicio,pro.fecha_termino FROM miembroproyecto AS mi 
        INNER JOIN rol AS ro
        ON ro.id_rol =mi.rolId 
        INNER JOIN proyecto AS pro
        ON mi.proyectoId=pro.id_proyecto
        WHERE mi.usuario_miembroid=".$usuario_miembroid;
        $rs=$sql->consulta($consulta);
        while($datos = $rs->recordset->fetch(PDO::FETCH_ASSOC)){
                $temp = new ClsUsuario;
                $temp->id                = $datos["id"];
                $temp->nombre            = $datos["nombre"];
                $temp->id_proyecto       = $datos["id_proyecto"]; 
                $temp->nombre_proyecto   = $datos["nombre_proyecto"];         
                $temp->listaMiembro      = $listaMiembro; 
                $temp->estado            = $datos["estado"];             
                $temp->index             = $contador;  	
                $temp->fecha_inicio      = $datos["fecha_inicio"];  
                $temp->fecha_termino     = $datos["fecha_termino"];  
               
                array_push($vector,$temp);  
                $contador++;                    
        }
        return $vector;
    }
    public function ObtenerIdMiembro($usuario_miembroid,$proyectoId){
        $sql = new tablalibre();
        $idusuarioJefe="";
        $consulta = "SELECT mi.id, usu.id_usuario, usu.nombre,usu.apellido,usu.tiposusuarioId,ti.id_tipo,ti.nombre as tiposusuario  from usuario  as usu
        INNER JOIN  tipousuario AS ti
        ON usu.tiposusuarioId =ti.id_tipo
        INNER JOIN miembroproyecto  mi 
        ON mi.usuario_miembroid =usu.id_usuario         
        WHERE  mi.usuario_miembroid =".$usuario_miembroid."  AND mi.proyectoId=".$proyectoId;
        $rs=$sql->consulta($consulta);
        $idusuarioJefe=self::ObtenerIdMiembroJefe($proyectoId);
      
        $usuario = new ClsUsuario;
        if($rs->nroregistros<>0){
              $datos=$rs->recordset->fetch(PDO::FETCH_ASSOC);
              $usuario->id              = $datos["id"];     
              $usuario->idusuarioJefe   = $idusuarioJefe;          
        }       
        return $usuario;
    }
    public function ObtenerIdMiembroJefe($proyectoId){
        $sql = new tablalibre();
        $consulta = "SELECT mi.id, usu.id_usuario, usu.nombre,usu.apellido,usu.tiposusuarioId,ti.id_tipo,ti.nombre as tiposusuario  from usuario  as usu
        INNER JOIN  tipousuario AS ti
        ON usu.tiposusuarioId =ti.id_tipo
        INNER JOIN miembroproyecto  mi 
        ON mi.usuario_miembroid =usu.id_usuario  
        WHERE ti.nombre='Jefe'    AND mi.proyectoId=".$proyectoId;
        $rs=$sql->consulta($consulta);
        $usuario = new ClsUsuario;
        $idusuarioJefe1="";
        if($rs->nroregistros<>0){
              $datos=$rs->recordset->fetch(PDO::FETCH_ASSOC);
              $idusuarioJefe1 = $datos["id"];             
        }       
        return $idusuarioJefe1;
    }  

}

