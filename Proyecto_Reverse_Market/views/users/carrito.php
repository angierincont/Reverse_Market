<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'comprador') {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Carrito de Compras</title>
  <link rel="stylesheet" href="../../public/css/styles.css" />
</head>
<body>
  <div class="container">
    <h2>Carrito de Compras</h2>
    <div id="productos-carrito"></div>
    <button onclick="realizarCompra()">Realizar Compra</button>
  </div>

  <script>
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];

    function mostrarCarrito() {
      const productosCarritoDiv = document.getElementById('productos-carrito');
      productosCarritoDiv.innerHTML = '';

      if (carrito.length === 0) {
        productosCarritoDiv.innerHTML = '<p>No hay productos en el carrito.</p>';
        return;
      }

      carrito.forEach(productoId => {
        // Aquí deberías hacer una llamada a la base de datos para obtener los detalles del producto
        // Simularemos esto con un objeto de producto
        const producto = { id: productoId, nombre: 'Producto ' + productoId, precio: (productoId * 10).toFixed(2) }; // Simulación

        const productoDiv = document.createElement('div');
        productoDiv.innerHTML = `<h3>${producto.nombre}</h3><p>Precio: $${producto.precio}</p>`;
        productosCarritoDiv.appendChild(productoDiv);
      });
    }

    function realizarCompra() {
      // Aquí puedes implementar la lógica para realizar la compra
      alert('Compra realizada!');
      // Limpiar el carrito
      localStorage.removeItem('carrito');
      mostrarCarrito();
    }

    mostrarCarrito();
  </script>
</body>
</html>
