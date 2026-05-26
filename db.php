<?php
$servidor   = getenv('MYSQLHOST')     ?: 'localhost';
$usuario    = getenv('MYSQLUSER')     ?: 'root';
$password   = getenv('MYSQLPASSWORD') ?: '';
$base_datos = getenv('MYSQLDATABASE') ?: 'tienda';
$puerto     = (int)(getenv('MYSQLPORT') ?: 3306);

$conexion = new mysqli($servidor, $usuario, $password, $base_datos, $puerto);

if ($conexion->connect_error) {
    die('Error de conexion: ' . $conexion->connect_error);
}
$conexion->set_charset('utf8mb4');