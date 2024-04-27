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

// Comprobación formulario

if (isset($_POST["enviar"])) {
    // Recibir los datos del formulario
    $placa = $_POST["placa"];
    $marca = $_POST["marca"];
    $modelo = $_POST["modelo"];
    $color = $_POST["color"];
    $puesto = $_POST["puesto"];
    $id_cliente = intval($_POST["cliente"]);

    // Validar los campos del formulario
    if (empty($placa) || empty($marca) || empty($modelo) || empty($color) || empty($puesto) || empty($id_cliente)) {
        echo "Por favor complete todos los campos.";
    } else {
        // Insertar los datos en la tabla "vehiculos"
        $sql = "INSERT INTO vehiculos (placa, marca, modelo, color, puesto, id_cliente) VALUES ('$placa', '$marca', '$modelo', '$color', '$puesto', '$id_cliente')";
        if (mysqli_query($conn, $sql)) {
            echo "Vehículo registrado correctamente.";

            $asignar_puesto = mysqli_query($conn, "UPDATE puestos SET disponibilidad = 0 WHERE id = '$puesto'");
            if ($asignar_puesto) {
                echo "Puesto asignado correctamente";
            } else {
                echo "Ha ocurrido un error";
            }
        } else {
            echo "Error al registrar el vehículo: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Vehiculo</title>

    <?php include "../includes/styles.php"; ?>
</head>

<body>
    <div class="container-fluid ">
        <div class="row flex-nowrap">
            <?php include "../includes/header.php"; ?>
            <div class="col py-3">
                <h2 class="mt-4 mb-4">Registrar Vehiculo</h2>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="placa">Placa:</label>
                        <input type="text" class="form-control" name="placa" required>
                    </div>
                    <div class="form-group">
                        <label for="marca">Marca:</label>
                        <input type="text" class="form-control" name="marca" required>
                    </div>
                    <div class="form-group">
                        <label for="modelo">Modelo:</label>
                        <input type="text" class="form-control" name="modelo" required>
                    </div>
                    <div class="form-group">
                        <label for="color">Color:</label>
                        <input type="color" class="form-control" name="color" required>
                    </div>
                    <div class="form-group">
                        <label for="puesto">Puesto:</label>
                        <?php
                        $resultado_puestos = mysqli_query($conn, "SELECT * FROM puestos WHERE disponibilidad = true");
                        if (mysqli_num_rows($resultado_puestos) > 0) { ?>
                            <select name="puesto" id="puesto" class="form-control">
                                <option value="0">Puesto</option>
                                <?php while ($puesto = mysqli_fetch_assoc($resultado_puestos)) { ?>
                                    <option value="<?php echo $puesto["id"]; ?>"><?php echo $puesto["numero"]; ?></option>
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
                        <select class="form-control" name="cliente">
                            <option value="">Seleccionar cliente</option>
                            <?php
                            // Obtener los dueños registrados en la base de datos
                            $sql = "SELECT * FROM clientes";
                            $resultado = mysqli_query($conn, $sql);
                            while ($cliente = mysqli_fetch_array($resultado)) {
                                echo "<option value='" . $cliente['id_cliente'] . "'>" . $cliente['nombre'] . " " . $cliente['apellido'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" name="enviar">Registrar Vehiculo</button>
                </form>
            </div>
        </div>
    </div>

    <?php include "../includes/js.php"; ?>

</body>

</html>