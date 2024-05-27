<?php
require("../../config/config.php");

$respuesta = array(
    "success" => false,
    "message" => "Vuelve a intentarlo..." 
);

// Recibir los datos del formulario
$placa = $_POST["placa"];
$marca = $_POST["marca"];
$modelo = $_POST["modelo"];
$color = $_POST["color"];
$puesto = $_POST["puesto"];
$tipo = $_POST["tipo"];
$id_cliente = intval($_POST["cliente"]);

// Comprobamos primero si el puesto es reservado
$comprobarPuestoVigente = mysqli_query($conn, "SELECT * FROM puestos WHERE id_cliente = '$id_cliente' AND reservado = 1 AND id = '$puesto'");
if (mysqli_num_rows($comprobarPuestoVigente) > 0) {
    // Insertamos auto en puesto si es reservado
    $insertar_auto_puesto = mysqli_query($conn, "UPDATE puestos SET reservado = 0, placa = '$placa' WHERE id = '$puesto'");
} else {
    // De lo contrario, comprobamos primero si la opción elegida en puesto es auto
    if ($puesto === "auto") {
        // Si es, primero comprobamos si hay puestos disponibles y no reservados
        $puestos_dispo = mysqli_query($conn, "SELECT * FROM puestos WHERE reservado = 0 AND disponibilidad = 1 OR reservado = 1 AND disponibilidad = 0 AND id_cliente = '$id_cliente' LIMIT 1");
        // Si hay puestos disponibles se elige el primero
        if (mysqli_num_rows($puestos_dispo) > 0) {
            $p = mysqli_fetch_assoc($puestos_dispo);
            $puesto = $p["id"];

            $insertar_auto_puesto = mysqli_query($conn, "UPDATE puestos SET reservado = 0, placa = '$placa', disponibilidad = 0, id_cliente = '$id_cliente' WHERE id = " . $p["id"]);
            if ($insertar_auto_puesto) {
                // Ahora insertamos el vehículo
                // pero antes comprobamos si esa placa ya está registrada
                $comprobar_placa = mysqli_query($conn, "SELECT * FROM vehiculos WHERE placa = '$placa'");

                if (mysqli_num_rows($comprobar_placa) > 0) {
                    $respuesta['success'] = false;
                    $respuesta['message'] = "La placa ya está en uso, debe ingresar otra";
                } else {
                    $crear_vehiculo = mysqli_query($conn, "INSERT INTO vehiculos (placa, marca, modelo, color, tipo, puesto, id_cliente, fecha_creado) VALUES ('$placa', '$marca', '$modelo', '$color', '$tipo', '$puesto', '$id_cliente', NOW())");

                    if ($crear_vehiculo) {
                        $respuesta['success'] = true;
                        $respuesta['message'] = "El vehículo ha sido creado correctamente!";
                    } else {
                        $respuesta['success'] = false;
                        $respuesta['message'] = "Ocurrió un error al crear el vehículo";
                    }
                }
            } else {
                $respuesta['success'] = false;
                $respuesta['message'] = "Ocurrió un error al crear el puesto automático";
            }
        } else {
            $respuesta['success'] = false;
            $respuesta['message'] = "No tenemos puestos, espera un momento.";
        }
    } else {
        // Si no es puesto automatico, entonces se elige el manual
        // Primero comprobamos si aún sigue vigente
        $comprobarPuestoVigente2 = mysqli_query($conn, "SELECT * FROM puestos WHERE reservado = 0 AND disponibilidad = 1 AND id = '$puesto' OR reservado = 1 AND disponibilidad = 1 AND id_cliente = '$id_cliente' AND id = '$puesto'");
        if (mysqli_num_rows($comprobarPuestoVigente2) > 0) {
            $p = mysqli_fetch_assoc($comprobarPuestoVigente2);
            // Se establece ese puesto, si es así
            $insertar_manual_puesto = mysqli_query($conn, "UPDATE puestos SET reservado = 0, placa = '$placa', id_cliente = '$id_cliente', disponibilidad = 0 WHERE id = " . $p["id"]);
            if ($insertar_manual_puesto) {
                // Ahora insertamos el vehículo
                // pero antes comprobamos si esa placa ya está registrada
                $comprobar_placa = mysqli_query($conn, "SELECT * FROM vehiculos WHERE placa = '$placa'");

                if (mysqli_num_rows($comprobar_placa) > 0) {
                    $respuesta['success'] = false;
                    $respuesta['message'] = "La placa ya está en uso, debe ingresar otra";
                } else {
                    $crear_vehiculo = mysqli_query($conn, "INSERT INTO vehiculos (placa, marca, modelo, color, tipo, puesto, id_cliente, fecha_creado) VALUES ('$placa', '$marca', '$modelo', '$color', '$tipo', '$puesto', '$id_cliente', NOW())");

                    if ($crear_vehiculo) {
                        $respuesta['success'] = true;
                        $respuesta['message'] = "El vehículo ha sido creado correctamente!";
                    } else {
                        $respuesta['success'] = false;
                        $respuesta['message'] = "Ocurrió un error al crear el vehículo";
                    }
                }
            } else {
                $respuesta['success'] = false;
                $respuesta['message'] = "Ocurrió un error al crear el puesto manual";
            }
        } else {
            $respuesta['success'] = false;
            $respuesta['message'] = "No tenemos puestos, espera un momento.";
        }
    }
}

echo json_encode($respuesta);