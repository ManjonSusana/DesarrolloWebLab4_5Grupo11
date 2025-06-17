<?php
include "conexion.php";
$usuarios = $con->query("SELECT nombre, correo FROM usuarios");

while ($user = $usuarios->fetch_assoc()) {
    $correoUsuario = $user['correo'];
    $nombreUsuario = $user['nombre'];

    echo "<h3>Correos para: $nombreUsuario ($correoUsuario)</h3>";

    $correo = $con->query("SELECT bandeja, asunto, mensaje, estado FROM correo WHERE correo = '$correoUsuario'");

    if ($correo->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                  <th>Bandeja</th>
                  <th>Asunto</th>
                  <th>Mensaje</th>
                  <th>Estado</th>
                </tr>";
        while ($c = $correo->fetch_assoc()) {
            echo "<tr>
                    <td>{$c['bandeja']}</td>
                    <td>{$c['asunto']}</td>
                    <td>{$c['mensaje']}</td>
                    <td>{$c['estado']}</td>
                  </tr>";
        }
        echo "</table><br>";
    } else {
        echo "<p style='color:gray'>Sin correos.</p><br>";
    }
}

$con->close();
?>

