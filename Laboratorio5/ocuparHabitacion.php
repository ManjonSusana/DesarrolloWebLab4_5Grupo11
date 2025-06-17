<?php
include("conexion.php");

$id_reserva = $_POST['id_reserva'];

// Recuperar id_habitaciones desde la reserva
$sql = "SELECT id_habitaciones FROM reservas WHERE id = $id_reserva";
$resultado = $conexion->query($sql);

if ($fila = $resultado->fetch_assoc()) {
    $id_habitacion = $fila['id_habitaciones'];

    if ($id_habitacion) {
        // Cambiar estado de la habitación a 'ocupado'
        $update = "UPDATE habitaciones SET estado = 'ocupado' WHERE id = $id_habitacion";
        if ($conexion->query($update)) {
            echo "Habitación actualizada a ocupado";
        } else {
            echo "Error al actualizar habitación";
        }
    } else {
        echo "No hay habitación asignada a esta reserva";
    }
} else {
    echo "Reserva no encontrada";
}
?>


