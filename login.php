<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Credenciales correctas, establecer cookie de autenticación
        setcookie("authenticated", "true", time() + 3600, "/"); // La cookie dura 1 hora
        header('Location: upload.html'); // Redirigir al usuario a upload.html
        exit();
    } else {
        // Credenciales incorrectas, redirigir con parámetro de error
        header('Location: login.html?error=invalid_credentials');
        exit();
    }
}
?>
