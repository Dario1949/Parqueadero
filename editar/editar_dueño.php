<?php
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

$id = $_GET["id"];

// Verificar si el formulario ha sido enviado
if (isset($_POST["guardar"])) {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];

    // Actualizar los datos del dueño en la base de datos
    $update = mysqli_query($conn, "UPDATE duenos SET nombre = '$nombre', apellido = '$apellido', telefono = '$telefono', correo = '$correo' WHERE id = $id");
    if ($update) {
        echo "<script>window.alert('Datos actualizados correctamente');</script>";
        echo "<script>window.location = '../vista/lista_dueño.php';</script>";
    } else {
        echo "Error al actualizar los datos";
    }
}

$disabled = "";
$message = "";

// Obtener los datos actuales del dueño de la base de datos
$consulta = mysqli_query($conn, "SELECT * FROM duenos WHERE id = $id");
if (mysqli_num_rows($consulta) > 0) {
    while ($fila = mysqli_fetch_assoc($consulta)) {
        $vistanombre = $fila["nombre"];
        $vistapellido = $fila["apellido"];
        $vistatel = $fila["telefono"];
        $vistacorreo = $fila["correo"];
        $vistaclave = $fila["clave"];
        $vistasalario = $fila["salario"];    
    }
} else {
    $disabled = "display:none";
    $message = "Usuario no existe";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Dueño | <?php echo $id; ?></title>

    <?php include "../includes/styles.php"; ?>
</head>

<body>
    <div class="container-fluid ">
        <div class="row flex-nowrap">
            <?php include "../includes/header.php"; ?>
            <div class="col py-3">
                <h2>Editar Dueño | <?php echo $id; ?></h2>

                <span>
                    <h4>
                        <?php echo $message; ?>
                    </h4>
                </span>

                <form action="" method="post" style="<?php echo $disabled; ?>">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" name="nombre" value="<?php echo $vistanombre; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido:</label>
                        <input type="text" class="form-control" name="apellido" value="<?php echo $vistapellido; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" class="form-control" name="telefono" value="<?php echo $vistatel; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo:</label>
                        <input type="email" class="form-control" name="correo" value="<?php echo $vistacorreo; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="clave">Clave:</label>
                        <input type="password" class="form-control" name="clave" value="<?php echo $vistaclave; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="salario">Salario:</label>
                        <input type="text" class="form-control" name="salario" value="<?php echo $vistasalario; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
                </form>
            </div>
        </div>
    </div>

    <?php include "../includes/js.php"; ?>

</body>

</html>