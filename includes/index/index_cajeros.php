<!-- Mostrar cajeros -->
<hr />
<h4>Cajeros</h4>
<hr />
<div class="container-fluid overflowy-auto p-4">
    <?php
    $cajeros = mysqli_query($conn, "SELECT * FROM cajeros");
    $contar_caj = mysqli_num_rows($cajeros);

    if ($contar_caj > 0) {
        while ($caj = mysqli_fetch_assoc($cajeros)) { ?>
            <div class="card" style="width: 18rem;margin-left:auto;margin-right:auto;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $caj["nombre"] . " " . $caj["apellido"]; ?></h5>
                    <p class="card-text"><?php echo $caj["correo"]; ?></p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><?php echo $caj["telefono"]; ?></li>
                    <li class="list-group-item"><?php echo $caj["salario"]; ?></li>
                </ul>
                <div class="card-body">
                    <button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-href="http://<?php echo $host; ?>/ParqueaderoVL/editar/editar_cajero.php?id=<?php echo $caj["id"]; ?>" title="Editar">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="d-inline-block align-middle">
                            <image href="icons/edit-svgrepo-com.svg" height="20" width="20" />
                        </svg>
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-confirm-delete="true" data-delete-card="cajero" data-href-delete="http://<?php echo $host; ?>/ParqueaderoVL/delete/delete_cajero.php?id=<?php echo $caj["id"]; ?>" title="Eliminar">
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

<!-- Fin mostrar cajeros -->