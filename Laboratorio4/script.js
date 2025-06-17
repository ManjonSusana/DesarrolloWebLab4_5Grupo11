function autenticar() {
    const form = document.getElementById("login");
    const formData = new FormData(form);

    fetch("autenticar.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const mensaje = document.getElementById("mensaje");

        if (data.status === "success") {
            mensaje.style.color = "green";
            mensaje.textContent = data.message;
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 1000);
        } else {
            mensaje.style.color = "red";
            mensaje.textContent = data.message;
        }
    })
    .catch(error => {
        console.error("Error en la solicitud AJAX:", error);
        document.getElementById("mensaje").textContent = "Ocurrió un error al intentar autenticar.";
    });
}


//bandeja entrada
function BandejaEntrada() {
	var contenedor;
	contenedor = document.getElementById('contenido');
	var ajax = new XMLHttpRequest() //crea el objetov ajax
	ajax.open("get", 'listarEntrada.php', true);
	ajax.onreadystatechange = function () {
		if (ajax.readyState == 4) {
			
			contenedor.innerHTML = ajax.responseText
		}
	}
	ajax.setRequestHeader("Content-Type", "text/html; charset=utf-8");
	ajax.send();
}
//bandeja salida
function BandejaSalida() {
	var contenedor;
	contenedor = document.getElementById('contenido');
	var ajax = new XMLHttpRequest() //crea el objetov ajax 
	ajax.open("get", 'listarSalida.php', true);
	ajax.onreadystatechange = function () {
		if (ajax.readyState == 4) {
			
			contenedor.innerHTML = ajax.responseText
		}
	}
	ajax.setRequestHeader("Content-Type", "text/html; charset=utf-8");
	ajax.send();
}

//bandejaBorradores
function BandejaBorradores() {
	var contenedor;
	contenedor = document.getElementById('contenido');
	var ajax = new XMLHttpRequest() //crea el objetov ajax 
	ajax.open("get", 'listarBorradores.php', true);
	ajax.onreadystatechange = function () {
		if (ajax.readyState == 4) {
			
			contenedor.innerHTML = ajax.responseText
		}
	}
	ajax.setRequestHeader("Content-Type", "text/html; charset=utf-8");
	ajax.send();
}
//crear correo
function crearcorreo() {
	var contenedor;
	contenedor = document.getElementById('contenido');
    var formulario = document.getElementById("datos-persona");
    var parametros =new FormData(formulario);
    var ajax = new XMLHttpRequest() //crea el objetov ajax 
    ajax.open("post", "insertar.php", true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            contenedor.innerHTML = ajax.responseText
        }
    }
    ajax.send(parametros);
}

function guardar() {
	var contenedor;
	contenedor = document.getElementById('contenido');
    var formulario = document.getElementById("datos-persona");
    var parametros =new FormData(formulario);
    var ajax = new XMLHttpRequest() //crea el objetov ajax 
    ajax.open("post", "guardar.php", true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            contenedor.innerHTML = ajax.responseText
        }
    }
    ajax.send(parametros);
    
}

function enviarMensaje(id) {
    var ajax = new XMLHttpRequest();
    var url = "actualizarrBandeja.php?id=" + encodeURIComponent(id);

    ajax.open("GET", url, true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState === 4) {
            if (ajax.status === 200) {
                // Mostrar respuesta del servidor
                alert(ajax.responseText);
                BandejaBorradores();
            } else {
                alert("Error al enviar el mensaje. Código: " + ajax.status);
            }
        }
    };

    ajax.send();
}


function verMensaje(id) {
    var contenedor = document.getElementById("mensajeContenido");
    var ajax = new XMLHttpRequest();

    ajax.open("GET", "verMensaje.php?id=" + id, true); // Abrir la petición

    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            contenedor.innerHTML = ajax.responseText;
            document.getElementById("myModal").style.display = "block";
        }
    };

    ajax.setRequestHeader("Content-Type", "text/html; charset=utf-8"); 
    ajax.send(); // Enviar la solicitud
}
//redactar
function redactar() {
	// var contenedor;
	var contenedor = document.getElementById('mensajeContenido');

	var ajax = new XMLHttpRequest()
	
    ajax.open("get", 'redactar.php', true);
	
    ajax.onreadystatechange = function () {
		if (ajax.readyState == 4 && ajax.status == 200) {
			contenedor.innerHTML = ajax.responseText;
            document.getElementById("myModal").style.display = "block";
		}
	}
	ajax.setRequestHeader("Content-Type", "text/html; charset=utf-8");
	ajax.send();
}

function cerrarModal() {
    document.getElementById("myModal").style.display = "none";
}

window.onclick = function(event) {
    var modal = document.getElementById("myModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
};
//eliminar
function eliminarCorreoSa(id) {
    
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "deleteCorreo.php?id=" + id, true);

    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            contenedor.innerHTML = ajax.responseText;
            document.getElementById("myModal").style.display = "block";
        }
            BandejaSalida();
    };
    ajax.send();
}
function eliminarCorreoEn(id) {
    
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "deleteCorreo.php?id=" + id, true);

    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            contenedor.innerHTML = ajax.responseText;
            document.getElementById("myModal").style.display = "block";
        }
            BandejaEntrada();
    };
    ajax.send();
}


function cerrarSesion() {
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "logout.php", true);

    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            window.location.href = "formlogin.html"; // Redirigir al inicio
        }
    };
    ajax.send();
}