<?php
session_start();

// Verifica si el usuario tiene un rol de vendedor
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'vendedor') {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Crear Perfil - Vendedor</title>
  <link rel="stylesheet" href="../../public/css/styles.css" />
  <style>
    .message {
      margin-top: 1em;
      padding: 10px;
      border-radius: 5px;
      font-weight: bold;
    }
    .message.success {
      color: #155724;
      background-color: #d4edda;
      border: 1px solid #c3e6cb;
    }
    .message.error {
      color: #721c24;
      background-color: #f8d7da;
      border: 1px solid #f5c6cb;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Crear Perfil</h2>
    <form id="perfilForm">
      <input type="text" name="nombre" placeholder="Nombre completo" required />
      <input type="text" name="telefono" placeholder="Teléfono" required />
      <input type="text" name="direccion" placeholder="Dirección" required />
      <textarea name="descripcion" placeholder="Descripción del perfil" required></textarea>
      <input type="hidden" name="id_vendedor" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>" />
      <button type="submit">Guardar Perfil</button>
    </form>
    <div id="message"></div>
  </div>
  <script>
    const form = document.getElementById('perfilForm');
    const messageDiv = document.getElementById('message');

    form.addEventListener('submit', async function(e) {
      e.preventDefault();
      messageDiv.innerHTML = '';
      messageDiv.className = '';

      const formData = new FormData(form);

      try {
        const response = await fetch('../../controllers/PerfilController.php', {
          method: 'POST',
          body: formData,
          headers: {
            'Accept': 'application/json'
          }
        });

        if (!response.ok) {
          throw new Error('Error en la respuesta del servidor');
        }

        const data = await response.json();

        if (data.success) {
          messageDiv.textContent = data.message;
          messageDiv.className = 'message success';

          // Redirigir después de 2 segundos al home de vendedor
          setTimeout(() => {
            window.location.href = 'home_vendedor.php';
          }, 2000);
        } else {
          messageDiv.textContent = data.message || 'Error desconocido';
          messageDiv.className = 'message error';
        }
      } catch (error) {
        messageDiv.textContent = 'Error al enviar el formulario: ' + error.message;
        messageDiv.className = 'message error';
      }
    });
  </script>
</body>
</html>