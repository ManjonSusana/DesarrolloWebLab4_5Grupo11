<?php
include "conexion.php";


    $id = $_POST['id'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $nombre = $_POST['nombre'];
    $nivel = $_POST['nivel'];

    $stmt = $con->prepare("UPDATE usuarios SET correo=?, password=?, nombre=?, nivel=? WHERE id=?");
    $stmt->bind_param("ssssi", $correo, $password, $nombre, $nivel, $id);

    if ($stmt->execute()) {
        echo "Usuario actualizado correctamente";
    } else {
        echo "Error al actualizar usuario";
    }

    $stmt->close();
    $con->close();

?>
