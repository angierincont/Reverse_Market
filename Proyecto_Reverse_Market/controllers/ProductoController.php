<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../config/Database.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class ProductoController {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // Método para listar todos los productos
    public function listarProductos() {
        $stmt = $this->db->prepare("SELECT * FROM productos");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para buscar productos por nombre o descripción
    public function buscarProductos($query) {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE nombre LIKE ? OR descripcion LIKE ?");
        $searchTerm = "%$query%";
        $stmt->execute([$searchTerm, $searchTerm]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para agregar un producto
    public function agregarProducto($id_vendedor, $nombre, $descripcion, $precio, $categoria) {
        try {
            $stmt = $this->db->prepare("INSERT INTO productos (id_vendedor, nombre, descripcion, precio, categoria) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$id_vendedor, $nombre, $descripcion, $precio, $categoria]);
            return ['success' => true, 'message' => 'Producto agregado exitosamente.'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al agregar el producto: ' . $e->getMessage()];
        }
    }
}

// Manejo de solicitudes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_vendedor = $_SESSION['user_id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];

    $productoController = new ProductoController();
    $response = $productoController->agregarProducto($id_vendedor, $nombre, $descripcion, $precio, $categoria);
    
    // Devolver respuesta JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Manejo de búsqueda de productos
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
    $query = $_GET['query'];
    $productoController = new ProductoController();
    $productos = $productoController->buscarProductos($query);
    
    // Devolver respuesta JSON
    header('Content-Type: application/json');
    echo json_encode($productos);
    exit;
}
?>
