<?php 
if (!isset($_SESSION["usuario"]) || !isset($_SESSION["id_usuario"]))
{
    echo "<!DOCTYPE html>";
    echo "<html><head><meta charset='UTF-8'>";
    echo "<style>body{font-family:Arial,sans-serif;background:#f0f0f0;display:flex;justify-content:center;align-items:center;min-height:100vh;margin:0;}</style>";
    echo "</head><body>";
    echo "<div style='text-align:center;background:white;padding:2rem;border-radius:10px;box-shadow:0 0 20px rgba(0,0,0,0.1);'>";
    echo "<div style='color:orange;font-size:1.5rem;margin-bottom:1rem;'>⚠️ Sesión expirada</div>";
    echo "<p>Debe iniciar sesión para acceder a esta página</p>";
    echo "<p>Redirigiendo al inicio...</p>";
    echo "</div></body></html>";
    echo "<meta http-equiv='refresh' content='3;url=seleccionar_acceso.html'>";
    die();
}
?>