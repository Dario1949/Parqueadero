<?php
session_start();
require "../config/config.php";

if (isset($_POST['enviar'])) {
    $correo = trim($_POST['email']);

    $resultado = mysqli_query($conn, "SELECT * FROM duenos WHERE correo = '$correo'");

    if (mysqli_num_rows($resultado) > 0) {
        $_SESSION['usuario'] = $correo;
        echo "<script>window.alert('Logueo éxitoso.');</script>";
        echo "<script>window.location = 'http://",$_SERVER['HTTP_HOST'],"/ParqueaderoVL/';</script>";        
    } else {
        echo "<script>window.alert('Correo incorrecto, vuelva a intentar.');</script>";
        echo "<script>window.location = 'http://", $_SERVER['HTTP_HOST'], "/ParqueaderoVL/acceso/login.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Parqueadero | Acceso</title>

    <?php include "../includes/styles.php"; ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <?php include "../includes/header.php"; ?>
            <div class="col py-3 align-items-center ">
                <h3>Parqueadero</h3>

                <form class="row g-3" method="POST" name="form">
                    <div class="col-md-4">
                        <label for="email" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit" name='enviar'>Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include "../includes/js.php"; ?>

</body>

</html>