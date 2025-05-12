<?php
require_once __DIR__ . '/../config/Database.php';

class Producto {
    public static function agregar($db, $id_vendedor, $nombre, $descripcion, $precio, $categoria) {
        $stmt = $db->prepare("INSERT INTO productos (id_vendedor, nombre, descripcion, precio, categoria) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$id_vendedor, $nombre, $descripcion, $precio, $categoria]);
    }

    public static function listarPorVendedor($db, $id_vendedor) {
        $stmt = $db->prepare("SELECT * FROM productos WHERE id_vendedor = ?");
        $stmt->execute([$id_vendedor]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
