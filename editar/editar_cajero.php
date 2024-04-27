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

// Formulario de actualización o edición

$success = false;

$consulta = mysqli_query($conn, "SELECT * FROM cajeros WHERE id_cliente = $id");
if (mysqli_num_rows($consulta) > 0) {
    while ($fila = mysqli_fetch_assoc($consulta)) {
        $vistanombre = $fila["nombre"];
        $vistapellido = $fila["apellido"];
        $vistatel = $fila["telefono"];
        $vistacorreo = $fila["correo"];
        $vistasalario = $fila["salario"];
    }
}

if (isset($_POST["guardar"])) {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    $salario = $_POST["salario"];

    $update = mysqli_query($conn, "UPDATE cajeros SET nombre = '$nombre', apellido = '$apellido', telefono = '$telefono', correo = '$correo', salario = '$salario' WHERE id_cliente = $id");
    if ($update) {
        $success = true;
    } else {
        $success = false;
        echo "Ha ocurrido un error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cajero | <?php echo $id; ?></title>

    <?php include "../includes/styles.php"; ?>
</head>

<body>
    <div class="container-fluid ">
        <div class="row flex-nowrap">
            <?php include "../includes/header.php"; ?>
            <div class="col py-3">
                <?php
                if ($success) { ?>
                    <div class="alert alert-success" role="alert">
                        Se ha realizado la modificación correctamente!
                    </div>
                <?php } ?>
                <h2>Editar Cliente | <?php echo $id; ?></h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" value="<?php echo $vistanombre; ?>" name="nombre" id="nombre" class="form-control" placeholder="Nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido:</label>
                        <input type="text" value="<?php echo $vistapellido; ?>" name="apellido" id="apellido" class="form-control" placeholder="Apellido" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="tel" value="<?php echo $vistatel; ?>" name="telefono" id="telefono" class="form-control" placeholder="Teléfono" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo:</label>
                        <input type="email" value="<?php echo $vistacorreo; ?>" name="correo" id="correo" class="form-control" placeholder="Correo" required>
                    </div>
                    <div class="form-group">
                        <label for="salario">Salario:</label>
                        <input type="text" class="form-control" name="salario" value="<?php echo $vistasalario; ?>" required>
                    </div>

                    <button type="submit" name="guardar" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>

    <?php include "../includes/js.php"; ?>

</body>

</html>