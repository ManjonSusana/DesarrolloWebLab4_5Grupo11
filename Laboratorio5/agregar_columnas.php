<?php
include('conexion.php');

echo "<!DOCTYPE html>";
echo "<html><head><meta charset='UTF-8'><title>Agregar Columnas Faltantes</title>";
echo "<style>body{font-family:Arial,sans-serif;padding:20px;background:#f4f4f4;}.result{background:white;padding:15px;margin:10px 0;border-radius:5px;}.success{color:green;}.error{color:red;}.warning{color:orange;}</style>";
echo "</head><body>";

echo "<h1>🔧 Agregar Columnas Faltantes a la Tabla usuarios</h1>";

if ($conexion) {
    echo "<div class='result'><p class='success'>✅ Conexión a BD exitosa</p></div>";
    
    // Agregar columna password
    echo "<h2>Agregando columna 'password':</h2>";
    $sql_password = "ALTER TABLE usuarios ADD COLUMN password VARCHAR(255) NOT NULL DEFAULT ''";
    
    if ($conexion->query($sql_password)) {
        echo "<div class='result'><p class='success'>✅ Columna 'password' agregada exitosamente</p></div>";
    } else {
        if (strpos($conexion->error, "Duplicate column name") !== false) {
            echo "<div class='result'><p class='warning'>⚠️ Columna 'password' ya existe</p></div>";
        } else {
            echo "<div class='result'><p class='error'>❌ Error agregando 'password': " . $conexion->error . "</p></div>";
        }
    }
    
    // Agregar columna tipo_usuario
    echo "<h2>Agregando columna 'tipo_usuario':</h2>";
    $sql_tipo = "ALTER TABLE usuarios ADD COLUMN tipo_usuario ENUM('administrador', 'cliente') NOT NULL DEFAULT 'cliente'";
    
    if ($conexion->query($sql_tipo)) {
        echo "<div class='result'><p class='success'>✅ Columna 'tipo_usuario' agregada exitosamente</p></div>";
    } else {
        if (strpos($conexion->error, "Duplicate column name") !== false) {
            echo "<div class='result'><p class='warning'>⚠️ Columna 'tipo_usuario' ya existe</p></div>";
        } else {
            echo "<div class='result'><p class='error'>❌ Error agregando 'tipo_usuario': " . $conexion->error . "</p></div>";
        }
    }
    
    // Mostrar estructura actualizada
    echo "<h2>Estructura actualizada de la tabla:</h2>";
    $describe = $conexion->query("DESCRIBE usuarios");
    if ($describe) {
        echo "<table border='1' style='border-collapse:collapse; margin:10px 0; width:100%;'>";
        echo "<tr style='background:#f8f9fa;'><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        while ($row = $describe->fetch_assoc()) {
            echo "<tr>";
            echo "<td><strong>{$row['Field']}</strong></td>";
            echo "<td>{$row['Type']}</td>";
            echo "<td>{$row['Null']}</td>";
            echo "<td>{$row['Key']}</td>";
            echo "<td>{$row['Default']}</td>";
            echo "<td>{$row['Extra']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // Insertar usuarios de prueba
    echo "<h2>Insertando usuarios de prueba:</h2>";
    
    // Limpiar usuarios existentes con esos emails para evitar duplicados
    $conexion->query("DELETE FROM usuarios WHERE correo IN ('admin@hotel.com', 'cliente@test.com')");
    
    // Insertar admin
    $sql_admin = "INSERT INTO usuarios (nombre, correo, telefono, ci, password, tipo_usuario) VALUES 
                  ('Administrador Sistema', 'admin@hotel.com', '78912345', '12345678', 'admin123', 'administrador')";
    
    if ($conexion->query($sql_admin)) {
        echo "<div class='result'><p class='success'>✅ Usuario administrador creado: admin@hotel.com / admin123</p></div>";
    } else {
        echo "<div class='result'><p class='error'>❌ Error creando admin: " . $conexion->error . "</p></div>";
    }
    
    // Insertar cliente
    $sql_cliente = "INSERT INTO usuarios (nombre, correo, telefono, ci, password, tipo_usuario) VALUES 
                    ('Cliente de Prueba', 'cliente@test.com', '76543210', '87654321', 'cliente123', 'cliente')";
    
    if ($conexion->query($sql_cliente)) {
        echo "<div class='result'><p class='success'>✅ Usuario cliente creado: cliente@test.com / cliente123</p></div>";
    } else {
        echo "<div class='result'><p class='error'>❌ Error creando cliente: " . $conexion->error . "</p></div>";
    }
    
    // Mostrar usuarios creados
    echo "<h2>Usuarios en el sistema:</h2>";
    $usuarios = $conexion->query("SELECT id, nombre, correo, tipo_usuario FROM usuarios");
    if ($usuarios && $usuarios->num_rows > 0) {
        echo "<table border='1' style='border-collapse:collapse; margin:10px 0; width:100%;'>";
        echo "<tr style='background:#f8f9fa;'><th>ID</th><th>Nombre</th><th>Email</th><th>Tipo Usuario</th></tr>";
        while ($user = $usuarios->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$user['id']}</td>";
            echo "<td>{$user['nombre']}</td>";
            echo "<td>{$user['correo']}</td>";
            echo "<td><strong>{$user['tipo_usuario']}</strong></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<div class='result'><p class='warning'>⚠️ No hay usuarios en el sistema</p></div>";
    }
    
    echo "<div class='result success'>";
    echo "<h2>🎉 Configuración Completada</h2>";
    echo "<p><strong>Credenciales de acceso:</strong></p>";
    echo "<ul>";
    echo "<li><strong>Administrador:</strong> admin@hotel.com / admin123</li>";
    echo "<li><strong>Cliente:</strong> cliente@test.com / cliente123</li>";
    echo "</ul>";
    echo "<p><strong>Campo de email:</strong> correo</p>";
    echo "</div>";
    
} else {
    echo "<div class='result'><p class='error'>❌ Error de conexión a BD</p></div>";
}

echo "<br><p><a href='seleccionar_acceso.html' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>🏨 Probar Sistema</a></p>";
echo "</body></html>";
?>
