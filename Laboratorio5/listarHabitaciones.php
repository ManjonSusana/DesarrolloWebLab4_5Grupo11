<?php
include("conexion.php");

if (isset($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
    $sql = "SELECT numero, piso, tipo, estado, descripcion 
            FROM habitaciones 
            WHERE tipo = '$tipo' AND estado = 'disponible'";
    $result = $conexion->query($sql);
} else {
    $sql = "SELECT numero, piso, tipo, estado, descripcion 
            FROM habitaciones 
            WHERE estado = 'disponible'";
    $result = $conexion->query($sql);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Habitaciones del Hotel</title>    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #faf7f0 0%, #f5f2e8 50%, #ede8d8 100%);
            margin: 0;
            padding: 0;
            color: #5a4a3a;
            min-height: 100vh;
        }

        .tabla-habitaciones {
            width: 90%;
            max-width: 1000px;
            margin: 40px auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(218, 188, 150, 0.2);
            overflow: hidden;
            border: 1px solid rgba(218, 188, 150, 0.3);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: linear-gradient(45deg, #d4af37, #f4d03f);
            color: #5a4a3a;
            font-size: 18px;
            padding: 16px;
        }        td {
            padding: 14px;
            text-align: center;
            font-size: 16px;
            color: #5a4a3a;
            border-bottom: 1px solid rgba(218, 188, 150, 0.2);
            background: rgba(255, 255, 255, 0.6);
        }

        tr:nth-child(even) td {
            background: rgba(244, 208, 63, 0.05);
        }

        tr:hover td {
            background: rgba(244, 208, 63, 0.15);
            transform: scale(1.01);
            transition: all 0.3s ease;
        }

        td:first-child {
            font-weight: bold;
            color: #4a3a2a;
        }

        .mensaje {
            text-align: center;
            padding: 20px;
            font-size: 17px;
            color: #8a7a6a;
        }

        @media (max-width: 768px) {
            th, td {
                font-size: 14px;
                padding: 10px;
            }

            .tabla-habitaciones {
                width: 95%;
            }
            .btn {
                padding: 8px 12px;
                font-size: 13px;
            }
        }
        .btn-reservar {
            background: linear-gradient(45deg, #a8d8a8, #90c695);
            color: #4a5a4a;
            padding: 10px 16px;
            font-size: 14px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }        .btn-reservar:hover {
            background: linear-gradient(45deg, #90c695, #7fb888);
            color: #3a4a3a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(168, 216, 168, 0.4);
        }
    </style>
</head>
<body>

<div class="tabla-habitaciones">    <table>
        <tr>
            <th>Tipo</th>
            <th>N° Habitación</th>
            <th>Piso</th>
            <th>Estado</th>
            <th>Descripción</th>
            <th></th>
        </tr>
        <?php if (isset($result) && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['tipo']) ?></td>
                    <td><?= htmlspecialchars($row['numero']) ?></td>
                    <td><?= htmlspecialchars($row['piso']) ?></td>
                    <td><?= htmlspecialchars($row['estado']) ?></td>
                    <td><?= htmlspecialchars($row['descripcion']) ?></td>
                    <td><button class="btn-reservar" onclick="javascript:cargarContenido('')">Reservar</button></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6" class="mensaje">No hay habitaciones disponibles</td></tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
