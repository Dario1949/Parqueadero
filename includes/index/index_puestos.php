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
                    <a href="vista/lista_puestos.php">Ver puestos</a>
                </div>
            </div>
    <?php

        }
    }
    ?>
</div>

<!-- Fin mostrar puestos -->