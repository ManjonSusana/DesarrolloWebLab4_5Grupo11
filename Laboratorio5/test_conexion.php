<?php
// Archivo de prueba de conexión
include('conexion.php');

echo "<!DOCTYPE html>";
echo "<html lang='es'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<title>Prueba de Conexión</title>";
echo "<style>";
echo "body { font-family: Arial, sans-serif; padding: 20px; background: #f4f4f4; }";
echo ".card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }";
echo ".success { color: green; } .error { color: red; }";
echo "</style>";
echo "</head>";
echo "<body>";
echo "<div class='card'>";
echo "<h2>Prueba de Conexión a Base de Datos</h2>";

if ($conexion) {
    echo "<p class='success'>✅ Conexión exitosa a la base de datos</p>";
      // Probar si existe la tabla usuarios
    $result = $conexion->query("SHOW TABLES LIKE 'usuarios'");
    if ($result->num_rows > 0) {
        echo "<p class='success'>✅ Tabla 'usuarios' encontrada</p>";
        
        // Verificar si hay usuarios
        $users = $conexion->query("SELECT COUNT(*) as total FROM usuarios");
        $userCount = $users->fetch_assoc()['total'];
        echo "<p class='success'>✅ Total de usuarios en la base de datos: " . $userCount . "</p>";
        
        if ($userCount == 0) {
            echo "<p class='error'>⚠️ No hay usuarios registrados. Necesitas insertar usuarios para poder hacer login.</p>";
            echo "<p>Ejemplo de SQL para insertar un usuario:</p>";
            echo "<code>INSERT INTO usuarios (email, password, tipo_usuario) VALUES ('admin@hotel.com', '123456', 'administrador');</code>";
        }
    } else {
        echo "<p class='error'>❌ Tabla 'usuarios' no encontrada</p>";
    }
    
    // Probar tabla reservas
    $result = $conexion->query("SHOW TABLES LIKE 'reservas'");
    if ($result->num_rows > 0) {
        echo "<p class='success'>✅ Tabla 'reservas' encontrada</p>";
    } else {
        echo "<p class='error'>❌ Tabla 'reservas' no encontrada</p>";
    }
    
    // Probar tabla habitaciones
    $result = $conexion->query("SHOW TABLES LIKE 'habitaciones'");
    if ($result->num_rows > 0) {
        echo "<p class='success'>✅ Tabla 'habitaciones' encontrada</p>";
    } else {
        echo "<p class='error'>❌ Tabla 'habitaciones' no encontrada</p>";
    }
    
} else {
    echo "<p class='error'>❌ Error de conexión: " . mysqli_connect_error() . "</p>";
}

echo "<br><a href='seleccionar_acceso.html' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Ir al Sistema</a>";
echo "</div>";
echo "</body>";
echo "</html>";
?>
