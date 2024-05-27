<script>
    $(document).ready(() => {
        const formulario = document.getElementById("form-ecliente");

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

        $("#form-ecliente").submit((e) => {
            e.preventDefault();

            const data = new FormData(formulario);

            const nombre = data.get("nombre");
            const apellido = data.get("apellido");
            const telefono = data.get("telefono");
            const correo = data.get("correo");
            const clave = data.get("clave");
            const id = data.get("id");
            const rol = "cliente";

            // Comprobamos si hay campos vacios : si hay : true - no hay : false
            const comprobarCampos = camposVacios([nombre, apellido, telefono, correo, clave, id]);

            if (!comprobarCampos) {
                $.post("../controllers/edit/user.php", {
                    nombre,
                    apellido,
                    telefono,
                    correo,
                    clave,
                    id,
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

<!-- Modal editar cliente -->
<div class="modal fade" id="editarCliente" tabindex="-1" aria-labelledby="editarClienteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editarClienteLabel">Editar cliente</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="form-ecliente">
          <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="" required>
          </div>
          <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" class="form-control" id="apellido" name="apellido" value="" required>
          </div>
          <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="" required>
          </div>
          <div class="form-group">
            <label for="correo">Correo:</label>
            <input type="email" class="form-control" id="correo" name="correo" value="" required>
          </div>
          <div class="form-group">
            <label for="clave">Clave:</label>
            <input type="password" class="form-control" id="clave" name="clave" value="" required>
          </div>
          <input type="hidden" name="id" id="id" value="" />
          <button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Fin modal editar cliente -->