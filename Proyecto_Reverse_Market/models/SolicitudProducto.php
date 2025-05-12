<?php
// models/SolicitudProducto.php
class SolicitudProducto {
    public static function guardarSolicitud($producto, $comprador, $vendedor) {
        // Aquí iría el código que guarda la solicitud en la base de datos
        // Ejemplo usando PDO:
        $pdo = Database::getConnection();
        $sql = "INSERT INTO solicitudes (producto, comprador, vendedor) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$producto, $comprador, $vendedor]);
    }
}
?>
