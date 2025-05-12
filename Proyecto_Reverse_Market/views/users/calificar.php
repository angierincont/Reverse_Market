<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'comprador') {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Calificar Vendedor</title>
  <link rel="stylesheet" href="../../public/css/styles.css" />
</head>
<body>
  <div class="container">
    <h2>Calificar Vendedor</h2>
    <form id="calificacionForm">
      <input type="hidden" name="id_vendedor" value="<?php echo htmlspecialchars($_GET['id_vendedor']); ?>" required />
      <input type="number" name="puntuacion" placeholder="Puntuación (1-5)" min="1" max="5" required />
      <textarea name="comentario" placeholder="Comentario" required></textarea>
      <button type="submit">Enviar Calificación</button>
    </form>
    <div id="message"></div>
  </div>

  <script>
    const form = document.getElementById('calificacionForm');
    const messageDiv = document.getElementById('message');

    form.addEventListener('submit', async function(e) {
      e.preventDefault();
      messageDiv.innerHTML = '';
      messageDiv.className = '';

      const formData = new FormData(form);

      try {
        const response = await fetch('../../controllers/CalificacionController.php', {
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
        } else {
          messageDiv.textContent = data.message || 'Error desconocido';
          messageDiv.className = 'message error';
        }
      } catch (error) {
        messageDiv.textContent = 'Error al enviar la calificación: ' + error.message;
        messageDiv.className = 'message error';
      }
    });
  </script>
</body>
</html>
