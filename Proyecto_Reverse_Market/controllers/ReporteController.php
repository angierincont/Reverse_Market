<?php
session_start();
require_once '../config/db.php'; // Asegúrate de tener la conexión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto_id = $_POST['producto_id'];
    $motivo = $_POST['motivo'];
    $comprador_id = $_SESSION['id_comprador'] ?? null;

    if ($producto_id && $motivo && $comprador_id) {
        $stmt = $conn->prepare("INSERT INTO reportes (producto_id, motivo, comprador_id, fecha_reporte) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("isi", $producto_id, $motivo, $comprador_id);

        if ($stmt->execute()) {
            echo "<script>alert('Reporte enviado correctamente'); window.location.href='../views/users/reportes.php';</script>";
        } else {
            echo "<script>alert('Error al enviar el reporte'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Datos incompletos'); window.history.back();</script>";
    }
} else {
    header('Location: ../views/users/reportes.php');
}
?>
