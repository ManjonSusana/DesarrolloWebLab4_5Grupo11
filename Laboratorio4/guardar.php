<?php
include("conexion.php");

$Correos = $_POST["correos"];
$Asuntos = $_POST["asuntos"];
$Mensajes = $_POST["mensajes"];



        $sql= "INSERT INTO `correo` (`bandeja`, `correo`, `asunto`, `mensaje`, `estado`) 
    VALUES ( 'borrador', '$Correos', '$Asuntos', '$Mensajes', 'PE');";

    $result = $con->query($sql);
    if(!$result){
        die("Error al insertar datos: " . $con->error);
    }

    echo "Se inserto con exito";
    
?>
}

