<?php
include "conexion.php";


    $asunto = $_POST["asunto"];
    $mensaje = $_POST["mensaje"];

    $result = $con->query("SELECT correo FROM usuarios");

    while ($row = $result->fetch_assoc()) {
        $correoDestino = $row['correo'];

        $con->query("INSERT INTO correo (bandeja, correo, asunto, mensaje, estado)
                    VALUES ('entrada', '$correoDestino', '$asunto', '$mensaje', 'no leído')");
    }

    echo "Correo enviado a todos los usuarios.";


$con->close();
?>

