<?php
session_start();
require("./config/config.php");

error_reporting(0);

// Comprobar sesión usuario
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
                <?php include "./vista/panel.php"; ?>
            </div>
        </div>
    </div>

    <?php include "./includes/js.php"; ?>
    <script>
    console.log(getCookie("usuario"));
    if (getCookie("usuario") === null) {
        window.location = "index.php";
    }
</script>

</body>

</html>