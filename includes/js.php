<!-- Agrega los scripts de Bootstrap al final del archivo -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<!-- Activar tooltips -->
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<!-- -->
<!-- Activar popovers -->
<script>
const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
</script>
<!-- -->
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
    })
</script>