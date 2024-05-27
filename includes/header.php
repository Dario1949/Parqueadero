<?php
if (file_exists("../funciones.php") && !strpos($_SERVER['REQUEST_URI'], "registrar") | file_exists("../funciones.php") && !strpos($_SERVER['REQUEST_URI'], "factura")) {
    require("../funciones.php");
}

if (file_exists("funciones.php") && !strpos($_SERVER['REQUEST_URI'], "registrar") | file_exists("funciones.php") && !strpos($_SERVER['REQUEST_URI'], "factura")) {
    require("funciones.php");
}

error_reporting(0);

$host = $_SERVER['HTTP_HOST'];
$folder = $_SERVER['REQUEST_URI'];

$session = empty($_COOKIE["usuario"]) ? false : true;
?>

<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white vh-100">
        <a href="/ParqueaderoVL/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none position-fixed">
            <span class="fs-5 d-none d-sm-inline">Parqueadero Volebam</span>
        </a>
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start position-fixed" style="margin-top: 60px;" id="menu">
            <li class="nav-item">
                <a href="/ParqueaderoVL/home.php" class="nav-link align-middle px-0">
                    <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Inicio</span>
                </a>
            </li>
            <?php if ($session) { ?>
                <?php
                if (obtenerCampo("rol") >= 2) { ?>

                <?php } else { ?>
                    <li>
                        <a href="#create" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Agregar</span> </a>
                        <ul class="collapse nav flex-column ms-1" id="create" data-bs-parent="#menu">
                            <li>
                                <a href="http://<?php echo $host; ?>/ParqueaderoVL/registrar/registrar_puesto_reservado.php" class="nav-link px-0"> <span class="d-none d-sm-inline">Puesto reservado</span></a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
            <?php } else { ?>
                <li>
                    <a href="#login" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                        <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Acceso</span> </a>
                    <ul class="collapse nav flex-column ms-1" id="login" data-bs-parent="#menu">
                        <li class="w-100">
                            <a href="http://<?php echo $host; ?>/ParqueaderoVL/acceso/login.php#" class="nav-link px-0"> <span class="d-none d-sm-inline">Loguearse</span></a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <li>
                <a href="#view" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                    <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Vista</span> </a>
                <ul class="collapse nav flex-column ms-1" id="view" data-bs-parent="#menu">
                    <?php
                    if (obtenerCampo("rol") >= 2) { ?>
                        <li class="w-100">
                            <a href="http://<?php echo $host; ?>/ParqueaderoVL/vista/lista_dueño.php" class="nav-link px-0"> <span class="d-none d-sm-inline">Administradores</span></a>
                        </li>
                        <li>
                            <a href="http://<?php echo $host; ?>/ParqueaderoVL/vista/lista_clientes.php" class="nav-link px-0"> <span class="d-none d-sm-inline">Clientes</span></a>
                        </li>
                        <li>
                            <a href="http://<?php echo $host; ?>/ParqueaderoVL/vista/lista_cajeros.php" class="nav-link px-0"> <span class="d-none d-sm-inline">Cajeros</span></a>
                        </li>
                        <li>
                            <a href="http://<?php echo $host; ?>/ParqueaderoVL/vista/lista_asistentes.php" class="nav-link px-0"> <span class="d-none d-sm-inline">Asistentes administrativos</span></a>
                        </li>
                        <li>
                            <a href="http://<?php echo $host; ?>/ParqueaderoVL/vista/lista_vehiculos.php" class="nav-link px-0"> <span class="d-none d-sm-inline">Vehículos</span></a>
                        </li>
                        <li>
                            <a href="http://<?php echo $host; ?>/ParqueaderoVL/vista/lista_puestos.php" class="nav-link px-0"> <span class="d-none d-sm-inline">Puestos</span></a>
                        </li>
                    <?php } else { ?>
                        <li>
                            <a href="http://<?php echo $host; ?>/ParqueaderoVL/vista/lista_vehiculos.php" class="nav-link px-0"> <span class="d-none d-sm-inline">Vehículos</span></a>
                        </li>
                        <li>
                            <a href="http://<?php echo $host; ?>/ParqueaderoVL/vista/lista_puestos.php" class="nav-link px-0"> <span class="d-none d-sm-inline">Puestos</span></a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        </ul>
        <?php if ($session) { ?>
            <hr>
            <div class="dropdown pb-4 position-fixed" style="bottom:10px;">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
                    <span class="d-none d-sm-inline mx-1">Admin</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <?php
                    if (obtenerCampo("rol") == 1) { ?>
                        <li><a class="dropdown-item" id="accountsb">Cuentas bancarias</a></li>
                    <?php } ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" id="logout">Cerrar sesión</a></li>
                </ul>
            </div>
        <?php } ?>
    </div>
</div>