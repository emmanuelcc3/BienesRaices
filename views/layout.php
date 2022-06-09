<?php
  
  if (!isset($_SESSION)) {
    session_start();
  }
  $auth = $_SESSION['login'] ?? false;
  //var_dump($auth);
  if (!isset($inicio)) {
      $inicio = false;
  }

?>

<!DOCTYPE php>
<php lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bienes Raices</title>
  <link rel="stylesheet" href="../build/css/app.css" />
</head>

<body>
  <header class="header <?php echo $inicio  ? 'inicio' : ''; ?>">
    <div class="contenedor contenido-header">
      <div class="barra">
        <a href="/">
          <img src="/build/img/logo.svg" alt="logotipo de Bienes Raices" />
        </a>
        <div class="mobile-menu">
          <img src="/build/img/barras.svg" alt="icono menu">
        </div> 
        <div class="derecha">
          <img class="dark-mode-boton" src="/build/img/dark-mode.svg">
        <nav class="navegacion">
          <a href="/nosotros">Nosotros</a>
          <a href="/propiedades">Propiedades</a>
          <a href="/blog">Blog</a>
          <?php if(!$auth): ?>
            <a href="/contacto">Contacto</a>
          <?php endif; ?>
          <?php if(!$auth): ?>
          <a href="/login">Login</a>
          <?php endif; ?>
          <?php if($auth): ?>
          <a href="/admin">Panel</a>    
          <?php endif; ?>
          <?php if($auth): ?>
          <a href="/logout">Cerrar Sesion</a>    
          <?php endif; ?>
        </nav>
      </div>
      </div>
      <!--Final de barra-->
     <?php echo $inicio ? "<h1 data-cy='heading-sitio'>Venta de Casas y Departamentos Exclusivos de Lujo<h1>": '';
    
     ?>
    </div>
  </header>

  <?php echo $contenido;?>

  <footer class="footer seccion">
    <div class="contenedor contenedor-footer">
      <nav class="navegacion">
        <a href="/nosotros">Nosotros</a>
        <a href="/propiedades">Anuncios</a>
        <a href="/blog">Blog</a>
        <a href="/contacto">Contacto</a>
      </nav>
    </div>
    <p class="copyright">Todos los derecho Reservados <?php echo date('Y');?> &copy;</p>
  </footer>

  <script src="../build/js/bundle.min.js"></script>
</body>

</html>