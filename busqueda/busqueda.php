<?php
include dirname(__DIR__, 1) . '/app/conexion.php';

// Obtener el término de búsqueda del formulario
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Consulta para buscar los libros que coincidan con el término de búsqueda en los campos especificados
$sql = "SELECT titulo, autor, img, asignatura, codigoisbn
        FROM libro
        WHERE titulo LIKE ? OR autor LIKE ? OR asignatura LIKE ? OR codigoisbn LIKE ?";

$stmt = $conn->prepare($sql);
$searchTerm = "%{$query}%";
$stmt->bind_param('ssss', $searchTerm, $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Resultados de Búsqueda</title>
    <link href="./styles.css" rel="stylesheet" />
    <!-- Agrega los enlaces a fuentes y estilos aquí -->
</head>
<body>
    <!-- Navigation -->
    <?php include '../views/busq.php'; ?>

    <main>
        <h1>Resultados de Búsqueda</h1>
        <?php if ($result->num_rows > 0): ?>
            <div class="products">
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="product">
                        <a href="#">
                            <div class="image">
                                <img src="../assets/products/<?php echo htmlspecialchars($row['img']); ?>" alt="<?php echo htmlspecialchars($row['titulo']); ?>" />
                            </div>
                        </a>
                        <div class="details">
                            <h3 class="title"><?php echo htmlspecialchars($row['titulo']); ?></h3>
                            <p class="author">de <?php echo htmlspecialchars($row['autor']); ?></p>
                            <p class="materia"><?php echo htmlspecialchars($row['asignatura']); ?></p>
                            <p class="codigoisbn"><strong>ISBN:</strong> <?php echo htmlspecialchars($row['codigoisbn']); ?></p>
                        </div>
                        <div class="actions">
                            <a href="#" class="add-to-cart"><i class="fa-solid fa-bag-shopping"></i> Disponible</a>
                            <a href="#" class="add-to-wishlist"><i class="fa-solid fa-heart"></i></a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No se encontraron resultados para "<?php echo htmlspecialchars($query); ?>".</p>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </main>

    <!-- Footer -->
</body>
</html>
