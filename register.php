<?php
session_start();
require("./config/config.php");

error_reporting(0);
$query = mysqli_query($conn, "SELECT * FROM duenos");
$duenos_contar = mysqli_num_rows($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Parqueadero</title>

    <?php include "./includes/styles.php"; ?>
</head>

<body>
    <!-- <div class="container-fluid">
        <div class="row flex-nowrap">
            <?php /* include "./includes/header.php"; */ ?>
            <div class="col py-3">
                <h3>Parqueadero</h3>                                                
                <?php /* include "./includes/index/index_asistentes.php"; */ ?>
                <?php /* include "./includes/index/index_cajeros.php"; */ ?>  
                <?php /* include "./includes/index/index_clientes.php"; */ ?>
                <?php /* include "./includes/index/index_dueños.php"; */ ?>
                <?php /* include "./includes/index/index_puestos.php"; */ ?>
                <?php /* include "./includes/index/index_vehiculos.php"; */ ?>       
            </div>
        </div>
    </div> -->

    <div class="container text-center">
        <div class="row align-items-center">
            <div class="col">
                <script>
                    window.addEventListener("load", () => {
                        let formulario = document.getElementById("form-login");

                        formulario.addEventListener("submit", (e) => {
                            e.preventDefault();
                            const data = new FormData(formulario);
                            const name = data.get("name");
                            const lastname = data.get("lastname");
                            const tel = data.get("tel");
                            const email = data.get("email");
                            const password = data.get("password");
                            const rol = data.get("rol");

                            if (name.length > 0) {
                                if (lastname.length > 0) {
                                    if (email.length > 0) {
                                        if (tel.length > 0) {
                                            if (password.length > 0) {
                                                $.post(
                                                    "controllers/register/index.php", {
                                                        name,
                                                        lastname,
                                                        tel,
                                                        email,
                                                        password,
                                                        rol,
                                                    },
                                                    function(res) {
                                                        const response = JSON.parse(res);

                                                        if (response.success) {
                                                            alert(response.message);
                                                            window.location = "home.php";
                                                            setSessionCookie(
                                                                "usuario",
                                                                "email:" + email + ":rol:" + rol
                                                            );
                                                        } else {
                                                            alert(response.message);
                                                        }
                                                    }
                                                );
                                            } else {
                                                alert("Debe agregar su contraseña");
                                            }
                                        } else {
                                            alert("Debe ingresar su correo electrónico");
                                        }
                                    } else {
                                        alert("Debe ingresar su teléfono");
                                    }
                                } else {
                                    alert("Debe ingresar su apellido");
                                }
                            } else {
                                alert("Debe ingresar su nombre");
                            }
                        });
                    });
                </script>

                <section class="align-middle vh-100 d-grid place-items-center justify-content-center">
                    <div></div>
                    <form method="post" id="form-login">
                        <h1>Bienvenid@</h1>
                        <div class="form-outline mb-4">
                            <label class="form-label" for="rol">Rol</label>
                            <select class="form-select" id="rol" name="rol" aria-label="Rol">
                                <option value="1" selected>Cliente</option>
                                <option value="2">Asistente</option>
                                <option value="3">Cajero</option>
                                <?php if ($duenos_contar == 0) { ?>
                                    <option value="4">Dueño</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-outline mb-4">
                            <label class="form-label" for="name">Nombre</label>
                            <input type="text" id="name" name="name" class="form-control" />
                        </div>
                        <div class="form-outline mb-4">
                            <label class="form-label" for="lastname">Apellido</label>
                            <input type="text" id="lastname" name="lastname" class="form-control" />
                        </div>
                        <div class="form-outline mb-4">
                            <label class="form-label" for="tel">Teléfono</label>
                            <input type="tel" id="tel" name="tel" class="form-control" />
                        </div>
                        <div class="form-outline mb-4">
                            <label class="form-label" for="email">Correo electrónico</label>
                            <input type="email" id="email" name="email" class="form-control" />
                        </div>
                        <div class="form-outline mb-4">
                            <label class="form-label" for="password">Clave</label>
                            <input type="password" id="password" name="password" class="form-control" />
                        </div>
                        <button type="submit" class="btn btn-dark btn-block mb-4 w-100">
                            Crear cuenta
                        </button>
                        <div class="text-center">
                            <p>¿Ya tienes una cuenta? <a href="index.php">Iniciar sesión</a></p>
                        </div>
                    </form>
                </section>
            </div>
            <div class="col align-items-center">
                <div class="more-sections w-100 vh-100 d-flex align-items-center align-middle justify-content-center">
                    <button class="btn btn-light d-block mt-1 w-50 btn-parqueadero">
                        Ver parqueadero
                    </button>
                    <button class="btn btn-light d-block mt-1 w-50 btn-parqueadero">
                        Ver vehiculos
                    </button>
                    <button class="btn btn-light d-block mt-1 w-50 btn-parqueadero">
                        Acerca de
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php include "./includes/js.php"; ?>

</body>

</html>