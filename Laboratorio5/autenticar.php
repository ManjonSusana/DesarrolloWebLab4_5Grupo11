<?php 
session_start();
include("conexion.php");

// Verificar que se recibieron los datos del formulario
if (!isset($_POST['correo']) || !isset($_POST['password']) || !isset($_POST['tipo_usuario'])) {
    echo "<div style='color: red; text-align: center; padding: 20px;'>Error: Datos incompletos</div>";
    echo "<meta http-equiv='refresh' content='3;url=seleccionar_acceso.html'>";
    exit();
}

$email = trim($_POST['correo']);
$password = trim($_POST['password']);
$tipo_usuario = trim($_POST['tipo_usuario']);

// Validar que el tipo de usuario sea válido
if ($tipo_usuario != 'admin' && $tipo_usuario != 'cliente') {
    echo "<div style='color: red; text-align: center; padding: 20px;'>Error: Tipo de usuario inválido</div>";
    echo "<meta http-equiv='refresh' content='3;url=seleccionar_acceso.html'>";
    exit();
}

// Convertir tipo de usuario para coincidir con la base de datos
$tipo_bd = ($tipo_usuario == 'admin') ? 'administrador' : 'cliente';

// Verificar usuario en la base de datos
$stmt = $conexion->prepare('SELECT id, correo, password, tipo_usuario FROM usuarios WHERE correo = ? AND tipo_usuario = ?');
$stmt->bind_param("ss", $email, $tipo_bd);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Verificar la contraseña (tanto hash como texto plano para compatibilidad)
    $password_valid = false;
    if (password_verify($password, $user['password'])) {
        // Contraseña hasheada
        $password_valid = true;
    } elseif ($password === $user['password']) {
        // Contraseña en texto plano (para usuarios de prueba)
        $password_valid = true;
    }
    
    if ($password_valid) {
        // Establecer variables de sesión
        $_SESSION['usuario'] = $email;
        $_SESSION['id_usuario'] = $user['id'];
        $_SESSION['tipo_usuario'] = $tipo_usuario;
        $_SESSION['ultimo_acceso'] = date('Y-m-d H:i:s');
        
        // Mostrar mensaje de éxito y redirigir
        echo "<!DOCTYPE html>";
        echo "<html><head><meta charset='UTF-8'>";
        echo "<style>body{font-family:Arial,sans-serif;background:#f0f0f0;display:flex;justify-content:center;align-items:center;min-height:100vh;margin:0;}</style>";
        echo "</head><body>";
        echo "<div style='text-align:center;background:white;padding:2rem;border-radius:10px;box-shadow:0 0 20px rgba(0,0,0,0.1);'>";
        echo "<div style='color:green;font-size:1.5rem;margin-bottom:1rem;'>✅ Acceso autorizado</div>";
        echo "<p>Bienvenido: <strong>" . htmlspecialchars($email) . "</strong></p>";
        echo "<p>Tipo de acceso: <strong>" . ucfirst($tipo_usuario) . "</strong></p>";
        echo "<p>Redirigiendo...</p>";
        echo "</div></body></html>";
        
        // Redirigir según el tipo de usuario
        if ($tipo_usuario == 'admin') {
            echo "<meta http-equiv='refresh' content='2;url=admin.html'>";
        } else {
            echo "<meta http-equiv='refresh' content='2;url=paginaCliente.html'>";
        }
        
        $stmt->close();
        exit();
    } else {
        echo "<!DOCTYPE html>";
        echo "<html><head><meta charset='UTF-8'>";
        echo "<style>body{font-family:Arial,sans-serif;background:#f0f0f0;display:flex;justify-content:center;align-items:center;min-height:100vh;margin:0;}</style>";
        echo "</head><body>";
        echo "<div style='text-align:center;background:white;padding:2rem;border-radius:10px;box-shadow:0 0 20px rgba(0,0,0,0.1);'>";
        echo "<div style='color:red;font-size:1.5rem;margin-bottom:1rem;'>❌ Contraseña incorrecta</div>";
        echo "<p>La contraseña no coincide para: <strong>" . htmlspecialchars($email) . "</strong></p>";
        echo "<p>Regresando al login...</p>";
        echo "</div></body></html>";
        echo "<meta http-equiv='refresh' content='4;url=seleccionar_acceso.html'>";
        $stmt->close();
    }
} else {
    echo "<!DOCTYPE html>";
    echo "<html><head><meta charset='UTF-8'>";
    echo "<style>body{font-family:Arial,sans-serif;background:#f0f0f0;display:flex;justify-content:center;align-items:center;min-height:100vh;margin:0;}</style>";
    echo "</head><body>";
    echo "<div style='text-align:center;background:white;padding:2rem;border-radius:10px;box-shadow:0 0 20px rgba(0,0,0,0.1);'>";
    echo "<div style='color:red;font-size:1.5rem;margin-bottom:1rem;'>❌ Usuario no encontrado</div>";
    echo "<p>No se encontró un usuario <strong>" . ucfirst($tipo_usuario) . "</strong> con email: <strong>" . htmlspecialchars($email) . "</strong></p>";
    echo "<p>Verifique el tipo de usuario seleccionado y el email registrado</p>";
    echo "<p>Regresando al inicio...</p>";
    echo "</div></body></html>";
    echo "<meta http-equiv='refresh' content='4;url=seleccionar_acceso.html'>";
    $stmt->close();
}

$conexion->close();
?>
