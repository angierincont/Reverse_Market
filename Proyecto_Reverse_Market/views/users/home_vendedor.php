<?php
session_start();

// Verifica que el usuario tenga el rol vendedor
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'vendedor') {
    header("Location: ../login.php");
    exit;
}

// Incluir conexión a BD para obtener perfil y productos
require_once '../../config/Database.php';
$db = Database::connect();
$id_vendedor = $_SESSION['user_id'];

// Obtener perfil para mostrar detalles en encabezado y sección perfil
$stmt = $db->prepare("SELECT * FROM perfiles WHERE id_vendedor = ?");
$stmt->execute([$id_vendedor]);
$perfil = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtener productos del vendedor
$stmtProductos = $db->prepare("SELECT * FROM productos WHERE id_vendedor = ?");
$stmtProductos->execute([$id_vendedor]);
$productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Panel Vendedor - Reverse Market</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
    <style>
        /* Reset y tipografía */
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        header {
            background: rgba(0,0,0,0.7);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        header h1 {
            font-weight: 700;
            font-size: 1.8rem;
            letter-spacing: 1px;
            margin: 0;
            user-select: text;
        }
        .perfil {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
        }
        .perfil img {
            width: 50px; height: 50px;
            border-radius: 50%;
            border: 2px solid #fff;
        }
        .perfil-info {
            max-width: 220px;
            user-select: none;
        }
        .perfil-info strong {
            display: block;
            font-size: 1.1rem;
            margin-bottom: 0.2rem;
        }
        .notificaciones {
            background: #27ae60;
            cursor: pointer;
            border-radius: 50%;
            width: 35px; height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: white;
            box-shadow: 0 0 10px #27ae60aa;
            transition: transform 0.3s ease;
            user-select: none;
        }
        .notificaciones:hover {
            transform: scale(1.2);
        }
        nav {
            background: rgba(0,0,0,0.6);
            padding: 0.5rem;
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
            position: sticky;
            top: 72px; /* Height of header to position nav below */
            z-index: 999;
        }
        nav button {
            background: transparent;
            border: 2px solid #fff;
            color: #fff;
            padding: 0.5rem 1.2rem;
            border-radius: 30px;
            font-weight: 600;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            user-select: none;
            outline: none;
        }
        nav button:hover,
        nav button.active {
            background: #fff;
            color: #4caf50;
            box-shadow: 0 4px 15px rgba(76,175,80,0.5);
        }
        main {
            flex-grow: 1;
            background: rgba(255,255,255,0.1);
            margin: 2rem auto 2rem; /* Added top margin to avoid overlap with fixed header/nav */
            padding: 1rem 1.5rem;
            max-width: 960px;
            border-radius: 10px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            overflow-y: auto;
        }
        h2.section-title {
            margin-bottom: 1rem;
            font-weight: 700;
            font-size: 1.5rem;
            text-align: center;
            letter-spacing: 1px;
        }
        section {
            display: none;
        }
        section.active {
            display: block;
        }
        .producto-lista {
            list-style: none;
            padding: 0;
            display: grid;
            grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
            gap: 1rem;
        }
        .producto-item {
            background: rgba(255,255,255,0.15);
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(255,255,255,0.1);
            transition: transform 0.3s ease;
            user-select: text;
        }
        .producto-item:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.3);
        }
        .producto-item h3 {
            margin: 0 0 0.5rem 0;
        }
        button.compra-btn {
            margin-top: 0.8rem;
            background: #4caf50;
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(76,175,80,0.6);
            transition: background-color 0.3s ease;
            user-select: none;
        }
        button.compra-btn:hover {
            background-color: #388e3c;
        }
        .perfil-info-seccion {
            max-width: 600px;
            margin: 0 auto;
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            padding: 1rem 2rem;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            user-select: text;
        }
        .perfil-info-seccion p {
            font-size: 1.1rem;
            margin: 0.5rem 0;
        }
        @media(max-width: 600px) {
            header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            nav {
                gap: 1rem;
                top: auto;
                position: relative;
            }
            .producto-lista {
                grid-template-columns: 1fr;
            }
            main {
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body>
<header>
  <h1>Reverse Market - Panel Vendedor</h1>
  <div class="perfil">
    <img src="/Proyecto_Reverse_Market/images/iconoreverse.icon.png" alt="Perfil" />
    <div class="perfil-info">
      <strong><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Vendedor'); ?></strong>
      <?php if ($perfil): ?>
        <p><?php echo htmlspecialchars($perfil['nombre']); ?></p>
        <p>📞 <?php echo htmlspecialchars($perfil['telefono']); ?></p>
      <?php else: ?>
        <p><em>Perfil no creado. <a href="crear_perfil.php" style="color:#fff;text-decoration:underline;">Crear Perfil</a></em></p>
      <?php endif; ?>
    </div>
    <div class="notificaciones" title="Ver solicitudes" tabindex="0" role="button" aria-pressed="false" aria-label="Notificaciones">
        🔔
    </div>
  </div>
</header>

<nav aria-label="Navegación principal">
  <button class="active" data-target="productos">PRODUCTOS</button>
  <button data-target="ofertas">OFERTAS</button>
  <button data-target="perfil">PERFIL</button>
  <button data-target="pagos">MEDIOS DE PAGO</button>
  <button onclick="window.location.href='agregar_producto.php'">AGREGAR PRODUCTO</button>
</nav>

<main>
  <section id="productos" class="active" tabindex="0">
    <h2 class="section-title">Productos</h2>
    <ul class="producto-lista" id="lista-productos">
      <?php foreach ($productos as $producto): ?>
        <li class="producto-item" tabindex="0">
          <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
          <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
          <p>Precio: $<?php echo htmlspecialchars($producto['precio']); ?></p>
          <p>Categoría: <?php echo htmlspecialchars($producto['categoria']); ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>

  <section id="ofertas" tabindex="0">
    <h2 class="section-title">Ofertas</h2>
    <p>No hay ofertas para mostrar aún.</p>
  </section>

  <section id="perfil" tabindex="0">
    <h2 class="section-title">Perfil del Vendedor</h2>
    <?php if ($perfil): ?>
      <div class="perfil-info-seccion" role="region" aria-live="polite">
        <p><strong>Nombre: </strong><?php echo htmlspecialchars($perfil['nombre']); ?></p>
        <p><strong>Teléfono: </strong><?php echo htmlspecialchars($perfil['telefono']); ?></p>
        <p><strong>Dirección: </strong><?php echo htmlspecialchars($perfil['direccion']); ?></p>
        <p><strong>Descripción: </strong><?php echo nl2br(htmlspecialchars($perfil['descripcion'])); ?></p>
      </div>
    <?php else: ?>
      <p>Aún no ha creado un perfil. <a href="crear_perfil.php" style="color:#fff;text-decoration:underline;">Crear Perfil</a></p>
    <?php endif; ?>
  </section>

  <section id="pagos" tabindex="0">
    <h2 class="section-title">Medios de Pago</h2>
    <p>Aquí puedes configurar tus medios de pago.</p>
  </section>
</main>

<script>
  // Navegación entre secciones
  const navButtons = document.querySelectorAll('nav button');
  const sections = document.querySelectorAll('main section');

  navButtons.forEach(button => {
    button.addEventListener('click', () => {
      navButtons.forEach(b => b.classList.remove('active'));
      button.classList.add('active');

      const target = button.getAttribute('data-target');
      sections.forEach(sec => {
        if (sec.id === target) {
          sec.classList.add('active');
          sec.focus();
        } else {
          sec.classList.remove('active');
        }
      });
    });
  });

  // Click en notificaciones abre página de solicitudes
  document.querySelector('.notificaciones').addEventListener('click', () => {
    window.location.href = '/Proyecto_Reverse_Market/views/users/ver_solicitudes.php';
  });
</script>
</body>
</html>
</content>
</create_file>
