<!-- Mostrar clientes -->
<hr />
<h4>Clientes</h4>
<hr />
<div class="container-fluid overflowy-auto p-4">
    <?php
    $clientes = mysqli_query($conn, "SELECT * FROM clientes");
    $contar_cli = mysqli_num_rows($clientes);

    if ($contar_cli > 0) {
        while ($cli = mysqli_fetch_assoc($clientes)) { ?>
            <div class="card d-inline-flex" style="width: 18rem;margin-left:auto;margin-right:auto;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $cli["nombre"] . " " . $cli["apellido"]; ?></h5>
                    <p class="card-text"><?php echo $cli["correo"]; ?></p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><?php echo $cli["telefono"]; ?></li>
                </ul>
                <div class="card-body">
                    <button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-href="http://<?php echo $host; ?>/ParqueaderoVL/editar/editar_cliente.php?id=<?php echo $cli["id_cliente"]; ?>" title="Editar">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" class="d-inline-block align-middle">
                            <image href="icons/edit-svgrepo-com.svg" height="20" width="20" />
                        </svg>
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-confirm-delete="true" data-delete-card="cliente" data-href-delete="http://<?php echo $host; ?>/ParqueaderoVL/delete/delete_cliente.php?id=<?php echo $cli["id_cliente"]; ?>" title="Eliminar">
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

<!-- Fin mostrar clientes -->