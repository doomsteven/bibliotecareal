<?php
// Conexión a la base de datos
include dirname(__DIR__, 1) . '/app/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Validar que el año tenga exactamente 4 dígitos
    if (!preg_match('/^\d{4}$/', $ano)) {
        die("El año debe ser un número de 4 dígitos.");
    }

    // Subir imagen
    if ($img) {
        $target_dir = "../assets/products/";
        $target_file = $target_dir . basename($img);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Comprueba si el archivo es una imagen real o falsa
        $check = getimagesize($_FILES["img"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "El archivo no es una imagen.";
            $uploadOk = 0;
        }

        // Verifica si $uploadOk es 0 por algún error
        if ($uploadOk == 0) {
            echo "Lo siento, tu archivo no fue subido.";
        } else {
            // Si todo está bien, intenta subir el archivo
            if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                echo "El archivo ". htmlspecialchars(basename($img)). " ha sido subido.";
            } else {
                echo "Lo siento, hubo un error al subir tu archivo.";
            }
        }
    }

    // Insertar datos en la base de datos
    $sql = "INSERT INTO libro (periodo, asignatura, areaconocimiento, autor, titulo, codigoisbn, numpag, ano, editorial, tipo, codigo, origen, img) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssssssssss', $periodo, $asignatura, $areaconocimiento, $autor, $titulo, $codigoisbn, $numpag, $ano, $editorial, $tipo, $codigo, $origen, $img);
    $stmt->execute();

    // Redirigir a la lista de libros
    header("Location: ../../admin/indexpanel.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Libro</title>
</head>
<body>
    <?php include '../views/header.php'; ?>
    <h1>Agregar Libro</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="periodo">Periodo:</label>
        <input type="text" name="periodo" required><br>
        <label for="asignatura">Asignatura:</label>
        <input type="text" name="asignatura" required><br>
        <label for="areaconocimiento">Área de Conocimiento:</label>
        <input type="text" name="areaconocimiento" required><br>
        <label for="autor">Autor:</label>
        <input type="text" name="autor" required><br>
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" required><br>
        <label for="codigoisbn">Código ISBN:</label>
        <input type="text" name="codigoisbn" required><br>
        <label for="numpag">Número de Páginas:</label>
        <input type="number" name="numpag" required><br>
        <label for="ano">Año:</label>
        <input type="number" name="ano" min="1900" max="2099" step="1" required><br>
        <label for="editorial">Editorial:</label>
        <input type="text" name="editorial" required><br>
        <label for="tipo">Tipo:</label>
        <input type="text" name="tipo" required><br>
        <label for="codigo">Código:</label>
        <input type="text" name="codigo" required><br>
        <label for="origen">Origen:</label>
        <input type="text" name="origen" required><br>
        <label for="img">Imagen:</label>
        <input type="file" name="img" accept="image/*"><br>
        <button type="submit">Agregar Libro</button>
    </form>
</body>
</html>
