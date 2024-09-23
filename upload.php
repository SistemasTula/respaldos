<?php
// Configuración de la conexión a la base de datos
$host = 'localhost'; // Cambia esto si el servidor de base de datos no está en localhost
$db = 'file_upload';
$user = 'root';
$pass = 'root123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Verifica si se ha enviado un archivo
if (isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $fileName = basename($file['name']);
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    // Define el directorio de destino
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . $fileName;

    // Verifica si el archivo ha sido subido sin errores
    if ($fileError === UPLOAD_ERR_OK) {
        // Verifica el tamaño del archivo (por ejemplo, limitar a 1 GB)
        if ($fileSize > 1024 * 1024 * 1024) { // 1 GB en bytes
            echo "Error: El archivo es demasiado grande. El tamaño máximo permitido es 1 GB.";
            exit;
        }

        // Mueve el archivo a la carpeta de destino
        if (move_uploaded_file($fileTmpName, $uploadFile)) {
            echo "Archivo cargado exitosamente.";

            // Guarda la información del archivo en la base de datos (opcional)
            try {
                $stmt = $pdo->prepare("INSERT INTO archivos (nombre, tamaño, tipo) VALUES (:nombre, :tamaño, :tipo)");
                $stmt->execute([
                    ':nombre' => $fileName,
                    ':tamaño' => $fileSize,
                    ':tipo' => $fileType
                ]);
            } catch (PDOException $e) {
                echo "Error al guardar la información del archivo en la base de datos: " . $e->getMessage();
            }
        } else {
            echo "Error: No se pudo mover el archivo al directorio de destino.";
        }
    } else {
        echo "Error: " . $fileError;
    }
} else {
    echo "No se ha enviado ningún archivo.";
}
?>
