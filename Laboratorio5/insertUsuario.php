<?php
include("conexion.php");

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$ci = $_POST['ci'];

$sql = "INSERT INTO usuarios (nombre, correo, telefono, ci) VALUES ('$nombre', '$correo', '$telefono', '$ci')";
if ($conexion->query($sql)) {
    echo "Usuario registrado correctamente.";
} else {
    echo "Error al registrar usuario.";
}
?>
