<?php
$host = 'localhost';
$user = 'root';     // Usuario por defecto de XAMPP
$pass = '';         // Contraseña vacía por defecto de XAMPP
$db   = 'proyecto_final'; // El nombre que acabamos de crear

$conexion = new mysqli($host, $user, $pass, $db);
$conexion->set_charset("utf8"); // Para que las tildes y ñ se vean bien

if ($conexion->connect_error) {
    die("❌ Error fatal de conexión: " . $conexion->connect_error);
}
?>