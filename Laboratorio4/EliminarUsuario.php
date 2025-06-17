<?php
include "conexion.php";


    $id = $_POST['id'];
    $stmt = $con->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Usuario eliminado correctamente";
    } else {
        echo "Error al eliminar usuario";
    }
    $stmt->close();
    $con->close();

?>
