<?php
require_once 'models/solicitud.php';

class SolicitudController {
    public function solicitar() {
        session_start();

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 'comprador') {
            echo "<script>alert('Solo los compradores pueden hacer solicitudes.'); window.location='index.php';</script>";
            exit;
        }

        if (isset($_POST['precio'], $_POST['tiempo_entrega'], $_POST['condiciones'])) {
            $id_comprador = $_SESSION['usuario']['id'];
            $precio = $_POST['precio'];
            $tiempo_entrega = $_POST['tiempo_entrega'];
            $condiciones = $_POST['condiciones'];

            $solicitud = new Solicitud();
            $resultado = $solicitud->crear($id_comprador, $precio, $tiempo_entrega, $condiciones);

            if ($resultado) {
                echo "<script>alert('Solicitud enviada con éxito.'); window.location='index.php';</script>";
            } else {
                echo "<script>alert('No se pudo enviar la solicitud.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Faltan datos para realizar la solicitud.'); window.history.back();</script>";
        }
    }
}
