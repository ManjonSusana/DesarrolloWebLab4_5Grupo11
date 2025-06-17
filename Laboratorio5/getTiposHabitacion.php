<?php
include("conexion.php");
$sql = "SELECT DISTINCT tipo FROM habitaciones";
$res = $conexion->query($sql);
$tipos = [];
while ($row = $res->fetch_assoc()) {
    $tipos[] = $row['tipo'];
}
echo json_encode($tipos);
?>
