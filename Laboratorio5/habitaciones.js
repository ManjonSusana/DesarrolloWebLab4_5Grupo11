function cargarHabitaciones(pisoActivo = "1") {
    fetch('readHabitaciones.php')
        .then(function(respuesta) {
            return respuesta.json();
        })
        .then(function(data) {
            var contenedor = document.getElementById("habitaciones-container");
            contenedor.innerHTML = "";

            var pisos = {};
            data.forEach(function(h) {
                if (!pisos[h.piso]) {
                    pisos[h.piso] = [];
                }
                pisos[h.piso].push(h);
            });

            var tabs = document.createElement("div");
            tabs.className = "tabs";

            var contenidoTabs = document.createElement("div");
            contenidoTabs.className = "contenedor-pisos";

            for (var piso in pisos) {
                var boton = document.createElement("button");
                boton.textContent = piso + "° NIVEL";
                boton.setAttribute("data-piso", piso);

                if (piso == pisoActivo) {
                    boton.className = "activo";
                }

                boton.onclick = function() {
                    var pisoSeleccionado = this.getAttribute("data-piso");
                    cargarHabitaciones(pisoSeleccionado);
                };
                tabs.appendChild(boton);

                var divPiso = document.createElement("div");
                divPiso.id = "piso-" + piso;
                divPiso.style.display = (piso == pisoActivo) ? "flex" : "none";
                divPiso.style.flexWrap = "wrap";
                divPiso.style.gap = "10px";

                pisos[piso].forEach(function(habitacion) {
                    var div = document.createElement("div");
                    div.className = "habitacion " + habitacion.estado;
                    div.setAttribute("data-id", habitacion.id);

                    var numero = document.createElement("div");
                    numero.className = "numero-habitacion";
                    numero.textContent = habitacion.numero;

                    var tipo = document.createElement("div");
                    tipo.className = "tipo-habitacion";
                    tipo.textContent = habitacion.tipo;

                    var icono = document.createElement("div");
                    icono.className = "icono-fondo";
                    icono.innerHTML = "<i class='bi bi-door-open'></i>";



                    var estado = document.createElement("div");
                    estado.className = "estado-texto";
                    estado.textContent = habitacion.estado.replace('_', ' ');

                    var menu = document.createElement("div");
                    menu.className = "menu-opciones";
                    menu.innerHTML =
                        "<div class='puntos' onclick='toggleMenu(this)'>⋮</div>" +
                        "<div class='estado-menu' style='display:none;'>" +
                        "<div onclick=\"actualizarEstado(" + habitacion.id + ", '" + habitacion.piso + "', 'disponible')\">Disponible</div>" +
                        "<div onclick=\"actualizarEstado(" + habitacion.id + ", '" + habitacion.piso + "', 'reservada')\">Reservada</div>" +
                        "<div onclick=\"actualizarEstado(" + habitacion.id + ", '" + habitacion.piso + "', 'ocupado')\">Ocupado</div>" +
                        "<div onclick=\"actualizarEstado(" + habitacion.id + ", '" + habitacion.piso + "', 'fuera_servicio')\">Fuera de servicio</div>" +
                        "</div>";

                    div.appendChild(menu);
                    div.appendChild(numero);
                    div.appendChild(tipo);
                    div.appendChild(icono);
                    div.appendChild(estado);

                    divPiso.appendChild(div);
                    var btnDetalles = document.createElement("button");
                    btnDetalles.className = "btn-detalles";
                    btnDetalles.innerHTML = "<i class='bi bi-info-circle'></i> Detalles";
                    btnDetalles.onclick = function() {  
                        mostrarDetallesHabitacion(habitacion.id);
                    };
                    div.appendChild(btnDetalles);

                });

                contenidoTabs.appendChild(divPiso);
            }

            contenedor.appendChild(tabs);
            contenedor.appendChild(contenidoTabs);
        });
}

function toggleMenu(puntos) {
    var menu = puntos.nextElementSibling;
    if (menu.style.display == "none") {
        menu.style.display = "block";
    } else {
        menu.style.display = "none";
    }
}

function actualizarEstado(id, piso, estado) {
    fetch("estadoHabitacion.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "id=" + id + "&estado=" + estado
    })
    .then(function(r) {
        return r.text();
    })
    .then(function(respuesta) {
        cargarHabitaciones(piso);
    });
}

function mostrarDetallesHabitacion(id_habitacion) {
    fetch("getDetalleHabitacion.php?id=" + id_habitacion)
        .then(r => r.json())
        .then(function(data) {
            document.getElementById("modal-detalles").style.display = "block";

            // Mostrar siempre detalles de habitación
            document.getElementById("det-descripcion").textContent = data.descripcion || "Sin descripción.";
            document.getElementById("det-imagen").src = data.fotografia ? data.fotografia : "imagenes/default.jpg";

            if (data && data.nombre) {
                document.getElementById("det-nombre").textContent = data.nombre;
                document.getElementById("det-ci").textContent = data.ci;
                document.getElementById("det-telefono").textContent = data.telefono;
                document.getElementById("det-entrada").textContent = data.fecha_entrada;
                document.getElementById("det-salida").textContent = data.fecha_salida;
                document.getElementById("cliente-info").style.display = "block";
            } else {
                document.getElementById("cliente-info").style.display = "none";
            }
        });
}

function cerrarModalDetalles() {
    document.getElementById("modal-detalles").style.display = "none";
}


