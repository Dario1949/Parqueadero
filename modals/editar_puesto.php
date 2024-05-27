<script>
    $(document).ready(() => {
        const formulario = document.getElementById("form-epuesto");

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

        $("#form-epuesto").submit((e) => {
            e.preventDefault();

            const data = new FormData(formulario);

            const numero = data.get("numero");
            const id = data.get("id");

            // Comprobamos si hay campos vacios : si hay : true - no hay : false
            const comprobarCampos = camposVacios([numero, id]);

            if (!comprobarCampos) {
                $.post("../controllers/edit/puesto.php", {
                    numero,
                    id,
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

<!-- Modal editar puesto -->
<div class="modal fade" id="editarPuesto" tabindex="-1" aria-labelledby="editarPuestoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editarPuestoLabel">Editar puesto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="form-epuesto">
                <div class="form-group">
                        <label for="numero">Número:</label>
                        <input type="text" class="form-control" name="numero" id="numero" value="" required>
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
<!-- Fin modal editar puesto -->