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
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Buscar productos - Comprador</title>
  <style>
    /* Estilos globales y reset básico */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background: linear-gradient(to right, #4facfe, #00f2fe);
        color: #333;
        padding: 20px;
    }

    header {
        text-align: center;
        margin-bottom: 20px;
        color: white;
    }

    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #0066cc;
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .hamburger {
        font-size: 24px;
        background: none;
        border: none;
        color: white;
        cursor: pointer;
    }

    .side-menu {
        position: fixed;
        top: 60px;
        left: 0;
        width: 200px;
        height: calc(100% - 60px);
        background-color: #004080;
        color: white;
        padding: 20px;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease;
        z-index: 1000;
    }

    .side-menu ul {
        list-style: none;
    }

    .side-menu ul li {
        margin-bottom: 15px;
    }

    .side-menu ul li a {
        color: white;
        text-decoration: none;
        font-weight: bold;
    }

    .side-menu.hidden {
        transform: translateX(-100%);
    }

    .cart-container {
        cursor: pointer;
        position: relative;
        font-size: 22px;
    }

    .cart-count {
        position: absolute;
        top: -10px;
        right: -10px;
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 12px;
    }

    .cart-modal {
        position: fixed;
        top: 70px;
        right: 20px;
        background: white;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        max-width: 300px;
        z-index: 1000;
    }

    .cart-modal.hidden {
        display: none;
    }

    .cart-modal h3 {
        margin-bottom: 10px;
    }

    .cart-modal ul {
        list-style: none;
        padding: 0;
    }

    .cart-modal li {
        margin-bottom: 8px;
    }

    .cart-modal button {
        margin-left: 10px;
        background: red;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 2px 6px;
        cursor: pointer;
    }

    #busqueda {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        margin-bottom: 20px;
        border-radius: 8px;
        border: none;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    #resultado {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .producto {
        background-color: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .producto:hover {
        transform: scale(1.02);
    }

    .producto img {
        max-width: 100%;
        max-height: 150px;
        object-fit: contain;
        margin-bottom: 15px;
        border-radius: 8px;
        box-shadow: 0 1px 5px rgba(0,0,0,0.2);
    }

    .producto h3 {
        margin-bottom: 10px;
        color: #0066cc;
        cursor: pointer;
        text-align: center;
    }

    .producto p {
        text-align:center;
        margin-bottom: 5px;
    }

    .producto button {
        margin-top: 10px;
        margin-right: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        padding: 8px 14px;
        border-radius: 6px;
        cursor: pointer;
    }

    .producto button:last-child {
        background-color: #28a745;
    }

    .producto button:hover {
        opacity: 0.9;
    }

    #bienvenida {
        font-size: 18px;
        margin-bottom: 20px;
        color: white;
        text-align: center;
    }

    @media (max-width: 600px) {
        .producto {
          padding: 15px;
        }
        .producto h3 {
          font-size: 18px;
        }
        .producto button {
          padding: 6px 10px;
          font-size: 14px;
        }
        .top-bar {
          flex-direction: column;
          align-items: flex-start;
        }
    }
  </style>
</head>

<body>

<div class="top-bar">
  <button id="menu-toggle" class="hamburger">&#9776;</button>
  <div class="cart-container">
    <span class="cart-count">0</span>
    🛒
  </div>
</div>

<div id="side-menu" class="side-menu hidden">
  <ul>
    <li><a href="#reportar">Reportar Problema</a></li>
    <li><a href="#inicio">Inicio</a></li>
    <li><a href="#como-funciona">Cómo funciona</a></li>
    <li><a href="#contacto">Contacto</a></li>
  </ul>
</div>

<div id="cart-modal" class="cart-modal hidden">
  <h3>Carrito de Compras</h3>
  <ul id="cart-items"></ul>
</div>

<header>
  <h1>Buscar productos - Reverse Market</h1>
</header>

<main>
  <div id="bienvenida">Bienvenido, <span id="nombre-comprador">Usuario</span></div>

  <input type="text" id="busqueda" placeholder="¿Qué estás buscando?" />
  <div id="resultado"></div>
</main>

<script>
  // Obtiene el nombre del comprador desde la sesión PHP, o muestra "Usuario" si no existe
  const nombreUsuario = "<?php echo $_SESSION['nombre_comprador'] ?? 'Usuario'; ?>";
  document.getElementById("nombre-comprador").textContent = nombreUsuario;

  // Array de productos disponibles simulados con imágenes locales
  const productos = [
    { nombre: "Laptop Dell", categoria: "Tecnología", descripcion: "Intel i5, 8GB RAM, SSD 256GB", id_vendedor: "vendedor1", vistas: 0, imagen: "img/laptop_dell.png" },
    { nombre: "Cafetera eléctrica", categoria: "Electrodomésticos", descripcion: "600W, color negro", id_vendedor: "vendedor2", vistas: 0, imagen: "img/cafetera.png" },
    { nombre: "Mesa de comedor", categoria: "Hogar", descripcion: "6 puestos, madera natural", id_vendedor: "vendedor3", vistas: 0, imagen: "img/comedor.png" },
    { nombre: "Teléfono Xiaomi", categoria: "Tecnología", descripcion: "Redmi Note 12, 128GB", id_vendedor: "vendedor1", vistas: 0, imagen: "img/celular.png" },
    { nombre: "Bicicleta de montaña", categoria: "Deporte", descripcion: "Rodado 29, suspensión delantera", id_vendedor: "vendedor2", vistas: 0, imagen: "img/bici.png" }
  ];

  // Inicialización de elementos del carrito y otros elementos del DOM
  const cart = {};
  const cartModal = document.getElementById('cart-modal');
  const cartCount = document.querySelector('.cart-count');
  const cartItems = document.getElementById('cart-items');
  const cartIcon = document.querySelector('.cart-container');
  const sideMenu = document.getElementById('side-menu');
  const menuToggle = document.getElementById('menu-toggle');
  const resultado = document.getElementById("resultado");
  const busquedaInput = document.getElementById("busqueda");

  // Creación dinámica del modal de detalles del producto
  const detailModal = document.createElement('div');
  detailModal.id = 'detail-modal';
  detailModal.style.cssText = `
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    border-radius: 12px;
    max-width: 90%;
    max-height: 80%;
    overflow-y: auto;
    box-shadow: 0 0 15px rgba(0,0,0,0.4);
    padding: 20px;
    z-index: 1500;
    display: none;
  `;
  document.body.appendChild(detailModal);

  // Oculta el modal de detalles
  function closeDetailModal() {
    detailModal.style.display = 'none';
  }

  // Muestra detalles del producto en el modal
  function showProductDetails(product) {
    product.vistas++;

    detailModal.innerHTML = `
      <h2>${product.nombre}</h2>
      <img src="${product.imagen}" alt="${product.nombre}" style="max-width:100%; max-height:200px; margin-bottom:15px; border-radius:8px; object-fit:contain;">
      <p><strong>Categoría:</strong> ${product.categoria}</p>
      <p><strong>Descripción:</strong> ${product.descripcion}</p>
      <p><strong>Vistas:</strong> ${product.vistas}</p>
      <button id="solicitar-btn">Solicitar este producto</button>
      <button id="agregar-btn">Agregar al carrito</button>
      <button id="cerrar-btn" style="margin-top:15px; background:#dc3545;">Cerrar</button>
    `;
    detailModal.style.display = 'block';

    // Cierra el modal
    document.getElementById('cerrar-btn').addEventListener('click', closeDetailModal);

    // Solicita el producto
    document.getElementById('solicitar-btn').addEventListener('click', () => {
      publicarSolicitud(product.nombre, product.id_vendedor);
      alert("Solicitud enviada al vendedor.");
      closeDetailModal();
    });

    // Agrega producto al carrito
    document.getElementById('agregar-btn').addEventListener('click', () => {
      addToCart(product.nombre);
      showNotification(`"${product.nombre}" agregado al carrito.`);
      closeDetailModal();
    });

    renderCart();
  }

  // Renderiza los productos agregados al carrito
  function renderCart() {
    cartItems.innerHTML = '';
    const keys = Object.keys(cart);
    if(keys.length === 0){
      cartItems.innerHTML = '<li>El carrito está vacío</li>';
    } else {
      keys.forEach(productName => {
        const li = document.createElement('li');
        li.innerHTML = `
          ${productName} x${cart[productName]}
          <button onclick="removeFromCart('${productName}')">❌</button>
        `;
        cartItems.appendChild(li);
      });
    }
    cartCount.textContent = keys.reduce((sum, k) => sum + cart[k], 0);
  }

  // Agrega producto al carrito
  function addToCart(productName) {
    if(cart[productName]){
      cart[productName]++;
    } else {
      cart[productName] = 1;
    }
    renderCart();
  }

  // Elimina producto del carrito
  function removeFromCart(productName) {
    if(cart[productName]){
      cart[productName]--;
      if(cart[productName] <= 0){
        delete cart[productName];
      }
      renderCart();
    }
  }

  // Muestra/oculta el carrito al hacer clic en el ícono
  cartIcon.addEventListener('click', () => {
    cartModal.classList.toggle('hidden');
  });

  // Muestra una notificación flotante al agregar producto
  function showNotification(message) {
    let notification = document.createElement('div');
    notification.textContent = message;
    notification.style.cssText = `
      position: fixed;
      top: 20px;
      right: 20px;
      background: #28a745;
      color: white;
      padding: 12px 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.3);
      opacity: 0;
      z-index: 1600;
      transition: opacity 0.5s ease;
      font-weight: bold;
    `;
    document.body.appendChild(notification);
    requestAnimationFrame(() => {
      notification.style.opacity = '1';
    });
    setTimeout(() => {
      notification.style.opacity = '0';
      notification.addEventListener('transitionend', () => notification.remove());
    }, 2000);
  }

  // Resalta el término buscado en los resultados
  function highlightTerm(text, term) {
    if(!term) return text;
    const regex = new RegExp(`(${term.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
    return text.replace(regex, '<mark>$1</mark>');
  }

  // Renderiza los productos en la pantalla
  function renderProducts(filtrados, filtro) {
    resultado.innerHTML = '';

    if (filtrados.length === 0) {
      resultado.innerHTML = "<p style='color:white;'>No se encontraron productos.</p>";
      return;
    }

    filtrados.forEach(p => {
      const div = document.createElement('div');
      div.className = 'producto';

      div.innerHTML = `
        <img src="${p.imagen}" alt="${p.nombre}" />
        <h3 class="clickable">${highlightTerm(p.nombre, filtro)}</h3>
        <p><strong>Categoría:</strong> ${highlightTerm(p.categoria, filtro)}</p>
        <p>${highlightTerm(p.descripcion, filtro)}</p>
        <button class="solicitar-btn">Solicitar este producto</button>
        <button class="agregar-btn">Agregar al carrito</button>
      `;

      // Evento para mostrar detalles
      div.querySelector('h3').addEventListener('click', () => {
        showProductDetails(p);
      });

      // Evento para solicitar producto
      div.querySelector('.solicitar-btn').addEventListener('click', () => {
        publicarSolicitud(p.nombre, p.id_vendedor);
        alert("Solicitud enviada al vendedor.");
      });

      // Evento para agregar al carrito
      div.querySelector('.agregar-btn').addEventListener('click', () => {
        addToCart(p.nombre);
        showNotification(`"${p.nombre}" agregado al carrito.`);
      });

      resultado.appendChild(div);
    });
  }

  // Filtro de productos según la búsqueda del usuario
  busquedaInput.addEventListener("input", function () {
    const filtro = this.value.trim().toLowerCase();
    const filtrados = productos.filter(p =>
      p.nombre.toLowerCase().includes(filtro) ||
      p.categoria.toLowerCase().includes(filtro) ||
      p.descripcion.toLowerCase().includes(filtro)
    );

    renderProducts(filtrados, filtro);
  });

  // Publica una solicitud al vendedor vía API
  function publicarSolicitud(nombreProducto, idVendedor) {
    const comprador = nombreUsuario;
    fetch('/Proyecto_Reverse_Market/public/api/guardar_notificacion.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        producto: nombreProducto,
        comprador: comprador,
        id_vendedor: idVendedor
      })
    }).catch(() => {
      alert("Error al enviar la solicitud.");
    });
  }

  // Muestra/oculta el menú lateral
  menuToggle.addEventListener("click", () => {
    sideMenu.classList.toggle("hidden");
  });

  // Renderiza todos los productos al inicio
  renderProducts(productos, '');

  // Expone la función de eliminar al ámbito global
  window.removeFromCart = removeFromCart;
</script>

</body>
</html>
</content>
</create_file>
