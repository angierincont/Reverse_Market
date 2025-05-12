<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../config/Database.php';

// Verifica si la sesión ya está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class PerfilController {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // Método para crear el perfil
    public function crearPerfil() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener datos del formulario
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];
            $descripcion = $_POST['descripcion'];
            $id_vendedor = $_POST['id_vendedor'];

            // Intentar guardar en la base de datos
            try {
                $stmt = $this->db->prepare("INSERT INTO perfiles (id_vendedor, nombre, telefono, direccion, descripcion) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$id_vendedor, $nombre, $telefono, $direccion, $descripcion]);

                // Si se guarda correctamente
                echo json_encode(['success' => true, 'message' => 'Perfil creado exitosamente.']);
            } catch (Exception $e) {
                // Manejo de errores
                echo json_encode(['success' => false, 'message' => 'Error al crear el perfil: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
        }
    }
}

// Manejo de solicitudes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $perfilController = new PerfilController();
    $perfilController->crearPerfil();
}
?>
