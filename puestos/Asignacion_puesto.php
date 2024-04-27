<?php
require("./config.php");
if (isset($_POST["enviar"])) {
    // Recibir los datos del formulario
    $puesto = $_POST["puesto"];
    $id_cliente = intval($_POST["cliente"]);

    // Validar los campos del formulario
    if (empty($puesto) || empty($id_cliente)) {
        echo "Por favor complete todos los campos.";
    } else {
        // Insertar los datos en la tabla "vehiculos"
        $sql = "INSERT INTO vehiculos (placa, id_cliente) VALUES ( '$puesto', '$id_cliente')";
        if (mysqli_query($conn, $sql)) {
            echo "Vehículo registrado correctamente.";
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
    <title>Asignacion puesto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #858584;
        }
    </style>
</head>
<body>
    
<div class="container">  
<div class="row justify-content-center">
            <div class="col-lg-6">
                <h2 class="mt-4 mb-4">Asignar puesto</h2>
                <form action="" method="post"> 
            <div class="form-group">
                <label for="cliente">Seleccione el cliente:</label>
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
            <label for="puesto">Numero del puesto a Asignar:</label>
                <input type="text" class="form-control" name="puesto" required>
                <button type="submit" class="btn btn-primary" name="enviar">Asignar Puesto</button>
            <a href="index.html" class="btn btn-secondary">Volver al inicio</a> <!-- Botón "Volver al inicio" --> 
            </div>
            <?php
            if (isset($_POST["enviar"])) {
            echo "<a href='lista_clientes_vehiculos.php'' class='btn btn-info'>Ir a la lista</a>"; // Botón "Registrar vehículo"
        }
        ?>
        </form>
    </div>
            
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>