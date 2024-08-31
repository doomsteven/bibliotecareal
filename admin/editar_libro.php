<?php
// Verificar si el ID está presente en la URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Libro no especificado");
}

// Conexión a la base de datos
include dirname(__DIR__, 1) . '/app/conexion.php';

// Obtener el ID del libro a editar
$id = $_GET['id'];

// Consulta para obtener los datos del libro
$sql = "SELECT * FROM libro WHERE id_peri = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$libro = $result->fetch_assoc();

// Verificar si se obtuvieron los datos del libro
if (!$libro) {
    die("Libro no encontrado");
}

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

    // Subir nueva imagen si se ha subido
    if ($img) {
        $target_dir = "../assets/products/";
        $target_file = $target_dir . basename($img);
        move_uploaded_file($_FILES["img"]["tmp_name"], $target_file);
    } else {
        $img = $libro['img']; // Mantener la imagen actual si no se sube una nueva
    }

    // Actualizar datos en la base de datos
    $sql = "UPDATE libro SET periodo = ?, asignatura = ?, areaconocimiento = ?, autor = ?, titulo = ?, codigoisbn = ?, numpag = ?, ano = ?, editorial = ?, tipo = ?, codigo = ?, origen = ?, img = ? WHERE id_peri = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssssi", $periodo, $asignatura, $areaconocimiento, $autor, $titulo, $codigoisbn, $numpag, $ano, $editorial, $tipo, $codigo, $origen, $img, $id);
    $stmt->execute();

    // Redirigir a la lista de libros
    header("Location: indexpanel.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Libro</title>
    <style>
        .btn.btn-warning {
            margin: 30px;
            padding: 30px;
            border: 30px;
        }
    </style>
</head>
<body>
<?php include'../views/header.php'   ?>
<div class="container mt-5">
        <h1 class="mb-4 text-center fw-bold">Editar Libro</h1> <!-- Negrita para el título -->
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="periodo" class="form-label fw-bold">Periodo:</label>
                <input type="text" class="form-control" id="periodo" name="periodo" value="<?php echo htmlspecialchars($libro['periodo']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="asignatura" class="form-label fw-bold">Asignatura:</label>
                <input type="text" class="form-control" id="asignatura" name="asignatura" value="<?php echo htmlspecialchars($libro['asignatura']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="areaconocimiento" class="form-label fw-bold">Área de Conocimiento:</label>
                <input type="text" class="form-control" id="areaconocimiento" name="areaconocimiento" value="<?php echo htmlspecialchars($libro['areaconocimiento']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="autor" class="form-label fw-bold">Autor:</label>
                <input type="text" class="form-control" id="autor" name="autor" value="<?php echo htmlspecialchars($libro['autor']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="titulo" class="form-label fw-bold">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($libro['titulo']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="codigoisbn" class="form-label fw-bold">Código ISBN:</label>
                <input type="text" class="form-control" id="codigoisbn" name="codigoisbn" value="<?php echo htmlspecialchars($libro['codigoisbn']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="numpag" class="form-label fw-bold">Número de Páginas:</label>
                <input type="number" class="form-control" id="numpag" name="numpag" value="<?php echo htmlspecialchars($libro['numpag']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="ano" class="form-label fw-bold">Año:</label>
                <input type="number" class="form-control" id="ano" name="ano" value="<?php echo htmlspecialchars($libro['ano']); ?>" min="1900" max="2099" step="1" required>
            </div>
            <div class="mb-3">
                <label for="editorial" class="form-label fw-bold">Editorial:</label>
                <input type="text" class="form-control" id="editorial" name="editorial" value="<?php echo htmlspecialchars($libro['editorial']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label fw-bold">Tipo:</label>
                <input type="text" class="form-control" id="tipo" name="tipo" value="<?php echo htmlspecialchars($libro['tipo']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="codigo" class="form-label fw-bold">Código:</label>
                <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo htmlspecialchars($libro['codigo']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="origen" class="form-label fw-bold">Origen:</label>
                <input type="text" class="form-control" id="origen" name="origen" value="<?php echo htmlspecialchars($libro['origen']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="img" class="form-label fw-bold">Imagen (dejar en blanco si no se desea cambiar):</label>
                <input type="file" class="form-control" id="img" name="img" accept="image/*">
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-warning">Actualizar</button>
            </div>
            <!-- <button type="submit " class="btn btn-warning">Actualizar</button> -->
        </form>
    </div>
</body>
</html>
