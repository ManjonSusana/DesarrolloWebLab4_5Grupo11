<?php
include('conexion.php');

echo "<!DOCTYPE html>";
echo "<html><head><meta charset='UTF-8'><title>Actualizar Estructura de BD</title>";
echo "<style>body{font-family:Arial,sans-serif;padding:20px;background:#f4f4f4;}.result{background:white;padding:15px;margin:10px 0;border-radius:5px;border-left:4px solid #007bff;}.success{border-left-color:#28a745;color:#28a745;}.error{border-left-color:#dc3545;color:#dc3545;}</style>";
echo "</head><body>";

echo "<h1>🔧 Actualizar Estructura de Base de Datos</h1>";

if ($conexion) {
    echo "<div class='result'>✅ Conexión a BD exitosa</div>";
    
    // 1. Verificar estructura actual
    echo "<h2>1. Estructura actual de la tabla usuarios:</h2>";
    $describe = $conexion->query("DESCRIBE usuarios");
    if ($describe) {
        echo "<table border='1' style='border-collapse:collapse; margin:10px 0;'>";
        echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        while ($row = $describe->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['Field']}</td>";
            echo "<td>{$row['Type']}</td>";
            echo "<td>{$row['Null']}</td>";
            echo "<td>{$row['Key']}</td>";
            echo "<td>{$row['Default']}</td>";
            echo "<td>{$row['Extra']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // 2. Verificar si las columnas ya existen
    $columns_needed = ['password', 'tipo_usuario'];
    $existing_columns = [];
    
    $describe = $conexion->query("DESCRIBE usuarios");
    while ($row = $describe->fetch_assoc()) {
        $existing_columns[] = $row['Field'];
    }
    
    echo "<h2>2. Verificar columnas necesarias:</h2>";
    foreach ($columns_needed as $column) {
        if (in_array($column, $existing_columns)) {
            echo "<div class='result success'>✅ Columna '$column' ya existe</div>";
        } else {
            echo "<div class='result error'>❌ Columna '$column' NO existe - necesita ser creada</div>";
        }
    }
    
    // 3. Agregar columnas faltantes
    echo "<h2>3. Agregando columnas faltantes:</h2>";
    
    // Agregar password
    if (!in_array('password', $existing_columns)) {
        $sql_password = "ALTER TABLE usuarios ADD COLUMN password VARCHAR(255) NOT NULL DEFAULT ''";
        if ($conexion->query($sql_password)) {
            echo "<div class='result success'>✅ Columna 'password' agregada exitosamente</div>";
        } else {
            echo "<div class='result error'>❌ Error agregando 'password': " . $conexion->error . "</div>";
        }
    }
    
    // Agregar tipo_usuario
    if (!in_array('tipo_usuario', $existing_columns)) {
        $sql_tipo = "ALTER TABLE usuarios ADD COLUMN tipo_usuario ENUM('administrador', 'cliente') NOT NULL DEFAULT 'cliente'";
        if ($conexion->query($sql_tipo)) {
            echo "<div class='result success'>✅ Columna 'tipo_usuario' agregada exitosamente</div>";
        } else {
            echo "<div class='result error'>❌ Error agregando 'tipo_usuario': " . $conexion->error . "</div>";
        }
    }
    
    // 4. Cambiar campo correo por email si es necesario
    if (in_array('correo', $existing_columns) && !in_array('email', $existing_columns)) {
        $sql_email = "ALTER TABLE usuarios CHANGE correo email VARCHAR(100) NOT NULL";
        if ($conexion->query($sql_email)) {
            echo "<div class='result success'>✅ Campo 'correo' renombrado a 'email'</div>";
        } else {
            echo "<div class='result error'>❌ Error renombrando a 'email': " . $conexion->error . "</div>";
        }
    }
    
    // 5. Insertar usuarios de prueba
    echo "<h2>4. Insertando usuarios de prueba:</h2>";
    
    // Verificar si ya existen usuarios de prueba
    $check_admin = $conexion->query("SELECT * FROM usuarios WHERE email = 'admin@hotel.com'");
    $check_cliente = $conexion->query("SELECT * FROM usuarios WHERE email = 'cliente@test.com'");
    
    if (!$check_admin || $check_admin->num_rows == 0) {
        $sql_admin = "INSERT INTO usuarios (nombre, email, telefono, ci, password, tipo_usuario) VALUES 
                      ('Administrador Sistema', 'admin@hotel.com', '78912345', '12345678', 'admin123', 'administrador')";
        if ($conexion->query($sql_admin)) {
            echo "<div class='result success'>✅ Usuario administrador creado: admin@hotel.com / admin123</div>";
        } else {
            echo "<div class='result error'>❌ Error creando admin: " . $conexion->error . "</div>";
        }
    } else {
        // Actualizar usuario existente
        $sql_update_admin = "UPDATE usuarios SET password = 'admin123', tipo_usuario = 'administrador' WHERE email = 'admin@hotel.com'";
        if ($conexion->query($sql_update_admin)) {
            echo "<div class='result success'>✅ Usuario administrador actualizado: admin@hotel.com / admin123</div>";
        }
    }
    
    if (!$check_cliente || $check_cliente->num_rows == 0) {
        $sql_cliente = "INSERT INTO usuarios (nombre, email, telefono, ci, password, tipo_usuario) VALUES 
                        ('Cliente de Prueba', 'cliente@test.com', '76543210', '87654321', 'cliente123', 'cliente')";
        if ($conexion->query($sql_cliente)) {
            echo "<div class='result success'>✅ Usuario cliente creado: cliente@test.com / cliente123</div>";
        } else {
            echo "<div class='result error'>❌ Error creando cliente: " . $conexion->error . "</div>";
        }
    } else {
        // Actualizar usuario existente
        $sql_update_cliente = "UPDATE usuarios SET password = 'cliente123', tipo_usuario = 'cliente' WHERE email = 'cliente@test.com'";
        if ($conexion->query($sql_update_cliente)) {
            echo "<div class='result success'>✅ Usuario cliente actualizado: cliente@test.com / cliente123</div>";
        }
    }
    
    // 6. Mostrar estructura final
    echo "<h2>5. Estructura final de la tabla usuarios:</h2>";
    $describe_final = $conexion->query("DESCRIBE usuarios");
    if ($describe_final) {
        echo "<table border='1' style='border-collapse:collapse; margin:10px 0;'>";
        echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        while ($row = $describe_final->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['Field']}</td>";
            echo "<td>{$row['Type']}</td>";
            echo "<td>{$row['Null']}</td>";
            echo "<td>{$row['Key']}</td>";
            echo "<td>{$row['Default']}</td>";
            echo "<td>{$row['Extra']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // 7. Mostrar usuarios en el sistema
    echo "<h2>6. Usuarios en el sistema:</h2>";
    $usuarios = $conexion->query("SELECT id, nombre, email, tipo_usuario FROM usuarios");
    if ($usuarios && $usuarios->num_rows > 0) {
        echo "<table border='1' style='border-collapse:collapse; margin:10px 0;'>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Tipo Usuario</th></tr>";
        while ($user = $usuarios->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$user['id']}</td>";
            echo "<td>{$user['nombre']}</td>";
            echo "<td>{$user['email']}</td>";
            echo "<td>{$user['tipo_usuario']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    echo "<div class='result success'>";
    echo "<h3>🎉 ¡Actualización completada!</h3>";
    echo "<p>La base de datos ha sido actualizada correctamente. Ahora puedes usar:</p>";
    echo "<ul>";
    echo "<li><strong>Admin:</strong> admin@hotel.com / admin123</li>";
    echo "<li><strong>Cliente:</strong> cliente@test.com / cliente123</li>";
    echo "</ul>";
    echo "</div>";
    
} else {
    echo "<div class='result error'>❌ Error de conexión a BD</div>";
}

echo "<p><a href='seleccionar_acceso.html' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>🏨 Ir al Sistema</a></p>";
echo "</body></html>";
?>
