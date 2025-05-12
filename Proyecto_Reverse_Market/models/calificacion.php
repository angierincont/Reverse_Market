<?php
class Calificacion {
    public static function calificar($db, $id_comprador, $id_vendedor, $id_transaccion, $puntos, $comentario) {
        $stmt = $db->prepare("INSERT INTO calificaciones (id_comprador, id_vendedor, id_transaccion, puntuacion, comentario) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$id_comprador, $id_vendedor, $id_transaccion, $puntos, $comentario]);
    }
}


?>