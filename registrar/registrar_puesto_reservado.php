<?php
require("../funciones.php");
require("../config/config.php");

error_reporting(0);

// Obtener id de puesto a reservar, si se envia 
$puesto_id = $_GET["id"];

$session = empty($_COOKIE["usuario"]) ? "" : $_COOKIE["usuario"];

// Obtener id cliente/cookie

$email_cookie = obtenerCampo("email");

$datos_cookie = mysqli_query($conn, "SELECT * FROM clientes WHERE correo = '$email_cookie'");
$dato = mysqli_fetch_assoc($datos_cookie);

// Comprobación formulario

if (isset($_POST["enviar"])) {
    // Recibir los datos del formulario
    $puesto = $_POST["puesto"];
    $id_cliente = intval($_POST["cliente"]);

    // Validar los campos del formulario
    if (empty($puesto) || empty($id_cliente)) {
        echo "Por favor complete todos los campos.";
    } else {
        // Si el usuario elige puesto automático, se configura lo siguiente
        $consultar_puesto_auto = mysqli_query($conn, "SELECT * FROM puestos WHERE disponibilidad = 1 AND reservado = 0 LIMIT 1");
        if (mysqli_num_rows($consultar_puesto_auto) > 0) {
            // Consultamos el id del puesto elegido

            $p = mysqli_fetch_assoc($consultar_puesto_auto);

            $puesto = $p["id"];

            // Si hay puestos disponibles, elegimos cualquiera
            // Insertar los datos en la tabla "vehiculos"            

            $asignar_puesto = mysqli_query($conn, "UPDATE puestos SET disponibilidad = 0, reservado = 1, id_cliente = '$id_cliente' WHERE id = '$puesto'");
            if ($asignar_puesto) {
                echo "Puesto asignado correctamente";
            } else {
                echo "Ha ocurrido un error";
            }
        } else {
            echo "Al parecer llegaste tarde, espera a que haya un puesto desocupado";
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
            <a href=" /ParqueaderoVL/home.php">Regresar</a> 
                <h2 class="mt-4 mb-4">Reservar puesto</h2>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="puesto">Puesto</label>
                        <?php
                        $resultado_puestos = mysqli_query($conn, "SELECT * FROM puestos WHERE disponibilidad = true");
                        if (mysqli_num_rows($resultado_puestos) > 0) { ?>
                            <select name="puesto" id="puesto" class="form-control">
                                <option value="auto">Automático</option>
                                <?php 
                                $validar = mysqli_query($conn, "SELECT * FROM puestos WHERE id = '".$puesto_id."' AND disponibilidad = 1 AND reservado = 0");
                                $p_ = mysqli_fetch_assoc($validar);
                                if(mysqli_num_rows($validar) > 0) { ?>
                                <option value="<?=$p_["id"];?>" selected><?=$p_["numero"];?></option>
                                <?php } ?>
                                <?php while ($puesto = mysqli_fetch_assoc($resultado_puestos)) { ?>
                                    <option value="<?php echo $puesto["id"]; ?>"><?php echo $puesto["numero"]; ?></option>
                                <?php
                                } ?>
                            </select>
                        <?php } else { ?>
                            <div class="d-block p-1">No hay puestos.</div>
                            <?php
                            if (obtenerCampo("rol") >= 2) { ?>
                                <div class="d-block p-1">
                                    <button type="button" data-href="http://<?php echo $host; ?>/ParqueaderoVL/vista/lista_puestos.php" class="btn btn-primary">Crear puesto</button>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <input type="hidden" name="cliente" id="cliente" value="<?php echo $dato["id_cliente"]; ?>">
                    <button type="submit" class="btn btn-primary" name="enviar">Reservar</button>
                </form>
            </div>
        </div>
    </div>

    <?php include "../includes/js.php"; ?>

</body>

</html>