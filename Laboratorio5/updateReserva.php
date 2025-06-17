<?php
include("conexion.php");

$id = $_POST['id'];
$tipo = $_POST['tipo'];
$entrada = $_POST['entrada'];
$salida = $_POST['salida'];

$sql = "UPDATE reservas SET 
            tipo_habitacion = '$tipo',
            fecha_entrada = '$entrada',
            fecha_salida = '$salida'
        WHERE id = $id";

if ($conexion->query($sql)) {
    echo "Reserva actualizada correctamente.";
} else {
    echo "Error al actualizar la reserva.";
}
?>


