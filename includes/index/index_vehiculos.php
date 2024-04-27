<!-- Mostrar vehiculos -->
<hr />
<h4>Vehículos</h4>
<hr />
<div class="container-fluid overflowy-auto p-4">
    <?php
    $vehiculos = mysqli_query($conn, "SELECT * FROM vehiculos");
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
                    <button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-href="http://<?php echo $host; ?>/ParqueaderoVL/editar/editar_vehiculo.php?id=<?php echo $vehiculo["id"]; ?>" data-bs-placement="top" title="Editar">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="d-inline-block align-middle">
                            <image href="icons/edit-svgrepo-com.svg" height="20" width="20" />
                        </svg>
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-confirm-delete="true" data-delete-card="vehículo" data-href-delete="http://<?php echo $host; ?>/ParqueaderoVL/delete/delete_vehiculo.php?id=<?php echo $vehiculo["id"]; ?>" data-bs-placement="top" title="Eliminar">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="d-inline-block align-middle">
                            <image href="icons/delete-1487-svgrepo-com.svg" height="20" width="20" />
                        </svg>
                    </button>
                </div>
            </div>
    <?php

        }
    }
    ?>
</div>

<!-- Fin mostrar puestos -->