<?php
// Archivo para insertar datos de prueba en bd_hoteles2
include('conexion.php');

echo "<!DOCTYPE html>";
echo "<html lang='es'>";
echo "<head><meta charset='UTF-8'><title>Insertar Datos de Prueba</title>";
echo "<style>body{font-family:Arial,sans-serif;padding:20px;background:#f4f4f4;}.card{background:white;padding:20px;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,0.1);max-width:600px;margin:0 auto;}.success{color:green;}.error{color:red;}</style>";
echo "</head><body><div class='card'>";
echo "<h2>Insertar Datos de Prueba - bd_hoteles2</h2>";

if ($conexion) {
    // Primero, verificar la estructura de la tabla usuarios
    $describe_result = $conexion->query("DESCRIBE usuarios");
    echo "<h3>Estructura de la tabla usuarios:</h3>";
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    while ($row = $describe_result->fetch_assoc()) {
        echo "<tr><td>{$row['Field']}</td><td>{$row['Type']}</td><td>{$row['Null']}</td><td>{$row['Key']}</td><td>{$row['Default']}</td></tr>";
    }
    echo "</table>";
    
    // Insertar usuario administrador de prueba
    $sql_admin = "INSERT INTO usuarios (email, password, tipo_usuario) VALUES 
                  ('admin@hotel.com', 'admin123', 'administrador')
                  ON DUPLICATE KEY UPDATE 
                  password = 'admin123', tipo_usuario = 'administrador'";
    
    if ($conexion->query($sql_admin)) {
        echo "<p class='success'>✅ Usuario administrador insertado/actualizado: admin@hotel.com / admin123</p>";
    } else {
        echo "<p class='error'>❌ Error al insertar admin: " . $conexion->error . "</p>";
    }
    
    // Insertar usuario cliente de prueba
    $sql_cliente = "INSERT INTO usuarios (email, password, tipo_usuario) VALUES 
                    ('cliente@test.com', 'cliente123', 'cliente')
                    ON DUPLICATE KEY UPDATE 
                    password = 'cliente123', tipo_usuario = 'cliente'";
    
    if ($conexion->query($sql_cliente)) {
        echo "<p class='success'>✅ Usuario cliente insertado/actualizado: cliente@test.com / cliente123</p>";
    } else {
        echo "<p class='error'>❌ Error al insertar cliente: " . $conexion->error . "</p>";
    }
    
    // Verificar usuarios insertados
    echo "<h3>Usuarios en el sistema:</h3>";
    $users_result = $conexion->query("SELECT email, tipo_usuario FROM usuarios");
    if ($users_result && $users_result->num_rows > 0) {
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr><th>Email</th><th>Tipo Usuario</th></tr>";
        while ($user = $users_result->fetch_assoc()) {
            echo "<tr><td>{$user['email']}</td><td>{$user['tipo_usuario']}</td></tr>";
        }
        echo "</table>";
    }
    
    // Verificar estado de habitaciones
    $habitaciones_count = $conexion->query("SELECT COUNT(*) as total FROM habitaciones")->fetch_assoc()['total'];
    if ($habitaciones_count > 0) {
        echo "<p class='success'>✅ Habitaciones disponibles en el sistema: $habitaciones_count</p>";
    } else {
        echo "<p class='error'>⚠️ No hay habitaciones en el sistema. Verificar importación de bd_hoteles2.sql</p>";
    }
    
    // Mostrar usuarios existentes
    echo "<h3>Usuarios en la base de datos:</h3>";
    $result = $conexion->query("SELECT id, nombre, correo, telefono FROM usuarios");
    if ($result) {
        echo "<table style='width:100%;border-collapse:collapse;'>";
        echo "<tr style='background:#f0f0f0;'><th style='border:1px solid #ddd;padding:8px;'>ID</th><th style='border:1px solid #ddd;padding:8px;'>Nombre</th><th style='border:1px solid #ddd;padding:8px;'>Correo</th><th style='border:1px solid #ddd;padding:8px;'>Teléfono</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td style='border:1px solid #ddd;padding:8px;'>" . $row['id'] . "</td>";
            echo "<td style='border:1px solid #ddd;padding:8px;'>" . htmlspecialchars($row['nombre']) . "</td>";
            echo "<td style='border:1px solid #ddd;padding:8px;'>" . htmlspecialchars($row['correo']) . "</td>";
            echo "<td style='border:1px solid #ddd;padding:8px;'>" . htmlspecialchars($row['telefono']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    echo "<br><h3>Instrucciones para probar el login:</h3>";
    echo "<p>1. Para acceso como <strong>Administrador</strong>:</p>";
    echo "<ul><li>Tipo: Administrador</li><li>Correo: admin@hotel.com</li><li>Contraseña: cualquier cosa (no se valida por ahora)</li></ul>";
    echo "<p>2. Para acceso como <strong>Cliente</strong>:</p>";
    echo "<ul><li>Tipo: Cliente</li><li>Correo: cliente@test.com</li><li>Contraseña: cualquier cosa (no se valida por ahora)</li></ul>";
    
} else {
    echo "<p class='error'>❌ Error de conexión a la base de datos</p>";
}

echo "<br><br>";
echo "<a href='formlogin.html' style='background:#c4002c;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;margin-right:10px;'>Probar Login</a>";
echo "<a href='test_conexion_bd_hoteles2.php' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Test Conexión</a>";
echo "</div></body></html>";
?>
