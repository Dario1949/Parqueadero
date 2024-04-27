<!-- Mostrar dueños -->
<hr />
<h4>Dueños</h4>
<hr />
<div class="container-fluid overflowy-auto p-4">
    <?php
    $duenos = mysqli_query($conn, "SELECT * FROM duenos");
    $contar_due = mysqli_num_rows($duenos);

    if ($contar_due > 0) {
        while ($due = mysqli_fetch_assoc($duenos)) { ?>
            <div class="card" style="width: 18rem;margin-left:auto;margin-right:auto;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $due["nombre"] . " " . $due["apellido"]; ?></h5>
                    <p class="card-text"><?php echo $due["correo"]; ?></p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><?php echo $due["telefono"]; ?></li>
                </ul>
                <div class="card-body">
                    <button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-href="http://<?php echo $host; ?>/ParqueaderoVL/editar/editar_dueño.php?id=<?php echo $due["id"]; ?>" title="Editar">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="d-inline-block align-middle">
                            <image href="icons/edit-svgrepo-com.svg" height="20" width="20" />
                        </svg>
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-confirm-delete="true" data-delete-card="dueño" data-href-delete="http://<?php echo $host; ?>/ParqueaderoVL/delete/delete_dueño.php?id=<?php echo $due["id"]; ?>" title="Eliminar">
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

<!-- Fin mostrar dueños -->