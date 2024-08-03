<?php
include '../app/conexion.php';

// Obtener el ID del libro de la URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Consulta para obtener los detalles del libro
$sql = "SELECT * FROM libro WHERE id_peri = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$libro = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Detalles del Libro</title>
  <link href="../styles.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com/" />
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Climate+Crisis&family=Montserrat:ital,wght@0,100;0,200;0,300;1,100;1,200;1,300&family=Roboto:wght@300&display=swap" rel="stylesheet" />
</head>

<body>
  <header id="header">
    <div class="main">
      <div class="logo">
        <a class="logo" href="#"><img src="/assets/image.png" alt="Logo" /></a>
      </div>
      <div class="search">
        <form action="busqueda/busqueda.php" method="get">
          <div class="input-group">
            <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" name="query" placeholder="Qué libro buscas?" />
          </div>
        </form>
      </div>
      <div class="links">
        <a class="link" href="admin/login/login.php">
          <i class="fa-solid fa-user"></i>
          Iniciar Sesion
        </a>
      </div>
    </div>
    <nav class="categories">
      <a class="category" href="#">Home</a>
    </nav>
  </header>

  <section id="book-detail">
    <?php if ($libro) : ?>
      <h1><?php echo htmlspecialchars($libro['titulo']); ?></h1>
      <div class="book-info">
        <img src="../assets/products/<?php echo htmlspecialchars($libro['img']); ?>" alt="<?php echo htmlspecialchars($libro['titulo']); ?>" width="300">
        <p><strong>Autor:</strong> <?php echo htmlspecialchars($libro['autor']); ?></p>
        <p><strong>Asignatura:</strong> <?php echo htmlspecialchars($libro['asignatura']); ?></p>
        <p><strong>Código ISBN:</strong> <?php echo htmlspecialchars($libro['codigoisbn']); ?></p>
        <p><strong>Año:</strong> <?php echo htmlspecialchars($libro['ano']); ?></p>
        <p><strong>Editorial:</strong> <?php echo htmlspecialchars($libro['editorial']); ?></p>
        <p><strong>Tipo:</strong> <?php echo htmlspecialchars($libro['tipo']); ?></p>
        <p><strong>Código:</strong> <?php echo htmlspecialchars($libro['codigo']); ?></p>
        <p><strong>Origen:</strong> <?php echo htmlspecialchars($libro['origen']); ?></p>
      </div>
    <?php else : ?>
      <p>Libro no encontrado.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>
  </section>
</body>

</html>
