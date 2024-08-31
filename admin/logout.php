<?php
session_start();
// Asegurar que no se guarde en cache
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

$_SESSION = [];
session_destroy();
header("Location: ../index.php");
exit();
?>
