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
        $target_dir = "../../../products/";
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
    header("Location: ../../admin/indexpanel.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Libro</title>
</head>
<body>
<?php include'../views/header.php'   ?>
    <h1>Editar Libro</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="periodo">Periodo:</label>
        <input type="text" name="periodo" value="<?php echo htmlspecialchars($libro['periodo']); ?>" required><br>
        <label for="asignatura">Asignatura:</label>
        <input type="text" name="asignatura" value="<?php echo htmlspecialchars($libro['asignatura']); ?>" required><br>
        <label for="areaconocimiento">Área de Conocimiento:</label>
        <input type="text" name="areaconocimiento" value="<?php echo htmlspecialchars($libro['areaconocimiento']); ?>" required><br>
        <label for="autor">Autor:</label>
        <input type="text" name="autor" value="<?php echo htmlspecialchars($libro['autor']); ?>" required><br>
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" value="<?php echo htmlspecialchars($libro['titulo']); ?>" required><br>
        <label for="codigoisbn">Código ISBN:</label>
        <input type="text" name="codigoisbn" value="<?php echo htmlspecialchars($libro['codigoisbn']); ?>" required><br>
        <label for="numpag">Número de Páginas:</label>
        <input type="number" name="numpag" value="<?php echo htmlspecialchars($libro['numpag']); ?>" required><br>
        <label for="ano">Año:</label>
        <input type="number" name="ano" value="<?php echo htmlspecialchars($libro['ano']); ?>" required><br>
        <label for="editorial">Editorial:</label>
        <input type="text" name="editorial" value="<?php echo htmlspecialchars($libro['editorial']); ?>" required><br>
        <label for="tipo">Tipo:</label>
        <input type="text" name="tipo" value="<?php echo htmlspecialchars($libro['tipo']); ?>" required><br>
        <label for="codigo">Código:</label>
        <input type="text" name="codigo" value="<?php echo htmlspecialchars($libro['codigo']); ?>" required><br>
        <label for="origen">Origen:</label>
        <input type="text" name="origen" value="<?php echo htmlspecialchars($libro['origen']); ?>" required><br>
        <label for="img">Imagen (dejar en blanco si no se desea cambiar):</label>
        <input type="file" name="img" accept="image/*"><br>
        <button type="submit" >Actualizar</button>
    </form>
</body>
</html>
