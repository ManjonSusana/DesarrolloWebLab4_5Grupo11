<?php
include "conexion.php";

$id = $_POST['id'];
$accion = $_POST['accion'];

$nuevoEstado = ($accion === 'suspender') ? 'suspendido' : 'activo';

$stmt = $con->prepare("UPDATE usuarios SET estado = ? WHERE id = ?");
$stmt->bind_param("si", $nuevoEstado, $id);
$stmt->execute();

echo "Estado actualizado a $nuevoEstado";

$stmt->close();
$con->close();
?>
