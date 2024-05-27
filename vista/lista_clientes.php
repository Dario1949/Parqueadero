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
    <title>Listado de Clientes</title>

    <?php include "../includes/styles.php"; ?>
</head>

<body>
    <div class="container-fluid ">
        <div class="row flex-nowrap">
            <?php include "../includes/header.php"; ?>
            <div class="col py-3">
                <h2>Clientes</h2>
                <div class="d-block p-10 mb-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearCliente" title="Crear cliente">
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
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resultado = mysqli_query($conn, "SELECT * FROM clientes ORDER BY id_cliente DESC");
                        if (mysqli_num_rows($resultado) > 0) {
                            while ($cliente = mysqli_fetch_assoc($resultado)) { ?>
                                <tr>
                                    <th scope="row"><?php echo $cliente["id_cliente"]; ?></th>
                                    <td><?php echo $cliente["nombre"]; ?></td>
                                    <td><?php echo $cliente["apellido"]; ?></td>
                                    <td><?php echo $cliente["telefono"]; ?></td>
                                    <td><?php echo $cliente["correo"]; ?></td>
                                    <td>
                                        <button type="button" data-modal="<?= $cliente["id_cliente"]; ?>:<?= $cliente["nombre"]; ?>:<?= $cliente["apellido"]; ?>:<?= $cliente["telefono"]; ?>:<?= $cliente["correo"]; ?>:<?= $cliente["clave"]; ?>" class="btn btn-success" id="editar" data-bs-toggle="modal" data-bs-target="#editarCliente" title="Editar">
                                            Editar
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-confirm-delete="true" data-delete-card="cliente" data-href-delete="http://<?php echo $host; ?>/ParqueaderoVL/delete/delete_cliente.php?id=<?php echo $cliente["id_cliente"]; ?>" title="Eliminar">
                                            Eliminar
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
    <?php include "../modals/editar_cliente.php"; ?>
    <?php include "../modals/crear_cliente.php"; ?>

    <script>
        $(document).ready(() => {
            $("button#editar").click((e) => {
                const data = e.target.getAttribute("data-modal").split(":");            
                $("#id").val(data[0]);
                $("#nombre").val(data[1]);
                $("#apellido").val(data[2]);
                $("#telefono").val(data[3]);
                $("#correo").val(data[4]);
                $("#clave").val(data[5]);               
            });            
        })
    </script>

</body>

</html>