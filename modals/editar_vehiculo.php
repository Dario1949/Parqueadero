<script>
    $(document).ready(() => {
        const formulario = document.getElementById("form-evehiculo");

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

        $("#form-evehiculo").submit((e) => {
            e.preventDefault();

            const data = new FormData(formulario);

            const marca = data.get("marca");
            const modelo = data.get("modelo");
            const color = data.get("color");
            const id = data.get("id");

            // Comprobamos si hay campos vacios : si hay : true - no hay : false
            const comprobarCampos = camposVacios([marca, modelo, color, id]);

            if (!comprobarCampos) {
                $.post("../controllers/edit/vehiculo.php", {
                    marca,
                    modelo,
                    color,
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

<!-- Modal editar vehiculo -->
<div class="modal fade" id="editarVehiculo" tabindex="-1" aria-labelledby="editarVehiculoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editarVehiculoLabel">Editar vehículo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="form-evehiculo">
                    <div class="form-group">
                        <label for="marca">Marca:</label>
                        <input type="text" name="marca" id="marca" class="form-control" value="<?php echo $vistamarca; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="modelo">Modelo:</label>
                        <input type="text" name="modelo" id="modelo" class="form-control" value="<?php echo $vistamodelo; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="color">Color:</label>
                        <input type="color" name="color" id="color" class="form-control" value="<?php echo $vistacolor; ?>" required>
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
<!-- Fin modal editar vehiculo -->