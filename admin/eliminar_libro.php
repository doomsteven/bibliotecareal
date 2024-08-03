<?php
// Conexión a la base de datos
include dirname(__DIR__, 1) . '/app/conexion.php';

// Obtener el ID del libro a eliminar
$id = $_GET['id'];

// Consultar el libro para obtener el nombre de la imagen
$sql = "SELECT img FROM libro WHERE id_peri = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$libro = $result->fetch_assoc();
$img = $libro['img'];

// Eliminar el libro de la base de datos
$sql = "DELETE FROM libro WHERE id_peri = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

// Eliminar la imagen del servidor si existe
if ($img) {
    $file_path = "uploads/" . $img;
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

// Redirigir a la lista de libros
header("Location: ../../admin/indexpanel.php");
exit();
?>
