<script>
    $(document).ready(() => {
        const formulario = document.getElementById("form-casistente");

        const camposVacios = (arr) => {
            let check = false;
            if (Array.isArray(arr)) {
                if (arr.length > 0) {
                    for (let f of arr) {
                        if (typeof f === "string" && f.length == 0) {
                            check = true;
                        }
                    }
                }
            }

            return check;
        }

        $("#form-casistente").submit((e) => {
            e.preventDefault();

            const data = new FormData(formulario);

            const nombre = data.get("nombre");
            const apellido = data.get("apellido");
            const telefono = data.get("telefono");
            const correo = data.get("correo");
            const clave = data.get("clave");
            const salario = data.get("salario");
            const rol = "asistente";

            // Comprobamos si hay campos vacios : si hay : true - no hay : false
            const comprobarCampos = camposVacios([nombre, apellido, telefono, correo, clave, salario]);

            if (!comprobarCampos) {
                $.post("../controllers/create/user.php", {
                    nombre,
                    apellido,
                    telefono,
                    correo,
                    clave,
                    salario,
                    rol
                }, function(data) {
                    const res = JSON.parse(data);

                    if (res.success) {
                        alert(res.message);
                        window.location.reload();
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
<div class="modal fade" id="crearAsistente" tabindex="-1" aria-labelledby="crearAsistenteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="crearAsistenteLabel">Crear asistente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="form-casistente">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido:</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo:</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                    <div class="form-group">
                        <label for="clave">Clave:</label>
                        <input type="password" class="form-control" id="clave" name="clave" required>
                    </div>
                    <div class="form-group">
                        <label for="salario">Salario:</label>
                        <input type="number" class="form-control" id="salario" name="salario" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="registrar">Crear asistente</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin modal -->