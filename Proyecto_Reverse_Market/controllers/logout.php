<?php
// Inicia o reanuda la sesión actual del usuario
session_start();

// Destruye toda la información registrada de la sesión actual
session_destroy();

// Redirige al usuario a la página de login
header("Location: login.php");

// Finaliza la ejecución del script para evitar que se ejecute más código
exit;
?>
