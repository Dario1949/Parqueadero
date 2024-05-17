<?php
require("../funciones.php");
require("../config/config.php");

//error_reporting(0);

$session = empty($_COOKIE["usuario"]) ? "" : $_COOKIE["usuario"];

// Obtener id cliente/cookie

$email_cookie = obtenerCampo("email");

$datos_cookie = mysqli_query($conn, "SELECT * FROM clientes WHERE correo = '$email_cookie'");
$dato = mysqli_fetch_assoc($datos_cookie);

// Comprobación datos vehiculo

$id = $_GET["id"];
$fecha_creado = "";
$tipo = "";
$id_puesto = "";

$seleccionar_vehiculo = mysqli_query($conn, "SELECT * FROM vehiculos WHERE id = '$id'");
if (mysqli_num_rows($seleccionar_vehiculo) > 0) {
    $v = mysqli_fetch_assoc($seleccionar_vehiculo);
    $fecha_creado = $v["fecha_creado"];
    $tipo = $v["tipo"];
    $id_puesto = $v["puesto"];
}

// Comprobar formulario de retiro de vehículo
if(isset($_POST["enviar"])) {
    // Procesar datos
    $fecha_inicio = $_POST["fecha_inicio"];
    $fecha_final = $_POST["fecha_final"];
    $precio_final = $_POST["precio_final"];
    $cliente = $_POST["cliente"];

    $crear_factura = mysqli_query($conn, "INSERT INTO facturas (id_cliente, id_cajero, fecha, total) VALUES ('$cliente', '1', NOW(), '$precio_final')");
    if($crear_factura) {
        // Obtenemos 
        $ultimo_id = mysqli_insert_id($conn);

        // Creamos detalles de factura
        $crear_detalles_factura = mysqli_query($conn, "INSERT INTO detalles_factura (id_factura, id_puesto, tiempo_llegada, tiempo_salida, subtotal) VALUES ('$ultimo_id', '$id_puesto', '$fecha_inicio', '$fecha_final', '$precio_final')");        
        if($crear_detalles_factura) {
            // Luego eliminamos el vehículo
            $eliminar_vehiculo = mysqli_query($conn, "DELETE FROM vehiculos WHERE id = '$id'");
            if($eliminar_vehiculo) {
                // Cambiamos el puesto a disponible
                $actualizar_puesto = mysqli_query($conn, "UPDATE puestos SET placa = '', reservado = 0, id_cliente = 0, disponibilidad = 1 WHERE id = '$id_puesto'");
                if($actualizar_puesto) {
                    echo "Se ha creado la factura exitosamente"; ?>     
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Fecha inicio</th>
                                <th>Fecha fin</th>
                                <th>Precio final</th>                                                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?=$fecha_inicio;?></td>
                                <td><?=$fecha_final;?></td>
                                <td><?=$precio_final;?></td>
                            </tr>
                        </tbody>
                    </table>    
                    <h1>Gracias por <b>visitarnos</b></h1>
                    <h2>Usted será redirrecionado en 10 segundos</h2>                               
                    <script>
                        setTimeout(() => {
                            window.location = "../home.php";
                        }, 10000);
                    </script>
                <?php }
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
    <title>Crear factura</title>

    <?php include "../includes/styles.php"; ?>

    <script>
        function calculateElapsedTime(startDateStr, endDateStr) {
            // Convert date strings to Date objects
            const startDate = new Date(startDateStr);
            const endDate = new Date(endDateStr);

            // Calculate time difference in milliseconds
            const timeDiffInMs = endDate.getTime() - startDate.getTime();

            // Convert milliseconds to hours and minutes
            const timeDiffInSeconds = timeDiffInMs / 1000;
            const hours = Math.floor(timeDiffInSeconds / 3600);
            const minutes = Math.floor((timeDiffInSeconds % 3600) / 60);

            // Format the output
            const elapsedTime = {
                hours,
                minutes
            };
            return elapsedTime;
        }

        function getCurrentDateAndTime() {
            const now = new Date();
            const year = now.getFullYear();
            const month = now.getMonth() + 1; // Months are zero-based
            const day = now.getDate();
            const hours = now.getHours();
            const minutes = now.getMinutes();
            const seconds = now.getSeconds();

            const formattedDate = ${year}-${pad(month)}-${pad(day)} ${pad(hours)}:${pad(minutes)}:${pad(seconds)};
            return formattedDate;
        }

        function pad(number) {
            return (number < 10 ? '0' : '') + number;
        }

        function precioSegunTipo(tipo) {
            if (tipo == 1) {
                return 50;
            } else if (tipo == 2) {
                return 140;
            } else if (tipo == 3) {
                return 230;
            } else if (tipo == 4) {
                return 350;
            }
        }

        function calcularPrecioFinal(tiempo, tipo) {
            const {
                hours,
                minutes
            } = tiempo;
            let r = 0;

            r = (precioSegunTipo(parseInt(tipo)) * (60 * hours)) + (precioSegunTipo(parseInt(tipo)) * (1 * minutes));

            return r;
        }
    </script>
</head>

<body>
    <div class="container-fluid ">
        <div class="row flex-nowrap">
            <?php /* include "../includes/header.php"; */ ?>
            <div class="col py-3">
                <h2 class="mt-4 mb-4">Crear factura</h2>
                <form method="post" action="">
                    <div>
                        <div id="fecha-inicio"><?= $fecha_creado; ?></div>
                        <div id="fecha-final"></div>
                        <div id="precio-final"></div>
                    </div>
                    <input type="hidden" name="fecha_inicio" id="fecha_inicio_input" value="<?= $fecha_creado; ?>" />
                    <input type="hidden" name="fecha_final" id="fecha_final_input" value="" />
                    <input type="hidden" name="precio_final" id="precio_final_input" value="" />
                    <input type="hidden" name="cliente" id="cliente" value="<?php echo $dato["id_cliente"]; ?>">
                    <button type="submit" class="btn btn-primary" name="enviar">Crear factura</button>
                </form>
            </div>
        </div>
    </div>

    <?php include "../includes/js.php"; ?>
    <script>
        $(window).ready(() => {
            setInterval(() => {
                const fecha_final = getCurrentDateAndTime();
                $("#fecha-final").text(fecha_final);
                let precio_final = calcularPrecioFinal(calculateElapsedTime('<?= $fecha_creado; ?>', getCurrentDateAndTime()), '<?= $tipo; ?>');
                $("#precio-final").text("$" + precio_final + " pesos colombianos")
                
                $("#fecha_final_input").val(fecha_final);
                $("#precio_final_input").val(precio_final);
            }, (500));
        });
    </script>

</body>

</html>