<?php
include("conexion.php");

$id = $_POST['id'];
$estado = $_POST['estado'];

$sql = "UPDATE reservas SET estado = '$estado' WHERE id = $id";
$conexion->query($sql);

if ($conexion->affected_rows > 0) {
    echo "Estado actualizado.";
} else {
    echo "No se pudo actualizar.";
}
?>
