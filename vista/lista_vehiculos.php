<?php
session_start();
require("../config/config.php");

//error_reporting(0);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Vehículos</title>

    <?php include "../includes/styles.php"; ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <?php include "../includes/header.php"; ?>
            <?php 
            if(obtenerCampo("email") != null) {
                $email_ = trim(obtenerCampo('email'));
                $select = mysqli_query($conn, "SELECT * FROM clientes WHERE correo = '$email_' LIMIT 1");
                if(mysqli_num_rows($select) > 0) {
                    $c = mysqli_fetch_assoc($select);

                    $id_c = $c["id_cliente"];
                }
            }
            ?>
            <div class="col py-3">
                <h2>Vehículos</h2>
                <div class="d-block p-10 mb-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearVehiculo" title="Crear vehículo">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="d-inline-block align-middle">
                            <image href="../icons/plus-circle-1441-svgrepo-com.svg" height="20" width="20" />
                        </svg>
                    </button>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"># id</th>
                            <th scope="col">Placa</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Color</th>
                            <th scope="col">Puesto</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        if(obtenerCampo("rol") >= 2) {
                            $resultado = mysqli_query($conn, "SELECT puestos.numero, clientes.id_cliente, clientes.nombre, clientes.apellido, vehiculos.* FROM vehiculos INNER JOIN clientes ON vehiculos.id_cliente = clientes.id_cliente INNER JOIN puestos ON vehiculos.puesto = puestos.id ORDER BY placa DESC");
                        } else {                            
                            $resultado = mysqli_query($conn, "SELECT puestos.numero, clientes.*, vehiculos.* FROM vehiculos INNER JOIN clientes ON vehiculos.id_cliente = clientes.id_cliente INNER JOIN puestos ON vehiculos.puesto = puestos.id WHERE vehiculos.id_cliente = '$id_c' ORDER BY placa DESC");
                        }
                        if (mysqli_num_rows($resultado) > 0) {
                            while ($vehiculo = mysqli_fetch_assoc($resultado)) { ?>
                                <tr>
                                    <th scope="row"><?php echo $vehiculo["id"]; ?></th>
                                    <td><?php echo $vehiculo["placa"]; ?></td>
                                    <td><?php echo $vehiculo["marca"]; ?></td>
                                    <td><?php echo $vehiculo["modelo"]; ?></td>
                                    <td style="background-color: <?php echo $vehiculo["color"]; ?>;"></td>
                                    <td><?php echo $vehiculo["numero"]; ?></td>
                                    <td><?php echo $vehiculo["id_cliente"], " | ", $vehiculo["nombre"], " ", $vehiculo["apellido"]; ?></td>
                                    <td>
                                        <button type="button" data-modal="<?php echo $vehiculo["id"]; ?>:<?php echo $vehiculo["marca"]; ?>:<?php echo $vehiculo["modelo"]; ?>:<?php echo $vehiculo["color"]; ?>" class="btn btn-success" id="editar" data-bs-toggle="modal" data-bs-target="#editarVehiculo" title="Editar">
                                            Editar
                                        </button>
                                        <button type="button" data-modal="<?php if(obtenerCampo("rol") >= 2) { echo $vehiculo["id_cliente"]; } else { echo $c["id_cliente"]; } ?>:<?=$vehiculo["id"];?>" class="btn btn-danger" id="eliminar" data-bs-toggle="modal" data-bs-target="#crearFactura" title="Eliminar">
                                            Retirar
                                        </button>
                                    </td>
                                </tr>
                        <?php }
                        }                    
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include "../includes/js.php"; ?>

    <script>
        $(document).ready(() => {
            $("#activar-reconocer").click(() => {
                if ($("#placas-reconocer").hasClass("d-none")) {
                    $("#placas-reconocer").removeClass("d-none");
                } else {
                    $("#placas-reconocer").addClass("d-none");
                }
            })
        })
    </script>    

    <?php include "../modals/editar_vehiculo.php"; ?>
    <?php include "../modals/crear_vehiculo.php"; ?>
    <?php include "../modals/crear_factura.php"; ?>

    <script src='https://unpkg.com/tesseract.js@2.0.0-alpha.7/dist/tesseract.min.js'></script>
    <script src="../js/reconocer-placas.js"></script>

    <script>
        $(document).ready(() => {
            $("button#editar").click((e) => {
                const data = e.target.getAttribute("data-modal").split(":");
                $("#id").val(data[0]);
                $("#marca").val(data[1]);
                $("#modelo").val(data[2]);
                $("#color").val(data[3]);
            });

            $("button#eliminar").click((e) => {
                const data = e.target.getAttribute("data-modal").split(":");
                $("#cliente").val(data[0]);
                $("#vehiculo").val(data[1]);
            });
        })
    </script>

    

</body>

</html>