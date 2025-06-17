<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "bd_hoteles";


$conexion = new mysqli($host, $usuario, $contrasena, $bd);

if ($conexion->connect_error) {
    die("Error en la conexion: " . $conexion->connect_error);
}
?>
