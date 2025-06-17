<?php
include("conexion.php");
$id = $_GET['id'];
$sql = "SELECT bandeja FROM correo WHERE id= $id";
//Cambiar el valor de la bandeja de borrador a salida
$sql2 = "UPDATE correo SET bandeja='salida' WHERE id= $id";
//actulizar el estado de la bandeja de entrada a 'E'
$sql3 = "UPDATE correo SET estado='E' WHERE id= $id";
$resultado = $con->query($sql);
$resultado2 = $con->query($sql2);
$resultado3 = $con->query($sql3);
if (!$resultado || !$resultado2 || !$resultado3) {
    die("Error al actualizar datos: " . $con->error);
}
echo "Enviado con exito";
