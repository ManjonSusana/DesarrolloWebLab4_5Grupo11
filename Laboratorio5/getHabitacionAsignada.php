<?php
include("conexion.php");

$id_reserva = $_GET['id_reserva'];

$sql = "SELECT h.numero 
        FROM reservas r 
        JOIN habitaciones h ON r.id_habitaciones = h.id 
        WHERE r.id = $id_reserva AND r.id_habitaciones IS NOT NULL";

$resultado = $conexion->query($sql);

$response = ["asignada" => false];

if ($fila = $resultado->fetch_assoc()) {
    $response = [
        "asignada" => true,
        "numero" => $fila['numero']
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
