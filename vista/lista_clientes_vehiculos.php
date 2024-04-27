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
    <title>Listado de Clientes y Vehículos</title>

    <?php include "../includes/styles.php"; ?>
</head>

<body>
    <div class="container-fluid ">
        <div class="row flex-nowrap">
            <?php include "../includes/header.php"; ?>
            <div class="col py-3">
                <h2>Lista de clientes y vehículos registrados</h2>
                <div class="d-block p-10">
                    <button type="button" class="btn btn-primary" data-href="http://<?php echo $host; ?>/ParqueaderoVL/registrar/registrar_cliente.php" data-bs-toggle="tooltip" data-bs-placement="top" title="Crear cliente">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="d-inline-block align-middle">
                            <image href="../icons/plus-circle-1441-svgrepo-com.svg" height="20" width="20" />
                        </svg>
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-href="http://<?php echo $host; ?>/ParqueaderoVL/registrar/registrar_vehiculo.php" data-bs-placement="top" title="Crear vehículo">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="d-inline-block align-middle">
                            <image href="../icons/plus-circle-1441-svgrepo-com.svg" height="20" width="20" />
                        </svg>
                    </button>
                </div>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Placa</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Color</th>
                            <th>Puesto</th>
                            <th>Editar cliente</th>
                            <th>Editar vehículo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Obtener la lista de clientes y sus vehículos registrados
                        $sql = "SELECT clientes.id_cliente, clientes.nombre, clientes.apellido, vehiculos.placa, vehiculos.marca, vehiculos.modelo, vehiculos.color, vehiculos.puesto, vehiculos.id
                        FROM clientes
                        INNER JOIN vehiculos ON clientes.id_cliente = vehiculos.id_cliente";
                        $resultado = mysqli_query($conn, $sql);

                        // Verificar si hay registros encontrados
                        if (mysqli_num_rows($resultado) > 0) {
                            while ($fila = mysqli_fetch_assoc($resultado)) { ?>
                                <tr>
                                <td><?php echo $fila["nombre"]; ?></td>
                                <td><?php echo $fila["apellido"]; ?></td>
                                <td><?php echo $fila["placa"]; ?></td>
                                <td><?php echo $fila["marca"]; ?></td>
                                <td><?php echo $fila["modelo"]; ?></td>
                                <td><?php echo $fila["color"]; ?></td>
                                <td><?php echo $fila["puesto"]; ?></td>
                                <td><a href='http://<?php echo $_SERVER['HTTP_HOST']; ?>/ParqueaderoVL/editar/editar_cliente.php?id=<?php echo $fila["id_cliente"]; ?>' class='btn btn-primary'>Editar</a></td>
                                <td><a href='http://<?php echo $_SERVER['HTTP_HOST']; ?>/ParqueaderoVL/editar/editar_vehiculo.php?id=<?php echo $fila["id"]; ?>' class='btn btn-primary'>Editar</a></td>
                                </tr>
                            <?php }
                        } else {
                            echo "<tr><td colspan='9'>No se encontraron registros de clientes y vehículos.</td></tr>";
                        }

                        // Cerrar la conexión a la base de datos
                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include "../includes/js.php"; ?>

</body>

</html>