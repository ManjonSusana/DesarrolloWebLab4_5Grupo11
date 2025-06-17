$(function () {
  $("#btn-crud").click(function (e) {
    e.preventDefault();
    cargarTabla();
  });
});

function cargarTabla() {
  $("#contenido").html("Cargando...");
  $.get("CuentasCorreos.php", function (data) {
    $("#contenido").html(data);
  });
}

function eliminarUsuario(id) {
  if (confirm("¿Estás seguro de eliminar este usuario?")) {
    $.post("EliminarUsuario.php", { id: id }, function (respuesta) {
      alert(respuesta);
      cargarTabla();
    });
  }
}

function editarUsuario(id, correo, password, nombre, nivel) {
  $("#contenido").html(`
    <h3>Editar Usuario</h3>
    <form id="formEditar">
      <input type="hidden" name="id" value="${id}">
      <label>Correo: <input type="text" name="correo" value="${correo}"></label><br>
      <label>Contraseña: <input type="text" name="password" value="${password}"></label><br>
      <label>Nombre: <input type="text" name="nombre" value="${nombre}"></label><br>
      <label>Nivel: <input type="text" name="nivel" value="${nivel}"></label><br>
      <button type="submit">Guardar Cambios</button>
    </form>
  `);

  $("#formEditar").submit(function (e) {
    e.preventDefault();
    $.post("ActualizarUsuario.php", $(this).serialize(), function (respuesta) {
      alert(respuesta);
      cargarTabla();
    });
  });
}

$(document).on("submit", "#formNuevoUsuario", function (e) {
  e.preventDefault();
  $.post("NuevoUsuario.php", $(this).serialize(), function (respuesta) {
    alert(respuesta);
    cargarTabla();
  });
});


// Mostrar lista de usuarios para suspender/habilitar
$("#btn-susp").click(function (e) {
  e.preventDefault();
  $("#contenido").html("Cargando...");
  $.get("SuspenderHabilitar.php", function (data) {
    $("#contenido").html(data);
  });
});

// Cambiar estado del usuario
function cambiarEstado(id, accion) {
  $.post("CambiarEstado.php", { id: id, accion: accion }, function (respuesta) {
    alert(respuesta);
    $("#btn-susp").click(); // Recargar la vista
  });
}


// Mostrar correos
$("#btn-revisar").click(function (e) {
  e.preventDefault();
  $("#contenido").html("Cargando...");
  $.get("RevisarCorreos.php", function (data) {
    $("#contenido").html(data);
  });
});


// Cargar formulario
$("#btn-enviar").click(function (e) {
  e.preventDefault();
  $("#contenido").html("Cargando...");
  $.get("FormularioEnviarCorreo.php", function (data) {
    $("#contenido").html(data);
  });
});

// Enviar formulario con AJAX
$(document).on("submit", "#form-enviar-aviso", function (e) {
  e.preventDefault();

  $.ajax({
    url: "EnviarCorreo.php",
    method: "POST",
    data: $(this).serialize(),
    success: function (respuesta) {
      alert(respuesta);
      $("#form-enviar-aviso")[0].reset();
    },
    error: function () {
      alert("Error al enviar el aviso.");
    }
  });
});


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