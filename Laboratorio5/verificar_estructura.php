<?php
include('conexion.php');

echo "<!DOCTYPE html>";
echo "<html><head><meta charset='UTF-8'><title>Verificar Estructura BD</title>";
echo "<style>body{font-family:Arial,sans-serif;padding:20px;background:#f4f4f4;}.result{background:white;padding:15px;margin:10px 0;border-radius:5px;}</style>";
echo "</head><body>";

echo "<h1>🔍 Verificar Estructura Actual de la Tabla</h1>";

if ($conexion) {
    // Mostrar estructura actual
    $describe = $conexion->query("DESCRIBE usuarios");
    if ($describe) {
        echo "<h2>Estructura actual de la tabla usuarios:</h2>";
        echo "<table border='1' style='border-collapse:collapse; margin:10px 0;'>";
        echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        $campos = [];
        while ($row = $describe->fetch_assoc()) {
            $campos[] = $row['Field'];
            echo "<tr>";
            echo "<td><strong>{$row['Field']}</strong></td>";
            echo "<td>{$row['Type']}</td>";
            echo "<td>{$row['Null']}</td>";
            echo "<td>{$row['Key']}</td>";
            echo "<td>{$row['Default']}</td>";
            echo "<td>{$row['Extra']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<h3>Campos encontrados:</h3>";
        echo "<ul>";
        foreach ($campos as $campo) {
            echo "<li>$campo</li>";
        }
        echo "</ul>";
        
        // Verificar qué campos necesitamos
        echo "<h3>Verificación de campos necesarios:</h3>";
        $necesarios = ['email', 'password', 'tipo_usuario'];
        $alternativos = ['correo']; // Campo alternativo para email
        
        foreach ($necesarios as $campo) {
            if (in_array($campo, $campos)) {
                echo "<p style='color:green;'>✅ $campo - EXISTE</p>";
            } else {
                echo "<p style='color:red;'>❌ $campo - NO EXISTE</p>";
            }
        }
        
        // Verificar alternativo
        if (in_array('correo', $campos) && !in_array('email', $campos)) {
            echo "<p style='color:orange;'>⚠️ Se encontró 'correo' en lugar de 'email'</p>";
        }
        
    } else {
        echo "<p style='color:red;'>Error obteniendo estructura: " . $conexion->error . "</p>";
    }
} else {
    echo "<p style='color:red;'>Error de conexión</p>";
}

echo "</body></html>";
?>
