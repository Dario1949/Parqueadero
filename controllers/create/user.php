<?php
require("../../config/config.php");

$nombre = "";
$apellido = "";
$telefono = "";
$correo = "";
$clave = "";
$salario = "";
$rol = "";

$respuesta = array(
    "success" => false,
    "message" => ""
);

$rol = $_POST["rol"];

if ($rol === "asistente" || $rol === "admin" || $rol === "cajero") {
    // Crear asistente || administrador || cajero

    if ($rol === "asistente") {
        $rol = "asistentes";
    }
    if ($rol === "admin") {
        $rol = "duenos";
    }
    if ($rol === "cajero") {
        $rol = "cajeros";
    }

    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];
    $salario = $_POST["salario"];

    // Comprobar si el correo ya existe

    $comprobar = mysqli_query($conn, "SELECT * FROM " . $rol . " WHERE correo = '$correo'");
    if (mysqli_num_rows($comprobar) > 0) {
        $respuesta['success'] = false;
        $respuesta['message'] = "El correo ya está en uso, elija otro";
    } else {
        // Insertar en base de datos
        $sql = "INSERT INTO ".$rol." (nombre, apellido, telefono, correo, clave, salario) VALUES ('$nombre', '$apellido', '$telefono', '$correo', '$clave', '$salario')";
        if (mysqli_query($conn, $sql)) {
            $respuesta['success'] = true;
            $respuesta['message'] = "Cuenta creada correctamente!";
        } else {
            $respuesta['success'] = false;
            $respuesta['message'] = "Ocurrió un error al registrar la cuenta";
        }
    }
} else if ($rol === "cliente") {
    // Crear cliente

    if ($rol === "cliente") {
        $rol = "clientes";
    }

    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];

    // Comprobar si el correo ya existe

    $comprobar = mysqli_query($conn, "SELECT * FROM " . $rol . " WHERE correo = '$correo'");
    if (mysqli_num_rows($comprobar) > 0) {
        $respuesta['success'] = false;
        $respuesta['message'] = "El correo ya está en uso, elija otro";
    } else {
        // Insertar en base de datos
        $sql = "INSERT INTO ".$rol." (nombre, apellido, telefono, correo, clave) VALUES ('$nombre', '$apellido', '$telefono', '$correo', '$clave')";
        if (mysqli_query($conn, $sql)) {
            $respuesta['success'] = true;
            $respuesta['message'] = "Cuenta creada correctamente!";
        } else {
            $respuesta['success'] = false;
            $respuesta['message'] = "Ocurrió un error al registrar la cuenta";
        }
    }
}

echo json_encode($respuesta);
