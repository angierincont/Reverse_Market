document.getElementById('formAgregarProducto').addEventListener('submit', async function(e) {
    e.preventDefault(); // Evita que el formulario se envíe de forma tradicional

    const formData = new FormData(this); // Obtiene los datos del formulario

    try {
        const response = await fetch('../../controllers/ProductoController.php', {
            method: 'POST',
            body: formData,
        });

        // Verifica si la respuesta es válida
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }

        const data = await response.json(); // Intenta convertir a JSON

        if (data.success) {
            alert('Producto agregado exitosamente');
            window.location.href = 'home_vendedor.php'; // Redirige a la lista de productos
        } else {
            alert('Error al agregar el producto: ' + data.message);
        }
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
        alert('Hubo un problema al agregar el producto. Intenta nuevamente.');
    }
});


