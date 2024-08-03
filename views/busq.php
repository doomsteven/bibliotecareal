<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Biblioteca ISTLT</title>
    <link href="../../styles.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com/" />
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Climate+Crisis&family=Montserrat:ital,wght@0,100;0,200;0,300;1,100;1,200;1,300&family=Roboto:wght@300&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
</head>
<body>
    <!-- Navigation -->
    <header id="header">
      <div class="main">
        <div class="logo">
          <a class="logo" href="../index.php"></a>
          <img src="../../assets/image.png" alt="Logo" />
        </div>
        <div class="search">
        <form action="../busqueda/busqueda.php" method="get">
          <div class="input-group">
            <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" name="query" placeholder="Qué libro buscas?" />

          </div>
        </form>
      </div>
        <div class="links">
          <a class="link" href="../index.php">
            <i class="fa-solid fa-reply-all"></i>
            Volver a la biblioteca
          </a>
        </div>
        <div class="links">
          <a class="link" href="../admin/login/login.php">
            <i class="fa-solid fa-user"></i>
            Iniciar Sesion 
          </a>
        </div>
      </div>
      <nav class="categories">
        <a class="category" href="../index.php">Biblioteca Instituto Superior Tecnologico La Troncal</a>
      </nav>
    </header>
