<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>

<form method="POST" action="../../controllers/UserController.php">
    <h2>Iniciar sesión</h2>
    <input type="email" name="email" placeholder="Correo electrónico" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit" name="login">Entrar</button>
</form>

<!-- Modal de error -->
<div id="errorModal" class="modal hidden">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <p id="errorMessage">Error</p>
  </div>
</div>

<!-- Mostrar error si viene por GET -->
<?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        showError("Correo o contraseña incorrectos.");
    });
</script>
<?php endif; ?>

<!-- JS del modal -->
<script>
function showError(message) {
    const modal = document.getElementById("errorModal");
    document.getElementById("errorMessage").textContent = message;
    modal.classList.remove("hidden");
}
function closeModal() {
    document.getElementById("errorModal").classList.add("hidden");
}
</script>

<!-- Estilos del modal -->
<style>
.modal {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    z-index: 999;
    left: 0; top: 0; right: 0; bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
}
.modal.hidden {
    display: none;
}
.modal-content {
    background-color: #fff;
    padding: 20px 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    text-align: center;
}
.modal-content .close {
    float: right;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
}
</style>

</body>
</html>
