<?php
// Conexión a la base de datos
include dirname(__DIR__, 1) . '/app/conexion.php';

// Consulta para obtener todos los libros
$sql = "SELECT * FROM libro";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Listar Libros</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            font-family: "Montserrat", sans-serif;
            overflow-x: hidden;
        }

        a {
            flex-direction: row;
            align-items: center;
            text-decoration: none;
        }

        h1 {
            font-size: 50px;
            text-align: center;
        }

        .ag {
            font-size: 30px;
        
        }

        .fa-plus-circle {
            margin-right: 10px; /* Espacio entre el icono y el texto */
        }

        hr {
            border: 0;
            height: 2px;
            background: white;
            width: 70%;
            margin: 20px auto;
        }
    </style>
</head>

<body>
    <hr>
    <h1>Lista de Libros</h1>
    <hr>
    <a class="ag" href="agregar_libro.php">
    <i class="fa fa-plus-circle"></i>
    Agregar Nuevo Libro</a>
    <hr>
    <table class="table table-striped table-hover" border="1">
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
                        <img src="../../assets/products/ echo htmlspecialchars($libro['img']); ?>" alt="Imagen" width="100">
                    <?php endif; ?>
                </td>
                <td>
                    <a href="editar_libro.php?id=<?php echo $libro['id_peri']; ?>">Editar</a>
                    <a href="eliminar_libro.php?id=<?php echo $libro['id_peri']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este libro?');">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>

</html>