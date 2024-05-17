<?php
session_start();
require("../config/config.php");

error_reporting(0);

$host = $_SERVER['HTTP_HOST'];

$id = $_GET["id"];

$eliminar = mysqli_query($conn, "DELETE FROM cuentas_bancarias WHERE id = '$id'");
if ($eliminar) {
    echo "<script>window.location.href = 'http://" . $host . "/ParqueaderoVL/personal/cuentas-bancarias.php'</script>";
} else {
    echo "<script>window.alert('Ha ocurrido un error');</script>";
    echo "<script>window.location.href = 'http://" . $host . "/ParqueaderoVL/personal/cuentas-bancarias.php'</script>";
}
