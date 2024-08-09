<?php
// Conexión a la base de datos
$servername = "bl0fufvntuwnh4e7ie4l-mysql.services.clever-cloud.com"; // Cambia esto si es necesario
$username = "u81jarbpi7jerby0"; // Cambia esto si es necesario
$password = "ZzSCxLuHflGDqI9QCBbS"; // Cambia esto si es necesario
$dbname = "bl0fufvntuwnh4e7ie4l"; // Cambia esto si es necesario

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>