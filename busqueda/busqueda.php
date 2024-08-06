<?php
include dirname(__DIR__, 1) . '/app/conexion.php';

// Obtener el término de búsqueda del formulario
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Consulta para buscar los libros que coincidan con el término de búsqueda en los campos especificados
$sql = "SELECT titulo, autor, img, asignatura, codigoisbn FROM libro WHERE titulo LIKE ? OR autor LIKE ? OR asignatura LIKE ? OR codigoisbn LIKE ?";

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
        body {
            font-family: "Montserrat", sans-serif;
        }
        h1{
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
        }

        .modal-content {
            background-color: rgba(255, 255, 255, 0.9);
            margin: 5% auto;
            padding: 30px;
            border: 1px solid #888;
            width: 80%;
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
            width: 200px;
            height: 300px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .modal-content .details {
            text-align: center;
            width: 100%;
            line-height: 1.5;
            padding: 0 20px;
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
            height: 2px;
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
                    <div class="product" onclick="openModal('<?php echo htmlspecialchars($row['titulo']); ?>', '<?php echo htmlspecialchars($row['autor']); ?>', '../assets/products/<?php echo htmlspecialchars($row['img']); ?>', '<?php echo htmlspecialchars($row['asignatura']); ?>', '<?php echo htmlspecialchars($row['codigoisbn']); ?>')">
                        <div class="image">
                            <img src="../assets/products/<?php echo htmlspecialchars($row['img']); ?>" alt="<?php echo htmlspecialchars($row['titulo']); ?>" />
                        </div>
                        <div class="details">
                            <h3 class="title"><?php echo htmlspecialchars($row['titulo']); ?></h3>
                            <p class="author">de <?php echo htmlspecialchars($row['autor']); ?></p>
                            <p class="materia"><?php echo htmlspecialchars($row['asignatura']); ?></p>
                            <p class="codigoisbn"><strong>ISBN:</strong> <?php echo htmlspecialchars($row['codigoisbn']); ?></p>
                            <div class="actions">
                                <a href="#" class="add-to-cart" onclick="showBookLocation1()"><i class="fa-solid fa-bag-shopping"></i> Disponible</a>
                                <a href="#" class="add-to-wishlist" onclick="showBookLocation2()"><i class="fa-solid fa-heart"></i></a>
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
                <hr>
                <p id="modal-asignatura" class="materia"></p>
                <hr>
                <p id="modal-codigoisbn" class="descripcion"></p>
                <hr>
                <div class="actions">
                    <a href="#" class="add-to-cart" onclick="showBookLocation1()"><i class="fa-solid fa-bag-shopping"></i> Disponible</a>
                    <a href="#" class="add-to-wishlist" onclick="showBookLocation2()"><i class="fa-solid fa-heart"></i></a>
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

    <script>
        function openModal(titulo, autor, imgSrc, asignatura, codigoisbn) {
            document.getElementById("modal-img").src = imgSrc;
            document.getElementById("modal-title").innerText = titulo;
            document.getElementById("modal-author").innerHTML = "<strong>Autor: </strong>" + autor;
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
    </script>
</body>

</html>