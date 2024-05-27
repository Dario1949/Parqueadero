<script>
    $(document).ready(() => {
        const formulario = document.getElementById("form-cpuesto");

        const camposVacios = (arr) => {
            let check = false;
            if (Array.isArray(arr)) {
                if (arr.length > 0) {
                    for (let f of arr) {
                        if (typeof f === "string" && f.trim().length == 0) {
                            check = true;
                        }
                        if (typeof f === "number" && parseInt(f.trim()) == 0) {
                            check = true;
                        }
                    }
                }
            }

            return check;
        }

        $("#form-cpuesto").submit((e) => {
            e.preventDefault();

            const _data = new FormData(formulario);
            const fields = [];

            for (let d of _data) {
                fields.push(d[1]);
            }

            // Comprobamos si hay campos vacios : si hay : true - no hay : false
            const comprobarCampos = camposVacios(fields);

            if (!comprobarCampos) {
                $.post("../controllers/create/puesto.php", {
                    numero: fields[0]
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

        });
    })
</script>

<!-- Modal -->
<div class="modal fade" id="crearPuesto" tabindex="-1" aria-labelledby="crearPuestoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="crearPuestoLabel">Crear puesto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="form-cpuesto">
                    <div class="form-group">
                        <label for="numero">Número puesto:</label>
                        <input type="text" name="numero" class="form-control" value="" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="registrar">Crear puesto</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin modal -->