<?php
include("conexion.php");
$tipo = $_GET['tipo'];
$sql = "SELECT id, numero, piso FROM habitaciones WHERE tipo = '$tipo' AND estado = 'disponible'";
$res = $conexion->query($sql);
$habitaciones = [];
while ($fila = $res->fetch_assoc()) {
    $habitaciones[] = $fila;
}
header('Content-Type: application/json');
echo json_encode($habitaciones);
?>
