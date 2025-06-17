<?php
// Verificación completa del sistema bd_hoteles2
include('conexion.php');

$errores = [];
$warnings = [];
$exitos = [];

echo "<!DOCTYPE html>";
echo "<html lang='es'>";
echo "<head><meta charset='UTF-8'><title>Verificación Sistema Hotel</title>";
echo "<style>
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; background: #f5f5f5; }
    .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
    .success { color: #28a745; background: #d4edda; padding: 10px; border-radius: 5px; margin: 5px 0; }
    .error { color: #dc3545; background: #f8d7da; padding: 10px; border-radius: 5px; margin: 5px 0; }
    .warning { color: #856404; background: #fff3cd; padding: 10px; border-radius: 5px; margin: 5px 0; }
    .info { color: #0c5460; background: #d1ecf1; padding: 10px; border-radius: 5px; margin: 5px 0; }
    h1 { color: #c4002c; text-align: center; }
    h2 { color: #333; border-bottom: 2px solid #c4002c; padding-bottom: 5px; }
    table { width: 100%; border-collapse: collapse; margin: 10px 0; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
    .btn { display: inline-block; padding: 10px 20px; margin: 5px; color: white; text-decoration: none; border-radius: 5px; }
    .btn-primary { background: #007bff; }
    .btn-success { background: #28a745; }
    .btn-danger { background: #dc3545; }
</style>";
echo "</head><body>";
echo "<div class='container'>";
echo "<h1>🏨 Verificación Sistema Hotel Chuquisaqueño</h1>";

// Verificar conexión a base de datos
echo "<h2>1. 🔗 Conexión a Base de Datos</h2>";
if ($conexion) {
    echo "<div class='success'>✅ Conexión exitosa a bd_hoteles2</div>";
    $exitos[] = "Conexión a base de datos";
} else {
    echo "<div class='error'>❌ Error de conexión: " . mysqli_connect_error() . "</div>";
    $errores[] = "Conexión a base de datos";
}

// Verificar tablas
echo "<h2>2. 📋 Verificación de Tablas</h2>";
$tablas_requeridas = ['usuarios', 'habitaciones', 'reservas', 'fotografia_habitacion'];
foreach ($tablas_requeridas as $tabla) {
    $result = $conexion->query("SHOW TABLES LIKE '$tabla'");
    if ($result && $result->num_rows > 0) {
        echo "<div class='success'>✅ Tabla '$tabla' existe</div>";
        $exitos[] = "Tabla $tabla";
        
        // Contar registros
        $count = $conexion->query("SELECT COUNT(*) as total FROM $tabla");
        if ($count) {
            $total = $count->fetch_assoc()['total'];
            echo "<div class='info'>📊 Registros en '$tabla': $total</div>";
        }
    } else {
        echo "<div class='error'>❌ Tabla '$tabla' no encontrada</div>";
        $errores[] = "Tabla $tabla";
    }
}

// Verificar archivos críticos
echo "<h2>3. 📁 Verificación de Archivos</h2>";
$archivos_criticos = [
    'conexion.php' => 'Conexión a BD',
    'autenticar.php' => 'Autenticación',
    'formlogin.html' => 'Formulario Login',
    'admin.html' => 'Panel Admin',
    'paginaCliente.html' => 'Panel Cliente',
    'readUsuarios.php' => 'Leer Usuarios',
    'readHabitaciones.php' => 'Leer Habitaciones',
    'readReservas.php' => 'Leer Reservas',
    'main.js' => 'JavaScript Principal'
];

foreach ($archivos_criticos as $archivo => $descripcion) {
    if (file_exists($archivo)) {
        echo "<div class='success'>✅ $descripcion ($archivo)</div>";
        $exitos[] = "Archivo $archivo";
    } else {
        echo "<div class='error'>❌ $descripcion ($archivo) no encontrado</div>";
        $errores[] = "Archivo $archivo";
    }
}

// Verificar datos de prueba
echo "<h2>4. 👥 Usuarios de Prueba</h2>";
$usuarios = $conexion->query("SELECT nombre, correo FROM usuarios WHERE correo IN ('admin@hotel.com', 'cliente@test.com')");
if ($usuarios && $usuarios->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Nombre</th><th>Correo</th><th>Uso</th></tr>";
    while ($user = $usuarios->fetch_assoc()) {
        $tipo = (strpos($user['correo'], 'admin') !== false) ? 'Administrador' : 'Cliente';
        echo "<tr>";
        echo "<td>" . htmlspecialchars($user['nombre']) . "</td>";
        echo "<td>" . htmlspecialchars($user['correo']) . "</td>";
        echo "<td>$tipo</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<div class='success'>✅ Usuarios de prueba disponibles</div>";
} else {
    echo "<div class='warning'>⚠️ No hay usuarios de prueba. Ejecutar insertar_datos_prueba.php</div>";
    $warnings[] = "Usuarios de prueba";
}

// Verificar habitaciones
echo "<h2>5. 🏠 Estado de Habitaciones</h2>";
$estados = $conexion->query("SELECT estado, COUNT(*) as cantidad FROM habitaciones GROUP BY estado");
if ($estados && $estados->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Estado</th><th>Cantidad</th></tr>";
    while ($estado = $estados->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . ucfirst($estado['estado']) . "</td>";
        echo "<td>" . $estado['cantidad'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<div class='warning'>⚠️ No hay habitaciones en la base de datos</div>";
    $warnings[] = "Habitaciones";
}

// Resumen
echo "<h2>6. 📊 Resumen de Verificación</h2>";
echo "<div class='success'>✅ Elementos funcionando: " . count($exitos) . "</div>";
if (count($warnings) > 0) {
    echo "<div class='warning'>⚠️ Advertencias: " . count($warnings) . "</div>";
}
if (count($errores) > 0) {
    echo "<div class='error'>❌ Errores críticos: " . count($errores) . "</div>";
}

// Estado general
if (count($errores) == 0) {
    echo "<div class='success' style='font-size: 1.2em; text-align: center; margin: 20px 0;'>";
    echo "🎉 <strong>SISTEMA LISTO PARA USAR</strong> 🎉";
    echo "</div>";
} else {
    echo "<div class='error' style='font-size: 1.2em; text-align: center; margin: 20px 0;'>";
    echo "⚠️ <strong>SISTEMA REQUIERE CORRECCIONES</strong> ⚠️";
    echo "</div>";
}

// Enlaces de acción
echo "<h2>7. 🚀 Acciones</h2>";
echo "<a href='formlogin.html' class='btn btn-primary'>🔐 Ir al Login</a>";
echo "<a href='insertar_datos_prueba.php' class='btn btn-success'>👥 Insertar Datos Prueba</a>";
echo "<a href='test_conexion_bd_hoteles2.php' class='btn btn-danger'>🔧 Test Conexión</a>";

echo "</div></body></html>";
?>
