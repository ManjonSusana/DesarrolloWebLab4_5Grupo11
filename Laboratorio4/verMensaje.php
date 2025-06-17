<?php
include("conexion.php");
$id = $_GET['id'];
$sql = "SELECT mensaje FROM correo WHERE id= $id";
$resultado = $con->query($sql);
if ($fila = $resultado->fetch_assoc()) {
    echo $fila['mensaje'];
} else {
    echo "Mensaje no encontrado.";
} 
