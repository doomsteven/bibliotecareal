<?php
include 'app/conexion.php';

// Consulta para obtener los datos de los libros
$sql = "SELECT id_peri, titulo, autor, img, asignatura, codigoisbn, ano, editorial FROM libro";
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
        padding: 20px;
    }

    .modal-content {
        background-color: rgba(255, 255, 255, 0.9);
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 90%;
        max-width: 800px;
        display: flex;
        flex-direction: row;
        align-items: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        font-size: 18px;
        border-radius: 12px;
        overflow: hidden;
        position: relative;
    }

    .modal-content img {
        width: 300px;
        height: 500px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    .modal-content .details {
        text-align: left;
        width: 100%;
        line-height: 1.5;
        padding: 0 20px;
    }

    .modal-content .details .title {
        text-align: center;
    }

    .modal-content .details .actions {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .close {
        color: #aaa;
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    hr {
        border: 0;
        height: 1px;
        background: #888;
        width: 70%;
        margin: 20px auto;
        border-radius: 2px;
        background: transparent;
    }

    .modal .add-to-cart {
        padding: 0.75rem 1rem;
        background-color: green;
        color: white;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }

    .modal .add-to-cart:hover {
        background-color: white;
        color: green;
    }

    .modal .question {
        padding: 0.75rem 1rem;
        background-color: var(--dark-color);
        color: var(--yellow-color);
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }

    .modal .question:hover {
        background-color: var(--yellow-color);
        color: var(--dark-color);
    }

    /* Estilos del segundo modal */
    .notification-modal {
        display: none;
        position: fixed;
        z-index: 2;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.6);
    }

    .notification-content {
        background-color: rgba(255, 255, 255, 0.9);
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
        text-align: center;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        position: relative;
    }

    .notification-content p {
        font-size: 18px;
        margin: 20px 0;
    }

    .add-to-wishlist {
        padding: 0.75rem 1rem;
        background-color: red;
        color: white;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }

    .add-to-wishlist:hover {
        background-color: white;
        color: red;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .modal-content {
            flex-direction: column;
            padding: 15px;
        }

        .modal-content img {
            width: 100%;
            height: auto;
        }

        .modal-content .details {
            padding: 15px 0;
        }

        .modal-content .details .actions {
            flex-direction: column;
            gap: 10px;
            text-align: center;
        }
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
          Iniciar Sesión
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
        <h1 class="title">Biblioteca Instituto La Troncal.</h1>
        <q class="quote">Contamos con una gran variedad de libros para reforzar tus conocimientos.</q>
        <!-- <a class="order" href="admin/login/login.php">Agregar Libros</a> -->
      </div>
      <img class="book" src="./assets/cod.webp" />
    </div>
  </section>

  <!-- Products -->
  <section id="promo" class="products-section">
    <h2 class="title">Catálogo de libros.</h2>
    <div class="products">
      <?php if ($result->num_rows > 0) : ?>
        <?php while ($row = $result->fetch_assoc()) : ?>
          <div class="product">
          <a href="javascript:void(0);" onclick="openModal('<?php echo htmlspecialchars($row['id_peri']); ?>', '<?php echo htmlspecialchars($row['titulo']); ?>', '<?php echo htmlspecialchars($row['autor']); ?>', 'assets/products/<?php echo htmlspecialchars($row['img']); ?>', '<?php echo htmlspecialchars($row['asignatura']); ?>', '<?php echo htmlspecialchars($row['codigoisbn']); ?>', '<?php echo htmlspecialchars($row['ano']); ?>', '<?php echo htmlspecialchars($row['editorial']); ?>')">
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
              <a href="#" class="add-to-cart" onclick="showBookLocation1()" ;><i class="fa-solid fa-bag-shopping"></i> Disponible</a>
              <a href="#" class="add-to-wishlist" onclick="showBookLocation2()"><i class="fa-solid fa-heart"></i></a>
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
        <p id="modal-editorial" class="editorial"></p>
        <hr>
        <p id="modal-ano" class="ano"></p>
        <hr>
        <p id="modal-asignatura" class="materia"></p>
        <hr>
        <p id="modal-codigoisbn" class="descripcion"></p>
        <hr>
        <div class="actions">
          <a href="#" class="add-to-cart" onclick="showBookLocation1()" ;><i class="fa-solid fa-bag-shopping"></i> Disponible</a>
          <a href="#" class="add-to-wishlist" onclick="showBookLocation2()"><i class="fa-solid fa-heart"></i></a>
          <a href="#" class="question" onclick="showBookLocation3()" ;><i class="fa-solid fa-search"></i>Encontrarlo</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Segundo Modal (Notificación) -->
  <div id="notificationModal" class="notification-modal">
    <div class="notification-content">
      <span class="close" onclick="closeNotificationModal1()">&times;</span>
      <p><strong>GRACIAS POR ORDENAR.</strong></p>
      <p>Puedes hallar el libro en la biblioteca.</p>
    </div>
  </div>

  <div id="notificationModallike" class="notification-modal">
    <div class="notification-content">
      <span class="close" onclick="closeNotificationModal2()">&times;</span>
      <p><strong>TE HA GUSTADO EL LIBRO ❤️.</strong></p>
      <p>Puedes hallar el libro en la biblioteca.</p>
    </div>
  </div>

  
  <div id="notificationModalquestion" class="notification-modal">
    <div class="notification-content">
      <span class="close" onclick="closeNotificationModal3()">&times;</span>
      <p><strong>BUSCANDO...</strong></p>
      <p>Libro encontrado en la biblioteca física de la institución.</p>
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
          <p>Acceso rápido</p>
        </div>
        <div class="links2">
          <ul>
            <li><a class="link3" href="https://www.istlatroncal.edu.ec">Quiénes somos</a></li>
            <li><a class="link3" href="https://www.istlatroncal.edu.ec">Carreras</a></li>
            <li><a class="link3" href="https://www.istlatroncal.edu.ec">Noticias</a></li>
            <li><a class="link3" href="https://www.istlatroncal.edu.ec">Contáctanos</a></li>
            
          </ul>
        </div> 
      </div>
      <div class="footer-right">
        <p>Contáctanos para mas información</p>
        <hr style="background:#00334a;">
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
    function openModal(id, titulo, autor, imgSrc, asignatura, codigoisbn, ano, editorial) {
      document.getElementById("modal-img").src = imgSrc;
      document.getElementById("modal-title").innerText = "" + titulo;
      document.getElementById("modal-author").innerHTML = "<strong>Autor: </strong>" + autor;
      document.getElementById("modal-editorial").innerHTML = "<strong>Editorial: </strong>" + editorial;
      document.getElementById("modal-ano").innerHTML = "<strong>Año: </strong>" + ano;
      document.getElementById("modal-asignatura").innerHTML = "<strong>Asignatura: </strong>" + asignatura;
      document.getElementById("modal-codigoisbn").innerHTML = "<strong>ISBN: </strong>" + codigoisbn;
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


    // document.querySelector('.modal .add-to-cart').onclick = function() {
    //   closeModal();
    // }

    function showBookLocation1() {
      document.getElementById("notificationModal").style.display = "block";
    }

    function closeNotificationModal1() {
      document.getElementById("notificationModal").style.display = "none";
    }

    function showBookLocation2() {
      document.getElementById("notificationModallike").style.display = "block";
    }

    function closeNotificationModal2() {
      document.getElementById("notificationModallike").style.display = "none";
    }
    function showBookLocation3() {
      document.getElementById("notificationModalquestion").style.display = "block";
    }

    function closeNotificationModal3() {
      document.getElementById("notificationModalquestion").style.display = "none";
    }
  </script>

</body>

</html>