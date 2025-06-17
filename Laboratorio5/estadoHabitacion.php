<?php
include("conexion.php");

$id = $_POST['id'];
$estado = $_POST['estado'];

$sql = "UPDATE habitaciones SET estado = '$estado' WHERE id = $id";
$conexion->query($sql);

if ($conexion->affected_rows > 0) {
    echo "Estado actualizado";
} else {
    echo "Error al actualizar";
}

if ($estado == 'disponible') {
    // Eliminar relación con la reserva si existe
    $sqlReset = "UPDATE reservas SET id_habitaciones = NULL WHERE id_habitaciones = $id";
    $conexion->query($sqlReset);
}

?>
