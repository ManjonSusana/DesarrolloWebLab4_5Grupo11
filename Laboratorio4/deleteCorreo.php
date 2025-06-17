<?php
include("conexion.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $con->prepare("DELETE FROM correo WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Correo eliminado correctamente.";
        
    } else {
        echo "Error al eliminar el correo.";
    }

    $stmt->close();
}
?>
