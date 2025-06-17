<?php
session_start();

// Destruir todas las variables de sesión
$_SESSION = array();

// Destruir la sesión
session_destroy();

// Mostrar mensaje de cierre de sesión y redirigir
echo "<!DOCTYPE html>";
echo "<html><head><meta charset='UTF-8'>";
echo "<style>body{font-family:Arial,sans-serif;background:#f0f0f0;display:flex;justify-content:center;align-items:center;min-height:100vh;margin:0;}</style>";
echo "</head><body>";
echo "<div style='text-align:center;background:white;padding:2rem;border-radius:10px;box-shadow:0 0 20px rgba(0,0,0,0.1);'>";
echo "<div style='color:green;font-size:1.5rem;margin-bottom:1rem;'>✅ Sesión cerrada</div>";
echo "<p>Ha cerrado sesión exitosamente</p>";
echo "<p>Gracias por usar el sistema del Hotel Chuquisaqueño</p>";
echo "<p>Redirigiendo al inicio...</p>";
echo "</div></body></html>";

// Redirigir a la página de selección de acceso
header("refresh:3;url=seleccionar_acceso.html");
exit;
?>
