<?php
include "conexion.php";

    $correo = $_POST['correo'];
    $passwordPlano = $_POST['password'];
    $passwordHash = password_hash($passwordPlano, PASSWORD_DEFAULT);

    $nombre = $_POST['nombre'];
    $nivel = $_POST['nivel'];

    $stmt = $con->prepare("INSERT INTO usuarios (correo, password, nombre, nivel) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $correo, $passwordHash, $nombre, $nivel);

    if ($stmt->execute()) {
        echo "Usuario registrado correctamente";
    } else {
        echo "Error al registrar usuario";
    }

    $stmt->close();
    $con->close();

?>

