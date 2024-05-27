<script>
    $(document).ready(() => {
        const formulario = document.getElementById("form-cvehiculo");

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

        $("#form-cvehiculo").submit((e) => {
            e.preventDefault();

            const _data = new FormData(formulario);
            const fields = [];

            for (let d of _data) {
                fields.push(d[1]);
            }

            // Comprobamos si hay campos vacios : si hay : true - no hay : false
            const comprobarCampos = camposVacios(fields);

            console.log(comprobarCampos);

            if (!comprobarCampos) {
                $.post("../controllers/create/vehiculo.php", {
                    placa: fields[0],
                    marca: fields[1],
                    modelo: fields[2],
                    color: fields[3],
                    puesto: fields[4],
                    cliente: fields[5],
                    tipo: fields[6]
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

        // Cargar los puestos y clientes cada que se cargue la ventana modal
        $("#crearVehiculo").on("show.bs.modal", () => {
            if ($("#puesto")) {
                $("#puesto").remove();
            }

            function cargarPuestos_(id = "") {
                $.post("../controllers/get/puestos.php", {
                    cliente: id
                }, function(data) {
                    if ($("#puesto")) $("#puesto").remove();
                    const res = JSON.parse(data);

                    if (res.success) {
                        const _puestos = res.data;

                        if (Array.isArray(_puestos) && _puestos.length > 0) {
                            const selectorPuestos = document.createElement("select");
                            selectorPuestos.setAttribute("name", "puesto");
                            selectorPuestos.setAttribute("id", "puesto");
                            selectorPuestos.setAttribute("class", "form-control");

                            const puestoAuto = document.createElement("option");
                            puestoAuto.setAttribute("value", "auto");
                            puestoAuto.text = "Automático";
                            selectorPuestos.appendChild(puestoAuto);

                            for (let p of _puestos) {
                                const puesto = document.createElement("option");
                                puesto.setAttribute("value", p.id);
                                puesto.text = p.numero;
                                selectorPuestos.appendChild(puesto);
                            }

                            $("#cargarPuestos").append(selectorPuestos);
                        } else {
                            const noPuestos = document.createElement("div");
                            noPuestos.setAttribute("class", "alert alert-danger");
                            const textChild = document.createTextNode("No hay puestos");
                            noPuestos.append(textChild);
                            $("#cargarPuestos").append(noPuestos);
                        }

                    }
                })
            }

            cargarPuestos_();

            <?php if (obtenerCampo("rol") >= 2) { ?>
                $.get("../controllers/get/clientes.php", function(data) {
                    if ($("#cliente")) $("#cliente").remove();
                    const res = JSON.parse(data);
                    if (res.success) {
                        const _clientes = res.data;
                        if (Array.isArray(_clientes) && _clientes.length > 0) {
                            const selectorClientes = document.createElement("select");
                            selectorClientes.setAttribute("name", "cliente");
                            selectorClientes.setAttribute("id", "cliente");
                            selectorClientes.setAttribute("class", "form-control");

                            for (let c of _clientes) {
                                const cliente = document.createElement("option");
                                cliente.setAttribute("value", c.id_cliente);
                                cliente.text = c.nombre + " " + c.apellido;
                                selectorClientes.appendChild(cliente);
                            }

                            $("#cargarClientes").append(selectorClientes);

                            selectorClientes.addEventListener("change", (e) => {
                                console.log(e.target.value);
                                cargarPuestos_(e.target.value);
                            })
                        } else {
                            const noClientes = document.createElement("div");
                            noClientes.setAttribute("class", "alert alert-danger");
                            const textChild = document.createTextNode("No hay clientes");
                            noClientes.append(textChild);
                            $("#cargarClientes").append(noClientes);
                        }
                    }
                })
            <?php } ?>
        })
    })
</script>

<!-- Modal -->
<div class="modal fade" id="crearVehiculo" tabindex="-1" aria-labelledby="crearVehiculoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="crearVehiculoLabel">Crear vehículo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="form-cvehiculo">
                    <div class="form-group">
                        <label for="placa">Placa:</label>
                        <input type="text" id="placa" class="form-control" name="placa" required>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="button" id="activar-reconocer">Subir placa y reconocer placa</button>
                    </div>
                    <div class="fom-group d-none" id="placas-reconocer">
                        <div class="col-12 col-md-6">
                            <h3>Selección de imagen</h3>
                            <div class="alert alert-warning">
                                Esta herramienta está en versión beta, entonces es posible que no arroje los resultados esperados.
                            </div>
                            <img class="img-fluid" id="imagenPrevisualizacion">
                            <div class="custom-file">
                                <input id="archivo" type="file" class="custom-file-input">
                                <label class="custom-file-label" for="archivo">Selecciona una imagen</label>
                            </div>
                            <br><br>
                            <button id="btnDetectar" type="button" class="btn btn-success">Detectar</button>
                        </div>
                        <div class="col-12 col-md-6">
                            <h3>Resultados</h3>
                            <p id="estado"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="marca">Marca:</label>
                        <input type="text" class="form-control" name="marca" required>
                    </div>
                    <div class="form-group">
                        <label for="modelo">Modelo:</label>
                        <input type="text" class="form-control" name="modelo" required>
                    </div>
                    <div class="form-group">
                        <label for="color">Color:</label>
                        <input type="color" class="form-control" name="color" required>
                    </div>
                    <div class="form-group" id="cargarPuestos">
                        <label for="puesto">Puesto</label>
                    </div>
                    <?php if (obtenerCampo("rol") >= 2) { ?>
                        <div class="form-group" id="cargarClientes">
                            <label for="cliente">Cliente:</label>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="cliente" id="cliente" value="<?= $id_c; ?>">
                    <?php } ?>
                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <select name="tipo" class="form-control" id="tipo">
                            <option value="1">Bicicleta</option>
                            <option value="2">Moto</option>
                            <option value="3" selected>Carro</option>
                            <option value="4">Camión/Bus</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" name="enviar">Registrar Vehiculo</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin modal -->