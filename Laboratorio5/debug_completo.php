<?php
session_start();

echo "<!DOCTYPE html>";
echo "<html><head><meta charset='UTF-8'><title>Debug Login</title>";
echo "<style>body{font-family:Arial,sans-serif;padding:20px;background:#f4f4f4;}.debug{background:white;padding:15px;margin:10px 0;border-radius:5px;border-left:4px solid #007bff;}</style>";
echo "</head><body>";

echo "<h1>🔍 Debug del Login - Análisis Completo</h1>";

echo "<div class='debug'>";
echo "<h3>1. Método de envío:</h3>";
echo "<p>Método: " . $_SERVER['REQUEST_METHOD'] . "</p>";
echo "</div>";

echo "<div class='debug'>";
echo "<h3>2. Datos POST recibidos (RAW):</h3>";
echo "<pre>";
var_dump($_POST);
echo "</pre>";
echo "</div>";

echo "<div class='debug'>";
echo "<h3>3. Análisis de campos individuales:</h3>";

$campos = ['correo', 'password', 'tipo_usuario'];
foreach ($campos as $campo) {
    echo "<h4>Campo: $campo</h4>";
    if (isset($_POST[$campo])) {
        $valor = $_POST[$campo];
        echo "✅ EXISTE<br>";
        echo "Valor: '" . htmlspecialchars($valor) . "'<br>";
        echo "Longitud: " . strlen($valor) . "<br>";
        echo "Valor trimmed: '" . htmlspecialchars(trim($valor)) . "'<br>";
        echo "Valor en hexadecimal: " . bin2hex($valor) . "<br>";
        echo "Es string vacío: " . (empty($valor) ? 'SÍ' : 'NO') . "<br>";
        echo "<hr>";
    } else {
        echo "❌ NO EXISTE<br><hr>";
    }
}
echo "</div>";

echo "<div class='debug'>";
echo "<h3>4. Test específico del tipo_usuario:</h3>";
if (isset($_POST['tipo_usuario'])) {
    $tipo = trim($_POST['tipo_usuario']);
    echo "Valor recibido: '" . htmlspecialchars($tipo) . "'<br>";
    echo "Comparación con 'admin': " . ($tipo === 'admin' ? 'IGUAL' : 'DIFERENTE') . "<br>";
    echo "Comparación con 'cliente': " . ($tipo === 'cliente' ? 'IGUAL' : 'DIFERENTE') . "<br>";
    echo "Resultado de validación actual: ";
    if ($tipo != 'admin' && $tipo != 'cliente') {
        echo "<span style='color:red;'>❌ INVÁLIDO</span><br>";
        echo "Posibles valores ocultos o espacios detectados<br>";
    } else {
        echo "<span style='color:green;'>✅ VÁLIDO</span><br>";
    }
} else {
    echo "❌ Campo tipo_usuario no encontrado<br>";
}
echo "</div>";

// Test de conexión a BD
echo "<div class='debug'>";
echo "<h3>5. Test de conexión a base de datos:</h3>";
try {
    include("conexion.php");
    if ($conexion && !$conexion->connect_error) {
        echo "✅ Conexión exitosa<br>";
        
        // Mostrar usuarios en BD
        $result = $conexion->query("SELECT email, tipo_usuario FROM usuarios LIMIT 5");
        if ($result) {
            echo "<h4>Usuarios en BD:</h4>";
            echo "<table border='1' style='border-collapse:collapse;'>";
            echo "<tr><th>Email</th><th>Tipo Usuario</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>{$row['email']}</td><td>{$row['tipo_usuario']}</td></tr>";
            }
            echo "</table>";
        }
    } else {
        echo "❌ Error de conexión: " . ($conexion ? $conexion->connect_error : 'conexion no definida') . "<br>";
    }
} catch (Exception $e) {
    echo "❌ Excepción: " . $e->getMessage() . "<br>";
}
echo "</div>";

echo "<div class='debug'>";
echo "<h3>6. Simulación de autenticación:</h3>";
if (isset($_POST['correo']) && isset($_POST['password']) && isset($_POST['tipo_usuario'])) {
    $email = trim($_POST['correo']);
    $password = trim($_POST['password']);
    $tipo_usuario = trim($_POST['tipo_usuario']);
    
    echo "Email: '$email'<br>";
    echo "Password: '" . str_repeat('*', strlen($password)) . "'<br>";
    echo "Tipo: '$tipo_usuario'<br>";
    
    if ($tipo_usuario === 'admin' || $tipo_usuario === 'cliente') {
        $tipo_bd = ($tipo_usuario === 'admin') ? 'administrador' : 'cliente';
        echo "✅ Tipo válido, buscando en BD como: '$tipo_bd'<br>";
        
        if (isset($conexion)) {
            $stmt = $conexion->prepare('SELECT id, email, password, tipo_usuario FROM usuarios WHERE email = ? AND tipo_usuario = ?');
            if ($stmt) {
                $stmt->bind_param("ss", $email, $tipo_bd);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    echo "✅ Usuario encontrado en BD<br>";
                    $user = $result->fetch_assoc();
                    echo "ID: {$user['id']}<br>";
                    echo "Email BD: {$user['email']}<br>";
                    echo "Tipo BD: {$user['tipo_usuario']}<br>";
                    
                    // Test password
                    if ($password === $user['password']) {
                        echo "✅ Password coincide (texto plano)<br>";
                    } elseif (password_verify($password, $user['password'])) {
                        echo "✅ Password coincide (hash)<br>";
                    } else {
                        echo "❌ Password no coincide<br>";
                    }
                } else {
                    echo "❌ Usuario NO encontrado en BD<br>";
                }
                $stmt->close();
            } else {
                echo "❌ Error preparando query<br>";
            }
        }
    } else {
        echo "❌ Tipo de usuario inválido detectado<br>";
    }
} else {
    echo "❌ Faltan campos del formulario<br>";
}
echo "</div>";

echo "<p><a href='seleccionar_acceso.html'>← Volver al sistema</a></p>";
echo "</body></html>";
?>
