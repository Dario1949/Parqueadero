<?php
require("../../config/config.php");

$respuesta = array(
    "success" => false,
    "message" => ""
);

$cliente = $_POST["cliente"];
$vehiculo = $_POST["vehiculo"];
$valor_pagar = $_POST["valor_pagar"];
$fecha_inicio = $_POST["fecha_inicio"];
$fecha_final = $_POST["fecha_final"];
$dinero = $_POST["dinero"];

$fecha_creado = "";
$tipo = "";
$id_puesto = "";

$seleccionar_vehiculo = mysqli_query($conn, "SELECT * FROM vehiculos WHERE id = '$vehiculo'");
if (mysqli_num_rows($seleccionar_vehiculo) > 0) {
    $v = mysqli_fetch_assoc($seleccionar_vehiculo);
    $fecha_creado = $v["fecha_creado"];
    $tipo = $v["tipo"];
    $id_puesto = $v["puesto"];
}


// Primero realizamos el respectivo pago

$obtener_cuenta = mysqli_query($conn, "SELECT * FROM cuentas_bancarias WHERE id = '$dinero' LIMIT 1");
if (mysqli_num_rows($obtener_cuenta) > 0) {
    // Obtenemos ese método
    $select_m = mysqli_fetch_assoc($obtener_cuenta);

    if (intval($select_m["dinero"]) >= intval($valor_pagar)) {
        // Actualizamos el dinero
        $calculo = intval($select_m["dinero"]) - intval($valor_pagar);
        $update_m = mysqli_query($conn, "UPDATE cuentas_bancarias SET dinero = '$calculo' WHERE id = '$dinero'");
        if ($update_m) {
            // Creamos factura

            $crear_factura = mysqli_query($conn, "INSERT INTO facturas (id_cliente, id_cajero, fecha, total) VALUES ('$cliente', '1', NOW(), '$valor_pagar')");
            if ($crear_factura) {
                // Obtenemos 
                $ultimo_id = mysqli_insert_id($conn);

                // Creamos detalles de factura
                $crear_detalles_factura = mysqli_query($conn, "INSERT INTO detalles_factura (id_factura, id_puesto, tiempo_llegada, tiempo_salida, subtotal) VALUES ('$ultimo_id', '$id_puesto', '$fecha_inicio', '$fecha_final', '$valor_pagar')");
                if ($crear_detalles_factura) {
                    // Luego eliminamos el vehículo
                    $eliminar_vehiculo = mysqli_query($conn, "DELETE FROM vehiculos WHERE id = '$vehiculo'");
                    if ($eliminar_vehiculo) {
                        // Cambiamos el puesto a disponible
                        $actualizar_puesto = mysqli_query($conn, "UPDATE puestos SET placa = '', reservado = 0, id_cliente = 0, disponibilidad = 1 WHERE id = '$id_puesto'");
                        if ($actualizar_puesto) {
                            $respuesta['success'] = true;
                            $respuesta['message'] = "Factura creada correctamente!";
                        } else {
                            $respuesta['success'] = false;
                            $respuesta['message'] = "Ocurrió un error al crear la factura ap";
                        }
                    } else {
                        $respuesta['success'] = false;
                        $respuesta['message'] = "Ocurrió un error al crear la factura dv";
                    }
                } else {
                    $respuesta['success'] = false;
                    $respuesta['message'] = "Ocurrió un error al crear la factura cdf";
                }
            } else {
                $respuesta['success'] = false;
                $respuesta['message'] = "Ocurrió un error al crear la factura cfi";
            }
        } else {
            $respuesta['success'] = false;
            $respuesta['message'] = "Ocurrió un error al crear la factura pgr";
        }
    } else {
        $respuesta['success'] = false;
        $respuesta['message'] = "No tienes suficiente dinero";
    }
}


echo json_encode($respuesta);
