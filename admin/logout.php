<?php
session_start();

// Destruir todas las variables de sesión
$_SESSION = [];

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio de sesión (o a cualquier otra página)
header("Location: ../index.php"); // Redirige a index.php después del cierre de sesión
exit(); // Asegúrate de detener el script después de la redirección
?>
