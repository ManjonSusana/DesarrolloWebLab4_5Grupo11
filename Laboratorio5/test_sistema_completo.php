<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Completo del Sistema Hotelero</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 20px;
            background: #f5f5f5;
        }
        .test-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .warning { color: #ffc107; }
        .info { color: #17a2b8; }
        .test-section {
            border-left: 4px solid #007bff;
            padding-left: 15px;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
        }
        .btn:hover { background: #0056b3; }
        .btn-success { background: #28a745; }
        .btn-danger { background: #dc3545; }
        .btn-warning { background: #ffc107; color: #000; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th { background: #f8f9fa; }
        .code {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            font-family: monospace;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="test-container">
        <h1>🏨 Test Completo del Sistema de Gestión Hotelera</h1>
        <p><strong>Fecha:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
        
        <?php
        $test_results = [];
        $overall_status = true;
        
        // Test 1: Database Connection
        echo "<div class='test-section'>";
        echo "<h2>🔗 Test 1: Conexión a Base de Datos</h2>";
        
        try {
            include('conexion.php');
            if ($conexion && !$conexion->connect_error) {
                echo "<p class='success'>✅ Conexión a bd_hoteles2 exitosa</p>";
                $test_results['database'] = true;
            } else {
                echo "<p class='error'>❌ Error de conexión: " . ($conexion ? $conexion->connect_error : 'Variable $conexion no definida') . "</p>";
                $test_results['database'] = false;
                $overall_status = false;
            }
        } catch (Exception $e) {
            echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
            $test_results['database'] = false;
            $overall_status = false;
        }
        echo "</div>";
        
        // Test 2: Table Structure
        if ($test_results['database']) {
            echo "<div class='test-section'>";
            echo "<h2>🗃️ Test 2: Estructura de Tablas</h2>";
            
            $required_tables = ['usuarios', 'habitaciones', 'reservas'];
            $tables_ok = true;
            
            foreach ($required_tables as $table) {
                $result = $conexion->query("SHOW TABLES LIKE '$table'");
                if ($result && $result->num_rows > 0) {
                    echo "<p class='success'>✅ Tabla '$table' existe</p>";
                    
                    // Count records
                    $count_result = $conexion->query("SELECT COUNT(*) as count FROM $table");
                    if ($count_result) {
                        $count = $count_result->fetch_assoc()['count'];
                        echo "<p class='info'>&nbsp;&nbsp;&nbsp;Registros: $count</p>";
                    }
                } else {
                    echo "<p class='error'>❌ Tabla '$table' no existe</p>";
                    $tables_ok = false;
                    $overall_status = false;
                }
            }
            $test_results['tables'] = $tables_ok;
            echo "</div>";
        }
        
        // Test 3: User Authentication System
        if ($test_results['database']) {
            echo "<div class='test-section'>";
            echo "<h2>👤 Test 3: Sistema de Autenticación</h2>";
            
            // Check users
            $users_result = $conexion->query("SELECT email, tipo_usuario FROM usuarios LIMIT 5");
            if ($users_result && $users_result->num_rows > 0) {
                echo "<p class='success'>✅ Usuarios encontrados en el sistema:</p>";
                echo "<table>";
                echo "<tr><th>Email</th><th>Tipo de Usuario</th></tr>";
                while ($user = $users_result->fetch_assoc()) {
                    echo "<tr><td>{$user['email']}</td><td>{$user['tipo_usuario']}</td></tr>";
                }
                echo "</table>";
                $test_results['users'] = true;
            } else {
                echo "<p class='error'>❌ No hay usuarios en el sistema</p>";
                echo "<p class='warning'>⚠️ Para crear usuarios de prueba, ejecuta: <a href='insertar_datos_prueba.php'>insertar_datos_prueba.php</a></p>";
                $test_results['users'] = false;
            }
            echo "</div>";
        }
        
        // Test 4: File Structure
        echo "<div class='test-section'>";
        echo "<h2>📁 Test 4: Estructura de Archivos</h2>";
        
        $required_files = [
            'seleccionar_acceso.html' => 'Página de selección de acceso',
            'formlogin.html' => 'Formulario de login',
            'autenticar.php' => 'Script de autenticación',
            'admin.html' => 'Panel de administrador',
            'paginaCliente.html' => 'Panel de cliente',
            'verificarsesion.php' => 'Verificación de sesión',
            'logout.php' => 'Cerrar sesión'
        ];
        
        $files_ok = true;
        foreach ($required_files as $file => $description) {
            if (file_exists($file)) {
                echo "<p class='success'>✅ $file - $description</p>";
            } else {
                echo "<p class='error'>❌ $file - $description (NO ENCONTRADO)</p>";
                $files_ok = false;
                $overall_status = false;
            }
        }
        $test_results['files'] = $files_ok;
        echo "</div>";
        
        // Test 5: Session Management
        echo "<div class='test-section'>";
        echo "<h2>🔐 Test 5: Gestión de Sesiones</h2>";
        
        if (isset($_SESSION)) {
            echo "<p class='success'>✅ Sesiones PHP funcionando</p>";
            if (isset($_SESSION['usuario'])) {
                echo "<p class='info'>ℹ️ Usuario actual: {$_SESSION['usuario']} ({$_SESSION['tipo_usuario']})</p>";
                echo "<p><a href='logout.php' class='btn btn-warning'>Cerrar Sesión</a></p>";
            } else {
                echo "<p class='info'>ℹ️ No hay sesión activa</p>";
            }
            $test_results['session'] = true;
        } else {
            echo "<p class='error'>❌ Error en la configuración de sesiones</p>";
            $test_results['session'] = false;
            $overall_status = false;
        }
        echo "</div>";
        
        // Summary
        echo "<div class='test-section'>";
        echo "<h2>📊 Resumen de Pruebas</h2>";
        
        $passed = array_sum($test_results);
        $total = count($test_results);
        
        echo "<table>";
        echo "<tr><th>Componente</th><th>Estado</th></tr>";
        foreach ($test_results as $test => $result) {
            $status = $result ? "<span class='success'>✅ PASÓ</span>" : "<span class='error'>❌ FALLÓ</span>";
            $test_name = ucfirst(str_replace('_', ' ', $test));
            echo "<tr><td>$test_name</td><td>$status</td></tr>";
        }
        echo "</table>";
        
        echo "<h3>Estado General del Sistema:</h3>";
        if ($overall_status) {
            echo "<p class='success'>🎉 ¡SISTEMA COMPLETAMENTE FUNCIONAL! ($passed/$total pruebas pasaron)</p>";
        } else {
            echo "<p class='error'>⚠️ Sistema tiene problemas ($passed/$total pruebas pasaron)</p>";
        }
        echo "</div>";
        
        // Action Buttons
        echo "<div class='test-section'>";
        echo "<h2>🎮 Acciones del Sistema</h2>";
        echo "<p><a href='seleccionar_acceso.html' class='btn btn-success'>🏨 Ir al Sistema</a></p>";
        echo "<p><a href='setup_database.php' class='btn btn-warning'>🔧 Configurar Base de Datos</a></p>";
        echo "<p><a href='insertar_datos_prueba.php' class='btn'>👥 Insertar Usuarios de Prueba</a></p>";
        echo "<p><a href='test_conexion.php' class='btn'>🔗 Test de Conexión Básico</a></p>";
        echo "</div>";
        
        // Test Credentials
        if ($test_results['users']) {
            echo "<div class='test-section'>";
            echo "<h2>🔑 Credenciales de Prueba</h2>";
            echo "<div class='code'>";
            echo "<strong>Administrador:</strong><br>";
            echo "Email: admin@hotel.com<br>";
            echo "Password: admin123<br><br>";
            echo "<strong>Cliente:</strong><br>";
            echo "Email: cliente@test.com<br>";
            echo "Password: cliente123";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
    
    <script>
        // Auto-refresh every 30 seconds if there are failures
        <?php if (!$overall_status): ?>
        setTimeout(function() {
            location.reload();
        }, 30000);
        <?php endif; ?>
    </script>
</body>
</html>
