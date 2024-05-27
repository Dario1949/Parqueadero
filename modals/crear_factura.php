<script>
    // Calculos

    function calculateElapsedTime(startDateStr, endDateStr) {
        // Convert date strings to Date objects
        const startDate = new Date(startDateStr);
        const endDate = new Date(endDateStr);

        // Calculate time difference in milliseconds
        const timeDiffInMs = endDate.getTime() - startDate.getTime();

        // Convert milliseconds to hours and minutes
        const timeDiffInSeconds = timeDiffInMs / 1000;
        const hours = Math.floor(timeDiffInSeconds / 3600);
        const minutes = Math.floor((timeDiffInSeconds % 3600) / 60);

        // Format the output
        const elapsedTime = {
            hours,
            minutes
        };
        return elapsedTime;
    }

    function getCurrentDateAndTime() {
        const now = new Date();
        const year = now.getFullYear();
        const month = now.getMonth() + 1; // Months are zero-based
        const day = now.getDate();
        const hours = now.getHours();
        const minutes = now.getMinutes();
        const seconds = now.getSeconds();

        const formattedDate = `${year}-${pad(month)}-${pad(day)} ${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;
        return formattedDate;
    }

    function pad(number) {
        return (number < 10 ? '0' : '') + number;
    }

    function precioSegunTipo(tipo) {
        if (tipo == 1) {
            return 5;
        } else if (tipo == 2) {
            return 10;
        } else if (tipo == 3) {
            return 15;
        } else if (tipo == 4) {
            return 30;
        }
    }

    function calcularPrecioFinal(tiempo, tipo) {
        const {
            hours,
            minutes
        } = tiempo;
        let r = 0;

        r = (precioSegunTipo(parseInt(tipo)) * (60 * hours)) + (precioSegunTipo(parseInt(tipo)) * (minutes));

        return r;
    }

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

    $(document).ready(() => {
        const datosFactura = {
            idCliente: "",
            idVehiculo: "",
            tipoVehiculo: "",
            fechaInicio: ""
        };

        $("#crearFactura").on("show.bs.modal", () => {
            const formulario = document.getElementById("form-cfactura");
            formulario.reset();

            //Obtener input cliente, vehiculo        

            setTimeout(() => {
                const cliente = $("#cliente").val();
                const vehiculo = $("#vehiculo").val();
                // Obtener cliente

                datosFactura.idCliente = parseInt(cliente);
                datosFactura.idVehiculo = parseInt(vehiculo);
                // Obtenemos datos cliente
                $.post("../controllers/get/cliente.php", {
                    cliente
                }, function(data) {
                    const res = JSON.parse(data);

                    if (res.success) {
                        const result = res.data;
                        if (Array.isArray(result) && result.length > 0) {
                            $("input#cliente").val(result[0].nombre + " " + result[0].apellido);
                        }
                    } else {
                        console.log(res.message);
                    }
                });

                // Obtenemos datos vehiculo
                $.post("../controllers/get/vehiculo.php", {
                    vehiculo
                }, function(data) {
                    const res = JSON.parse(data);

                    if (res.success) {
                        const result = res.data;
                        if (Array.isArray(result) && result.length > 0) {
                            $("#vehiculo").val(result[0].placa + " | " + result[0].marca + " | " + result[0].modelo);
                            $("#fecha_inicio").val(result[0].fecha_creado);
                            datosFactura.tipoVehiculo = result[0].tipo;
                            datosFactura.fechaInicio = result[0].fecha_creado;
                        }
                    } else {
                        console.log(res.message);
                    }
                })

                // Agregar fecha final

                const fechaActual = getCurrentDateAndTime();
                $("#fecha_final").val(fechaActual);

                // Comprobar si el cliente tiene dinero

                const email = "<?= obtenerCampo("email"); ?>";

                $.post("../controllers/get/dinero.php", {
                    email
                }, function(data) {
                    const res = JSON.parse(data);
                    const result = res.data;

                    if (Array.isArray(result) && result.length > 0) {
                        const createSelectorDinero = document.createElement("select");
                        createSelectorDinero.setAttribute("class", "form-control");
                        createSelectorDinero.setAttribute("id", "dinero");
                        createSelectorDinero.setAttribute("name", "dinero");
                        // Crear opciones dinero
                        for (let r of result) {
                            const option = document.createElement("option");
                            option.setAttribute("value", r.id);
                            option.text = r.tipo + " - " + r.dinero;
                            createSelectorDinero.appendChild(option);
                        }
                        $("#metodosPago").append(createSelectorDinero);
                    } else {
                        const noMetodos = document.createElement("div");
                        noMetodos.setAttribute("class", "alert alert-warning");
                        noMetodos.text = "No tienes cuentas de dinero, debes agregar una";

                        $("#metodosPago").append(noMetodos);
                    }
                });

                // Enviar datos formulario
                $("#form-cfactura").submit((e) => {
                    e.preventDefault();

                    const data = new FormData(formulario);

                    const fields = [];

                    for (let d of data) {
                        fields.push(d[1]);
                    }

                    const comprobarCampos = camposVacios(fields);

                    if (!comprobarCampos) {
                        $.post("../controllers/create/factura.php", {
                            cliente: datosFactura.idCliente,
                            vehiculo: datosFactura.idVehiculo,
                            valor_pagar: parseInt($("#pagar").val()),
                            fecha_inicio: $("#fecha_inicio").val(),
                            fecha_final: $("#fecha_final").val(),
                            dinero: $("#dinero").val()
                        }, function(data) {
                            const res = JSON.parse(data);
                            if (res.success) {
                                alert(res.message);
                                window.location.reload();
                            } else {
                                alert(res.message);
                            }
                        })
                    }
                })

            }, 500);
        })

        setInterval(() => {
            // Agregar valor a pagar
            const tiempoQuePaso = calculateElapsedTime($("#fecha_inicio").val(), $("#fecha_final").val());
            const valorPagar = calcularPrecioFinal(tiempoQuePaso, datosFactura.tipoVehiculo);
            $("#pagar").val(valorPagar);
        }, 1000);
    });
</script>

<!-- Modal -->
<div class="modal fade" id="crearFactura" tabindex="-1" aria-labelledby="crearFacturaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="crearFacturaLabel">Factura</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="form-cfactura">
                    <div class="form-group">
                        <label for="cliente">Cliente:</label>
                        <input type="text" class="form-control" id="cliente" name="cliente" disabled>
                    </div>
                    <div class="form-group">
                        <label for="vehiculo">Vehículo:</label>
                        <input type="text" class="form-control" id="vehiculo" name="vehiculo" disabled>
                    </div>
                    <div class="form-group">
                        <label for="pagar">Valor a pagar:</label>
                        <input type="tel" class="form-control" id="pagar" name="pagar" disabled>
                    </div>
                    <div class="m-3 d-block">
                        <section class="alert alert-warning">
                            Cosas a tener en cuenta
                            <ul style="list-style-type: none;">
                                <li>El valor depende del tipo de vehículo elegido</li>
                            </ul>
                        </section>
                    </div>
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha inicio:</label>
                        <input type="text" class="form-control" id="fecha_inicio" name="fecha_inicio" disabled>
                    </div>
                    <div class="form-group">
                        <label for="fecha_final">Fecha final:</label>
                        <input type="text" class="form-control" id="fecha_final" name="fecha_final" disabled>
                    </div>
                    <div class="form-group" id="metodosPago">
                        <label for="metodo_pago">Métodos de pago:</label>
                    </div>
                    <button type="submit" class="btn btn-primary" name="registrar">Pagar</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin modal -->