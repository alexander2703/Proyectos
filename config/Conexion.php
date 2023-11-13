<?php 

class Conexion{

    public static function Conexion(){
        $conexion = new mysqli("localhost", "root", "", "examen");
        if($conexion->connect_errno){
            die("Error inesperado en la conexión a base de datos: ". $conexion->connect_errno);
        }else{
            return $conexion; 
        }
    }
}



?>