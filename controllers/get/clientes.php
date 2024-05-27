<?php
require("../../config/config.php");

$respuesta = array(
    "success" => false,
    "message" => "",
    "data" => []
);

// Obtener clientes
$comprobar = mysqli_query($conn, "SELECT * FROM clientes");
if(mysqli_num_rows($comprobar) > 0) {
    $respuesta['success'] = true;
    $respuesta['message'] = "Si hay clientes";

    while ($row = mysqli_fetch_assoc($comprobar)) {
        $respuesta['data'][] = $row;
    }
} else {
    // Si no hay, se procede a enviar ese mensaje
    $respuesta['success'] = false;
    $respuesta['message'] = "No hay clientes";
}

echo json_encode($respuesta);