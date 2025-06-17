<?php
include("conexion.php");

$id = $_GET['id'];

$sql = "SELECT r.id, u.nombre AS nombre_usuario, r.tipo_habitacion, r.fecha_entrada, r.fecha_salida 
        FROM reservas r
        JOIN usuarios u ON r.id_usuario = u.id
        WHERE r.id = $id";

$res = $conexion->query($sql);
$data = $res->fetch_assoc();

echo json_encode($data);
?>
