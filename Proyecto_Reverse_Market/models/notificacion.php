<?php
class Notificacion {
    public static function enviar($db, $id_usuario, $mensaje) {
        $stmt = $db->prepare("INSERT INTO notificaciones (mensaje, id_usuario_destino) VALUES (?, ?)");
        return $stmt->execute([$mensaje, $id_usuario]);
    }
}


?>