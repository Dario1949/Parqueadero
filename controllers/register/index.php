<?php
require("../../config/config.php");

$respuesta = array(
    "success" => true,
    "message" => ""
);

// Vamos a obtener los datos del formulario

$name = htmlspecialchars(trim($_POST["name"]));
$lastname = htmlspecialchars(trim($_POST["lastname"]));
$tel = htmlspecialchars(trim($_POST["tel"]));
$email = htmlspecialchars(trim($_POST["email"]));
$password = htmlspecialchars(trim($_POST["password"]));
$rol = htmlspecialchars(trim($_POST["rol"]));

// Según el rol, comprobamos los datos

if ($rol == 1) {
    $rol = "clientes";
} else if ($rol == 2) {
    $rol = "asistentes";
} else if ($rol == 3) {
    $rol = "cajeros";
} else if ($rol == 4) {
    $rol = "duenos";
} else {
    $rol = "clientes";
}

// Vamos a comprobar si el correo ya existe

$comprobar_correo_existe = mysqli_query($conn, "SELECT * FROM ".$rol." WHERE correo = '$email'");
if (mysqli_num_rows($comprobar_correo_existe) > 0) {
    $respuesta['success'] = false;
    $respuesta['message'] = "El correo ya está en uso, por favor elija otro";
} else {
    // Vamos a crear la cuenta
    $crear_cuenta = mysqli_query($conn, "INSERT INTO ".$rol." (nombre,apellido,correo,clave,telefono,salario) VALUES ('$name', '$lastname', '$email', '$password', '$tel', '1200000')");
    if ($crear_cuenta) {
        $respuesta['success'] = true;
        $respuesta['message'] = "Se ha creado la cuenta con éxito";
    }
}

echo json_encode($respuesta);
