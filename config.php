<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "citas_medicas";

try {
    $conexion = new mysqli($host, $usuario, $contrasena, $base_datos);
    $conexion->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("Error de conexión con la base de datos: " . $e->getMessage());
}
?>