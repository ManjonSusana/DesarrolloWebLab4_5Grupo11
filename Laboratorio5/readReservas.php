<?php
include("conexion.php");

$filtro = $_GET['filtro'] ?? null;
$nombre = $_GET['nombre'] ?? null;

$sql = "SELECT r.id, r.tipo_habitacion, r.fecha_entrada, r.fecha_salida, r.estado, r.fecha_reserva, u.nombre AS nombre_usuario
        FROM reservas r
        INNER JOIN usuarios u ON r.id_usuario = u.id";

if ($nombre) {
    $sql .= " WHERE u.nombre LIKE '%$nombre%'";
} else if ($filtro == "pasadas") {
    $sql .= " WHERE r.fecha_entrada < CURDATE()";
} else if ($filtro == "futuras") {
    $sql .= " WHERE r.fecha_entrada > CURDATE()";
} else if ($filtro == "hoy") {
    $sql .= " WHERE r.fecha_entrada = CURDATE()";
}

$sql .= " ORDER BY r.fecha_entrada DESC";

$resultado = $conexion->query($sql);

$datos = array();
while ($fila = $resultado->fetch_assoc()) {
    $datos[] = $fila;
}

header('Content-Type: application/json');
echo json_encode($datos);
?>



