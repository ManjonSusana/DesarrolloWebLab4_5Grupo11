<?php
include('conexion.php');
$sql = "SELECT DISTINCT tipo, COUNT(*) as cantidad, 
               GROUP_CONCAT(DISTINCT descripcion SEPARATOR ' | ') as descripciones
        FROM habitaciones 
        GROUP BY tipo";
$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipos de Habitación - Hotel Chuquisaqueño</title>
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
            border-radius: 10px 10px 0 0;
        }
        
        .table-light td {
            border-color: rgba(218, 188, 150, 0.2);
            vertical-align: middle;
            background: rgba(255, 255, 255, 0.6);
        }
        
        .table-hover tbody tr:hover {
            background: rgba(244, 208, 63, 0.15);
            transform: scale(1.01);
            transition: all 0.3s ease;
        }
        
        .btn-ver {
            background: linear-gradient(45deg, #a8d8a8, #90c695);
            border: none;
            color: #4a5a4a;
            box-shadow: 0 4px 15px rgba(168, 216, 168, 0.3);
            transition: all 0.3s ease;
            font-weight: 500;
            border-radius: 25px;
        }
        
        .btn-ver:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(168, 216, 168, 0.4);
            background: linear-gradient(45deg, #90c695, #7fb888);
            color: #3a4a3a;
        }
        
        .page-title {
            background: linear-gradient(45deg, #d4af37, #f4d03f, #daa520);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
            margin-bottom: 2rem;
            font-weight: bold;
        }
        
        .tipo-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .tipo-card:hover {
            transform: translateY(-3px);
        }
        
        .superficie-badge {
            background: linear-gradient(45deg, #b5a7d4, #d4c5f9);
            color: #4a3a6a;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .camas-badge {
            background: linear-gradient(45deg, #ffb3ba, #ffc0cb);
            color: #6a3a4a;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .nombre-tipo {
            background: linear-gradient(45deg, #f4d03f, #d4af37);
            color: #5a4a3a;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            display: inline-block;
            box-shadow: 0 2px 10px rgba(212, 175, 55, 0.3);
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
                    <i class="fas fa-star me-3"></i>
                    Tipos de Habitación
                </h1>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card card-custom">                    <div class="card-header bg-transparent border-bottom-0 text-center py-4">
                        <h3 class="mb-0" style="color: #5a4a3a;">
                            <i class="fas fa-bed me-2" style="color: #d4af37;"></i>
                            Nuestras Comodidades y Espacios
                        </h3>
                        <p class="mt-2 mb-0" style="color: #8a7a6a;">Descubre nuestros diferentes tipos de habitaciones</p>
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
                                            <th scope="col" class="text-center">
                                                <i class="fas fa-door-open me-2"></i>
                                                Cantidad Disponible
                                            </th>
                                            <th scope="col" class="text-center">
                                                <i class="fas fa-info-circle me-2"></i>
                                                Características
                                            </th>
                                            <th scope="col" class="text-center">
                                                <i class="fas fa-eye me-2"></i>
                                                Ver Habitaciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr class="">
                                                <td>
                                                    <div class="">
                                                        <i class="fas fa-door-open me-2"></i>
                                                        <?= htmlspecialchars(ucfirst($row['tipo'])) ?>
                                                    </div>
                                                </td>
                                                <td class="">
                                                    <span class="">
                                                        <i class="fas fa-building me-1"></i>
                                                        <?= htmlspecialchars($row['cantidad']) ?> 
                                                        <?= $row['cantidad'] == 1 ? 'habitación' : 'habitaciones' ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="">
                                                        <small><?= htmlspecialchars($row['descripciones']) ?></small>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-ver btn-sm px-4 py-2" 
                                                            onclick="cargarContenido('listarHabitaciones.php?tipo=<?= $row['tipo'] ?>')"
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-placement="top" 
                                                            title="Ver habitaciones disponibles">
                                                        <i class="fas fa-list me-2"></i>
                                                        Ver Habitaciones
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <div class="alert alert-info" role="alert">
                                    <i class="fas fa-info-circle fa-3x mb-3"></i>
                                    <h4 class="alert-heading">Sin información disponible</h4>
                                    <p class="mb-0">En este momento no hay tipos de habitaciones para mostrar.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                          <div class="text-center mt-4">
                            <small style="color: #8a7a6a;">
                                <i class="fas fa-info-circle me-1" style="color: #d4af37;"></i>
                                Haz clic en "Ver Habitaciones" para explorar las opciones disponibles de cada tipo
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Área para contenido dinámico -->
        <div id="contenido" class="mt-4"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Inicializar tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Función para cargar contenido con efectos mejorados
        function cargarContenido(url) {
            const contenedor = document.getElementById("contenido");
            
            // Mostrar spinner de carga
            contenedor.innerHTML = `
                <div class="card card-custom">
                    <div class="card-body text-center py-5">
                        <div class="spinner-border text-primary mb-3" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p style="color: #5a4a3a;">Cargando habitaciones...</p>
                    </div>
                </div>
            `;
            
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.text();
                })
                .then(data => {
                    contenedor.innerHTML = data;
                    
                    // Reinicializar tooltips para el nuevo contenido
                    var newTooltips = [].slice.call(contenedor.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    newTooltips.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                    
                    // Scroll suave hacia el contenido cargado
                    contenedor.scrollIntoView({ behavior: 'smooth', block: 'start' });
                })
                .catch(error => {
                    console.error('Error al cargar contenido:', error);
                    contenedor.innerHTML = `
                        <div class="card card-custom">
                            <div class="card-body text-center py-5">
                                <div class="alert alert-danger" role="alert">
                                    <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                                    <h4 class="alert-heading">Error al cargar</h4>
                                    <p class="mb-0">No se pudo cargar el contenido solicitado. Inténtalo nuevamente.</p>
                                </div>
                            </div>
                        </div>
                    `;
                });
        }
    </script>
</body>
</html>
