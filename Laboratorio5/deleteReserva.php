<?php
include("conexion.php");

$id = $_POST['id'];

$sql = "DELETE FROM reservas WHERE id = $id";
if ($conexion->query($sql)) {
    echo "Reserva eliminada correctamente.";
} else {
    echo "Error al eliminar la reserva.";
}
?>
