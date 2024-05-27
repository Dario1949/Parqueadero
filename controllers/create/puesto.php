<?php
require("../../config/config.php");

$respuesta = array(
    "success" => false,
    "message" => ""
);

// Recibir los datos del formulario
$numero = $_POST["numero"];

// Comprobamos si ya existe el número de ese puesto
$comprobar = mysqli_query($conn, "SELECT * FROM puestos WHERE numero = '$numero'");
if (mysqli_num_rows($comprobar) > 0) {
    $respuesta['success'] = false;
    $respuesta['message'] = "El número del puesto ingresado ya existe";
} else {
    // Creamos el puesto si no existe aún
    $insertar = mysqli_query($conn, "INSERT INTO puestos (numero, disponibilidad) VALUES ('$numero', '1')");
    if ($insertar) {
        $respuesta['success'] = true;
        $respuesta['message'] = "El puesto se ha creado correctamente!";
    } else {
        $respuesta['success'] = false;
        $respuesta['message'] = "Ocurrió un error al crear el puesto";
    }
}

echo json_encode($respuesta);