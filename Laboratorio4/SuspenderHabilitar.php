<?php
include "conexion.php";

$result = $con->query("SELECT id, correo, nombre, estado FROM usuarios");

echo "<h3>Suspender / Habilitar Cuentas</h3>";
echo "<table border='1'>
        <tr>
          <th>Correo</th>
          <th>Nombre</th>
          <th>Estado</th>
          <th>Acción</th>
        </tr>";

while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $correo = $row['correo'];
    $nombre = $row['nombre'];
    $estado = $row['estado'];

    $nuevaAccion = ($estado === 'activo') ? 'suspender' : 'habilitar';

    echo "<tr>
            <td>$correo</td>
            <td>$nombre</td>
            <td>$estado</td>
            <td>
              <button onclick=\"cambiarEstado($id, '$nuevaAccion')\">$nuevaAccion</button>
            </td>
          </tr>";
}

echo "</table>";
$con->close();
?>
