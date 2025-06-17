<?php
include("conexion.php");

$Correos = $_POST["correos"];
$Asuntos = $_POST["asuntos"];
$Mensajes = $_POST["mensajes"];

$sql= "INSERT INTO `correo` (`bandeja`, `correo`, `asunto`, `mensaje`, `estado`) 
VALUES ( 'salida', '$Correos', '$Asuntos', '$Mensajes', 'E');";

$result = $con->query($sql);
if(!$result){
    die("Error al insertar datos: " . $con->error);
}
?>
<div>Se inserto con exito</div>