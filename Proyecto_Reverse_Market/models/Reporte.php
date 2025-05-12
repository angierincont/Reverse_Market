<?php
require_once 'config/db.php';

class Reporte {
    private $conn;

    public function __construct() {
        $this->conn = Database::conectar();
    }

    public function crearReporte($id_usuario, $id_producto, $motivo) {
        $sql = "INSERT INTO reportes (id_usuario, id_producto, motivo) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id_usuario, $id_producto, $motivo]);
    }

    public function obtenerReportesPorUsuario($id_usuario) {
        $sql = "SELECT r.*, p.nombre AS producto FROM reportes r 
                JOIN productos p ON r.id_producto = p.id 
                WHERE r.id_usuario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
