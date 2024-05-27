<?php if (obtenerCampo("rol") >= 2) { ?>
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
                    <a href="vista/lista_cajeros.php">Ver cajeros</a>
                </div>
            </div>
    <?php
            
        }
    }
    ?>
</div>

<!-- Fin mostrar cajeros -->
<?php } ?>