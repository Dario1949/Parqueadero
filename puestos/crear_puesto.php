<?php
session_start();
require("../config/config.php");

error_reporting(0);

$id = $_GET['id'];

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

// Formulario de creación

$success = false;

if (isset($_POST["registrar"])) {
    $numero = $_POST["numero"];
    $disponible = true;

    $comparar = mysqli_query($conn, "SELECT * FROM puestos WHERE numero = '$numero'");
    if (mysqli_num_rows($comparar) > 0) {
        echo "El número o número del puesto ya está creado.";
    } else {
        $insertar = mysqli_query($conn, "INSERT INTO puestos (numero, disponibilidad) VALUES ('$numero', '$disponible')");
        if ($insertar) {
            echo "<script>window.alert('Datos insertados correctamente');</script>";
            echo "<script>window.location.href = 'crear_puesto.php;</script>";
        } else {
            echo "<script>window.alert('Ha ocurrido un error');</script>";
            echo "<script>window.location.href = 'crear_puesto.php';</script>";
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
    <title>Crear puesto</title>

    <?php include "../includes/styles.php"; ?>
</head>

<body>
    <div class="container-fluid ">
        <div class="row flex-nowrap">
            <?php include "../includes/header.php"; ?>
            <div class="col py-3">
                <h2>Crear puesto</h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="numero">Número puesto:</label>
                        <input type="text" name="numero" class="form-control" value="" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="registrar">Crear</button>
                </form>
            </div>
        </div>
    </div>

    <?php include "../includes/js.php"; ?>

</body>

</html>