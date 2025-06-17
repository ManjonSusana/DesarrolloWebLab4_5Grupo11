<?php
session_start();
include("conexion.php");

echo "<h2>Debug del Sistema de Autenticación</h2>";
echo "<p><strong>Datos recibidos via POST:</strong></p>";

// Mostrar todos los datos POST recibidos
echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<pre>";
print_r($_POST);
echo "</pre>";
"</div>";

// Verificar variables específicas
echo "<p><strong>Variables específicas:</strong></p>";
echo "<ul>";
echo "<li>correo: " . (isset($_POST['correo']) ? $_POST['correo'] : 'NO DEFINIDO') . "</li>";
echo "<li>password: " . (isset($_POST['password']) ? '***DEFINIDO***' : 'NO DEFINIDO') . "</li>";
echo "<li>tipo_usuario: " . (isset($_POST['tipo_usuario']) ? $_POST['tipo_usuario'] : 'NO DEFINIDO') . "</li>";
echo "</ul>";

// Test de conexión a BD
echo "<h3>Test de Base de Datos:</h3>";
if ($conexion && !$conexion->connect_error) {
    echo "<p style='color: green;'>Conexión a BD exitosa</p>";
    
    // Verificar usuarios en la BD
    $query = "SELECT email, tipo_usuario FROM usuarios";
    $result = $conexion->query($query);
    
    if ($result) {
        echo "<p><strong>Usuarios en la base de datos:</strong></p>";
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr><th>Email</th><th>Tipo Usuario</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['email']}</td><td>{$row['tipo_usuario']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: red;'>Error consultando usuarios: " . $conexion->error . "</p>";
    }
} else {
    echo "<p style='color: red;'> Error de conexión a BD</p>";
}

// Simular validación
if (isset($_POST['tipo_usuario'])) {
    $tipo_usuario = trim($_POST['tipo_usuario']);
    echo "<h3>Validación de tipo_usuario:</h3>";
    echo "<p>Valor recibido: '" . $tipo_usuario . "'</p>";
    echo "<p>Longitud: " . strlen($tipo_usuario) . "</p>";
    echo "<p>Es 'admin': " . ($tipo_usuario == 'admin' ? 'SÍ' : 'NO') . "</p>";
    echo "<p>Es 'cliente': " . ($tipo_usuario == 'cliente' ? 'SÍ' : 'NO') . "</p>";
    
    if ($tipo_usuario != 'admin' && $tipo_usuario != 'cliente') {
        echo "<p style='color: red;'> Tipo de usuario inválido detectado</p>";
        echo "<p>Valor hexadecimal: " . bin2hex($tipo_usuario) . "</p>";
    } else {
        echo "<p style='color: green;'> Tipo de usuario válido</p>";
    }
}

echo "<hr>";
echo "<p><a href='seleccionar_acceso.html'>← Volver al sistema</a></p>";
?>
