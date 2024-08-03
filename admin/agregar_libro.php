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
    <div class="container mt-5">
        <h1 class="mb-4 text-center fw-bold">Agregar Libro</h1> <!-- Negrita y centrado para el título -->
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="periodo" class="form-label fw-bold">Periodo:</label>
                <input type="text" class="form-control" id="periodo" name="periodo" required>
            </div>
            <div class="mb-3">
                <label for="asignatura" class="form-label fw-bold">Asignatura:</label>
                <input type="text" class="form-control" id="asignatura" name="asignatura" required>
            </div>
            <div class="mb-3">
                <label for="areaconocimiento" class="form-label fw-bold">Área de Conocimiento:</label>
                <input type="text" class="form-control" id="areaconocimiento" name="areaconocimiento" required>
            </div>
            <div class="mb-3">
                <label for="autor" class="form-label fw-bold">Autor:</label>
                <input type="text" class="form-control" id="autor" name="autor" required>
            </div>
            <div class="mb-3">
                <label for="titulo" class="form-label fw-bold">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="mb-3">
                <label for="codigoisbn" class="form-label fw-bold">Código ISBN:</label>
                <input type="text" class="form-control" id="codigoisbn" name="codigoisbn" required>
            </div>
            <div class="mb-3">
                <label for="numpag" class="form-label fw-bold">Número de Páginas:</label>
                <input type="number" class="form-control" id="numpag" name="numpag" required>
            </div>
            <div class="mb-3">
                <label for="ano" class="form-label fw-bold">Año:</label>
                <input type="number" class="form-control" id="ano" name="ano" min="1900" max="2099" step="1" required>
            </div>
            <div class="mb-3">
                <label for="editorial" class="form-label fw-bold">Editorial:</label>
                <input type="text" class="form-control" id="editorial" name="editorial" required>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label fw-bold">Tipo:</label>
                <input type="text" class="form-control" id="tipo" name="tipo" required>
            </div>
            <div class="mb-3">
                <label for="codigo" class="form-label fw-bold">Código:</label>
                <input type="text" class="form-control" id="codigo" name="codigo" required>
            </div>
            <div class="mb-3">
                <label for="origen" class="form-label fw-bold">Origen:</label>
                <input type="text" class="form-control" id="origen" name="origen" required>
            </div>
            <div class="mb-3">
                <label for="img" class="form-label fw-bold">Imagen:</label>
                <input type="file" class="form-control" id="img" name="img" accept="image/*">
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-warning">Agregar Libro</button>
            </div>
        </form>
    </div>

</body>
</html>
