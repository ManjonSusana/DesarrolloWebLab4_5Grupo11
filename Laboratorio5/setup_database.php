<?php
echo "<h2>Setup de Base de Datos bd_hoteles2</h2>";

try {
    // Connect to MySQL without database selection
    $host = "localhost";
    $usuario = "root";
    $contrasena = "";
    $puerto = 3306;
    
    $mysqli = new mysqli($host, $usuario, $contrasena, "", $puerto);
    
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }
    
    echo "<p style='color: green;'>✓ Conectado a MySQL</p>";
    
    // Check if database exists
    $result = $mysqli->query("SHOW DATABASES LIKE 'bd_hoteles2'");
    
    if ($result->num_rows == 0) {
        echo "<p style='color: orange;'>Database bd_hoteles2 no existe. Creándola...</p>";
        
        // Create database
        if ($mysqli->query("CREATE DATABASE bd_hoteles2")) {
            echo "<p style='color: green;'>✓ Database bd_hoteles2 creada exitosamente</p>";
        } else {
            die("<p style='color: red;'>Error creando database: " . $mysqli->error . "</p>");
        }
    } else {
        echo "<p style='color: green;'>✓ Database bd_hoteles2 ya existe</p>";
    }
    
    // Select the database
    $mysqli->select_db("bd_hoteles2");
    
    // Check if tables exist
    $tables_exist = true;
    $required_tables = ['usuarios', 'habitaciones', 'reservas'];
    
    foreach ($required_tables as $table) {
        $result = $mysqli->query("SHOW TABLES LIKE '$table'");
        if ($result->num_rows == 0) {
            echo "<p style='color: red;'>✗ Tabla '$table' no existe</p>";
            $tables_exist = false;
        } else {
            echo "<p style='color: green;'>✓ Tabla '$table' existe</p>";
        }
    }
    
    if (!$tables_exist) {
        echo "<h3>Ejecutando script de creación de tablas...</h3>";
        
        // Read and execute the SQL file
        $sql_file = 'bd_hoteles2.sql';
        if (file_exists($sql_file)) {
            $sql_content = file_get_contents($sql_file);
            
            // Split SQL commands and execute them
            $sql_commands = explode(';', $sql_content);
            
            foreach ($sql_commands as $command) {
                $command = trim($command);
                if (!empty($command) && !preg_match('/^(USE|CREATE DATABASE)/i', $command)) {
                    if ($mysqli->query($command)) {
                        echo "<p style='color: green;'>✓ Comando ejecutado exitosamente</p>";
                    } else {
                        if (!preg_match('/Table .* already exists/', $mysqli->error)) {
                            echo "<p style='color: red;'>Error ejecutando comando: " . $mysqli->error . "</p>";
                            echo "<p>Comando: " . htmlspecialchars($command) . "</p>";
                        }
                    }
                }
            }
        } else {
            echo "<p style='color: red;'>Archivo bd_hoteles2.sql no encontrado</p>";
        }
    }
    
    // Insert test users if users table is empty
    $result = $mysqli->query("SELECT COUNT(*) as count FROM usuarios");
    $user_count = $result->fetch_assoc()['count'];
    
    if ($user_count == 0) {
        echo "<h3>Insertando usuarios de prueba...</h3>";
        
        $test_users = [
            ['admin@hotel.com', 'admin123', 'administrador'],
            ['cliente@test.com', 'cliente123', 'cliente']
        ];
        
        foreach ($test_users as $user) {
            $email = $user[0];
            $password = password_hash($user[1], PASSWORD_DEFAULT);
            $tipo = $user[2];
            
            $query = "INSERT INTO usuarios (email, password, tipo_usuario) VALUES (?, ?, ?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("sss", $email, $password, $tipo);
            
            if ($stmt->execute()) {
                echo "<p style='color: green;'>✓ Usuario $email creado (password: {$user[1]})</p>";
            } else {
                echo "<p style='color: red;'>Error creando usuario $email: " . $stmt->error . "</p>";
            }
        }
    } else {
        echo "<p style='color: blue;'>ℹ Ya existen $user_count usuarios en el sistema</p>";
    }
    
    echo "<h3>Estado final del sistema:</h3>";
    echo "<p><a href='test_conexion.php' style='background: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>Probar Conexión</a></p>";
    echo "<p><a href='seleccionar_acceso.html' style='background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;'>Ir al Sistema</a></p>";
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>
