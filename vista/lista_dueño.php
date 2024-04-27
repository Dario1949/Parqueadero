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
    <title>Listado de Dueños</title>

    <?php include "../includes/styles.php"; ?>
</head>

<body>
    <div class="container-fluid ">
        <div class="row flex-nowrap">
            <?php include "../includes/header.php"; ?>
            <div class="col py-3">
                <h2>Listado de Dueños</h2>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Consultar los datos de los dueños
                        $resultado = mysqli_query($conn, "SELECT * FROM duenos");
                        // Verificar si se encontraron resultados
                        if (mysqli_num_rows($resultado) > 0) {
                            // Recorrer los resultados y mostrar los datos
                            while ($dueño = mysqli_fetch_assoc($resultado)) {
                                $id = $dueño['id'];
                                $nombre = $dueño['nombre'];
                                $apellido = $dueño['apellido'];
                                $telefono = $dueño['telefono'];
                                $correo = $dueño['correo'];

                                // Imprimir cada fila de la tabla
                                echo "<tr>";
                                echo "<td>" . $nombre . "</td>";
                                echo "<td>" . $apellido . "</td>";
                                echo "<td>" . $telefono . "</td>";
                                echo "<td>" . $correo . "</td>";
                                echo "<td>";
                                if ($session) { ?>                                    
                                    <button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-href="http://<?php echo $host; ?>/ParqueaderoVL/editar/editar_dueño.php?id=<?php echo $id; ?>" title="Editar">
                                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="d-inline-block align-middle">
                                            <image href="../icons/edit-svgrepo-com.svg" height="20" width="20" />
                                        </svg>
                                    </button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-confirm-delete="true" data-delete-card="dueño" data-href-delete="http://<?php echo $host; ?>/ParqueaderoVL/delete/delete_dueño.php?id=<?php echo $id; ?>" title="Eliminar">
                                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="d-inline-block align-middle">
                                            <image href="../icons/delete-1487-svgrepo-com.svg" height="20" width="20" />
                                        </svg>
                                    </button>
                        <?php }
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            // Mostrar mensaje si no se encontraron dueños en la base de datos
                            echo "<tr><td colspan='5'>No se encontraron dueños en la base de datos.</td></tr>";
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