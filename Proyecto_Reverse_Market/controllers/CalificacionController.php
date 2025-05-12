<?php
require_once __DIR__ . '/../config/Database.php';

session_start();

class CalificacionController {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function calificar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_vendedor = $_POST['id_vendedor'];
            $puntuacion = $_POST['puntuacion'];
            $comentario = $_POST['comentario'];
            $id_comprador = $_SESSION['user_id'];

            try {
                $stmt = $this->db->prepare("INSERT INTO calificaciones (id_comprador, id_vendedor, puntuacion, comentario) VALUES (?, ?, ?, ?)");
                $stmt->execute([$id_comprador, $id_vendedor, $puntuacion, $comentario]);

                echo json_encode(['success' => true, 'message' => 'Calificación enviada exitosamente.']);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error al enviar la calificación: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
        }
    }
}

// Manejo de solicitudes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $calificacionController = new CalificacionController();
    $calificacionController->calificar();
}
?>
