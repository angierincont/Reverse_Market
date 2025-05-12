<?php
class solicitud {
    public $id, $precio, $tiempo_entrega, $condiciones, $id_comprador, $estado;

    public static function crear($db, $precio, $tiempo, $cond, $id_comprador) {
        $stmt = $db->prepare("INSERT INTO solicitudes (precio, tiempo_entrega, condiciones, id_comprador) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$precio, $tiempo, $cond, $id_comprador]);
    }

    public static function listarPorComprador($db, $id_comprador) {
        $stmt = $db->prepare("SELECT * FROM solicitudes WHERE id_comprador = ?");
        $stmt->execute([$id_comprador]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}


?>