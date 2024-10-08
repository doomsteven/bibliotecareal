<?php
// Conexión a la base de datos
include dirname(__DIR__, 1) . '/app/conexion.php';

// Consulta para obtener todos los libros
$sql = "SELECT * FROM libro";
$result = $conn->query($sql);
session_start();
if (!isset($_SESSION['usuario'])) {
    // Si no hay sesión activa, redirige a la página de inicio de sesión
    header("Location: ../../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Listar Libros</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="../styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            font-family: "Montserrat", sans-serif;
            overflow-x: hidden;
        }

        body a {
            text-decoration: none;
        }

        .titulo1 {
            flex-direction: row;
            text-align: center;
            font-size: 30px;
            text-decoration: none;
        }

        .titulo1 a {
            text-decoration: none;
        }

        .titulo1 a:hover {
            color: #ffc107;
        }

        h1 {
            font-size: 50px;
            text-align: center;
        }


        .fa-plus-circle {
            margin-right: 10px;
        }

        hr {
            border: 0;
            height: 2px;
            background: white;
            width: 70%;
            margin: 20px auto;
        }

        /* Estilos del modal */
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
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 12px;
            position: relative;
        }

        .close {
            color: #aaa;
            position: absolute;
            top: 10px;
            right: 10px;
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

        .table-small {
            width: 80%;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <header id="header">
        <div class="main">
            <div class="logo">
                <a class="logo" href="#"></a>
                <img src="../../assets/image.png" alt="Logo" />
            </div>
            <div class="links">
                <a class="link" href="#" id="logoutLink">
                    <i class="fa fa-sign-out"></i>
                    Cerrar Sesión
                </a>
            </div>
        </div>
        <nav class="categories">
            <a class="category" href="indexpanel.php">Administración de libros</a>
        </nav>
        
    </header>

    <hr>
    <h1>Lista de Libros</h1>
    <hr>
    <div class="titulo1">

        <a class="ag" href="agregar_libro.php">
            <i class="fa fa-plus-circle"></i>
            Agregar nuevo libro.
        </a>
    </div>
    <hr>
    <table class="table table-striped table-hover table-small" border="1">
        <tr>
            <th>ID</th>
            <th>Periodo</th>
            <th>Asignatura</th>
            <th>Área de Conocimiento</th>
            <th>Autor</th>
            <th>Título</th>
            <th>Código ISBN</th>
            <th>Número de Páginas</th>
            <th>Año</th>
            <th>Editorial</th>
            <th>Tipo</th>
            <th>Código</th>
            <th>Origen</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
        <?php while ($libro = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $libro['id_peri']; ?></td>
                <td><?php echo $libro['periodo']; ?></td>
                <td><?php echo $libro['asignatura']; ?></td>
                <td><?php echo $libro['areaconocimiento']; ?></td>
                <td><?php echo $libro['autor']; ?></td>
                <td><?php echo $libro['titulo']; ?></td>
                <td><?php echo $libro['codigoisbn']; ?></td>
                <td><?php echo $libro['numpag']; ?></td>
                <td><?php echo $libro['ano']; ?></td>
                <td><?php echo $libro['editorial']; ?></td>
                <td><?php echo $libro['tipo']; ?></td>
                <td><?php echo $libro['codigo']; ?></td>
                <td><?php echo $libro['origen']; ?></td>
                <td>
                    <?php if ($libro['img']) : ?>
                        <img src="../../assets/products/<?php echo htmlspecialchars($libro['img']); ?>" alt="Imagen"
                            width="100">
                    <?php endif; ?>
                </td>
                <td>
                    <a href="editar_libro.php?id=<?php echo $libro['id_peri']; ?>">Editar</a>
                    <a href="eliminar_libro.php?id=<?php echo $libro['id_peri']; ?>"
                        onclick="return confirm('¿Estás seguro de que deseas eliminar este libro?');">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Modal de confirmación de cierre de sesión -->
    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h5>Confirmación de cierre de sesión</h5>
            <p>¿Estás seguro de que deseas cerrar sesión?</p>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancelBtn">Cancelar</button>
                <a href="logout.php" class="btn btn-warning" id="confirmLogoutBtn">Cerrar Sesión</a>
            </div>
        </div>
    </div>
    <hr>
    <?php include '../views/footer.php'
    ?>

    <!-- Scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var logoutLink = document.getElementById("logoutLink");
            var logoutModal = document.getElementById("logoutModal");
            var closeModal = document.getElementsByClassName("close")[0];
            var cancelBtn = document.getElementById("cancelBtn");

            logoutLink.onclick = function(event) {
                event.preventDefault();
                logoutModal.style.display = "block";
            }

            closeModal.onclick = function() {
                logoutModal.style.display = "none";
            }

            cancelBtn.onclick = function() {
                logoutModal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == logoutModal) {
                    logoutModal.style.display = "none";
                }
            }
        });
    </script>
</body>

</html>