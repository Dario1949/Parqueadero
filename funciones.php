<?php
function obtenerCampo($nombre) {
    $r = null;
    $c = $_COOKIE["usuario"] ? $_COOKIE["usuario"] : "";
    $cortar = explode(":", $c);

    if($nombre === "email") {
        $r = $cortar[1];
    }

    if($nombre === "rol") {
        $r = $cortar[3];
    }

    return $r;
}