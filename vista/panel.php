<div class="col vh-100 mb-5 ">
    <?php
    $email_cookie = obtenerCampo("email");

    $datos_cookie = mysqli_query($conn, "SELECT * FROM clientes WHERE correo = '$email_cookie'");
    $dato = mysqli_fetch_assoc($datos_cookie);

    $resultado = mysqli_query($conn, "SELECT * FROM puestos");
    while ($row = mysqli_fetch_array($resultado)) {
        $auto = mysqli_query($conn, "SELECT * FROM vehiculos WHERE placa = '" . $row["placa"] . "'");
        $auto = mysqli_fetch_array($auto);
        $cliente = mysqli_query($conn, "SELECT * FROM clientes WHERE id_cliente = '" . $row["id_cliente"] . "'");
        $cliente = mysqli_fetch_array($cliente);
        ?>
        <div class="card d-inline-block m-2" style="width: 18rem;">
            <section class="card-img-top w-100 h-25 d-block p-3 bg-secondary text-center ">
                <h1><?= $row["placa"]; ?></h1>
            </section>
            <div class="card-body">
                <h3>
                    <?php if ($row["disponibilidad"]) { ?><span class="badge bg-primary user-select-none"
                            role="button">Disponible</span><?php } else { ?><span class="badge bg-primary user-select-none"
                            role="button">Ocupado</span><?php } ?></php>
                    <?php if ($row["reservado"]) { ?><span class="badge bg-secondary user-select-none"
                            role="button">Reservado</span><?php } else if (!$row["reservado"] && $row["disponibilidad"]) { ?><a
                                href="registrar/registrar_puesto_reservado.php?id=<?= $row["id"]; ?>"
                                class="btn btn-primary">Reservar</a><?php } ?></php>
                </h3>
                <h5 class="card-title"><b>Puesto</b> <?= $row["numero"]; ?></h5>
                <p class="card-text">
                    <b>Marca</b>: <?= $auto["marca"]; ?> <br />
                    <b>Modelo</b>: <?= $auto["modelo"]; ?> <br />                    
                    <?php if ($auto["tipo"] == 1) {
                        echo "<b>Tipo</b>: Bicicleta";
                    } else if ($auto["tipo"] == 2) {
                        echo "<b>Tipo</b>: Moto";
                    } else if ($auto["tipo"] == 3) {
                        echo "<b>Tipo</b>: Carro";
                    } else if ($auto["tipo"] == 4) {
                        echo "<b>Tipo</b>: Camión/Bus";
                    } ?>
                </p>
                <?php if ($row["disponibilidad"]) { ?><a href="vista/lista_vehiculos.php" class="btn btn-primary">Ocupar</a><?php } ?>
                <?php if ($dato["id_cliente"] == $row["id_cliente"]) { ?>
                    <div class="badge bg-primary"><h5>Tu puesto</h5></div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>