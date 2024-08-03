<?php
// Conexión a la base de datos
include dirname(__DIR__, 1) . '/app/conexion.php';

// Obtener datos del formulario
$periodo = $_POST['periodo'];
$asignatura = $_POST['asignatura'];
$areaconocimiento = $_POST['areaconocimiento'];
$autor = $_POST['autor'];
$titulo = $_POST['titulo'];
$codigoisbn = $_POST['codigoisbn'];
$numpag = $_POST['numpag'];
$ano = $_POST['ano'];
$editorial = $_POST['editorial'];
$tipo = $_POST['tipo'];
$codigo = $_POST['codigo'];
$origen = $_POST['origen'];
$img = $_FILES['img']['name'];

// Subir imagen
$target_dir = "uploads/";
$target_file = $target_dir . basename($img);
move_uploaded_file($_FILES["img"]["tmp_name"], $target_file);

// Insertar datos en la base de datos
$sql = "INSERT INTO libro (periodo, asignatura, areaconocimiento, autor, titulo, codigoisbn, numpag, ano, editorial, tipo, codigo, origen, img) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssssss", $periodo, $asignatura, $areaconocimiento, $autor, $titulo, $codigoisbn, $numpag, $ano, $editorial, $tipo, $codigo, $origen, $img);
$stmt->execute();

// Redirigir a la lista de libros
header("Location: listar_libros.php");
exit();
?>
