<?php
require("./config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarifa</title>
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
                <h2 class="mt-4 mb-4">Tarifas</h2>
                <form action="" method="post"> 
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
            <label for="hora">Hora:</label>
                <input type="text" class="form-control" name="hora" required>
                <label for="costo">Costo:</label>
                <input type="text" class="form-control" name="costo" required>
                <button type="submit" class="btn btn-primary" name="enviar">Cargar Tarifa</button>
            <a href="index.html" class="btn btn-secondary">Volver al inicio</a> <!-- Botón "Volver al inicio" --> 
            </div>
            
            
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>