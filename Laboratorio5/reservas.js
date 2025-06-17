var filtroActual = "hoy";

function cargarReservas(filtro = 'hoy') {
    const pestanaActiva = document.querySelector('.btn-pestana.activo');
    const filtroActivo = pestanaActiva ? pestanaActiva.getAttribute('data-filtro') : filtro;

    fetch('readReservas.php?filtro=' + filtroActivo)
        .then(function(respuesta) {
            return respuesta.json();
        })
        .then(function(data) {
            var tabla = document.getElementById("tabla-reservas");
            tabla.innerHTML = "";

            data.forEach(function(r) {
                var fila = "<tr>" +
                    "<td>" + r.nombre_usuario + "</td>" +
                    "<td>" + r.tipo_habitacion + "</td>" +
                    "<td>" + r.fecha_entrada + "</td>" +
                    "<td>" + r.fecha_salida + "</td>" +
                    "<td>" + r.estado + "</td>" +
                    "<td>" + r.fecha_reserva + "</td>" +
                    "<td>" +
                        "<button class='btn-estado pendiente' onclick=\"actualizarEstadoReserva(" + r.id + ", 'pendiente')\">" +
                        "<i class='bi bi-hourglass-split'></i> Pendiente</button> " +

                        "<button class='btn-estado confirmada' onclick=\"actualizarEstadoReserva(" + r.id + ", 'confirmada')\">" +
                        "<i class='bi bi-check-circle'></i> Confirmada</button> " +

                        "<button class='btn-estado cancelada' onclick=\"actualizarEstadoReserva(" + r.id + ", 'cancelada')\">" +
                        "<i class='bi bi-x-circle'></i> Cancelada</button> " +

                        "<button class='btn-estado reservar' onclick='asignarHabitacion(" + r.id + ", " + JSON.stringify(r.tipo_habitacion) + ")'>" +
                        "<i class='bi bi-door-closed'></i> Reservar</button>" +
                    "</td>" +
                    "<td>" +
                        "<button class='btn-editar' onclick='editarReserva(" + r.id + ")'>" +
                        "<i class='bi bi-pencil-square'></i> Editar</button> " +

                        "<button class='btn-eliminar' onclick='eliminarReserva(" + r.id + ")'>" +
                        "<i class='bi bi-trash'></i> Eliminar</button>" +
                    "</td>" +
                "</tr>";

                tabla.innerHTML += fila;
            });
        });
}


function crearPestanasReserva() {
    var contenedor = document.getElementById("pestanas-reservas");
    contenedor.innerHTML = "";

    var pestañas = [
        { nombre: "Hoy", valor: "hoy" },
        { nombre: "Futuras", valor: "futuras" },
        { nombre: "Pasadas", valor: "pasadas" }
    ];

    pestañas.forEach(function(p) {
        var btn = document.createElement("button");
        btn.textContent = p.nombre;
        btn.setAttribute("data-filtro", p.valor);
        btn.className = "btn-pestana";

        btn.onclick = function() {
            var activo = document.querySelector(".btn-pestana.activo");
            if (activo) activo.classList.remove("activo");
            this.classList.add("activo");
            cargarReservas(p.valor);
        };

        contenedor.appendChild(btn);
    });

    contenedor.querySelector("button[data-filtro='hoy']").classList.add("activo");
    cargarReservas("hoy");
}

document.addEventListener("DOMContentLoaded", function() {
    crearPestanasReserva();
});



function mostrarModalReserva() {
    document.getElementById("modal-reserva").style.display = "block";
}

function cerrarModalReserva() {
    document.getElementById("modal-reserva").style.display = "none";
}

function registrarReserva() {
    var nombre = document.getElementById("nombre_cliente").value;
    var correo = document.getElementById("correo_cliente").value;
    var telefono = document.getElementById("telefono_cliente").value;
    var tipo = document.getElementById("tipo_habitacion").value;
    var entrada = document.getElementById("fecha_entrada").value;
    var salida = document.getElementById("fecha_salida").value;

    if (nombre == "" || correo == "" || telefono == "" || tipo == "" || entrada == "" || salida == "") {
        alert("Todos los campos son obligatorios.");
        return;
    }

    var datos = "nombre=" + encodeURIComponent(nombre) +
                "&correo=" + encodeURIComponent(correo) +
                "&telefono=" + encodeURIComponent(telefono) +
                "&tipo=" + encodeURIComponent(tipo) +
                "&entrada=" + entrada +
                "&salida=" + salida;

    fetch("insertReserva.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: datos
    })
    .then(function(r) { return r.text(); })
    .then(function(respuesta) {
        alert(respuesta);
        cerrarModalReserva();
        cargarReservas(filtroActual);
    });
}


function actualizarEstadoReserva(id, estado) {
    fetch("estadoReserva.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "id=" + id + "&estado=" + estado
    })
    .then(function(r) { return r.text(); })
    .then(function(respuesta) {
        
        if (estado === "confirmada") {
            fetch("ocuparHabitacion.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "id_reserva=" + id
            })
            .then(function(r2) { return r2.text(); })
            .then(function(res2) {  
                if (res2.includes("actualizada a ocupado")) {
                    alert("Reserva confirmada y habitación ocupada.");
                } else if (res2.includes("No hay habitación asignada")) {
                    alert("No se puede confirmar: esta reserva no tiene habitación asignada.");
                } else {
                    alert("Error al actualizar la habitación.");
                }
                cargarReservas(filtroActual);
            });

        } else {
            cargarReservas(filtroActual);
        }
    });
}





function editarReserva(id) {
    fetch("getReserva.php?id=" + id)
        .then(r => r.json())
        .then(function(data) {
            document.getElementById("editar-id").value = data.id;
            document.getElementById("editar-nombre").value = data.nombre_usuario;
            document.getElementById("editar-entrada").value = data.fecha_entrada;
            document.getElementById("editar-salida").value = data.fecha_salida;

            fetch("getTiposHabitacion.php")
                .then(r => r.json())
                .then(function(tipos) {
                    var selectTipo = document.getElementById("editar-tipo");
                    selectTipo.innerHTML = "";
                    tipos.forEach(function(t) {
                        var op = document.createElement("option");
                        op.value = t;
                        op.text = t;
                        if (t == data.tipo_habitacion) op.selected = true;
                        selectTipo.appendChild(op);
                    });

                    document.getElementById("modal-editar-reserva").style.display = "block";
                });
        });
}

function guardarEdicionReserva() {
    var id = document.getElementById("editar-id").value;
    var nombre = document.getElementById("editar-nombre").value;
    var tipo = document.getElementById("editar-tipo").value;
    var entrada = document.getElementById("editar-entrada").value;
    var salida = document.getElementById("editar-salida").value;

    fetch("updateReserva.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "id=" + id +
              "&nombre=" + encodeURIComponent(nombre) +
              "&tipo=" + encodeURIComponent(tipo) +
              "&entrada=" + entrada +
              "&salida=" + salida
    })
    .then(r => r.text())
    .then(function(resp) {
        alert(resp);
        cerrarModalEditarReserva();
        cargarReservas(filtroActual);
    });
}

function cerrarModalEditarReserva() {
    document.getElementById("modal-editar-reserva").style.display = "none";
}


function eliminarReserva(id) {
    if (confirm("¿Seguro que deseas eliminar esta reserva?")) {
        fetch("deleteReserva.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "id=" + id
        })
        .then(function(r) {
            return r.text();
        })
        .then(function(respuesta) {
            alert(respuesta);
            cargarReservas(filtroActual);
        });
    }
}


function buscarPorNombre() {
    var nombre = document.getElementById("filtro-nombre").value.trim();

    if (nombre == "") {
        crearPestanasReserva();
        return;
    }

    fetch("readReservas.php?nombre=" + encodeURIComponent(nombre))
        .then(function(r) { return r.json(); })
        .then(function(data) {
            var tabla = document.getElementById("tabla-reservas");
            tabla.innerHTML = "";

            data.forEach(function(r) {
                var fila = "<tr>" +
                    "<td>" + r.nombre_usuario + "</td>" +
                    "<td>" + r.tipo_habitacion + "</td>" +
                    "<td>" + r.fecha_entrada + "</td>" +
                    "<td>" + r.fecha_salida + "</td>" +
                    "<td>" + r.estado + "</td>" +
                    "<td>" + r.fecha_reserva + "</td>" +
                    "<td>" +
                        "<button class='btn-estado pendiente' onclick=\"actualizarEstadoReserva(" + r.id + ", 'pendiente')\">" +
                        "<i class='bi bi-hourglass-split'></i> Pendiente</button> " +
                        "<button class='btn-estado confirmada' onclick=\"actualizarEstadoReserva(" + r.id + ", 'confirmada')\">" +
                        "<i class='bi bi-check-circle'></i> Confirmada</button> " +
                        "<button class='btn-estado cancelada' onclick=\"actualizarEstadoReserva(" + r.id + ", 'cancelada')\">" +
                        "<i class='bi bi-x-circle'></i> Cancelada</button>" +
                    "</td>" +
                    "<td>" +
                        "<button class='btn-editar' onclick='editarReserva(" + r.id + ")'>" +
                        "<i class='bi bi-pencil-square'></i> Editar</button> " +
                        "<button class='btn-eliminar' onclick='eliminarReserva(" + r.id + ")'>" +
                        "<i class='bi bi-trash'></i> Eliminar</button>" +
                    "</td>" +
                    "</tr>";
                tabla.innerHTML += fila;
            });
        });
}


function asignarHabitacion(id, tipo) {
    fetch("getHabitacionAsignada.php?id_reserva=" + id)
        .then(r => r.json())
        .then(function(data) {
            if (data.asignada) {
                alert("Esta reserva ya tiene asignada la habitación N° " + data.numero);
            } else {
                document.getElementById("reserva-id-asignar").value = id;
                document.getElementById("tipo-mostrar").textContent = tipo;

                fetch("getHabitacionesDisponibles.php?tipo=" + tipo)
                    .then(r => r.json())
                    .then(function(lista) {
                        var select = document.getElementById("habitacion-disponible");
                        select.innerHTML = "";
                        lista.forEach(function(h) {
                            var op = document.createElement("option");
                            op.value = h.id;
                            op.text = "N° " + h.numero;
                            select.appendChild(op);
                        });

                        document.getElementById("modal-asignar").style.display = "block";
                    });
            }
        });
}



function confirmarAsignacion() {
    var id_reserva = document.getElementById("reserva-id-asignar").value;
    var id_habitacion = document.getElementById("habitacion-disponible").value;

    if (!id_habitacion) {
        alert("Seleccione una habitación.");
        return;
    }

    fetch("asignarHabitacion.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "id_reserva=" + id_reserva + "&id_habitacion=" + id_habitacion
    })
    .then(function(r) { return r.text(); })
    .then(function(res) {
        alert(res);
        cerrarModalAsignar();
        cargarReservas(filtroActual);
    });
}

function cerrarModalAsignar() {
    document.getElementById("modal-asignar").style.display = "none";
}

