<?php
require("../../config/config.php");

$respuesta = array(
    "success" => false,
    "message" => ""
);

// Recibir datos

$email = htmlspecialchars(trim($_POST["email"]));
$password = htmlspecialchars(trim($_POST["password"]));
$rol = htmlspecialchars(trim($_POST["rol"]));

// Según el rol, comprobamos los datos

if($rol == 1) {
    $rol = "clientes";
} else if($rol == 2) {
    $rol = "asistentes";
} else if($rol == 3) {
    $rol = "cajeros";
} else if($rol == 4) {
    $rol = "duenos";
} else {
    $rol = "clientes";
}

// Y hacemos la ejecución de la consulta

$consulta = mysqli_query($conn, "SELECT * FROM ".$rol." WHERE correo = '$email' AND clave = '$password'");
if(mysqli_num_rows($consulta) > 0) {
    $respuesta['success'] = true;
    $respuesta['message'] = "Se ha logueado exitosamente";
} else {
    $respuesta['success'] = false;
    $respuesta['message'] = "La contraseña, correo o rol no son los correctos. Por favor revise";
}

echo json_encode($respuesta);