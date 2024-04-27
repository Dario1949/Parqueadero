<?php 
session_start();
require("./config/config.php");

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Parqueadero</title>

    <?php include "./includes/styles.php"; ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <?php include "./includes/header.php"; ?>
            <div class="col py-3">
                <h3>Parqueadero</h3>                                                
                <?php include "./includes/index/index_asistentes.php"; ?>
                <?php include "./includes/index/index_cajeros.php"; ?>  
                <?php include "./includes/index/index_clientes.php"; ?>
                <?php include "./includes/index/index_dueños.php"; ?>
                <?php include "./includes/index/index_puestos.php"; ?>
                <?php include "./includes/index/index_vehiculos.php"; ?>       
            </div>
        </div>
    </div>

    <?php include "./includes/js.php"; ?>

</body>

</html>