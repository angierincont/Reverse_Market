<?php
// config/db.php

// Define el host de la base de datos (usualmente localhost en entornos locales)
$host = 'localhost';

// Define el nombre de la base de datos a la que se va a conectar
$db   = 'reverse_market'; // ← Cambia esto si usas un nombre diferente

// Usuario de la base de datos (por defecto en XAMPP es 'root')
$user = 'root'; // o el usuario que estés usando

// Contraseña del usuario de la base de datos (vacía por defecto en XAMPP)
$pass = '';     // si no tienes contraseña en XAMPP

// Define el conjunto de caracteres a usar en la conexión
$charset = 'utf8mb4';

// Construye el DSN (Data Source Name) para la conexión PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Opciones de configuración para PDO
$options = [
    // Lanza excepciones si ocurre un error en la conexión o consulta
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,

    // Devuelve los resultados como arrays asociativos por defecto
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

    // Desactiva la emulación de sentencias preparadas, mejora la seguridad
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Intenta establecer la conexión a la base de datos usando PDO
try {
    // Crea una nueva instancia de PDO con los parámetros definidos
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Si ocurre un error, detiene la ejecución y muestra el mensaje de error
    die('Error de conexión a la base de datos: ' . $e->getMessage());
}


