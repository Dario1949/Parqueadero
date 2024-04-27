<!-- Mostrar puestos -->
<hr />
<h4>Puestos</h4>
<hr />
<div class="container-fluid p-4 overflow-auto">
    <?php
    $puestos = mysqli_query($conn, "SELECT * FROM puestos");
    $contar_pues = mysqli_num_rows($puestos);

    if ($contar_pues > 0) {
        while ($puesto = mysqli_fetch_assoc($puestos)) { ?>
            <div class="card d-inline-flex" style="width: 18rem;margin-left:auto;margin-right:auto;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $puesto["numero"]; ?></h5>
                    <p class="card-text">
                        <?php
                        if ($puesto["disponibilidad"]) { ?>
                            <button type="button" class="btn btn-primary">Disponible</button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-secondary">Ocupado</button>
                        <?php } ?>
                    </p>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-href="http://<?php echo $host; ?>/ParqueaderoVL/editar/editar_puesto.php?id=<?php echo $puesto["id"]; ?>" title="Editar">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="d-inline-block align-middle">
                            <image href="icons/edit-svgrepo-com.svg" height="20" width="20" />
                        </svg>
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-confirm-delete="true" data-delete-card="puesto" data-href-delete="http://<?php echo $host; ?>/ParqueaderoVL/delete/delete_puesto.php?id=<?php echo $puesto["id"]; ?>" title="Eliminar">
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