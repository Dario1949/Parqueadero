<?php 
session_start();
require("../config/config.php");

error_reporting(0);

$host = $_SERVER['HTTP_HOST'];

$id = $_GET["id"];

$eliminar_detalles_factura = mysqli_query($conn, "DELETE FROM detalles_factura WHERE id_puesto = '$id'");
$eliminar = mysqli_query($conn, "DELETE FROM puestos WHERE id = '$id'");
$eliminar_vehiculo = mysqli_query($conn, "DELETE FROM vehiculos WHERE puesto = '$id'");
if($eliminar && $eliminar_vehiculo && $eliminar_detalles_factura) {
    echo "<script>window.location.href = '/ParqueaderoVL/vista/lista_puestos.php'</script>";
} else {
    echo "<script>window.alert('Ha ocurrido un error');</script>";
    echo "<script>window.location.href = '/ParqueaderoVL/vista/lista_puestos.php'</script>";
}
