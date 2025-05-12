<?php

class Oferta {
    public static function crear($db, $id_solicitud, $id_vendedor, $precio, $tiempo, $cond) {
        $stmt = $db->prepare("INSERT INTO ofertas (id_solicitud, id_vendedor, precio, tiempo_entrega, condiciones) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$id_solicitud, $id_vendedor, $precio, $tiempo, $cond]);
    }
}

?>