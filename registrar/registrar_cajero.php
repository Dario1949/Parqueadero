<?php
session_start();
require("../config/config.php");

error_reporting(0);

// Comprobar sesión usuario
function sessionLocal($session, $c)
{
    $check = false;

    if (!empty($session)) {
        $resultado = mysqli_query($c, "SELECT * FROM duenos WHERE correo = '$session'");

        if (mysqli_num_rows($resultado) > 0) $check = true;
    }

    return $check;
}
// Fin comprobar usuario sesión

$session = empty($_SESSION["usuario"]) ? "" : $_SESSION["usuario"];

$session = sessionLocal($session, $conn);

// Comprobación formulario

if (isset($_POST["registrar"])) {
    // Recibir los datos del formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    $salario = $_POST["salario"];

    // Validar los campos del formulario
    if (empty($nombre) || empty($apellido) || empty($telefono) || empty($correo) || empty($salario)) {
        echo "Por favor complete todos los campos.";
    } else {
        // Insertar los datos en la tabla "asistentes"
        $sql = "INSERT INTO cajeros (nombre, apellido, telefono, correo, salario) VALUES ('$nombre', '$apellido', '$telefono', '$correo', '$salario')";
        if (mysqli_query($conn, $sql)) {
            echo "Asistente registrado correctamente.";
        } else {
            echo "Error al registrar el asistente: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar cajero</title>

    <?php include "../includes/styles.php"; ?>
</head>

<body>
    <div class="container-fluid ">
        <div class="row flex-nowrap">
            <?php include "../includes/header.php"; ?>
            <div class="col py-3">
                <h2>Registrar Cajero</h2>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido:</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo:</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                    <div class="form-group">
                        <label for="salario">Salario:</label>
                        <input type="number" class="form-control" id="salario" name="salario" required>
                    </div>
                    <div class="mt-10 p-6">
                        <button type="submit" class="btn btn-primary" name="registrar">Registrar Asistente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include "../includes/js.php"; ?>

</body>

</html>