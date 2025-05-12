<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrarse</title>
  <link rel="stylesheet" href="../../public/css/styles.css">

</head>
<body>

  <form method="POST" action="../../controllers/UserController.php" onsubmit="return validarFormulario()">
    <h2>Registrarse</h2>
    <input type="text" name="name" id="name" placeholder="Nombre completo" required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" title="Solo letras y espacios"> <!--Solo permite letras y espacios en el nombre.-->

    <input type="email" name="email" placeholder="Correo electrónico" required>

    <!-- Contenedor con input y toggle -->
    <div class="password-container">
      <input type="password" id="password" name="password" placeholder="Contraseña (máx 8 caracteres)" maxlength="8" required>
      <span class="toggle-password" onclick="togglePassword()">👁️</span>
    </div>

    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirmar contraseña" maxlength="8" required>

    <select name="role" required>
      <option value="">Selecciona tu rol</option>
      <option value="comprador">Comprador</option>
      <option value="vendedor">Vendedor</option>
    </select>

    <button type="submit" name="register">Registrarse</button>

    <p style="text-align: center; margin-top: 15px;">
      ¿Ya tienes cuenta?
      <a href="login.php">Inicia sesión</a>
    </p>
  </form>

  <!-- Scripts -->
  <script>
    function togglePassword() {
      const passwordField = document.getElementById("password");
      const type = passwordField.type === "password" ? "text" : "password";
      passwordField.type = type;
    }

    function validarFormulario() {
      const password = document.getElementById("password").value;
      const confirmPassword = document.getElementById("confirmPassword").value;

      if (password !== confirmPassword) {
        alert("Las contraseñas no coinciden.");
        return false;
      }

      return true;
    }
  </script>

</body>
</html>
