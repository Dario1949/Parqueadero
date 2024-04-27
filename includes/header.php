<?php
if (!isset($_SESSION)) {
    session_start();
}

error_reporting(0);

$host = $_SERVER['HTTP_HOST'];
$folder = $_SERVER['REQUEST_URI'];

$session = empty($_SESSION["usuario"]) ? false : true;
?>

<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
        <a href="http://<?php echo $host; ?>/ParqueaderoVL/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-5 d-none d-sm-inline">Parqueadero Volebam</span>
        </a>
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            <li class="nav-item">
                <a href="http://<?php echo $host; ?>/ParqueaderoVL/" class="nav-link align-middle px-0">
                    <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Inicio</span>
                </a>
            </li>
            <?php if ($session) { ?>
                <li>
                    <a href="#create" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                        <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Crear</span> </a>
                    <ul class="collapse nav flex-column ms-1" id="create" data-bs-parent="#menu">
                        <li class="w-100">
                            <a href="http://<?php echo $host; ?>/ParqueaderoVL/registrar/registrar_dueño.php" class="nav-link px-0"> <span class="d-none d-sm-inline">Administrador</span></a>
                        </li>
                        <li>
                            <a href="http://<?php echo $host; ?>/ParqueaderoVL/registrar/registrar_cliente.php" class="nav-link px-0"> <span class="d-none d-sm-inline">Cliente</span></a>
                        </li>
                        <li>
                            <a href="http://<?php echo $host; ?>/ParqueaderoVL/registrar/registrar_cajero.php" class="nav-link px-0"> <span class="d-none d-sm-inline">Cajero</span></a>
                        </li>
                        <li>
                            <a href="http://<?php echo $host; ?>/ParqueaderoVL/registrar/registrar_asistente.php" class="nav-link px-0"> <span class="d-none d-sm-inline">Asistente administrativo</span></a>
                        </li>
                        <li>
                            <a href="http://<?php echo $host; ?>/ParqueaderoVL/registrar/registrar_vehiculo.php" class="nav-link px-0"> <span class="d-none d-sm-inline">Vehículo</span></a>
                        </li>
                        <li>
                            <a href="http://<?php echo $host; ?>/ParqueaderoVL/puestos/crear_puesto.php" class="nav-link px-0"> <span class="d-none d-sm-inline">Puesto</span></a>
                        </li>
                    </ul>
                </li>                
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
                        <a href="http://<?php echo $host; ?>/ParqueaderoVL/vista/lista_clientes_vehiculos.php" class="nav-link px-0"> <span class="d-none d-sm-inline">Clientes y vehículos</span></a>
                    </li>
                    <li>
                        <a href="http://<?php echo $host; ?>/ParqueaderoVL/vista/lista_puestos.php" class="nav-link px-0"> <span class="d-none d-sm-inline">Puestos</span></a>
                    </li>
                </ul>
            </li>
        </ul>
        <?php if ($session) { ?>
            <hr>
            <div class="dropdown pb-4">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
                    <span class="d-none d-sm-inline mx-1">Admin</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="#">Editar perfil</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Cerrar sesión</a></li>
                </ul>
            </div>
        <?php } ?>
    </div>
</div> <?php include "../includes/js.php"; ?>