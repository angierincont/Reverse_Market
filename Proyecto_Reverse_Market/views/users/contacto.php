<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contacto</title>
  <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
  <header>
    <nav class="navbar">
      <div class="nav-left">
        <a href="login.php" class="btn">Iniciar Sesión</a>
        <a href="register.php" class="btn">Registrarse</a>
      </div>
      <div class="nav-center">
        <ul class="nav-menu">
          <li><a href="../../public/index.php">Inicio</a></li>
          <li><a href="como_funciona.php">Cómo Funciona</a></li>
          <li><a href="servicios.php">Servicios</a></li>
          <li><a href="contacto.php">Contacto</a></li>
        </ul>
      </div>
    </nav>
  </header>

  <div class="container">
    <h1>Contáctanos</h1>
    <p>¿Tienes preguntas o sugerencias? Rellena el siguiente formulario:</p>
    <form class="contact-form" action="#" method="post">
      <input type="text" name="nombre" placeholder="Tu nombre" required>
      <input type="email" name="email" placeholder="Tu correo electrónico" required>
      <textarea name="mensaje" rows="5" placeholder="Escribe tu mensaje aquí..." required></textarea>
      <button type="submit">Enviar</button>
    </form>
  </div>
</body>
</html>
