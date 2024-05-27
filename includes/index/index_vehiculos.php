<!-- Mostrar vehiculos -->
<hr />
<h4>Vehículos</h4>
<hr />
<div class="container-fluid overflowy-auto p-4">
<?php 
            if(obtenerCampo("email") != null) {
                $email_ = trim(obtenerCampo('email'));
                $select = mysqli_query($conn, "SELECT * FROM clientes WHERE correo = '$email_' LIMIT 1");
                if(mysqli_num_rows($select) > 0) {
                    $c = mysqli_fetch_assoc($select);

                    $id_c = $c["id_cliente"];
                }
            }
            ?>
    <?php    
    if(obtenerCampo("rol") >= 2) {
        $vehiculos = mysqli_query($conn, "SELECT * FROM vehiculos");
    } else {
        $vehiculos = mysqli_query($conn, "SELECT * FROM vehiculos WHERE id_cliente = '$id_c'");
    }
    $contar_veh = mysqli_num_rows($vehiculos);

    if ($contar_veh > 0) {
        while ($vehiculo = mysqli_fetch_assoc($vehiculos)) { ?>
            <div class="card" style="width: 18rem;margin-left:auto;margin-right:auto;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $vehiculo["placa"]; ?></h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Marca: <?php echo $vehiculo["marca"]; ?></li>
                    <li class="list-group-item">Modelo: <?php echo $vehiculo["modelo"]; ?></li>
                    <li class="list-group-item" style="background-color: <?php echo $vehiculo["modelo"]; ?>"></li>
                    <li class="list-group-item">Puesto: <?php echo $vehiculo["puesto"]; ?></li>
                </ul>
                <div class="card-body">
                    <a href="vista/lista_vehiculos.php">Ver vehículos</a>
                </div>
            </div>
    <?php

        }
    }
    ?>
</div>

<!-- Fin mostrar puestos -->