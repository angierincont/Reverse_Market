<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Agregar Producto</h2>
        <form id="formAgregarProducto">
            <input type="text" name="nombre" placeholder="Nombre del producto" required>
            <input type="text" name="descripcion" placeholder="Descripción" required>
            <input type="number" name="precio" placeholder="Precio" required>
            <input type="text" name="categoria" placeholder="Categoría" required>
            <button type="submit">Agregar Producto</button>
        </form>
    </div>

    <script src="../../public/js/agregar_producto.js"></script> <!-- Asegúrate de que la ruta sea correcta -->
</body>
</html>
