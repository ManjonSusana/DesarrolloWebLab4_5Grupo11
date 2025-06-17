<?php
include("conexion.php");

$id = $_GET['id'];

$sql = "SELECT * FROM usuarios WHERE id = $id";
$resultado = $conexion->query($sql);

$usuario = $resultado->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($usuario);
?>
