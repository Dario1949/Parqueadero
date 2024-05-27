<?php
require("../../config/config.php");

$respuesta = array(
    "success" => false,
    "message" => "",
    "data" => []
);

// obtenemos datos formulario

$id = $_POST["vehiculo"];

// Comprobamos

$comprobar = mysqli_query($conn, "SELECT * FROM vehiculos WHERE id = '$id' LIMIT 1");
if($comprobar) {
    while($c = mysqli_fetch_assoc($comprobar)) {
        $respuesta['data'][] = $c;
    }

    $respuesta['success'] = true;
    $respuesta['message'] = "Datos obtenidos con éxito";
} else {
    $respuesta['success'] = false;
    $respuesta['message'] = "Ocurrió un error";
}

echo json_encode($respuesta);