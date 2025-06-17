<?php
include("conexion.php");

$sql = "SELECT id, numero, piso, tipo, estado FROM habitaciones";
$resultado = $conexion->query($sql);

$datos = array();
while ($fila = $resultado->fetch_assoc()) {
    $datos[] = $fila;
}

header('Content-Type: application/json');
echo json_encode($datos);
?>
