<?php

class Transaccion {
    public static function crear($db, $id_comprador, $id_vendedor, $id_oferta) {
        $stmt = $db->prepare("INSERT INTO transacciones (id_comprador, id_vendedor, id_oferta, estado) VALUES (?, ?, ?, 'pendiente')");
        return $stmt->execute([$id_comprador, $id_vendedor, $id_oferta]);
    }
}

?>