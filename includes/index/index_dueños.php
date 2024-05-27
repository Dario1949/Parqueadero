<?php if (obtenerCampo("rol") >= 2) { ?>
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
                    <a href="vista/lista_dueño.php">Ver dueños</a>
                </div>
            </div>
    <?php

        }
    }
    ?>
</div>

<!-- Fin mostrar dueños -->
<?php } ?>