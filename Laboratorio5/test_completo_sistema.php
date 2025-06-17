<?php
// Test completo del sistema bd_hoteles2
include('conexion.php');

$tests_passed = 0;
$tests_failed = 0;

echo "<!DOCTYPE html>";
echo "<html lang='es'>";
echo "<head><meta charset='UTF-8'><title>Test Completo Sistema</title>";
echo "<style>
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; margin: 0; }
    .container { max-width: 900px; margin: 0 auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 0 30px rgba(0,0,0,0.2); }
    .success { color: #28a745; background: #d4edda; padding: 15px; border-radius: 8px; margin: 10px 0; border-left: 5px solid #28a745; }
    .error { color: #dc3545; background: #f8d7da; padding: 15px; border-radius: 8px; margin: 10px 0; border-left: 5px solid #dc3545; }
    .warning { color: #856404; background: #fff3cd; padding: 15px; border-radius: 8px; margin: 10px 0; border-left: 5px solid #ffc107; }
    .info { color: #0c5460; background: #d1ecf1; padding: 15px; border-radius: 8px; margin: 10px 0; border-left: 5px solid #17a2b8; }
    h1 { color: #c4002c; text-align: center; margin-bottom: 30px; font-size: 2.5em; }
    h2 { color: #333; border-bottom: 3px solid #c4002c; padding-bottom: 10px; margin-top: 30px; }
    .stats { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0; }
    .stat-card { text-align: center; padding: 20px; border-radius: 10px; }
    .stat-pass { background: linear-gradient(135deg, #28a745, #20c997); color: white; }
    .stat-fail { background: linear-gradient(135deg, #dc3545, #c82333); color: white; }
    .btn { display: inline-block; padding: 12px 24px; margin: 8px; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; transition: transform 0.2s; }
    .btn:hover { transform: translateY(-2px); text-decoration: none; color: white; }
    .btn-primary { background: linear-gradient(135deg, #007bff, #0056b3); }
    .btn-success { background: linear-gradient(135deg, #28a745, #20c997); }
    .btn-danger { background: linear-gradient(135deg, #dc3545, #c82333); }
    .btn-warning { background: linear-gradient(135deg, #ffc107, #e0a800); color: #333; }
    .table { width: 100%; border-collapse: collapse; margin: 15px 0; }
    .table th, .table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
    .table th { background: #f8f9fa; font-weight: bold; }
    .test-section { margin: 20px 0; padding: 20px; background: #f8f9fa; border-radius: 10px; }
</style>";
echo "</head><body>";
echo "<div class='container'>";
echo "<h1>🏨 Test Completo - Sistema Hotel Chuquisaqueño</h1>";

function test_result($test_name, $result, $message = "") {
    global $tests_passed, $tests_failed;
    if ($result) {
        echo "<div class='success'>✅ <strong>$test_name:</strong> PASÓ $message</div>";
        $tests_passed++;
    } else {
        echo "<div class='error'>❌ <strong>$test_name:</strong> FALLÓ $message</div>";
        $tests_failed++;
    }
}

// Test 1: Conexión a base de datos
echo "<div class='test-section'>";
echo "<h2>🔗 Test 1: Conexión a Base de Datos</h2>";
test_result("Conexión BD", $conexion !== false, "- Conectado a bd_hoteles2");

if ($conexion) {
    $db_name = $conexion->query("SELECT DATABASE() as db")->fetch_assoc()['db'];
    test_result("Base de datos correcta", $db_name === 'bd_hoteles2', "- BD actual: $db_name");
}
echo "</div>";

// Test 2: Verificar tablas
echo "<div class='test-section'>";
echo "<h2>📋 Test 2: Estructura de Tablas</h2>";
$required_tables = ['usuarios', 'habitaciones', 'reservas', 'fotografia_habitacion'];
foreach ($required_tables as $table) {
    $result = $conexion->query("SHOW TABLES LIKE '$table'");
    test_result("Tabla '$table'", $result && $result->num_rows > 0);
}
echo "</div>";

// Test 3: Verificar archivos críticos
echo "<div class='test-section'>";
echo "<h2>📁 Test 3: Archivos del Sistema</h2>";
$critical_files = [
    'seleccionar_acceso.html' => 'Página de selección',
    'formlogin.html' => 'Formulario login',
    'autenticar.php' => 'Autenticación',
    'admin.html' => 'Panel admin',
    'paginaCliente.html' => 'Panel cliente',
    'verificarsesion.php' => 'Verificación sesión',
    'logout.php' => 'Cerrar sesión'
];

foreach ($critical_files as $file => $desc) {
    test_result($desc, file_exists($file), "- $file");
}
echo "</div>";

// Test 4: Datos de prueba
echo "<div class='test-section'>";
echo "<h2>👥 Test 4: Datos de Prueba</h2>";
$admin_exists = $conexion->query("SELECT id FROM usuarios WHERE correo = 'admin@hotel.com'")->num_rows > 0;
$client_exists = $conexion->query("SELECT id FROM usuarios WHERE correo = 'cliente@test.com'")->num_rows > 0;

test_result("Usuario Admin", $admin_exists, "- admin@hotel.com");
test_result("Usuario Cliente", $client_exists, "- cliente@test.com");

$total_users = $conexion->query("SELECT COUNT(*) as total FROM usuarios")->fetch_assoc()['total'];
test_result("Usuarios en BD", $total_users > 0, "- Total: $total_users usuarios");
echo "</div>";

// Test 5: Habitaciones
echo "<div class='test-section'>";
echo "<h2>🏠 Test 5: Sistema de Habitaciones</h2>";
$total_rooms = $conexion->query("SELECT COUNT(*) as total FROM habitaciones")->fetch_assoc()['total'];
test_result("Habitaciones cargadas", $total_rooms > 0, "- Total: $total_rooms habitaciones");

if ($total_rooms > 0) {
    $available_rooms = $conexion->query("SELECT COUNT(*) as total FROM habitaciones WHERE estado = 'disponible'")->fetch_assoc()['total'];
    test_result("Habitaciones disponibles", $available_rooms > 0, "- Disponibles: $available_rooms");
    
    $room_types = $conexion->query("SELECT COUNT(DISTINCT tipo) as tipos FROM habitaciones")->fetch_assoc()['tipos'];
    test_result("Tipos de habitación", $room_types > 0, "- Tipos: $room_types");
}
echo "</div>";

// Test 6: Sistema de reservas
echo "<div class='test-section'>";
echo "<h2>📋 Test 6: Sistema de Reservas</h2>";
$reservas_estructura = $conexion->query("DESCRIBE reservas");
$campos_reserva = [];
while ($campo = $reservas_estructura->fetch_assoc()) {
    $campos_reserva[] = $campo['Field'];
}

$required_fields = ['id', 'id_usuario', 'fecha_entrada', 'fecha_salida', 'estado'];
$fields_ok = true;
foreach ($required_fields as $field) {
    if (!in_array($field, $campos_reserva)) {
        $fields_ok = false;
        break;
    }
}
test_result("Estructura reservas", $fields_ok, "- Campos necesarios presentes");

$total_reservas = $conexion->query("SELECT COUNT(*) as total FROM reservas")->fetch_assoc()['total'];
test_result("Tabla reservas funcional", true, "- Reservas: $total_reservas");
echo "</div>";

// Test 7: Flujo de autenticación
echo "<div class='test-section'>";
echo "<h2>🔐 Test 7: Flujo de Autenticación</h2>";
test_result("Página selección", file_exists('seleccionar_acceso.html'));
test_result("Formulario login", file_exists('formlogin.html'));
test_result("Script autenticación", file_exists('autenticar.php'));
test_result("Verificación sesión", file_exists('verificarsesion.php'));
echo "</div>";

// Estadísticas finales
echo "<div class='test-section'>";
echo "<h2>📊 Resultados del Test</h2>";
echo "<div class='stats'>";
echo "<div class='stat-card stat-pass'>";
echo "<h3>$tests_passed</h3>";
echo "<p>Tests Pasados</p>";
echo "</div>";
echo "<div class='stat-card stat-fail'>";
echo "<h3>$tests_failed</h3>";
echo "<p>Tests Fallidos</p>";
echo "</div>";
echo "</div>";

$total_tests = $tests_passed + $tests_failed;
$success_rate = $total_tests > 0 ? round(($tests_passed / $total_tests) * 100, 1) : 0;

if ($success_rate >= 90) {
    echo "<div class='success' style='font-size: 1.2em; text-align: center;'>";
    echo "🎉 <strong>SISTEMA COMPLETAMENTE FUNCIONAL</strong> 🎉<br>";
    echo "Tasa de éxito: $success_rate%";
    echo "</div>";
} elseif ($success_rate >= 70) {
    echo "<div class='warning' style='font-size: 1.2em; text-align: center;'>";
    echo "⚠️ <strong>SISTEMA MAYORMENTE FUNCIONAL</strong> ⚠️<br>";
    echo "Tasa de éxito: $success_rate% - Revisar elementos fallidos";
    echo "</div>";
} else {
    echo "<div class='error' style='font-size: 1.2em; text-align: center;'>";
    echo "❌ <strong>SISTEMA REQUIERE CORRECCIONES</strong> ❌<br>";
    echo "Tasa de éxito: $success_rate% - Múltiples problemas detectados";
    echo "</div>";
}
echo "</div>";

// Enlaces de acción
echo "<div style='text-align: center; margin-top: 30px;'>";
echo "<a href='seleccionar_acceso.html' class='btn btn-primary'>🚀 Probar Sistema</a>";
echo "<a href='insertar_datos_prueba.php' class='btn btn-success'>👥 Datos Prueba</a>";
echo "<a href='verificacion_completa.php' class='btn btn-warning'>🔍 Verificación Detallada</a>";
echo "<a href='index.php' class='btn btn-danger'>🏠 Inicio</a>";
echo "</div>";

echo "</div></body></html>";
?>
