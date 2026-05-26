<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAMI SHOP | INICIO</title>
    <style>
        /* --- ESTILOS DE DISEÑO --- */
        * { box-sizing: border-box; text-transform: uppercase; margin: 0; padding: 0; }

        body {
            font-family: 'Times New Roman', serif;
            background-color: #F2E8DF; /* Color crema de tu logo */
            color: #000;
            scroll-behavior: smooth;
            overflow-x: hidden;
        }

        /* Menú superior elegante */
        header {
            background-color: #fff;
            padding: 10px 60px;
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #000;
            height: 90px;
        }

        .logo-header { height: 70px; }

        nav {
            display: flex;
            align-items: center;
        }

        nav a {
            color: #000;
            text-decoration: none;
            margin-left: 30px;
            font-size: 0.85em;
            letter-spacing: 3px;
            font-weight: bold;
            transition: 0.3s;
        }

        nav a:hover { color: #888; }

        /* ESTILO ESPECIAL PARA EL BOTÓN DE CUENTA */
        .btn-cuenta {
            background-color: #000;
            color: #fff !important; /* Forzamos el color blanco */
            padding: 10px 20px;
            border-radius: 2px;
            transition: 0.4s;
        }

        .btn-cuenta:hover {
            background-color: #444;
            color: #fff !important;
        }

        /* SECCIÓN DE BIENVENIDA GIGANTE (LANDING PAGE) */
        .bienvenida {
            height: calc(100vh - 90px); 
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 40px;
        }

        .bienvenida h2 { 
            font-size: 8vw; 
            letter-spacing: 20px; 
            margin-bottom: 20px;
            line-height: 1;
            font-weight: 400;
            animation: fadeIn 2s;
        }
        
        .bienvenida p { 
            font-size: 1.2em; 
            max-width: 800px; 
            text-transform: none; 
            line-height: 1.8; 
            margin-bottom: 50px;
            letter-spacing: 1px;
            color: #333;
        }

        /* Botón que lleva al catálogo separado */
        .btn-ver-mas {
            padding: 22px 70px;
            background-color: #000;
            color: #F2E8DF;
            text-decoration: none;
            font-weight: bold;
            border: 1px solid #000;
            transition: 0.4s;
            letter-spacing: 4px;
            cursor: pointer;
        }

        .btn-ver-mas:hover { 
            background-color: transparent; 
            color: #000; 
        }

        /* Animación simple para el título */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* WhatsApp Flotante */
        .whatsapp {
            position: fixed;
            bottom: 40px;
            right: 40px;
            background: #25d366;
            width: 65px; height: 65px;
            border-radius: 50%;
            text-align: center;
            line-height: 65px;
            font-size: 35px;
            color: white;
            text-decoration: none;
            z-index: 2000;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        footer { 
            background-color: #000; 
            color: #F2E8DF; 
            text-align: center; 
            padding: 60px;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>

<header>
    <img src="Imagenes/logo1.jpeg" alt="RAMI SHOP" class="logo-header">
    
    <nav>
        <a href="index.php">INICIO</a>
        <a href="catalogo.php">CATÁLOGO</a>
        <a href="contacto.php">CONTACTO</a>
        <a href="login.php" class="btn-cuenta">MI CUENTA</a>
    </nav>
</header>

<section id="inicio" class="bienvenida">
    <h2>BIENVENIDO</h2>
    <p>A LA EXPERIENCIA DE RAMI SHOP. ARTÍCULOS IMPORTADOS CON GRAN VARIEDAD Y EXCELENTES PRECIOS PARA TU HOGAR.</p>
    
    <a href="catalogo.php" class="btn-ver-mas">VER CATÁLOGO COMPLETO</a>
</section>

<a href="https://wa.me/5562325524" class="whatsapp" target="_blank">💬</a>

<footer>
    <p>© 2026 RAMI SHOP MX - EXCLUSIVIDAD Y CALIDAD</p>
</footer>

</body>
</html>