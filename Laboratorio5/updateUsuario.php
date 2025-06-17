<?php
include("conexion.php");

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$ci = $_POST['ci'];

$sql = "UPDATE usuarios SET 
            nombre = '$nombre',
            correo = '$correo',
            telefono = '$telefono',
            ci = '$ci'
        WHERE id = $id";

if ($conexion->query($sql)) {
    echo "Usuario actualizado correctamente.";
} else {
    echo "Error al actualizar.";
}
?>
