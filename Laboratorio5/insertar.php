<?php session_start();
include("conexion.php");

$fechaI = $_POST["fecha_ing"];
$fechaS = $_POST["fecha_sal"];
$id_habitacion = $_POST["id_habitacion"];
$id_usuario = $_POST["id_usuario"];

// Obtener el tipo de habitación
$sql_tipo = "SELECT tipo FROM habitaciones WHERE id = $id_habitacion";
$result_tipo = $conexion->query($sql_tipo);
$tipo_habitacion = 'individual'; // valor por defecto
if ($result_tipo && $row_tipo = $result_tipo->fetch_assoc()) {
    $tipo_habitacion = $row_tipo['tipo'];
}

$sql = "INSERT INTO reservas (fecha_entrada, fecha_salida, id_habitaciones, id_usuario, tipo_habitacion, estado) 
        VALUES ('$fechaI', '$fechaS', '$id_habitacion', '$id_usuario', '$tipo_habitacion', 'pendiente')";
$result = $conexion->query($sql);  
if(!$result){
    die("Error al insertar datos: " . $conexion->error);
}
?>
<div class="alert alert-success text-center">
    <i class="fas fa-check-circle me-2"></i>
    ✅ Reserva creada con éxito
</div>
