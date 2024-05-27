<?php
require("../../config/config.php");

$id_cliente = $_POST["cliente"];

$respuesta = array(
    "success" => false,
    "message" => "",
    "data" => []
);

// Obtener puestos y comprobar si hay disponibles
if(empty($id_cliente)) {
    $comprobar = mysqli_query($conn, "SELECT * FROM puestos WHERE reservado = 0 AND disponibilidad = 1");
} else {
    $comprobar = mysqli_query($conn, "SELECT * FROM puestos WHERE reservado = 0 AND disponibilidad = 1 OR reservado = 1 AND id_cliente = '$id_cliente'");
}
if(mysqli_num_rows($comprobar) > 0) {
    $respuesta['success'] = true;
    $respuesta['message'] = "Puestos disponibles";

    while ($row = mysqli_fetch_assoc($comprobar)) {
        $respuesta['data'][] = $row;
    }
} else {
    // Si no hay, se procede a enviar ese mensaje
    $respuesta['success'] = false;
    $respuesta['message'] = "No hay puestos disponibles";
}

echo json_encode($respuesta);