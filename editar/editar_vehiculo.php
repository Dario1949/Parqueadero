<?php
session_start();
require("../config/config.php");

error_reporting(0);

$id = $_GET['id'];

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

// Formulario de actualización o edición

$success = false;

$consulta = mysqli_query($conn, "SELECT * FROM vehiculos WHERE id = $id");
if (mysqli_num_rows($consulta) > 0) {
    while ($fila = mysqli_fetch_assoc($consulta)) {
        $vistaplaca = $fila["placa"];
        $vistamarca = $fila["marca"];
        $vistamodelo = $fila["modelo"];
        $vistacolor = $fila["color"];
        $vistapuesto = $fila["puesto"];
        $vistacliente = $fila["id_cliente"];
    }
}

if (isset($_POST["guardar"])) {
    $placa = $_POST["placa"];
    $marca = $_POST["marca"];
    $modelo = $_POST["modelo"];
    $color = $_POST["color"];
    $puesto = $_POST["puesto"];
    $cliente = intval($_POST["cliente"]);

    $normalizar_puesto_anterior = mysqli_query($conn, "UPDATE puestos SET disponibilidad = 1 WHERE id = '$vistapuesto'");
    if ($normalizar_puesto_anterior) {
        echo "Puesto asignado correctamente";
    } else {
        echo "Ha ocurrido un error";
    }

    $update = mysqli_query($conn, "UPDATE vehiculos SET placa = '$placa', marca = '$marca', modelo = '$modelo', color = '$color', puesto = '$puesto', id_cliente = '$cliente' WHERE id = $id");
    if ($update) {
        $success = true;

        $asignar_puesto = mysqli_query($conn, "UPDATE puestos SET disponibilidad = 0 WHERE id = '$puesto'");
        if ($asignar_puesto) {
            echo "Puesto asignado correctamente";
        } else {
            echo "Ha ocurrido un error";
        }
    } else {
        $success = false;
        echo "Ha ocurrido un error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cajero | <?php echo $id; ?></title>

    <?php include "../includes/styles.php"; ?>
</head>

<body>
    <div class="container-fluid ">
        <div class="row flex-nowrap">
            <?php include "../includes/header.php"; ?>
            <div class="col py-3">
                <?php
                if ($success) { ?>
                    <div class="alert alert-success" role="alert">
                        Se ha realizado la modificación correctamente!
                    </div>
                <?php } ?>
                <h2>Editar vehículo | <?php echo $id; ?></h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="placa">Placa:</label>
                        <input type="text" name="placa" class="form-control" value="<?php echo $vistaplaca; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="marca">Marca:</label>
                        <input type="text" name="marca" class="form-control" value="<?php echo $vistamarca; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="modelo">Modelo:</label>
                        <input type="text" name="modelo" class="form-control" value="<?php echo $vistamodelo; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="color">Color:</label>
                        <input type="color" name="color" class="form-control" value="<?php echo $vistacolor; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="puesto">Puesto:</label>
                        <?php
                        $resultado_puestos = mysqli_query($conn, "SELECT * FROM puestos WHERE disponibilidad = true");
                        if (mysqli_num_rows($resultado_puestos) > 0) { ?>
                            <select name="puesto" id="puesto" class="form-control">
                                <option value="0">Puesto</option>
                                <?php while ($puesto = mysqli_fetch_assoc($resultado_puestos)) { ?>
                                    <option value="<?php echo $puesto["id"]; ?>" <?php if ($puesto["id"] === $vistapuesto) { ?>selected<?php } ?>><?php echo $puesto["numero"]; ?></option>
                                <?php
                                } ?>
                            </select>
                        <?php } else { ?>
                            <div class="d-block p-1">No hay puestos.</div>
                            <div class="d-block p-1">
                                <button type="button" data-href="http://<?php echo $host; ?>/ParqueaderoVL/puestos/crear_puesto.php" class="btn btn-primary">Crear puesto</button>
                            </div>
                        <?php } ?>

                    </div>
                    <div class="form-group">
                        <label for="cliente">Cliente:</label>
                        <select name="cliente" id="cliente" class="form-control">

                            <option value="">Seleccionar cliente</option>
                            <?php
                            // Obtener los dueños registrados en la base de datos
                            $sql = "SELECT * FROM clientes";
                            $resultado = mysqli_query($conn, $sql);
                            $seleccionado = "";
                            while ($cliente = mysqli_fetch_array($resultado)) {
                                if ($cliente["id_cliente"] == $vistacliente) {
                                    $seleccionado = "selected";
                                } else {
                                    $seleccionado = "";
                                }
                                echo "<option value='" . $cliente['id_cliente'] . "' " . $seleccionado . ">" . $cliente['nombre'] . " " . $cliente['apellido'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
                </form>
            </div>
        </div>
    </div>

    <?php include "../includes/js.php"; ?>

</body>

</html>