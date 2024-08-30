<?php
include dirname(__DIR__, 1) . '/app/conexion.php';

// Obtener el término de búsqueda del formulario
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Consulta para buscar los libros que coincidan con el término de búsqueda en los campos especificados
$sql = "SELECT titulo, autor, img, asignatura, codigoisbn, numpag, ano, editorial, tipo, codigo, origen FROM libro WHERE titulo LIKE ? OR autor LIKE ? OR asignatura LIKE ? OR codigoisbn LIKE ?";

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

    <style>
        /* General Styles */
        body {
            font-family: "Montserrat", sans-serif;
        }

        h1 {
            text-align: center;
            padding: 40px;
        }

        .products {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .product {
            cursor: pointer;
            max-width: 300px;
            margin: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .product img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
        }

        .product h3,
        .product p {
            margin: 10px 0;
        }

        /* Modal Styles */
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
            /* Añadido para mejorar la presentación en pantallas pequeñas */
        }

        .modal-content {
            background-color: rgba(255, 255, 255, 0.9);
            margin: auto;
            padding: 50px;
            border: 1px solid #888;
            width: 90%;
            max-width: 900px;
            display: flex;
            flex-direction: row;
            /* align-items: center; */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-size: 22px;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            /* flex-wrap: wrap;  */
        }

        .modal-content .details p {
            margin-bottom: 10px;
            /* Añade espacio entre párrafos */
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
            padding: 20px;
        }

        /* Close Button Styles */
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

        /* Divider Line */
        hr {
            border: 0;
            height: 2px;
            background: #888;
            width: 70%;
            margin: 20px auto;
            border-radius: 2px;
        }

        /* Modal Buttons */
        /* .modal .add-to-cart {
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
        } */

        /* Responsive Design */
        @media (max-width: 768px) {
            .modal-content {
                width: 90%;
                flex-direction: column;
                padding: 20px;
            }

            .modal-content img {
                width: 100%;
                height: auto;
                margin-bottom: 20px;
            }

            .modal-content .details {
                padding: 0;
            }

            .modal-content .details .actions {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }

        /* Notification Modal Styles */
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
    </style>
</head>

<body>
    <!-- Navigation -->
    <?php include '../views/busq.php'; ?>

    <main>
        <h1>Resultados de Búsqueda</h1>
        <?php if ($result->num_rows > 0) : ?>
            <div class="products">
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <div class="product" onclick="openModal('<?php echo htmlspecialchars($row['titulo']); ?>', '<?php echo htmlspecialchars($row['autor']); ?>', '../assets/products/<?php echo htmlspecialchars($row['img']); ?>', '<?php echo htmlspecialchars($row['asignatura']); ?>', '<?php echo htmlspecialchars($row['codigoisbn']); ?>', '<?php echo htmlspecialchars($row['numpag']); ?>', '<?php echo htmlspecialchars($row['ano']); ?>', '<?php echo htmlspecialchars($row['editorial']); ?>', '<?php echo htmlspecialchars($row['tipo']); ?>', '<?php echo htmlspecialchars($row['codigo']); ?>', '<?php echo htmlspecialchars($row['origen']); ?>')">
                        <div class="image">
                            <img src="../assets/products/<?php echo htmlspecialchars($row['img']); ?>" alt="<?php echo htmlspecialchars($row['titulo']); ?>" />
                        </div>
                        <div class="details">
                            <h3 class="title"><?php echo htmlspecialchars($row['titulo']); ?></h3>
                            <p class="author">de <?php echo htmlspecialchars($row['autor']); ?></p>
                            <p class="materia"><?php echo htmlspecialchars($row['asignatura']); ?></p>
                            <p class="codigoisbn"><strong>ISBN:</strong> <?php echo htmlspecialchars($row['codigoisbn']); ?></p>
                            <p class="numpag"><strong>Número de Páginas:</strong> <?php echo htmlspecialchars($row['numpag']); ?></p>
                            <p class="ano"><strong>Año:</strong> <?php echo htmlspecialchars($row['ano']); ?></p>
                            <p class="editorial"><strong>Editorial:</strong> <?php echo htmlspecialchars($row['editorial']); ?></p>
                            <p class="tipo"><strong>Tipo:</strong> <?php echo htmlspecialchars($row['tipo']); ?></p>
                            <p class="codigo"><strong>Código:</strong> <?php echo htmlspecialchars($row['codigo']); ?></p>
                            <p class="origen"><strong>Origen:</strong> <?php echo htmlspecialchars($row['origen']); ?></p>
                            <div class="actions">
                                <a href="#" class="add-to-cart"> Disponible</a>
                                <!-- <a href="#" class="add-to-wishlist" onclick="showBookLocation2()"><i class="fa-solid fa-heart"></i></a> -->
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <p>No se encontraron resultados para "<?php echo htmlspecialchars($query); ?>".</p>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </main>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <img id="modal-img" src="" alt="Imagen del Libro" />
            <div class="details">
                <h3 id="modal-title" class="title"></h3>
                <hr>
                <p id="modal-author" class="author"></p>
                <p id="modal-materia" class="materia"></p>
                <p id="modal-codigoisbn" class="codigoisbn"></p>
                <p id="modal-numpag" class="numpag"></p>
                <p id="modal-ano" class="ano"></p>
                <p id="modal-editorial" class="editorial"></p>
                <p id="modal-tipo" class="tipo"></p>
                <p id="modal-codigo" class="codigo"></p>
                <p id="modal-origen" class="origen"></p>
                <!-- <div class="actions">
                    <a href="#" class="add-to-cart" onclick="showBookLocation1()" ;><i class=""></i> Disponible</a>
                    <a href="#" class="add-to-wishlist" onclick="showBookLocation2()"><i class="fa-solid fa-heart"></i></a>
                    <a href="#" class="question" onclick="showBookLocation3()" ;><i class=""></i>Ver libro</a>
                </div> -->
            </div>
        </div>
    </div>

    <!-- Segundo modal -->
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
      <p><strong></strong></p>
      <p>Ya estas observando los detalles del libro.</p>
    </div>
  </div>
  <?php include '../views/footer.php'
   ?>
    <script>
        function openModal(title, author, imgSrc, materia, codigoisbn, numpag, ano, editorial, tipo, codigo, origen) {
            document.getElementById('modal-title').textContent = title;
            document.getElementById('modal-author').innerHTML = "<strong>Autor:</strong> " + author;
            document.getElementById('modal-img').src = imgSrc;
            document.getElementById('modal-materia').innerHTML = "<strong>Asignatura:</strong> " + materia;
            document.getElementById('modal-codigoisbn').innerHTML = "<strong>ISBN:</strong> " + codigoisbn;
            document.getElementById('modal-numpag').innerHTML = "<strong>Número de Páginas:</strong> " + numpag;
            document.getElementById('modal-ano').innerHTML = "<strong>Año:</strong> " + ano;
            document.getElementById('modal-editorial').innerHTML = "<strong>Editorial:</strong> " + editorial;
            document.getElementById('modal-tipo').innerHTML = "<strong>Tipo:</strong> " + tipo;
            document.getElementById('modal-codigo').innerHTML = "<strong>Código:</strong> " + codigo;
            document.getElementById('modal-origen').innerHTML = "<strong>Origen:</strong> " + origen;

            document.getElementById('myModal').style.display = 'block';
        }


        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
        }

        function showBookLocation1() {
            // Mostrar el segundo modal
            document.getElementById('notificationModal').style.display = 'block';

            // Ocultar el segundo modal después de 2 segundos
            setTimeout(function() {
                document.getElementById('notificationModal').style.display = 'none';
            }, 2000);
        }

        function showBookLocation2() {
            // Mostrar el segundo modal
            document.getElementById('notificationModallike').style.display = 'block';

            // Ocultar el segundo modal después de 2 segundos
            setTimeout(function() {
                document.getElementById('notificationModallike').style.display = 'none';
            }, 2000);
        }
        function showBookLocation3() {
            // Mostrar el segundo modal
            document.getElementById('notificationModalquestion').style.display = 'block';

            // Ocultar el segundo modal después de 2 segundos
            setTimeout(function() {
                document.getElementById('notificationModalquestion').style.display = 'none';
            }, 2000);
        }
    </script>
</body>

</html>