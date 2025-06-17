<?php
include("conexion.php");

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$tipo = $_POST['tipo'];
$entrada = $_POST['entrada'];
$salida = $_POST['salida'];

// 1. Insertar en usuarios
$sql_usuario = "INSERT INTO usuarios (nombre, correo, telefono) 
                VALUES ('$nombre', '$correo', '$telefono')";
$conexion->query($sql_usuario);
$id_usuario = $conexion->insert_id;

// 2. Insertar en reservas
$sql_reserva = "INSERT INTO reservas (id_usuario, tipo_habitacion, fecha_entrada, fecha_salida) 
                VALUES ('$id_usuario', '$tipo', '$entrada', '$salida')";

if ($conexion->query($sql_reserva)) {
    echo "Reserva registrada correctamente.";
} else {
    echo "Error al registrar reserva.";
}
?>


