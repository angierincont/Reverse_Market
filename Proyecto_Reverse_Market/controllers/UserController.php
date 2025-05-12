<?php
// Incluir archivo de conexión a la base de datos
require_once __DIR__ . '/../config/db.php';

session_start(); // Iniciar sesión al comienzo

// ========== REGISTRO DE USUARIO ==========
if (isset($_POST['register'])) {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirmPassword'];
    $role     = $_POST['role'];

    // Validaciones
    if ($password !== $confirm) {
        echo "<script>alert('Las contraseñas no coinciden.'); window.history.back();</script>";
        exit;
    }

    if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/", $name)) {
        echo "<script>alert('El nombre solo debe contener letras y espacios.'); window.history.back();</script>";
        exit;
    }

    if (strlen($password) > 8) {
        echo "<script>alert('La contraseña no debe tener más de 8 caracteres.'); window.history.back();</script>";
        exit;
    }

    try {
        // Verificar si el correo ya existe
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE correo = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Este correo ya está registrado.'); window.history.back();</script>";
            exit;
        }

        // Encriptar y guardar usuario
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, contraseña, rol) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword, $role]);

        // Redirigir al login
        header("Location: ../views/users/login.php");
        exit;

    } catch (PDOException $e) {
        echo "<script>alert('Error al registrar el usuario.'); window.history.back();</script>";
        // Descomenta para depurar:
        // echo "<script>console.error('".$e->getMessage()."');</script>";
        exit;
    }
}

// ========== LOGIN DE USUARIO ==========
if (isset($_POST['login'])) {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['contraseña'])) {
            // Guardar datos en la sesión
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['nombre'];
            $_SESSION['user_role'] = $user['rol'];

            // Redirigir según rol
            if ($user['rol'] === 'comprador') {
                header("Location: ../views/users/home_comprador.php");
            } elseif ($user['rol'] === 'vendedor') {
                header("Location: ../views/users/home_vendedor.php");
            } else {
                header("Location: ../views/users/home.php");
            }
            exit;
        } else {
            echo "<script>alert('Correo o contraseña incorrectos.'); window.history.back();</script>";
            exit;
        }

    } catch (PDOException $e) {
        echo "<script>alert('Error al iniciar sesión.'); window.history.back();</script>";
        // Descomenta para depurar:
        // echo "<script>console.error('".$e->getMessage()."');</script>";
        exit;
    }
}
?>
