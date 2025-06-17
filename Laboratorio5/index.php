<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Chuquisaqueño - Sistema de Gestión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">    <style>
        body {
            background: linear-gradient(135deg, #faf7f0 0%, #f5f2e8 50%, #ede8d8 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            color: #5a4a3a;
        }
        
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .hero-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(218, 188, 150, 0.3);
            box-shadow: 0 8px 32px rgba(218, 188, 150, 0.2);
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            max-width: 600px;
        }
        
        .hotel-logo {
            font-size: 4rem;
            background: linear-gradient(45deg, #d4af37, #f4d03f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .btn-custom {
            background: linear-gradient(45deg, #d4af37, #f4d03f);
            border: none;
            padding: 1rem 2rem;            border-radius: 15px;
            color: #5a4a3a;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            margin: 0.5rem;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        }
        
        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
            background: linear-gradient(45deg, #f4d03f, #daa520);
            color: #4a3a2a;
        }
        
        .btn-outline-custom {
            border: 2px solid #d4af37;
            color: #d4af37;
            background: transparent;
            padding: 1rem 2rem;
            border-radius: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin: 0.5rem;
        }
        
        .btn-outline-custom:hover {
            background: #d4af37;
            color: #5a4a3a;
            transform: translateY(-3px);
        }
        
        .stars {
            color: #ffd700;
            font-size: 1.5rem;
            margin: 1rem 0;
        }
        
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }
          .feature-item {
            background: rgba(244, 208, 63, 0.1);
            border: 1px solid rgba(218, 188, 150, 0.2);
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
            color: #5a4a3a;
        }
        
        .feature-icon {
            font-size: 2rem;
            color: #c4002c;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="hero-card">
                        <div class="hotel-logo">
                            <i class="fas fa-hotel"></i>
                        </div>
                        
                        <h1 class="display-4 mb-3">HOTEL CHUQUISAQUEÑO</h1>
                        <p class="lead">Sucre - Bolivia</p>
                        <div class="stars">★★★★★</div>
                        
                        <p class="mb-4">Sistema de Gestión Hotelera Completo</p>
                          <div class="d-flex flex-wrap justify-content-center">
                            <a href="seleccionar_acceso.html" class="btn btn-custom">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Acceder al Sistema
                            </a>
                            <a href="verificacion_completa.php" class="btn btn-outline-custom">
                                <i class="fas fa-cogs me-2"></i>
                                Verificar Sistema
                            </a>
                        </div>
                        
                        <div class="feature-grid">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h6>Gestión de Usuarios</h6>
                                <small>Administrar clientes y personal</small>
                            </div>
                            
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-bed"></i>
                                </div>
                                <h6>Control de Habitaciones</h6>
                                <small>Estado y disponibilidad</small>
                            </div>
                            
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <h6>Sistema de Reservas</h6>
                                <small>Reservas en tiempo real</small>
                            </div>
                            
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h6>Reportes y Estadísticas</h6>
                                <small>Dashboard administrativo</small>
                            </div>
                        </div>
                        
                        <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
                        
                        <div class="row text-center">
                            <div class="col-md-6">
                                <h6><i class="fas fa-user-shield me-2"></i>Panel Administrativo</h6>
                                <p><small>Gestión completa del hotel</small></p>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-user me-2"></i>Portal Cliente</h6>
                                <p><small>Reservas y consultas</small></p>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <small class="text-muted">
                                <i class="fas fa-database me-1"></i>
                                Base de datos: bd_hoteles2 | 
                                <i class="fas fa-code me-1"></i>
                                PHP + MySQL + Bootstrap
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer flotante -->
    <div class="position-fixed bottom-0 end-0 p-3">
        <div class="d-flex gap-2">
            <a href="README_INSTALACION.md" target="_blank" class="btn btn-sm btn-outline-light">
                <i class="fas fa-book me-1"></i>
                Manual
            </a>
            <a href="insertar_datos_prueba.php" class="btn btn-sm btn-outline-warning">
                <i class="fas fa-database me-1"></i>
                Datos Prueba
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Verificar si XAMPP está corriendo
        fetch('test_conexion_bd_hoteles2.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('XAMPP no está corriendo');
                }
                return response.text();
            })
            .then(data => {
                console.log('✅ Sistema verificado correctamente');
            })
            .catch(error => {
                console.warn('⚠️ Verificar que XAMPP esté corriendo:', error);
                // Mostrar alerta discreta
                const alert = document.createElement('div');
                alert.className = 'alert alert-warning position-fixed top-0 start-50 translate-middle-x mt-3';
                alert.style.zIndex = '1050';
                alert.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Verificar que XAMPP esté corriendo';
                document.body.appendChild(alert);
                
                setTimeout(() => {
                    alert.remove();
                }, 5000);
            });
    </script>
</body>
</html>
