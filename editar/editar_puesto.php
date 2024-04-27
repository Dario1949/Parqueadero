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

$consulta = mysqli_query($conn, "SELECT * FROM puestos WHERE id = $id");
if (mysqli_num_rows($consulta) > 0) {
    while ($fila = mysqli_fetch_assoc($consulta)) {
        $vistanumero = $fila["numero"];
    }
}

if (isset($_POST["guardar"])) {
    $numero = $_POST["numero"];

    $update = mysqli_query($conn, "UPDATE puestos SET numero = '$numero' WHERE id = $id");
    if ($update) {
        $success = true;
    } else {
        $success = false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Asistente | <?php echo $id; ?></title>

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
                <h2>Editar puesto | <?php echo $id; ?></h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="numero">Número:</label>
                        <input type="text" class="form-control" name="numero" value="<?php echo $vistanumero; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
                </form>
            </div>
        </div>
    </div>

    <?php include "../includes/js.php"; ?>

</body>

</html>