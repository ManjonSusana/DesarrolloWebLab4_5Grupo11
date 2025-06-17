<?php
session_start();
include("verificarsesion.php");
include('conexion.php');

$sql = "SELECT id, numero, piso, tipo, estado, descripcion 
        FROM habitaciones
        ORDER BY numero";
$result = $conexion->query($sql);

$id_usuario = $_SESSION['id_usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Habitaciones - Hotel Chuquisaqueño</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">    <style>
        body {
            background: linear-gradient(135deg, #faf7f0 0%, #f5f2e8 50%, #ede8d8 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            color: #5a4a3a;
        }
        
        .card-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(218, 188, 150, 0.3);
            box-shadow: 0 8px 32px rgba(218, 188, 150, 0.2);
            border-radius: 20px;
        }
        
        .table-light {
            background: rgba(255, 255, 255, 0.8);
        }
        
        .table-light th {
            background: linear-gradient(45deg, #d4af37, #f4d03f);
            border: none;
            color: #5a4a3a;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .table-light td {
            border-color: rgba(218, 188, 150, 0.2);
            vertical-align: middle;
        }
        
        .table-hover tbody tr:hover {
            background: rgba(196, 0, 44, 0.2);
            transform: scale(1.02);
            transition: all 0.3s ease;
        }
        
        .btn-reservar {
            background: linear-gradient(45deg,rgb(217, 197, 68),rgb(246, 214, 110));
            border: none;
            box-shadow: 0 4px 15px rgba(242, 222, 93, 0.3);
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .btn-reservar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(196, 0, 44, 0.4);
            background: linear-gradient(45deg, #a70024, #8a001d);
        }
        
        .page-title {
            background: linear-gradient(45deg, #c4002c, #a70024);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
            margin-bottom: 2rem;
            font-weight: bold;
        }
        
        .tipo-badge {
            background: linear-gradient(45deg, #c4002c, #a70024);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .habitacion-card {
            transition: all 0.3s ease;
        }
        
        .habitacion-card:hover {
            transform: translateY(-5px);
        }
        
        @media (max-width: 768px) {
            .table-responsive {
                border-radius: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h1 class="page-title display-4">
                    <i class="fas fa-bed me-3"></i>
                    Lista de Habitaciones
                </h1>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card card-custom">
                    <div class="card-header bg-transparent border-bottom-0 text-center py-4">
                        <h3 class="text-white mb-0">
                            <i class="fas fa-hotel me-2"></i>
                            Hotel Chuquisaqueño - Habitaciones Disponibles
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        <?php if ($result && $result->num_rows > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-light table-hover">                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                <i class="fas fa-tag me-2"></i>
                                                Tipo de Habitación
                                            </th>
                                            <th scope="col">
                                                <i class="fas fa-door-open me-2"></i>
                                                Número
                                            </th>
                                            <th scope="col">
                                                <i class="fas fa-building me-2"></i>
                                                Piso
                                            </th>
                                            <th scope="col">
                                                <i class="fas fa-info-circle me-2"></i>
                                                Estado
                                            </th>
                                            <th scope="col" class="text-center">
                                                <i class="fas fa-calendar-check me-2"></i>
                                                Acción
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr class="habitacion-card">
                                                <td>
                                                    <span class="tipo-badge">
                                                        <?= htmlspecialchars($row['tipo']) ?>
                                                    </span>
                                                </td>
                                                <td class="fw-bold">
                                                    <i class="fas fa-hashtag me-1"></i>
                                                    <?= htmlspecialchars($row['numero']) ?>
                                                </td>
                                                <td>
                                                    <i class="fas fa-layer-group me-1"></i>
                                                    Piso <?= htmlspecialchars($row['piso']) ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?= $row['estado'] == 'disponible' ? 'success' : ($row['estado'] == 'ocupado' ? 'danger' : 'warning') ?>">
                                                        <?= htmlspecialchars($row['estado']) ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($row['estado'] == 'disponible'): ?>
                                                        <button class="btn btn-reservar btn-sm px-4 py-2" 
                                                                onclick="cargarContenido('reservar.php?id_habitacion=<?= $row['id'] ?>')"
                                                                data-bs-toggle="tooltip" 
                                                                data-bs-placement="top" 
                                                                title="Reservar esta habitación">
                                                            <i class="fas fa-calendar-plus me-2"></i>
                                                            Reservar
                                                        </button>
                                                    <?php else: ?>
                                                        <span class="text-muted">No disponible</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <div class="alert alert-warning" role="alert">
                                    <i class="fas fa-bed fa-3x mb-3"></i>
                                    <h4 class="alert-heading">No hay habitaciones disponibles</h4>
                                    <p class="mb-0">En este momento no contamos con habitaciones disponibles para mostrar.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="text-center mt-4">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Haz clic en "Reservar" para seleccionar las fechas de tu estadía
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Inicializar tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Función para cargar contenido (debe estar definida en el archivo principal)
        if (typeof cargarContenido === 'undefined') {
            function cargarContenido(url) {
                // Si no existe la función cargarContenido, redirigir directamente
                window.location.href = url;
            }
        }
    </script>
</body>
</html>
