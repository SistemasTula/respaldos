<?php
$host = 'localhost'; // Cambia si tu servidor de base de datos está en otro host
$dbname = 'file_upload'; // Nombre de tu base de datos
$charset = 'utf8mb4'; // Charset para la conexión
$username = 'root'; // Usuario de la base de datos
$password = ''; // Contraseña de la base de datos

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit();
}
?>
