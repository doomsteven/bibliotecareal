<?php
include 'app/conexion.php';

// Consulta para obtener los datos de los libros
$sql = "SELECT id_peri, titulo, autor, img, asignatura, codigoisbn FROM libro";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Biblioteca ISTLT</title>
  <link href="./styles.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com/" />
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Climate+Crisis&family=Montserrat:ital,wght@0,100;0,200;0,300;1,100;1,200;1,300&family=Roboto:wght@300&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4);

    }

    .modal-content {
      background-color: #fefefe;
      margin: 5% auto;
      /* Ajusta el margen superior para centrar verticalmente */
      padding: 50px;
      border: 1px solid #888;
      width: 80%;
      max-width: 800px;
      /* Aumenta el tamaño máximo del modal */
      display: flex;
      text-align: center;
      /* Cambia a alineación izquierda para que los datos se alineen mejor con la imagen */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      font-size: 25px;
      /* Ajusta el tamaño de la fuente */
      border-radius: 12px;
    }

    .modal-content img {
      max-width: 50%;
      height: 500px;
      margin-right: 20px;
    }

    .modal-content .details {
      max-width: 50%;

    }

    .close {
      color: #aaa;
      position: absolute;
      /* Ajusta la posición para que esté en la esquina superior derecha */
      top: 10px;
      /* Ajusta el espacio desde la parte superior */
      right: 20px;
      /* Ajusta el espacio desde el borde derecho */
      font-size: 32px;
      /* Aumenta el tamaño del icono de cerrar */
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    .add-to-cart {
      padding: 7px;
      background-color: green;
      color: white;
      border-radius: 0.5rem;
      transition: all 0.3s ease;
    }

    hr {
      border: 0;
      height: 2px;
      /* Grosor del hr */
      background: white;
      /* Gradiente de color */

      width: 70%;
      /* Ancho del hr */
      margin: 20px auto;
      /* Espacio alrededor del hr */
    }
  </style>
</head>

<body>
  <!-- Navigation -->
  <header id="header">
    <div class="main">
      <div class="logo">
        <a class="logo" href="https://www.istlatroncal.edu.ec"></a>
        <img src="assets/image.png" alt="Logo">
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

  <!-- Hero -->
  <section id="hero">
    <div class="overlay">
      <div class="description">
        <h1 class="title">Biblioteca Institucional</h1>
        <q class="quote">Contamos con una gran variedad de libros para reforzar tus conocimientos.</q>
        <a class="order" href="admin/login/login.php">Agregar Libros</a>
      </div>
      <img class="book" src="./assets/hero-book.jpg" />
    </div>
  </section>

  <!-- Products -->
  <section id="promo" class="products-section">
    <h2 class="title">Biblioteca Instituto La Troncal</h2>
    <div class="products">
      <?php if ($result->num_rows > 0) : ?>
        <?php while ($row = $result->fetch_assoc()) : ?>
          <div class="product">
            <a href="javascript:void(0);" onclick="openModal('<?php echo htmlspecialchars($row['id_peri']); ?>', '<?php echo htmlspecialchars($row['titulo']); ?>', '<?php echo htmlspecialchars($row['autor']); ?>', 'assets/products/<?php echo htmlspecialchars($row['img']); ?>', '<?php echo htmlspecialchars($row['asignatura']); ?>', '<?php echo htmlspecialchars($row['codigoisbn']); ?>')">
              <div class="image">
                <img src="assets/products/<?php echo htmlspecialchars($row['img']); ?>" alt="<?php echo htmlspecialchars($row['titulo']); ?>" />
              </div>
            </a>
            <div class="details">
              <h3 class="title"><?php echo htmlspecialchars($row['titulo']); ?></h3>
              <p class="author">de <?php echo htmlspecialchars($row['autor']); ?></p>
              <p class="materia"><?php echo htmlspecialchars($row['asignatura']); ?></p>
              <p class="descripcion"><?php echo htmlspecialchars($row['codigoisbn']); ?></p>
            </div>
            <div class="actions">
              <a href="#" class="add-to-cart"><i class="fa-solid fa-bag-shopping"></i> Disponible</a>
              <a href="#" class="add-to-wishlist"><i class="fa-solid fa-heart"></i></a>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else : ?>
        <p>No hay libros disponibles en este momento.</p>
      <?php endif; ?>
    </div>
  </section>

  <!-- Modal -->
  <div id="myModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <img id="modal-img" src="" alt="Imagen del Libro" />
      <div class="details">
        <h3 id="modal-title" class="title"></h3>
        <hr>
        <p id="modal-author" class="author"></p>
        <hr>
        <p id="modal-asignatura" class="materia"></p>
        <hr>
        <p id="modal-codigoisbn" class="descripcion"></p>
        <hr>
        <a href="#" class="add-to-cart"><i class="fa-solid fa-bag-shopping"></i> Disponible</a>
      </div>
    </div>
  </div>
  <footer id="footer1">
    <div class="footer-grid">
      <div class="footer-left">
        <a class="logo" href="https://www.istlatroncal.edu.ec">ISTLT</a>
        <p class="description">
        Contamos con una gran variedad de libros para reforzar tus conocimientos.
        </p>
        <div class="contact">
          <ul>
            <li class="company">Instituto Superior Tecnologico La Troncal</li>
            <li class="address">La Troncal Av. 4 de Noviembre y Loja</li>
            <li class="phone">Whatsapp: +(593) 991317897</li>
            <li class="hours">secretaria@istlatroncal.edu.ec</li>
          </ul>
        </div>
        <div class="social-media"></div>
      </div>
      <div class="footer-center">
        <div class="title">
          <p>Biblioteca</p>
        </div>
        <!-- <div class="links">
          <ul>
            <li><a href="#">Despre noi</a></li>
            <li><a href="#">Cum Cumpar?</a></li>
            <li><a href="#">Livrare si Retur</a></li>
            <li><a href="#">Termeni si Conditii</a></li>
            <li><a href="#">Politica de confidentialitate</a></li>
            <li><a href="#">ANPC</a></li>
          </ul>
        </div> -->
      </div>
      <div class="footer-right">
        <p>Contáctanos para mas información</p>
        <hr style="background-color: #00334a;">
      <a class="order" href="https://www.istlatroncal.edu.ec/contact/">Contáctanos</a>
        </div>
      </div>
    </div>
    <div class="copyright">
      <hr />
      <p>© 2024 Biblioteca ISTLT - All rights reserved</p>
    </div>
  </footer>

  <script>
    function openModal(id, titulo, autor, imgSrc, asignatura, codigoisbn) {
      document.getElementById("modal-img").src = imgSrc;
      document.getElementById("modal-title").innerText = "Titulo: " + titulo;
      document.getElementById("modal-author").innerText = "Autor: " + autor;
      document.getElementById("modal-asignatura").innerText = "Asignatura: " + asignatura;
      document.getElementById("modal-codigoisbn").innerText = "Codigo: " + codigoisbn;
      document.getElementById("myModal").style.display = "block";
    }

    function closeModal() {
      document.getElementById("myModal").style.display = "none";
    }

    // Cierra el modal cuando se hace clic fuera de él
    window.onclick = function(event) {
      if (event.target == document.getElementById("myModal")) {
        closeModal();
      }
    }

    // Cierra el modal cuando se hace clic en el botón "Disponible" dentro del modal
    document.querySelector('.modal .add-to-cart').onclick = function() {
      closeModal();
    }
  </script>

</body>

</html>