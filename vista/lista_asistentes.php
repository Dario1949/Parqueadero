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
    <title>Listado de Asistentes</title>

    <?php include "../includes/styles.php"; ?>
</head>

<body>
    <div class="container-fluid ">
        <div class="row flex-nowrap">
            <?php include "../includes/header.php"; ?>
            <div class="col py-3">
                <h2>Asistentes</h2>
                <div class="d-block p-10">
                    <button type="button" class="btn btn-primary" data-href="http://<?php echo $host; ?>/ParqueaderoVL/registrar/registrar_asistente.php" data-bs-toggle="tooltip" data-bs-placement="top" title="Crear asistente">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="d-inline-block align-middle">
                            <image href="../icons/plus-circle-1441-svgrepo-com.svg" height="20" width="20" />
                        </svg>
                    </button>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"># id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Salario</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resultado = mysqli_query($conn, "SELECT * FROM asistentes ORDER BY id DESC");
                        if (mysqli_num_rows($resultado) > 0) {
                            while ($cajero = mysqli_fetch_assoc($resultado)) { ?>
                                <tr>
                                    <th scope="row"><?php echo $cajero["id"]; ?></th>
                                    <td><?php echo $cajero["nombre"]; ?></td>
                                    <td><?php echo $cajero["apellido"]; ?></td>
                                    <td><?php echo $cajero["telefono"]; ?></td>
                                    <td><?php echo $cajero["correo"]; ?></td>
                                    <td><?php echo $cajero["salario"]; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-href="http://<?php echo $host; ?>/ParqueaderoVL/editar/editar_asistentes.php?id=<?php echo $cajero["id"]; ?>" title="Editar">
                                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="d-inline-block align-middle">
                                                <image href="../icons/edit-svgrepo-com.svg" height="20" width="20" />
                                            </svg>
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-confirm-delete="true" data-delete-card="asistente" data-href-delete="http://<?php echo $host; ?>/ParqueaderoVL/delete/delete_asistente.php?id=<?php echo $cajero["id"]; ?>" title="Eliminar">
                                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="d-inline-block align-middle">
                                                <image href="../icons/delete-1487-svgrepo-com.svg" height="20" width="20" />
                                            </svg>
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

</body>

</html>