function crearReserva() {
    var contenedor;
    contenedor = document.getElementById('contenido');
    var formulario = document.getElementById("datos-persona");
    var parametros = new FormData(formulario);
    var ajax = new XMLHttpRequest(); //crea el objeto ajax 
    console.log("Creando reserva...");
    ajax.open("post", "insertar.php", true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            contenedor.innerHTML = ajax.responseText;
        }
    }
    ajax.send(parametros);
}

function cargarContenido(abrir) {
    var contenedor;
    contenedor = document.getElementById("contenido");
    
    // Añadir un efecto de carga
    contenedor.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-3 text-muted">Cargando contenido...</p>
        </div>
    `;
    
    fetch(abrir)
        .then((response) => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.text();
        })
        .then((data) => {
            contenedor.innerHTML = data;
            
            // Reinicializar tooltips de Bootstrap si existen
            if (typeof bootstrap !== 'undefined') {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        })
        .catch((error) => {
            console.error('Error al cargar contenido:', error);
            contenedor.innerHTML = `
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Error:</strong> No se pudo cargar el contenido solicitado.
                </div>
            `;
        });
}

function cargarContenidoModal(abrir) {
    const modalBody = document.getElementById("modal-body");
    
    // Añadir spinner al modal
    modalBody.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-3">Cargando...</p>
        </div>
    `;
    
    fetch(abrir)
        .then((response) => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.text();
        })
        .then((data) => {
            modalBody.innerHTML = data;
            document.getElementById("modal").style.display = "block";
        })
        .catch((error) => {
            console.error('Error al cargar contenido del modal:', error);
            modalBody.innerHTML = `
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error al cargar el contenido.
                </div>
            `;
            document.getElementById("modal").style.display = "block";
        });
}

function cerrarModal() {
    document.getElementById("modal").style.display = "none";
}

// Función mejorada para enviar reservas con validación
function enviarReservaAjax(formData, successCallback, errorCallback) {
    fetch('insertar.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        return response.text();
    })
    .then(data => {
        if (typeof successCallback === 'function') {
            successCallback(data);
        }
    })
    .catch(error => {
        console.error('Error al enviar reserva:', error);
        if (typeof errorCallback === 'function') {
            errorCallback(error);
        }
    });
}

// Cerrar modal al hacer clic fuera de él
window.onclick = function(event) {
    const modal = document.getElementById("modal");
    if (event.target == modal) {
        cerrarModal();
    }
}

// Función para mostrar notificaciones toast (si se usa Bootstrap)
function mostrarNotificacion(mensaje, tipo = 'success') {
    const toastContainer = document.querySelector('.toast-container') || createToastContainer();
    
    const toastId = 'toast-' + Date.now();
    const toastHTML = `
        <div id="${toastId}" class="toast align-items-center text-white bg-${tipo} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    ${mensaje}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHTML);
    
    const toast = new bootstrap.Toast(document.getElementById(toastId));
    toast.show();
    
    // Remover el toast del DOM después de que se oculte
    document.getElementById(toastId).addEventListener('hidden.bs.toast', function () {
        this.remove();
    });
}

function createToastContainer() {
    const container = document.createElement('div');
    container.className = 'toast-container position-fixed top-0 end-0 p-3';
    container.style.zIndex = '9999';
    document.body.appendChild(container);
    return container;
}
