<?php if (obtenerCampo("rol") >= 2) { ?>
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
                    <a href="vista/lista_clientes.php">Ver clientes</a>
                </div>
            </div>
    <?php
        }
    }
    ?>
</div>

<!-- Fin mostrar clientes -->
<?php } ?>