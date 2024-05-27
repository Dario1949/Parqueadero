<?php if (obtenerCampo("rol") >= 2) { ?>
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
                        <a href="vista/lista_asistentes.php">Ver asistentes</a>
                    </div>
                </div>
        <?php

            }
        }
        ?>
    </div>

    <!-- Fin mostrar asistentes -->
<?php } ?>