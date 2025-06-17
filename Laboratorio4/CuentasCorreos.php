<?php
include "conexion.php";

echo '
  <h3>Registrar Nuevo Usuario</h3>
  <form id="formNuevoUsuario">
    <label>Correo: <input type="email" name="correo" required></label><br>
    <label>Contraseña: <input type="text" name="password" required></label><br>
    <label>Nombre: <input type="text" name="nombre" required></label><br>
    <label>Nivel: <input type="text" name="nivel" required></label><br>
    <button type="submit">Registrar</button><br>
  </form>
  <hr>
';

$result = $con->query("SELECT id, correo, password, nombre, nivel FROM usuarios");

echo "<table border='1'>
        <tr>
            <th>Correo</th>
            <th>Password</th>
            <th>Nombre</th>
            <th>Nivel</th>
            <th>Acciones</th>
        </tr>";

while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $correo = $row['correo'];
    $password = $row['password'];
    $nombre = $row['nombre'];
    $nivel = $row['nivel'];

    echo "<tr>
            <td>$correo</td>
            <td>$password</td>
            <td>$nombre</td>
            <td>$nivel</td>
            <td>
                <button onclick=\"editarUsuario('$id', '$correo', '$password', '$nombre', '$nivel')\">Editar</button>
                <button onclick=\"eliminarUsuario($id)\">Eliminar</button>
            </td>
          </tr>";
}

echo "</table>";
$con->close();
?>

