<?php
include("conexion.php");

$id = $_POST['id'];

$sql = "DELETE FROM usuarios WHERE id = $id";
$conexion->query($sql);

if ($conexion->affected_rows > 0) {
    echo "Usuario eliminado correctamente.";
} else {
    echo "No se pudo eliminar el usuario.";
}
?>
