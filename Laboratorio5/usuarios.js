function cargarUsuarios() {
    fetch('readUsuarios.php')
        .then(function(respuesta) {
            return respuesta.json();
        })
        .then(function(data) {
            var tabla = document.getElementById("tabla-usuarios");
            tabla.innerHTML = "";

            data.forEach(function(u) {
                var fila = "<tr>" +
                    "<td>" + u.nombre + "</td>" +
                    "<td>" + u.correo + "</td>" +
                    "<td>" + u.telefono + "</td>" +
                    "<td>" + (u.ci ? u.ci : '') + "</td>" +
                    "<td>" + u.fecha_registro + "</td>" +
                    "<td>" +
                        "<button class='btn-editar' onclick='editarUsuario(" + u.id + ")'><i class='bi bi-pencil-square'></i>Editar</button> " +
                        "<button class='btn-eliminar' onclick='eliminarUsuario(" + u.id + ")'><i class='bi bi-trash'></i>Eliminar</button>" +
                    "</td>" +
                "</tr>";
                tabla.innerHTML += fila;
            });
        });
}

function mostrarModal() {
    document.getElementById("modal-registro").style.display = "block";
}

function cerrarModal() {
    document.getElementById("modal-registro").style.display = "none";
}

function registrarUsuario() {
    var nombre = document.getElementById("nombre").value;
    var correo = document.getElementById("correo").value;
    var telefono = document.getElementById("telefono").value;
    var ci = document.getElementById("ci").value;

    if (nombre == "" || correo == "" || telefono == "") {
        alert("Nombre, correo y teléfono son obligatorios.");
        return;
    }

    var datos = "nombre=" + encodeURIComponent(nombre) +
                "&correo=" + encodeURIComponent(correo) +
                "&telefono=" + encodeURIComponent(telefono) +
                "&ci=" + encodeURIComponent(ci);

    fetch("insertUsuario.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: datos
    })
    .then(function(r) {
        return r.text();
    })
    .then(function(respuesta) {
        alert(respuesta);
        cerrarModal();
        cargarUsuarios();
    });
}


function cerrarModalEditar() {
    document.getElementById("modal-editar").style.display = "none";
}

function editarUsuario(id) {
    fetch("getUsuario.php?id=" + id)
        .then(function(r) {
            return r.json();
        })
        .then(function(data) {
            document.getElementById("editar-id").value = data.id;
            document.getElementById("editar-nombre").value = data.nombre;
            document.getElementById("editar-correo").value = data.correo;
            document.getElementById("editar-telefono").value = data.telefono;
            document.getElementById("editar-ci").value = data.ci;

            document.getElementById("modal-editar").style.display = "block";
        });
}



function guardarEdicion() {
    var id = document.getElementById("editar-id").value;
    var nombre = document.getElementById("editar-nombre").value;
    var correo = document.getElementById("editar-correo").value;
    var telefono = document.getElementById("editar-telefono").value;
    var ci = document.getElementById("editar-ci").value;

    if (nombre == "" || correo == "" || telefono == "") {
        alert("Nombre, correo y teléfono son obligatorios.");
        return;
    }

    var datos = "id=" + id +
                "&nombre=" + encodeURIComponent(nombre) +
                "&correo=" + encodeURIComponent(correo) +
                "&telefono=" + encodeURIComponent(telefono) +
                "&ci=" + encodeURIComponent(ci);

    fetch("updateUsuario.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: datos
    })
    .then(function(r) {
        return r.text();
    })
    .then(function(respuesta) {
        alert(respuesta);
        cerrarModalEditar();
        cargarUsuarios();
    });
}


function eliminarUsuario(id) {
    if (confirm("¿Seguro que deseas eliminar este usuario?")) {
        fetch("deleteUsuario.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "id=" + id
        })
        .then(function(r) {
            return r.text();
        })
        .then(function(respuesta) {
            alert(respuesta);
            cargarUsuarios();
        });
    }
}



function buscarUsuario() {
    var texto = document.getElementById("filtro-usuario").value.toLowerCase();
    var filas = document.querySelectorAll("#tabla-usuarios tr");

    filas.forEach(function(fila) {
        var celdas = fila.getElementsByTagName("td");
        if (celdas.length > 3) {
            var ci = celdas[3].textContent.toLowerCase();

            fila.style.display = ci.includes(texto) ? "" : "none";
        }
    });
}
