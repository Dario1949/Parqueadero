<?php
require("../../config/config.php");

$respuesta = array(
    "success" => false,
    "message" => "",
    "data" => []
);

$id_cliente = $_POST["email"];

// Obtener usuario con su correo
$obtener = mysqli_query($conn, "SELECT * FROM clientes WHERE correo = '$id_cliente'");
if(mysqli_num_rows($obtener) > 0) {
    $cc = mysqli_fetch_assoc($obtener);

    $id_cliente = $cc["id_cliente"];
} 

// Comprobar cuentas de dinero
$comprobar = mysqli_query($conn, "SELECT * FROM cuentas_bancarias WHERE id_cliente = '$id_cliente' LIMIT 1");
if(mysqli_num_rows($comprobar) > 0) {
    while($c = mysqli_fetch_assoc($comprobar)) {
        $respuesta['data'][] = $c;
    }

    $respuesta['success'] = true;
    $respuesta['message'] = "Cuentas encontradas";
} else {
    $respuesta['success'] = false;
    $respuesta['message'] = "Cuentas no encontradas";
}

echo json_encode($respuesta);