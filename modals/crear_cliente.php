<script>
    $(document).ready(() => {
        const formulario = document.getElementById("form-ccliente");

        const camposVacios = (arr) => {
            let check = false;
            if (Array.isArray(arr)) {
                if (arr.length > 0) {
                    for (let f of arr) {
                        if (typeof f === "string" && f.trim().length == 0) {                            
                            check = true;
                        }
                    }
                }
            }

            return check;
        }

        $("#form-ccliente").submit((e) => {
            e.preventDefault();

            const data = new FormData(formulario);

            const nombre = data.get("nombre");
            const apellido = data.get("apellido");
            const telefono = data.get("telefono");
            const correo = data.get("correo");
            const clave = data.get("clave");
            const rol = "cliente";

            // Comprobamos si hay campos vacios : si hay : true - no hay : false
            const comprobarCampos = camposVacios([nombre, apellido, telefono, correo, clave]);

            console.log(nombre);

            if (!comprobarCampos) {
                $.post("../controllers/create/user.php", {
                    nombre,
                    apellido,
                    telefono,
                    correo,
                    clave,
                    rol
                }, function(data) {
                    const res = JSON.parse(data);

                    if (res.success) {
                        alert(res.message);
                        //window.location.reload();
                    } else {
                        alert(res.message);
                    }
                })
            } else {
                alert("Debe llenar todos los campos!");
            }

        })
    })
</script>

<!-- Modal -->
<div class="modal fade" id="crearCliente" tabindex="-1" aria-labelledby="crearClienteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="crearClienteLabel">Crear cliente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="form-ccliente">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido:</label>
                        <input type="text" class="form-control" name="apellido" id="apellido" placeholder="Apellido" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="tel" class="form-control" name="telefono" id="telefono" placeholder="Teléfono" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo:</label>
                        <input type="email" class="form-control" name="correo" id="correo" placeholder="Correo" required>
                    </div>
                    <div class="form-group">
                        <label for="clave">Clave:</label>
                        <input type="password" class="form-control" name="clave" id="clave" placeholder="Contraseña" required>
                    </div>
                    <input type="submit" class="btn btn-primary" name="enviar" value="Crear cliente">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin modal -->