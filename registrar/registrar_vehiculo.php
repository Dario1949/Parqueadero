<?php
require("../funciones.php");
require("../config/config.php");

error_reporting(0);

$session = empty($_COOKIE["usuario"]) ? "" : $_COOKIE["usuario"];

// Obtener id cliente/cookie

$email_cookie = obtenerCampo("email");

$datos_cookie = mysqli_query($conn, "SELECT * FROM clientes WHERE correo = '$email_cookie'");
$dato = mysqli_fetch_assoc($datos_cookie);

// Comprobación formulario

if (isset($_POST["enviar"])) {
    // Recibir los datos del formulario
    $placa = $_POST["placa"];
    $marca = $_POST["marca"];
    $modelo = $_POST["modelo"];
    $color = $_POST["color"];
    $puesto = $_POST["puesto"];
    $tipo = $_POST["tipo"];
    $id_cliente = intval($_POST["cliente"]);

    // Validar los campos del formulario
    if (empty($placa) || empty($marca) || empty($modelo) || empty($color) || empty($puesto) || empty($id_cliente) || empty($tipo)) {
        echo "Por favor complete todos los campos.";
    } else {
        if ($puesto === "auto") {
            // Si el usuario elige puesto automático, se configura lo siguiente
            $consultar_puesto_auto = mysqli_query($conn, "SELECT * FROM puestos WHERE disponibilidad = 1 AND reservado = 0 LIMIT 1");
            if (mysqli_num_rows($consultar_puesto_auto) > 0) {
                // Consultamos el id del puesto elegido

                $p = mysqli_fetch_assoc($consultar_puesto_auto);

                $puesto = $p["id"];

                // Si hay puestos disponibles, elegimos cualquiera
                // Insertar los datos en la tabla "vehiculos"            

                $sql = "INSERT INTO vehiculos (placa, marca, modelo, color, tipo, puesto, id_cliente, fecha_creado) VALUES ('$placa', '$marca', '$modelo', '$color', '$tipo', '$puesto', '$id_cliente', NOW())";
                if (mysqli_query($conn, $sql)) {
                    echo "Vehículo registrado correctamente.";

                    $asignar_puesto = mysqli_query($conn, "UPDATE puestos SET disponibilidad = 0, reservado = 0, placa = '$placa', id_cliente = '$id_cliente' WHERE id = '$puesto'");
                    if ($asignar_puesto) {
                        echo "Puesto asignado correctamente";
                    } else {
                        echo "Ha ocurrido un error";
                    }
                } else {
                    echo "Error al registrar el vehículo: " . mysqli_error($conn);
                }
            } else {
                echo "Al parecer llegaste tarde, espera a que haya un puesto desocupado";
            }
        } else {
            $sql = "INSERT INTO vehiculos (placa, marca, modelo, color, tipo, puesto, id_cliente, fecha_creado) VALUES ('$placa', '$marca', '$modelo', '$color', '$tipo', '$puesto', '$id_cliente', NOW())";
            if (mysqli_query($conn, $sql)) {
                echo "Vehículo registrado correctamente.";

                $asignar_puesto = mysqli_query($conn, "UPDATE puestos SET disponibilidad = 0, reservado = 0, placa = '$placa', id_cliente = '$id_cliente' WHERE id = '$puesto'");
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
            <?php /* include "../includes/header.php"; */ ?>
            <div class="col py-3">
                <button class="btn btn-primary" data-href="/ParqueaderoVL/home.php">Volver a inicio</button>
                <h2 class="mt-4 mb-4">Registrar Vehiculo</h2>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="placa">Placa:</label>
                        <input type="text" id="placa" class="form-control" name="placa" required>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="button" id="activar-reconocer">Subir placa y reconocer placa</button>
                    </div>
                    <div class="fom-group d-none" id="placas-reconocer">
                        <div class="col-12 col-md-6">
                            <h3>Selección de imagen</h3>
                            <div class="alert alert-warning">
                                Esta herramienta está en versión beta, entonces es posible que no arroje los resultados esperados.
                            </div>
                            <img class="img-fluid" id="imagenPrevisualizacion">
                            <div class="custom-file">
                                <input id="archivo" type="file" class="custom-file-input">
                                <label class="custom-file-label" for="archivo">Selecciona una imagen</label>
                            </div>
                            <br><br>
                            <button id="btnDetectar" type="button" class="btn btn-success">Detectar</button>
                        </div>
                        <div class="col-12 col-md-6">
                            <h3>Resultados</h3>
                            <p id="estado"></p>
                        </div>
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
                        <label for="puesto">Puesto</label>
                        <?php
                        $resultado_puestos = mysqli_query($conn, "SELECT * FROM puestos WHERE disponibilidad = 1 AND reservado = 0");
                        $resultado_puestos_reservados = mysqli_query($conn, "SELECT * FROM puestos WHERE reservado = 1 AND id_cliente = '" . $dato["id_cliente"] . "'");
                        if (mysqli_num_rows($resultado_puestos) > 0) { ?>
                            <select name="puesto" id="puesto" class="form-control">
                                <option value="auto">Automático</option>
                                <?php while ($puesto = mysqli_fetch_assoc($resultado_puestos)) { ?>
                                    <option value="<?php echo $puesto["id"]; ?>"><?php echo $puesto["numero"]; ?></option>
                                <?php } ?>
                                <?php if (mysqli_num_rows($resultado_puestos_reservados) > 0) { ?>
                                    <?php while ($puesto_r = mysqli_fetch_assoc($resultado_puestos_reservados)) { ?>
                                        <option value="<?php echo $puesto_r["id"]; ?>"><?php echo $puesto_r["numero"]; ?> | Puesto reservado</option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        <?php } else { ?>
                            <div class="d-block p-1">No hay puestos.</div>
                            <?php
                            if (obtenerCampo("rol") >= 2) { ?>
                                <div class="d-block p-1">
                                    <button type="button" data-href="http://<?php echo $host; ?>/ParqueaderoVL/puestos/crear_puesto.php" class="btn btn-primary">Crear puesto</button>
                                </div>
                            <?php } ?>
                        <?php } ?>

                    </div>
                    <?php
                    if (obtenerCampo("rol") >= 2) { ?>
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
                    <?php } else { ?>
                        <input type="hidden" name="cliente" id="cliente" value="<?php echo $dato["id_cliente"]; ?>">
                    <?php } ?>
                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <select name="tipo" class="form-control" id="tipo">
                            <option value="1">Bicicleta</option>
                            <option value="2">Moto</option>
                            <option value="3" selected>Carro</option>
                            <option value="4">Camión/Bus</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" name="enviar">Registrar Vehiculo</button>
                </form>
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

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src='https://unpkg.com/tesseract.js@2.0.0-alpha.7/dist/tesseract.min.js'></script>
    <script src="../js/reconocer-placas.js"></script>

</body>

</html>