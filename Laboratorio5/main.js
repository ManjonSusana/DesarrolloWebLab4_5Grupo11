function cargarContenido(ruta) {
    var ajax = new XMLHttpRequest();
    ajax.open("get", ruta, true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            document.getElementById("contenido").innerHTML = ajax.responseText;

            if (ruta.endsWith("usuarios.html")) {
                var script = document.createElement("script");
                script.src = "usuarios.js";
                script.onload = function () {
                    cargarUsuarios();
                };
                document.body.appendChild(script);
            }

            if (ruta == "habitaciones.html") {
                var script = document.createElement("script");
                script.src = "habitaciones.js";
                script.onload = function () {
                    cargarHabitaciones();
                };
                document.body.appendChild(script);
            }

            if (ruta.endsWith("reservas.html")) {
                var script = document.createElement("script");
                script.src = "reservas.js";
                script.onload = function () {
                    crearPestanasReserva();
                };
                document.body.appendChild(script);
            }
        }
    };
    ajax.send();
}



