<?php
require("../funciones.php");
require("../config/config.php");

//error_reporting(0);

$session = empty($_COOKIE["usuario"]) ? "" : $_COOKIE["usuario"];

// Obtener id cliente/cookie

$email_cookie = obtenerCampo("email");

$datos_cookie = mysqli_query($conn, "SELECT * FROM clientes WHERE correo = '$email_cookie'");
$dato = mysqli_fetch_assoc($datos_cookie);

$obtener_cuentas_b = mysqli_query($conn, "SELECT * FROM cuentas_bancarias WHERE id_cliente = " . $dato["id_cliente"]);

// Comprobar formulario de retiro de vehículo
if (isset($_POST["crear_cuenta"])) {
    // Procesar datos
    $tipo = $_POST["tipo"];
    $dinero = $_POST["dinero"];
    $dinero_per = $_POST["dinero_per"];
    $cliente = $_POST["cliente"];

    // Crear cuenta bancaria

    // Si dinero es igual a all hacer lo siguiente

    if ($dinero === "all") {
        $insertar_cuenta = mysqli_query($conn, "INSERT INTO cuentas_bancarias (id_cliente, tipo, dinero) VALUES ('$cliente', '$tipo', '10000000')");
        if ($insertar_cuenta) {
            echo "Cuenta creada correctamente!";
            echo "<script>window.location = '/ParqueaderoVL/personal/cuentas-bancarias.php';</script>";
        }
    } else if ($dinero === "custom") {
        $insertar_cuenta = mysqli_query($conn, "INSERT INTO cuentas_bancarias (id_cliente, tipo, dinero) VALUES ('$cliente', '$tipo', '$dinero_per')");
        if ($insertar_cuenta) {
            echo "Cuenta creada correctamente!";
            echo "<script>window.location = '/ParqueaderoVL/personal/cuentas-bancarias.php';</script>";
        }
    } else {
        $insertar_cuenta = mysqli_query($conn, "INSERT INTO cuentas_bancarias (id_cliente, tipo, dinero) VALUES ('$cliente', '$tipo', '$dinero')");
        if ($insertar_cuenta) {
            echo "Cuenta creada correctamente!";
            echo "<script>window.location = '/ParqueaderoVL/personal/cuentas-bancarias.php';</script>";
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
    <title>Cuentas bancarias</title>

    <?php include "../includes/styles.php"; ?>
</head>

<body>
    <div class="container-fluid ">
        <div class="row flex-nowrap">
            <?php /* include "../includes/header.php"; */ ?>
            <div class="col py-3">
            <button class="btn btn-primary" data-href="/ParqueaderoVL/home.php">Volver a inicio</button>
                <h2 class="mt-4 mb-4">Agregar cuenta bancaria</h2>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="tipo">Tipo cuenta</label>
                        <select name="tipo" id="tipo" class="form-control">
                            <option value="nequi">Nequi</option>
                            <option value="paypal">Paypal</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dinero">Dinero a sacar</label>
                        <select name="dinero" id="dinero" class="form-control">
                            <option value="all">Todo</option>
                            <option value="800000">800.000</option>
                            <option value="600000">600.000</option>
                            <option value="400000">400.000</option>
                            <option value="200000">200.000</option>
                            <option value="100000">100.000</option>
                            <option value="50000">50.000</option>
                            <option value="custom">Personalizado</option>
                        </select>
                    </div>
                    <div class="form-group d-none" id="dinero_fper">
                        <label for="dinero_per">Dinero a sacar</label>
                        <input type="number" class="form-control" id="dinero_per" name="dinero_per" />
                    </div>
                    <input type="hidden" name="cliente" id="cliente" value="<?php echo $dato["id_cliente"]; ?>">
                    <button type="submit" class="btn btn-primary" name="crear_cuenta">Agregar cuenta bancaria</button>
                </form>

                <h1>Ver cuentas</h1>
                <table class="table">
                    <thead>
                        <th scope="col">Tipo</th>
                        <th scope="col">Dinero</th>
                        <th scope="col" rowspan="2">Acciones</th>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($obtener_cuentas_b) > 0) { ?>
                            <?php while ($cuenta = mysqli_fetch_assoc($obtener_cuentas_b)) { ?>
                                <tr>
                                    <td><?= $cuenta["tipo"]; ?></td>
                                    <td><?= $cuenta["dinero"]; ?></td>
                                    <td><button class="btn btn-danger" data-href="/ParqueaderoVL/delete/delete_cuenta_bancaria.php?id=<?= $cuenta["id"]; ?>">Eliminar</button></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include "../includes/js.php"; ?>
    <script>
        $(window).ready(() => {
            $("#dinero").change((e) => {
                if (e.target.value === "custom") {
                    $("#dinero_fper").removeClass("d-none");
                } else {
                    $("#dinero_fper").addClass("d-none");
                }
            })
        });
    </script>

</body>

</html>