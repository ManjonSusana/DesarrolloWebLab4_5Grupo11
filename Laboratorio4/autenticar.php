<?php
session_start();
include("conexion.php");

$correo = $_POST['correo'];
$password = sha1($_POST['password']);

$stmt = $con->prepare('SELECT correo, nombre, nivel FROM usuarios WHERE correo=? AND password=?');
$stmt->bind_param("ss", $correo, $password);
$stmt->execute();
$result = $stmt->get_result();

header('Content-Type: application/json');

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    $_SESSION['correo'] = $usuario['correo'];
    $_SESSION['nivel'] = $usuario['nivel'];

    echo json_encode([
        'status' => 'success',
        'message' => 'Bienvenido ' . $usuario['nombre'],
        'redirect' => ($usuario['nivel'] == 1) ? 'Administrador.html' : 'interfazusuario.html'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No se puede ingresar.'
    ]);
}
?>
