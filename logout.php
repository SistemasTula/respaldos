<?php
session_start();
session_destroy();
setcookie("authenticated", "", time() - 3600, "/"); // Elimina la cookie
header('Location: login.html');
exit();
?>
