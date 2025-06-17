<?php
// Archivo de prueba de conexión para bd_hoteles2
include('conexion.php');

echo "<!DOCTYPE html>";
echo "<html lang='es'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<title>Prueba de Conexión - bd_hoteles2</title>";
echo "<style>";
echo "body { font-family: Arial, sans-serif; padding: 20px; background: #f4f4f4; }";
echo ".card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto; }";
echo ".success { color: green; } .error { color: red; } .warning { color: orange; }";
echo "code { background: #f0f0f0; padding: 2px 4px; border-radius: 3px; }";
echo "</style>";
echo "</head>";
echo "<body>";
echo "<div class='card'>";
echo "<h2>Prueba de Conexión a Base de Datos bd_hoteles2</h2>";

if ($conexion) {
    echo "<p class='success'>✅ Conexión exitosa a la base de datos bd_hoteles2</p>";
    
    // Probar si existe la tabla usuarios
    $result = $conexion->query("SHOW TABLES LIKE 'usuarios'");
    if ($result->num_rows > 0) {
        echo "<p class='success'>✅ Tabla 'usuarios' encontrada</p>";
        
        // Verificar si hay usuarios
        $users = $conexion->query("SELECT COUNT(*) as total FROM usuarios");
        $userCount = $users->fetch_assoc()['total'];
        echo "<p class='success'>📊 Total de usuarios en la base de datos: " . $userCount . "</p>";
        
        if ($userCount == 0) {
            echo "<p class='warning'>⚠️ No hay usuarios registrados. Necesitas insertar usuarios para poder hacer login.</p>";
            echo "<p>Ejemplo de SQL para insertar un usuario:</p>";
            echo "<code>INSERT INTO usuarios (nombre, correo, telefono, ci) VALUES ('Admin', 'admin@hotel.com', '12345678', '12345678');</code>";
        }
    } else {
        echo "<p class='error'>❌ Tabla 'usuarios' no encontrada</p>";
    }
    
    // Probar tabla habitaciones
    $result = $conexion->query("SHOW TABLES LIKE 'habitaciones'");
    if ($result->num_rows > 0) {
        echo "<p class='success'>✅ Tabla 'habitaciones' encontrada</p>";
        
        $habitaciones = $conexion->query("SELECT COUNT(*) as total FROM habitaciones");
        $habitacionCount = $habitaciones->fetch_assoc()['total'];
        echo "<p class='success'>🏨 Total de habitaciones: " . $habitacionCount . "</p>";
    } else {
        echo "<p class='error'>❌ Tabla 'habitaciones' no encontrada</p>";
    }
    
    // Probar tabla reservas
    $result = $conexion->query("SHOW TABLES LIKE 'reservas'");
    if ($result->num_rows > 0) {
        echo "<p class='success'>✅ Tabla 'reservas' encontrada</p>";
        
        $reservas = $conexion->query("SELECT COUNT(*) as total FROM reservas");
        $reservaCount = $reservas->fetch_assoc()['total'];
        echo "<p class='success'>📋 Total de reservas: " . $reservaCount . "</p>";
    } else {
        echo "<p class='error'>❌ Tabla 'reservas' no encontrada</p>";
    }
    
    // Probar tabla fotografia_habitacion
    $result = $conexion->query("SHOW TABLES LIKE 'fotografia_habitacion'");
    if ($result->num_rows > 0) {
        echo "<p class='success'>✅ Tabla 'fotografia_habitacion' encontrada</p>";
    } else {
        echo "<p class='error'>❌ Tabla 'fotografia_habitacion' no encontrada</p>";
    }
    
} else {
    echo "<p class='error'>❌ Error de conexión: " . mysqli_connect_error() . "</p>";
}

echo "<br><br>";
echo "<a href='formlogin.html' style='background: #c4002c; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>Ir al Login</a>";
echo "<a href='admin.html' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Panel Admin</a>";
echo "</div>";
echo "</body>";
echo "</html>";
?>
