<?php
include("conexion.php");

$id_reserva = $_POST['id_reserva'];
$id_habitacion = $_POST['id_habitacion'];

// 1. Actualizar la reserva con la habitación asignada
$sql = "UPDATE reservas SET id_habitaciones = $id_habitacion WHERE id = $id_reserva";
if ($conexion->query($sql)) {

    // 2. Cambiar estado de la habitación a 'reservada'
    $sql2 = "UPDATE habitaciones SET estado = 'reservada' WHERE id = $id_habitacion";
    if ($conexion->query($sql2)) {
        echo "Habitación asignada y actualizada correctamente";
    } else {
        echo "Error al cambiar estado de habitación";
    }

} else {
    echo "Error al asignar habitación";
}
?>

