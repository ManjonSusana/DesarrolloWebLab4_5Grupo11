<?php
include("conexion.php");

$id = $_GET['id'];

// Obtener detalles de la habitación
$sqlHabitacion = "SELECT h.descripcion, f.fotografia 
                  FROM habitaciones h 
                  LEFT JOIN fotografia_habitacion f ON h.id = f.id_habitaciones 
                  WHERE h.id = $id 
                  LIMIT 1";
$resHabitacion = $conexion->query($sqlHabitacion);
$habitacion = $resHabitacion->fetch_assoc();

// Obtener datos del cliente si hay reserva activa
$sqlCliente = "SELECT u.nombre, u.ci, u.telefono, r.fecha_entrada, r.fecha_salida 
               FROM reservas r
               INNER JOIN usuarios u ON u.id = r.id_usuario
               WHERE r.id_habitaciones = $id AND r.estado = 'confirmada'
               LIMIT 1";
$resCliente = $conexion->query($sqlCliente);
$cliente = $resCliente->fetch_assoc();

$data = [];

if ($habitacion) {
    $data['descripcion'] = $habitacion['descripcion'];
    $data['fotografia'] = $habitacion['fotografia'];
}

if ($cliente) {
    $data['nombre'] = $cliente['nombre'];
    $data['ci'] = $cliente['ci'];
    $data['telefono'] = $cliente['telefono'];
    $data['fecha_entrada'] = $cliente['fecha_entrada'];
    $data['fecha_salida'] = $cliente['fecha_salida'];
}

header('Content-Type: application/json');
echo json_encode($data);
?>

