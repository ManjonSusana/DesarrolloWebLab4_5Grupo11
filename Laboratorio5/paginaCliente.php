<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Sistema Hotel</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
</head>
<body>
        <header class="navbar">
            <div class="logo" onclick="javascript:cargarContenido('menu.php')">
            HOTEL CHUQUISAQUEÑO<br><span>Sucre</span>
            </div>

            <div class="navegador">
            <div class="nav-item" onclick="javascript:cargarContenido('verTipos.php')">TIPO DE HABITACIÓN</div>
            <div class="nav-item" onclick="javascript:cargarContenido('verHabitaciones.php')">HABITACIÓN</div>
            <div class="nav-item" onclick="cargarPagina()">CONTÁCTANOS</div>
            </div>

            <div class="btn-reserva" onclick="cargarContenido('verReservas.php')">RESERVACIONES</div>
        </header>
            
    <div id="contenido" >

        <section class="hero">
            <div class="overlay"></div>
            <div class="hero-content">
            <h1>Somos el mejor Hotel</h1>
            <h2>HOTEL CHUQUISAQUEÑO</h2>
            <p>Contamos con todas las comodidades para ti</p>
            <div class="stars">★★★</div>
            </div>
        </section>
    </div>
    
    <div id="modal" class="modal">
    <div class="modal-content">
        <span class="cerrar" onclick="cerrarModal()">&times;</span>
        <div id="modal-body"></div>
    </div>
    </div>

</body>
</html>
