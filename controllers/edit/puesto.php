<?php
require("../../config/config.php");

$respuesta = array(
    "success" => false,
    "message" => ""
);

// Recibir los datos del formulario
$numero = $_POST["numero"];
$id = $_POST["id"];

$get_puesto = mysqli_query($conn, "SELECT * FROM puestos WHERE id = $id LIMIT 1");
if (mysqli_num_rows($get_puesto) > 0) {
    $p = mysqli_fetch_assoc($get_puesto);
    // Si existe entonces, seguimos los pasos
    // Si el id numero enviado es el mismo que está en base de datos
    // No se hace nada
    if ($numero === $p["numero"]) {
        $respuesta['success'] = false;
        $respuesta['message'] = "No se han hecho cambios";
    } else {
        $update = mysqli_query($conn, "UPDATE puestos SET numero = '$numero' WHERE id = $id");
        if ($update) {
            $respuesta['success'] = true;
            $respuesta['message'] = "Se ha actualizado el puesto";
        } else {
            $respuesta['success'] = false;
            $respuesta['message'] = "Ha ocurrido un error";
        }
    }
}

echo json_encode($respuesta);
