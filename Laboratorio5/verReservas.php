<?php 
session_start();
include("verificarsesion.php");
include("conexion.php");

$id_usuario = $_SESSION['id_usuario'];

// Consulta adaptada para la base de datos bd_hoteles2
$sql = "SELECT r.id, r.fecha_entrada, r.fecha_salida, r.fecha_reserva, r.estado, r.tipo_habitacion,
               h.numero, h.piso, h.descripcion
        FROM reservas r
        LEFT JOIN habitaciones h ON r.id_habitaciones = h.id
        WHERE r.id_usuario = ?
        ORDER BY r.fecha_reserva DESC";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas - Hotel Chuquisaqueño</title>
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
        
        .reserva-card {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(218, 188, 150, 0.3);
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(218, 188, 150, 0.1);
        }
        
        .reserva-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            border-color: #c4002c;
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
        
        .fecha-badge {
            background: linear-gradient(45deg, #17a2b8, #138496);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
            display: inline-block;
            margin: 0.25rem;
        }
        
        .habitacion-info {
            background: linear-gradient(45deg, #c4002c, #a70024);
            color: white;
            padding: 1rem;
            border-radius: 10px;
            margin: 1rem 0;
        }
        
        .estado-activa {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .estado-pasada {
            background: linear-gradient(45deg, #6c757d, #5a6268);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .estado-proxima {
            background: linear-gradient(45deg, #ffc107, #e0a800);
            color: #333;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .duracion-estadia {
            background: rgba(255, 255, 255, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 10px;
            border-left: 4px solid #c4002c;
        }
        
        @media (max-width: 768px) {
            .reserva-card {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h1 class="page-title display-4">
                    <i class="fas fa-calendar-check me-3"></i>
                    Mis Reservas
                </h1>
            </div>
        </div>
        
        <?php if ($resultado->num_rows > 0): ?>
            <div class="row">
                <div class="col-12">
                    <div class="card card-custom mb-4">
                        <div class="card-header bg-transparent border-bottom-0 text-center py-4">
                            <h3 class="text-white mb-0">
                                <i class="fas fa-list me-2"></i>
                                Historial de Reservaciones
                            </h3>
                            <p class="text-muted mt-2 mb-0">Total de reservas: <?= $resultado->num_rows ?></p>
                        </div>
                    </div>
                </div>
            </div>
              <div class="row">
                <?php while ($reserva = $resultado->fetch_assoc()): 
                    $fecha_actual = date('Y-m-d');
                    $fecha_ingreso = $reserva['fecha_entrada'];
                    $fecha_salida = $reserva['fecha_salida'];
                    
                    // Determinar el estado de la reserva
                    $estado = 'proxima';
                    $estado_texto = 'Próxima';
                    $estado_icon = 'fa-calendar-plus';
                    
                    if ($fecha_actual >= $fecha_ingreso && $fecha_actual <= $fecha_salida) {
                        $estado = 'activa';
                        $estado_texto = 'Activa';
                        $estado_icon = 'fa-bed';
                    } elseif ($fecha_actual > $fecha_salida) {
                        $estado = 'pasada';
                        $estado_texto = 'Completada';
                        $estado_icon = 'fa-check-circle';
                    }
                    
                    // Calcular duración de la estadía
                    $fecha_ing_obj = new DateTime($fecha_ingreso);
                    $fecha_sal_obj = new DateTime($fecha_salida);
                    $diferencia = $fecha_ing_obj->diff($fecha_sal_obj);
                    $dias = $diferencia->days;
                ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card reserva-card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="text-white mb-0">
                                        <i class="fas fa-door-open me-2"></i>
                                        Reserva #<?= $reserva['id'] ?>
                                    </h5>
                                    <span class="estado-<?= $estado ?>">
                                        <i class="fas <?= $estado_icon ?> me-1"></i>
                                        <?= $estado_texto ?>
                                    </span>
                                </div>
                                  <div class="habitacion-info">
                                    <h6 class="mb-2">
                                        <i class="fas fa-bed me-2"></i>
                                        <?= htmlspecialchars($reserva['tipo_habitacion']) ?>
                                    </h6>
                                    <div class="row text-sm">
                                        <div class="col-6">
                                            <small><i class="fas fa-hashtag me-1"></i> 
                                                <?= $reserva['numero'] ? 'Hab. ' . htmlspecialchars($reserva['numero']) : 'Sin asignar' ?>
                                            </small>
                                        </div>
                                        <div class="col-6">
                                            <small><i class="fas fa-layer-group me-1"></i> 
                                                <?= $reserva['piso'] ? 'Piso ' . htmlspecialchars($reserva['piso']) : 'N/A' ?>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="row text-sm mt-1">
                                        <div class="col-12">
                                            <small><i class="fas fa-info-circle me-1"></i> Estado: 
                                                <span class="badge bg-<?= $reserva['estado'] == 'confirmada' ? 'success' : ($reserva['estado'] == 'pendiente' ? 'warning' : 'info') ?>">
                                                    <?= htmlspecialchars($reserva['estado']) ?>
                                                </span>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-center">
                                    <div class="fecha-badge">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        <strong>Ingreso:</strong> <?= date('d/m/Y', strtotime($fecha_ingreso)) ?>
                                    </div>
                                    <div class="fecha-badge">
                                        <i class="fas fa-calendar-times me-2"></i>
                                        <strong>Salida:</strong> <?= date('d/m/Y', strtotime($fecha_salida)) ?>
                                    </div>
                                </div>
                                
                                <div class="duracion-estadia mt-3 text-center">
                                    <small class="text-white">
                                        <i class="fas fa-clock me-1"></i>
                                        Duración: <strong><?= $dias ?> <?= $dias == 1 ? 'día' : 'días' ?></strong>
                                    </small>
                                </div>
                                
                                <?php if ($reserva['fecha_reserva']): ?>
                                    <div class="text-center mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-plus me-1"></i>
                                            Reservado el: <?= date('d/m/Y H:i', strtotime($reserva['fecha_reserva'])) ?>
                                        </small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-12">
                    <div class="card card-custom">
                        <div class="card-body text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-calendar-times fa-4x text-muted"></i>
                            </div>
                            <h4 class="text-white mb-3">No tienes reservas</h4>
                            <p class="text-muted mb-4">Aún no has realizado ninguna reserva en nuestro hotel.</p>
                            <button class="btn btn-primary btn-lg" onclick="cargarContenido('verHabitaciones.php')">
                                <i class="fas fa-bed me-2"></i>
                                Explorar Habitaciones
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="row mt-4">
            <div class="col-12 text-center">
                <button class="btn btn-outline-light btn-lg" onclick="cargarContenido('verHabitaciones.php')">
                    <i class="fas fa-plus me-2"></i>
                    Hacer Nueva Reserva
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Función para cargar contenido (debe estar definida en el archivo principal)
        if (typeof cargarContenido === 'undefined') {
            function cargarContenido(url) {
                window.location.href = url;
            }
        }
        
        // Animación para las tarjetas al cargar
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.reserva-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });
    </script>
</body>
</html>

<?php
$stmt->close();
// $conn->close();
?>
