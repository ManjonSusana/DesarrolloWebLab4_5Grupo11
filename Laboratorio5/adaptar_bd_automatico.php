<?php
include('conexion.php');

echo "<!DOCTYPE html>";
echo "<html><head><meta charset='UTF-8'><title>Adaptar BD Automáticamente</title>";
echo "<style>body{font-family:Arial,sans-serif;padding:20px;background:#f4f4f4;}.result{background:white;padding:15px;margin:10px 0;border-radius:5px;border-left:4px solid #007bff;}.success{border-left-color:#28a745;}.error{border-left-color:#dc3545;}.warning{border-left-color:#ffc107;}</style>";
echo "</head><body>";

echo "<h1>🔧 Adaptación Automática de Base de Datos</h1>";

if ($conexion) {
    // 1. Obtener estructura actual
    $describe = $conexion->query("DESCRIBE usuarios");
    $campos_existentes = [];
    
    if ($describe) {
        while ($row = $describe->fetch_assoc()) {
            $campos_existentes[] = $row['Field'];
        }
        
        echo "<div class='result'>";
        echo "<h3>Campos existentes en la tabla usuarios:</h3>";
        echo "<p>" . implode(', ', $campos_existentes) . "</p>";
        echo "</div>";
        
        // 2. Verificar y agregar campos faltantes
        $cambios_realizados = [];
        
        // Agregar password si no existe
        if (!in_array('password', $campos_existentes)) {
            echo "<div class='result warning'>";
            echo "<h3>Agregando campo 'password'...</h3>";
            $sql = "ALTER TABLE usuarios ADD COLUMN password VARCHAR(255) NOT NULL DEFAULT ''";
            if ($conexion->query($sql)) {
                echo "<p class='success'>✅ Campo 'password' agregado exitosamente</p>";
                $cambios_realizados[] = "password agregado";
            } else {
                echo "<p class='error'>❌ Error: " . $conexion->error . "</p>";
            }
            echo "</div>";
        } else {
            echo "<div class='result success'><p>✅ Campo 'password' ya existe</p></div>";
        }
        
        // Agregar tipo_usuario si no existe
        if (!in_array('tipo_usuario', $campos_existentes)) {
            echo "<div class='result warning'>";
            echo "<h3>Agregando campo 'tipo_usuario'...</h3>";
            $sql = "ALTER TABLE usuarios ADD COLUMN tipo_usuario ENUM('administrador', 'cliente') NOT NULL DEFAULT 'cliente'";
            if ($conexion->query($sql)) {
                echo "<p class='success'>✅ Campo 'tipo_usuario' agregado exitosamente</p>";
                $cambios_realizados[] = "tipo_usuario agregado";
            } else {
                echo "<p class='error'>❌ Error: " . $conexion->error . "</p>";
            }
            echo "</div>";
        } else {
            echo "<div class='result success'><p>✅ Campo 'tipo_usuario' ya existe</p></div>";
        }
        
        // 3. Determinar si usar 'correo' o 'email'
        $campo_email = '';
        if (in_array('email', $campos_existentes)) {
            $campo_email = 'email';
            echo "<div class='result success'><p>✅ Usando campo 'email'</p></div>";
        } elseif (in_array('correo', $campos_existentes)) {
            $campo_email = 'correo';
            echo "<div class='result success'><p>✅ Usando campo 'correo'</p></div>";
        } else {
            echo "<div class='result error'><p>❌ No se encontró campo de email</p></div>";
        }
        
        // 4. Insertar/actualizar usuarios de prueba
        if ($campo_email) {
            echo "<div class='result'>";
            echo "<h3>Configurando usuarios de prueba...</h3>";
            
            // Usuario admin
            $check_admin = $conexion->query("SELECT * FROM usuarios WHERE $campo_email = 'admin@hotel.com'");
            if ($check_admin && $check_admin->num_rows > 0) {
                // Actualizar usuario existente
                $sql = "UPDATE usuarios SET password = 'admin123', tipo_usuario = 'administrador' WHERE $campo_email = 'admin@hotel.com'";
                if ($conexion->query($sql)) {
                    echo "<p>✅ Usuario admin actualizado: admin@hotel.com / admin123</p>";
                }
            } else {
                // Crear usuario admin
                if (in_array('nombre', $campos_existentes)) {
                    $sql = "INSERT INTO usuarios (nombre, $campo_email, telefono, ci, password, tipo_usuario) VALUES 
                            ('Administrador', 'admin@hotel.com', '78912345', '12345678', 'admin123', 'administrador')";
                } else {
                    $sql = "INSERT INTO usuarios ($campo_email, password, tipo_usuario) VALUES 
                            ('admin@hotel.com', 'admin123', 'administrador')";
                }
                
                if ($conexion->query($sql)) {
                    echo "<p>✅ Usuario admin creado: admin@hotel.com / admin123</p>";
                } else {
                    echo "<p>❌ Error creando admin: " . $conexion->error . "</p>";
                }
            }
            
            // Usuario cliente
            $check_cliente = $conexion->query("SELECT * FROM usuarios WHERE $campo_email = 'cliente@test.com'");
            if ($check_cliente && $check_cliente->num_rows > 0) {
                // Actualizar usuario existente
                $sql = "UPDATE usuarios SET password = 'cliente123', tipo_usuario = 'cliente' WHERE $campo_email = 'cliente@test.com'";
                if ($conexion->query($sql)) {
                    echo "<p>✅ Usuario cliente actualizado: cliente@test.com / cliente123</p>";
                }
            } else {
                // Crear usuario cliente
                if (in_array('nombre', $campos_existentes)) {
                    $sql = "INSERT INTO usuarios (nombre, $campo_email, telefono, ci, password, tipo_usuario) VALUES 
                            ('Cliente Prueba', 'cliente@test.com', '76543210', '87654321', 'cliente123', 'cliente')";
                } else {
                    $sql = "INSERT INTO usuarios ($campo_email, password, tipo_usuario) VALUES 
                            ('cliente@test.com', 'cliente123', 'cliente')";
                }
                
                if ($conexion->query($sql)) {
                    echo "<p>✅ Usuario cliente creado: cliente@test.com / cliente123</p>";
                } else {
                    echo "<p>❌ Error creando cliente: " . $conexion->error . "</p>";
                }
            }
            echo "</div>";
        }
        
        // 5. Mostrar usuarios actuales
        echo "<div class='result'>";
        echo "<h3>Usuarios en el sistema:</h3>";
        $usuarios = $conexion->query("SELECT id, $campo_email as email, tipo_usuario FROM usuarios");
        if ($usuarios && $usuarios->num_rows > 0) {
            echo "<table border='1' style='border-collapse:collapse; margin:10px 0;'>";
            echo "<tr><th>ID</th><th>Email</th><th>Tipo</th></tr>";
            while ($user = $usuarios->fetch_assoc()) {
                echo "<tr><td>{$user['id']}</td><td>{$user['email']}</td><td>{$user['tipo_usuario']}</td></tr>";
            }
            echo "</table>";
        }
        echo "</div>";
        
        // 6. Crear archivo de configuración para autenticar.php
        echo "<div class='result'>";
        echo "<h3>Creando configuración para autenticar.php...</h3>";
        
        $config_content = "<?php\n";
        $config_content .= "// Configuración automática generada\n";
        $config_content .= "define('CAMPO_EMAIL', '$campo_email');\n";
        $config_content .= "?>";
        
        file_put_contents('config_bd.php', $config_content);
        echo "<p>✅ Archivo config_bd.php creado</p>";
        echo "</div>";
        
        echo "<div class='result success'>";
        echo "<h3>🎉 Configuración completada</h3>";
        echo "<p><strong>Credenciales de acceso:</strong></p>";
        echo "<ul>";
        echo "<li><strong>Administrador:</strong> admin@hotel.com / admin123</li>";
        echo "<li><strong>Cliente:</strong> cliente@test.com / cliente123</li>";
        echo "</ul>";
        echo "<p>Campo de email utilizado: <strong>$campo_email</strong></p>";
        echo "</div>";
        
    } else {
        echo "<div class='result error'><p>Error obteniendo estructura: " . $conexion->error . "</p></div>";
    }
} else {
    echo "<div class='result error'><p>Error de conexión a la base de datos</p></div>";
}

echo "<p><a href='seleccionar_acceso.html' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>🏨 Probar Sistema</a></p>";
echo "</body></html>";
?>
