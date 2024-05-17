<?php
session_start();
require("../config/config.php");

error_reporting(0);

// Comprobar sesión usuario
function sessionLocal($session, $c)
{
    $check = false;

    if (!empty($session)) {
        $resultado = mysqli_query($c, "SELECT * FROM duenos WHERE correo = '$session'");

        if (mysqli_num_rows($resultado) > 0) $check = true;
    }

    return $check;
}
// Fin comprobar usuario sesión

$session = empty($_SESSION["usuario"]) ? "" : $_SESSION["usuario"];

$session = sessionLocal($session, $conn);
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
            <div class="col py-3">
                <h2>Vehículos</h2>
                <div class="d-block p-10">
                    <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Crear vehículo" data-href="http://<?php echo $host; ?>/ParqueaderoVL/registrar/registrar_vehiculo.php">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="d-inline-block align-middle">
                            <image href="../icons/plus-circle-1441-svgrepo-com.svg" height="20" width="20" />
                        </svg>
                        <span class="d-inline-block align-middle">Crear vehículo</span>
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
                        $resultado = mysqli_query($conn, "SELECT clientes.id_cliente, clientes.nombre, clientes.apellido, vehiculos.* FROM vehiculos INNER JOIN clientes ON vehiculos.id_cliente = clientes.id_cliente ORDER BY id DESC");
                        if (mysqli_num_rows($resultado) > 0) {
                            while ($vehiculo = mysqli_fetch_assoc($resultado)) { ?>
                                <tr>
                                    <th scope="row"><?php echo $vehiculo["id"]; ?></th>
                                    <td><?php echo $vehiculo["placa"]; ?></td>
                                    <td><?php echo $vehiculo["marca"]; ?></td>
                                    <td><?php echo $vehiculo["modelo"]; ?></td>
                                    <td style="background-color: <?php echo $vehiculo["color"]; ?>;"></td>
                                    <td><?php echo $vehiculo["puesto"]; ?></td>
                                    <td><?php echo $vehiculo["id_cliente"], " | ", $vehiculo["nombre"], " ", $vehiculo["apellido"]; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-href="http://<?php echo $host; ?>/ParqueaderoVL/editar/editar_vehiculo.php?id=<?php echo $vehiculo["id"]; ?>" data-bs-placement="top" title="Editar">
                                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="d-inline-block align-middle">
                                                <image href="../icons/edit-svgrepo-com.svg" height="20" width="20" />
                                            </svg>
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-confirm-delete="true" data-delete-card="vehículo" data-href-delete="http://<?php echo $host; ?>/ParqueaderoVL/factura/crear.php?id=<?php echo $vehiculo["id"]; ?>" data-bs-placement="top" title="Eliminar">
                                            Retirar
                                        </button>
                                    </td>et
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

</body>

</html>