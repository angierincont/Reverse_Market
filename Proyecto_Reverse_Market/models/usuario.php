<?php
class Usuario {
    public $id;
    public $nombre;
    public $correo;
    public $contraseña;
    public $rol;
    public $fecha_creacion;

    // CREATE
    public static function crear($db, $nombre, $correo, $contraseña, $rol) {
        $stmt = $db->prepare("INSERT INTO usuarios (nombre, correo, contraseña, rol) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nombre, $correo, password_hash($contraseña, PASSWORD_BCRYPT), $rol]);
    }

    // READ
    public static function obtenerPorId($db, $id) {
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // UPDATE
    public static function actualizarCorreo($db, $id, $nuevoCorreo) {
        $stmt = $db->prepare("UPDATE usuarios SET correo = ? WHERE id = ?");
        return $stmt->execute([$nuevoCorreo, $id]);
    }

    // DELETE
    public static function eliminar($db, $id) {
        $stmt = $db->prepare("DELETE FROM usuarios WHERE id = ?");
        return $stmt->execute([$id]);
    }
}


?>