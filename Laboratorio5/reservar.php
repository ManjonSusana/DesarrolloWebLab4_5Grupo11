<?php
session_start();
include("verificarsesion.php");
include('conexion.php');

$id_usuario = $_SESSION['id_usuario'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id_habitacion = intval($_GET['id_habitacion'] ?? 0);
    
    // Obtener información de la habitación
    $sql_habitacion = "SELECT numero, piso, tipo, descripcion 
                       FROM habitaciones
                       WHERE id = ?";
    $stmt = $conexion->prepare($sql_habitacion);
    $stmt->bind_param("i", $id_habitacion);
    $stmt->execute();
    $result_habitacion = $stmt->get_result();
    $habitacion = $result_habitacion->fetch_assoc();
    ?>
    
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reservar Habitación</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">        <style>
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
            
            .form-control {
                background: rgba(250, 247, 240, 0.8);
                border: 1px solid rgba(218, 188, 150, 0.4);
                color: #5a4a3a;
            }
              .form-control:focus {
                background: rgba(255, 255, 255, 0.9);
                border-color: #d4af37;
                color: #5a4a3a;
                box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
            }
            
            .form-control::placeholder {
                color: rgba(90, 74, 58, 0.6);
            }
            
            .btn-primary {
                background: linear-gradient(45deg, #a8d8a8, #90c695);
                border: none;
                color: #4a5a4a;
                box-shadow: 0 4px 15px rgba(168, 216, 168, 0.3);
                transition: all 0.3s ease;
            }
            
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(168, 216, 168, 0.4);
                background: linear-gradient(45deg, #90c695, #7fb888);
                color: #3a4a3a;
            }
            
            .habitacion-info {
                background: rgba(244, 208, 63, 0.2);
                border-left: 4px solid #d4af37;
                border-radius: 10px;
            }
            
            .icon-input {
                position: relative;
            }
            
            .icon-input i {
                position: absolute;
                left: 12px;
                top: 50%;
                transform: translateY(-50%);
                color: rgba(90, 74, 58, 0.6);
                z-index: 10;
            }
            
            .icon-input .form-control {
                padding-left: 40px;
            }
            
            .loading-spinner {
                display: none;
            }
        </style>
    </head>
    <body>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card card-custom">
                        <div class="card-header bg-transparent border-bottom-0 text-center py-4">
                            <h2 class="text-white mb-0">
                                <i class="fas fa-bed me-2"></i>
                                Reservar Habitación
                            </h2>
                        </div>
                        <div class="card-body p-4">                            <?php if ($habitacion): ?>
                                <div class="habitacion-info p-3 rounded mb-4">
                                    <h5 class="text-white mb-2">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Información de la Habitación
                                    </h5>
                                    <div class="row text-white">
                                        <div class="col-6">
                                            <strong>Tipo:</strong> <?= htmlspecialchars(ucfirst($habitacion['tipo'])) ?>
                                        </div>
                                        <div class="col-6">
                                            <strong>Número:</strong> <?= htmlspecialchars($habitacion['numero']) ?>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <strong>Piso:</strong> <?= htmlspecialchars($habitacion['piso']) ?>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <strong>Descripción:</strong> <?= htmlspecialchars($habitacion['descripcion']) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <form id="form-reserva" onsubmit="return enviarReserva(event)">
                                <input type="hidden" id="id_habitacion" value="<?= htmlspecialchars($id_habitacion) ?>">
                                
                                <div class="mb-3">
                                    <label for="fecha_ing" class="form-label text-white">
                                        <i class="fas fa-calendar-plus me-2"></i>
                                        Fecha de Ingreso
                                    </label>
                                    <div class="icon-input">
                                        <i class="fas fa-calendar"></i>
                                        <input type="date" 
                                               class="form-control" 
                                               id="fecha_ing" 
                                               required 
                                               min="<?= date('Y-m-d') ?>">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="fecha_sal" class="form-label text-white">
                                        <i class="fas fa-calendar-minus me-2"></i>
                                        Fecha de Salida
                                    </label>
                                    <div class="icon-input">
                                        <i class="fas fa-calendar"></i>
                                        <input type="date" 
                                               class="form-control" 
                                               id="fecha_sal" 
                                               required 
                                               min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-3">
                                    <span class="button-text">
                                        <i class="fas fa-check me-2"></i>
                                        Confirmar Reserva
                                    </span>
                                    <span class="loading-spinner">
                                        <i class="fas fa-spinner fa-spin me-2"></i>
                                        Procesando...
                                    </span>
                                </button>
                            </form>
                            
                            <div id="resultado-reserva" class="mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Actualizar fecha mínima de salida cuando cambie la fecha de ingreso
            document.getElementById('fecha_ing').addEventListener('change', function() {
                const fechaIngreso = new Date(this.value);
                fechaIngreso.setDate(fechaIngreso.getDate() + 1);
                const fechaMinSalida = fechaIngreso.toISOString().split('T')[0];
                document.getElementById('fecha_sal').min = fechaMinSalida;
                
                // Si la fecha de salida es anterior a la nueva fecha mínima, resetearla
                const fechaSalida = document.getElementById('fecha_sal').value;
                if (fechaSalida && fechaSalida <= this.value) {
                    document.getElementById('fecha_sal').value = '';
                }
            });
            
            function enviarReserva(event) {
                event.preventDefault();

                const button = event.target.querySelector('button[type="submit"]');
                const buttonText = button.querySelector('.button-text');
                const loadingSpinner = button.querySelector('.loading-spinner');
                
                // Mostrar spinner de carga
                buttonText.style.display = 'none';
                loadingSpinner.style.display = 'inline';
                button.disabled = true;

                const id_habitacion = document.getElementById('id_habitacion').value;
                const fecha_ing = document.getElementById('fecha_ing').value;
                const fecha_sal = document.getElementById('fecha_sal').value;                const formData = new FormData();
                formData.append('id_habitacion', id_habitacion);
                formData.append('fecha_ing', fecha_ing);
                formData.append('fecha_sal', fecha_sal);
                formData.append('id_usuario', <?= $_SESSION['id_usuario'] ?>);

                fetch('insertar.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.text())
                .then(data => {
                    document.getElementById('resultado-reserva').innerHTML = data;
                    
                    // Si la reserva fue exitosa, limpiar el formulario
                    if (data.includes('alert-success')) {
                        document.getElementById('form-reserva').reset();
                    }
                })
                .catch(err => {
                    console.error('Error al enviar la reserva:', err);
                    document.getElementById('resultado-reserva').innerHTML = 
                        '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Error de conexión. Inténtalo nuevamente.</div>';
                })
                .finally(() => {
                    // Restaurar botón
                    buttonText.style.display = 'inline';
                    loadingSpinner.style.display = 'none';
                    button.disabled = false;
                });

                return false;
            }
        </script>
    </body>
    </html>

    <?php
    exit;
}
?>
