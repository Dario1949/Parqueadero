<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="/ParqueaderoVL/js/jquery-3.7.1.min.js"></script>
<script src="/ParqueaderoVL/js/cookies.js"></script>

<script>
    window.addEventListener("load", function() {
        var all_links = document.querySelectorAll("[data-href]");
        var all_del = document.querySelectorAll("[data-confirm-delete]");

        for (let i = 0; i < all_links.length; i++) {
            if (all_links[i].getAttribute("data-href") !== (null | "")) {
                all_links[i].addEventListener("click", function() {
                    window.location.href = all_links[i].getAttribute("data-href");
                })
            }
        }

        for (let i = 0; i < all_del.length; i++) {
            if (all_del[i].getAttribute("data-confirm-delete") !== (null | "")) {
                all_del[i].addEventListener("click", function() {
                    var confirm = window.confirm("¿Deseas eliminar este " + all_del[i].getAttribute("data-delete-card") + "?");
                    if (confirm) window.location.href = all_del[i].getAttribute("data-href-delete");
                })
            }
        }

        $("#logout").click((e) => {
            e.preventDefault();
            deleteCookie("usuario");
            window.location = "/ParqueaderoVL/index.php";
        });

        $("#accountsb").click((e) => {
            e.preventDefault();
            window.location = "/ParqueaderoVL/personal/cuentas-bancarias.php";
        });
    })
</script>
<!-- <script>
    $(document).ready(() => {
        $("#home-init").load("vistas/clientes.php");
    })
</script> -->
<?php if (strpos($_SERVER['SCRIPT_FILENAME'], "index") || strpos($_SERVER['SCRIPT_FILENAME'], "register")) { ?>
    <script>
        if (getCookie("usuario") != null) {
            window.location = "home.php";
        }
    </script>
<?php } ?>