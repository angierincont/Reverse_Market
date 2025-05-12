<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Buscar productos - Comprador</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(to right, #56cc9d, #2f80ed);
    }
    header {
      background: #004a7c;
      color: white;
      padding: 1em;
      text-align: center;
    }
    main {
      padding: 2em;
    }
    #bienvenida {
      background: rgba(255,255,255,0.8);
      padding: 1em;
      border-left: 5px solid #2f80ed;
      margin-bottom: 1.5em;
      font-weight: bold;
      border-radius: 5px;
    }
    input {
      width: 100%;
      padding: 0.7em;
      margin-bottom: 1em;
      font-size: 1em;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    .producto {
      background: white;
      padding: 1em;
      border-radius: 10px;
      margin-bottom: 1em;
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
    }
    .producto button {
      background: #2f80ed;
      color: white;
      border: none;
      padding: 0.5em 1em;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 0.5em;
    }
  </style>
</head>
<body>
  <header>
    <h1>Buscar productos - Reverse Market</h1>
  </header>

  <main>
    <div id="bienvenida">Bienvenido, <span id="nombre-comprador">Usuario</span></div>

    <input type="text" id="busqueda" placeholder="¿Qué estás buscando?" />
    <div id="resultado"></div>
  </main>

  <script>
    const nombreUsuario = localStorage.getItem("comprador") || "Usuario";
    document.getElementById("nombre-comprador").textContent = nombreUsuario;

    const productos = [
      { nombre: "Laptop Dell", categoria: "Tecnología", descripcion: "Intel i5, 8GB RAM, SSD 256GB" },
      { nombre: "Cafetera eléctrica", categoria: "Electrodomésticos", descripcion: "600W, color negro" },
      { nombre: "Mesa de comedor", categoria: "Hogar", descripcion: "6 puestos, madera natural" },
      { nombre: "Teléfono Xiaomi", categoria: "Tecnología", descripcion: "Redmi Note 12, 128GB" },
      { nombre: "Bicicleta de montaña", categoria: "Deporte", descripcion: "Rodado 29, suspensión delantera" }
    ];

    document.getElementById("busqueda").addEventListener("input", function () {
      const filtro = this.value.toLowerCase();
      const resultado = document.getElement
