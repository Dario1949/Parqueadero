<?php
require("../../config/config.php");

$nombre = "";
$apellido = "";
$telefono = "";
$correo = "";
$clave = "";
$salario = "";
$id = "";
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
    $id = $_POST["id"];

    $get_user = mysqli_query($conn, "SELECT * FROM " . $rol . " WHERE id = '$id'");
    $u = mysqli_fetch_assoc($get_user);

    // Si correo es el mismo, no se comprueba si ya existe

    if ($correo === $u["correo"]) {
        // Actualizar en base de datos
        $sql = "UPDATE " . $rol . " SET nombre = '$nombre', apellido = '$apellido', telefono = '$telefono', correo = '$correo', salario = '$salario', clave = '$clave' WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            $respuesta['success'] = true;
            $respuesta['message'] = "Cuenta actualizada correctamente!";
        } else {
            $respuesta['success'] = false;
            $respuesta['message'] = "Ocurrió un error al registrar la cuenta";
        }
    } else {
        // Caso contrario comprobamos

        // Comprobar si el correo ya existe
        $comprobar = mysqli_query($conn, "SELECT * FROM " . $rol . " WHERE correo = '$correo'");
        if (mysqli_num_rows($comprobar) > 0) {
            $respuesta['success'] = false;
            $respuesta['message'] = "El correo ya está en uso, elija otro";
        } else {
            // Actualizar en base de datos
            $sql = "UPDATE " . $rol . " SET nombre = '$nombre', apellido = '$apellido', telefono = '$telefono', correo = '$correo', salario = '$salario', clave = '$clave' WHERE id = '$id'";
            if (mysqli_query($conn, $sql)) {
                $respuesta['success'] = true;
                $respuesta['message'] = "Cuenta actualizada correctamente!";
            } else {
                $respuesta['success'] = false;
                $respuesta['message'] = "Ocurrió un error al actualizar la cuenta";
            }
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
    $id = $_POST["id"];

    $get_user = mysqli_query($conn, "SELECT * FROM " . $rol . " WHERE id_cliente = $id");
    $u = mysqli_fetch_assoc($get_user);

    // Si correo es el mismo, no se comprueba si ya existe

    if ($correo === $u["correo"]) {
        // Actualizar en base de datos
        $sql = "UPDATE clientes SET nombre = '$nombre', apellido = '$apellido', telefono = '$telefono', correo = '$correo', clave = '$clave' WHERE id_cliente = $id";
        if (mysqli_query($conn, $sql)) {
            $respuesta['success'] = true;
            $respuesta['message'] = "Cuenta actualizada correctamente!";
        } else {
            $respuesta['success'] = false;
            $respuesta['message'] = "Ocurrió un error al actualizar la cuenta";
        }
    } else {
        // Comprobar si el correo ya existe

        $comprobar = mysqli_query($conn, "SELECT * FROM " . $rol . " WHERE correo = '$correo'");
        if (mysqli_num_rows($comprobar) > 0) {
            $respuesta['success'] = false;
            $respuesta['message'] = "El correo ya está en uso, elija otro";
        } else {
            // Actualizar en base de datos
            $sql = "UPDATE clientes SET nombre = '$nombre', apellido = '$apellido', telefono = '$telefono', correo = '$correo', clave = '$clave' WHERE id_cliente = $id";
            if (mysqli_query($conn, $sql)) {
                $respuesta['success'] = true;
                $respuesta['message'] = "Cuenta actualizada correctamente!";
            } else {
                $respuesta['success'] = false;
                $respuesta['message'] = "Ocurrió un error al actualizar la cuenta";
            }
        }
    }
}

echo json_encode($respuesta);
