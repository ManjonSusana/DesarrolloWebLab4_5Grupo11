<?php
include('conexion.php');

echo "<!DOCTYPE html>";
echo "<html><head><meta charset='UTF-8'><title>Diagnóstico y Reparación Final</title>";
echo "<style>body{font-family:Arial,sans-serif;padding:20px;background:#f4f4f4;}.section{background:white;padding:20px;margin:15px 0;border-radius:8px;box-shadow:0 2px 5px rgba(0,0,0,0.1);}.success{color:#28a745;}.error{color:#dc3545;}.warning{color:#ffc107;}.code{background:#f8f9fa;padding:10px;border-radius:4px;font-family:monospace;margin:10px 0;}</style>";
echo "</head><body>";

echo "<h1>🔧 Diagnóstico y Reparación Final de BD</h1>";

if (!$conexion) {
    echo "<div class='section'><p class='error'>❌ Error de conexión a BD</p></div>";
    exit();
}

echo "<div class='section'><p class='success'>✅ Conexión a BD exitosa</p></div>";

// 1. Verificar estructura actual
echo "<div class='section'>";
echo "<h2>1. Estructura Actual de la Tabla usuarios</h2>";
$describe = $conexion->query("DESCRIBE usuarios");
$columnas = [];

if ($describe) {
    echo "<table border='1' style='border-collapse:collapse; width:100%;'>";
    echo "<tr style='background:#f8f9fa;'><th>Campo</th><th>Tipo</th><th>Null</th><th>Default</th></tr>";
    while ($row = $describe->fetch_assoc()) {
        $columnas[] = $row['Field'];
        echo "<tr>";
        echo "<td><strong>{$row['Field']}</strong></td>";
        echo "<td>{$row['Type']}</td>";
        echo "<td>{$row['Null']}</td>";
        echo "<td>{$row['Default']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<p><strong>Columnas encontradas:</strong> " . implode(', ', $columnas) . "</p>";
} else {
    echo "<p class='error'>❌ Error obteniendo estructura</p>";
}
echo "</div>";

// 2. Verificar y reparar columnas faltantes
echo "<div class='section'>";
echo "<h2>2. Verificación y Reparación de Columnas</h2>";

$columnas_requeridas = [
    'password' => "VARCHAR(255) NOT NULL DEFAULT ''",
    'tipo_usuario' => "ENUM('administrador', 'cliente') NOT NULL DEFAULT 'cliente'"
];

foreach ($columnas_requeridas as $columna => $definicion) {
    if (!in_array($columna, $columnas)) {
        echo "<p class='warning'>⚠️ Columna '$columna' faltante. Agregando...</p>";
        
        $sql = "ALTER TABLE usuarios ADD COLUMN $columna $definicion";
        echo "<div class='code'>$sql</div>";
        
        if ($conexion->query($sql)) {
            echo "<p class='success'>✅ Columna '$columna' agregada exitosamente</p>";
        } else {
            echo "<p class='error'>❌ Error: " . $conexion->error . "</p>";
        }
    } else {
        echo "<p class='success'>✅ Columna '$columna' existe</p>";
    }
}
echo "</div>";

// 3. Limpiar y recrear usuarios de prueba
echo "<div class='section'>";
echo "<h2>3. Configurar Usuarios de Prueba</h2>";

// Eliminar usuarios de prueba existentes
$conexion->query("DELETE FROM usuarios WHERE correo IN ('admin@hotel.com', 'cliente@test.com')");
echo "<p>🧹 Usuarios de prueba existentes eliminados</p>";

// Crear usuarios nuevos
$usuarios_prueba = [
    [
        'nombre' => 'Administrador Sistema',
        'correo' => 'admin@hotel.com',
        'telefono' => '78912345',
        'ci' => '12345678',
        'password' => 'admin123',
        'tipo_usuario' => 'administrador'
    ],
    [
        'nombre' => 'Cliente de Prueba',
        'correo' => 'cliente@test.com',
        'telefono' => '76543210',
        'ci' => '87654321',
        'password' => 'cliente123',
        'tipo_usuario' => 'cliente'
    ]
];

foreach ($usuarios_prueba as $usuario) {
    $sql = "INSERT INTO usuarios (nombre, correo, telefono, ci, password, tipo_usuario) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ssssss", 
            $usuario['nombre'], 
            $usuario['correo'], 
            $usuario['telefono'], 
            $usuario['ci'], 
            $usuario['password'], 
            $usuario['tipo_usuario']
        );
        
        if ($stmt->execute()) {
            echo "<p class='success'>✅ Usuario {$usuario['tipo_usuario']} creado: {$usuario['correo']} / {$usuario['password']}</p>";
        } else {
            echo "<p class='error'>❌ Error creando {$usuario['correo']}: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}
echo "</div>";

// 4. Verificar usuarios creados
echo "<div class='section'>";
echo "<h2>4. Usuarios en el Sistema</h2>";
$result = $conexion->query("SELECT id, nombre, correo, tipo_usuario, password FROM usuarios");

if ($result && $result->num_rows > 0) {
    echo "<table border='1' style='border-collapse:collapse; width:100%;'>";
    echo "<tr style='background:#f8f9fa;'><th>ID</th><th>Nombre</th><th>Email</th><th>Tipo</th><th>Password</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['nombre']}</td>";
        echo "<td><strong>{$row['correo']}</strong></td>";
        echo "<td><span style='background:" . ($row['tipo_usuario'] == 'administrador' ? '#dc3545' : '#28a745') . ";color:white;padding:2px 8px;border-radius:3px;'>{$row['tipo_usuario']}</span></td>";
        echo "<td>{$row['password']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='error'>❌ No hay usuarios en el sistema</p>";
}
echo "</div>";

// 5. Test de consulta de autenticación
echo "<div class='section'>";
echo "<h2>5. Test de Consulta de Autenticación</h2>";

$test_queries = [
    "SELECT id, correo, password, tipo_usuario FROM usuarios WHERE correo = 'admin@hotel.com' AND tipo_usuario = 'administrador'",
    "SELECT id, correo, password, tipo_usuario FROM usuarios WHERE correo = 'cliente@test.com' AND tipo_usuario = 'cliente'"
];

foreach ($test_queries as $query) {
    echo "<div class='code'>$query</div>";
    $result = $conexion->query($query);
    
    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<p class='success'>✅ Query exitoso - Usuario encontrado: {$row['correo']} ({$row['tipo_usuario']})</p>";
        } else {
            echo "<p class='warning'>⚠️ Query ejecutado pero no encontró resultados</p>";
        }
    } else {
        echo "<p class='error'>❌ Error en query: " . $conexion->error . "</p>";
    }
}
echo "</div>";

// 6. Resultado final
echo "<div class='section success'>";
echo "<h2>🎉 Sistema Configurado</h2>";
echo "<p><strong>Credenciales de acceso:</strong></p>";
echo "<ul>";
echo "<li><strong>Administrador:</strong> admin@hotel.com / admin123</li>";
echo "<li><strong>Cliente:</strong> cliente@test.com / cliente123</li>";
echo "</ul>";
echo "<p><strong>Campo de email utilizado:</strong> correo</p>";
echo "<p><strong>Estado:</strong> ✅ Listo para probar</p>";
echo "</div>";

echo "<p style='text-align:center;'>";
echo "<a href='seleccionar_acceso.html' style='background:#007bff;color:white;padding:15px 30px;text-decoration:none;border-radius:5px;font-size:18px;'>🏨 PROBAR SISTEMA</a>";
echo "</p>";

echo "</body></html>";
?>
