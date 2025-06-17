<?php
include("conexion.php");

$sql = "SELECT id, nombre, correo, telefono, ci, fecha_registro FROM usuarios ORDER BY id DESC";
$resultado = $conexion->query($sql);

$usuarios = array();
while ($fila = $resultado->fetch_assoc()) {
    $usuarios[] = $fila;
}

header('Content-Type: application/json');
echo json_encode($usuarios);
?>
