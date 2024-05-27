<?php
$host = "localhost";
$port = "3306";
$username = "id22216953_dario";
$password = "Dario.2002";
$dbname = "id22216953_parqueadero2";

// Conexión a la base de datos
$conn = new mysqli($host, $username, $password, $dbname, $port);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "";
