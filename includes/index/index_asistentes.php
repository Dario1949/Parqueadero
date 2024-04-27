<!-- Mostrar asistentes -->
<hr />
<h4>Asistentes</h4>
<hr />
<div class="container-fluid overflowy-auto p-4">
    <?php
    $asistentes = mysqli_query($conn, "SELECT * FROM asistentes");
    $contar_asis = mysqli_num_rows($asistentes);

    if ($contar_asis > 0) {
        while ($asis = mysqli_fetch_assoc($asistentes)) { ?>
            <div class="card" style="width: 18rem;margin-left:auto;margin-right:auto;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $asis["nombre"] . " " . $asis["apellido"]; ?></h5>
                    <p class="card-text"><?php echo $asis["correo"]; ?></p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><?php echo $asis["telefono"]; ?></li>
                    <li class="list-group-item"><?php echo $asis["salario"]; ?></li>
                </ul>
                <div class="card-body">
                    <button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-href="http://<?php echo $host; ?>/ParqueaderoVL/editar/editar_asistentes.php?id=<?php echo $asis["id"]; ?>" title="Editar">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="d-inline-block align-middle">
                            <image href="icons/edit-svgrepo-com.svg" height="20" width="20" />
                        </svg>
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-confirm-delete="true" data-delete-card="asistente" data-href-delete="http://<?php echo $host; ?>/ParqueaderoVL/delete/delete_asistente.php?id=<?php echo $asis["id"]; ?>" title="Eliminar">
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

<!-- Fin mostrar asistentes -->