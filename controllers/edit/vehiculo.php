<?php
require("../../config/config.php");

$respuesta = array(
    "success" => false,
    "message" => ""
);

// Recibir los datos del formulario
$marca = $_POST["marca"];
$modelo = $_POST["modelo"];
$color = $_POST["color"];
$id = $_POST["id"];

// Actualizar datos

$update = mysqli_query($conn, "UPDATE vehiculos SET marca = '$marca', modelo = '$modelo', color = '$color' WHERE id = $id");
if($update) {
    $respuesta['success'] = true;
    $respuesta['message'] = "El vehículo se ha actualizado correctamente!";
} else {
    $respuesta['success'] = false;
    $respuesta['message'] = "Ha ocurrido un error";
}

echo json_encode($respuesta);