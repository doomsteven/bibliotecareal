<!DOCTYPE html>
<html>

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
    body, html {
        height: 100%;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        background-image: url('/assets/fondo1.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .container {
        max-width: 600px;
        width: 100%;
        padding: 3rem;
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        z-index: 1;
        position: relative;
        text-align: center; /* Centro el contenido del contenedor */
    }

    .form-label {
        font-size: 1.2rem;
        display: block; /* Asegura que las etiquetas se muestren en una línea separada */
        margin-bottom: 0.5rem; /* Añade espacio debajo de las etiquetas */
    }

    .form-control {
        font-size: 1.1rem;
        padding: 0.75rem;
        width: 100%; /* Hace que los campos ocupen todo el ancho disponible */
        margin-bottom: 1rem; /* Añade espacio debajo de los campos */
        box-sizing: border-box; /* Incluye el padding y el border en el ancho total */
    }

    .btn {
        font-size: 1.2rem;
        padding: 0.75rem 1.5rem;
        cursor: pointer; /* Cambia el cursor al pasar por el botón */
    }

    .btn-container {
        text-align: center; /* Centro el contenido dentro del contenedor del botón */
        margin-top: 1rem; /* Añade espacio encima del contenedor del botón */
    }
</style>

</head>

<body>
    <div class="container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include '../../app/conexion.php';
            // Obtener datos del formulario
            $usuario = $_POST['username'];
            $password = $_POST['password'];

            // Consulta para obtener el usuario y contraseña
            $sql = "SELECT * FROM usuarios WHERE usuario = ? AND pass = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                die("Error en la preparación de la consulta: " . $conn->error);
            }

            $stmt->bind_param('ss', $usuario, $password);
            if ($stmt->execute() === false) {
                die("Error en la ejecución de la consulta: " . $stmt->error);
            }

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Inicio de sesión exitoso
                session_start();
                $_SESSION['usuario'] = $usuario;

                // Redirigir al usuario al panel
                header("Location: ../../admin/indexpanel.php");
                exit(); // Asegúrate de detener el script después de la redirección
            } else {
                echo "Usuario o contraseña incorrectos.";
            }

            $stmt->close();
            $conn->close();
        }
        ?>

        <form action="" method="post">
        <div class="logo">
        <a class="logo" href="#"></a>
        <img src="/assets/image.png" alt="Logo" />
      </div>
            <div class="mb-3">
                <label for="username" class="form-label">Usuario</label>
                <input type="text" id="username" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" id="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-warning">Iniciar sesión</button>
        </form>
    </div>
</body>

</html>
