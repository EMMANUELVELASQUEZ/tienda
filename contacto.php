<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONTACTO | RAMI SHOP</title>
    <style>
        * { box-sizing: border-box; text-transform: uppercase; margin: 0; padding: 0; }
        body { font-family: 'Times New Roman', serif; background-color: #fff; color: #000; line-height: 1.6; }
        
        /* HEADER IGUAL AL CATÁLOGO */
        header { background-color: #fff; padding: 10px 60px; position: sticky; top: 0; z-index: 1000; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #000; height: 90px; }
        .logo-header { height: 70px; }
        nav a { color: #000; text-decoration: none; margin-left: 30px; font-size: 0.85em; letter-spacing: 3px; font-weight: bold; }

        .seccion-contacto { padding: 80px 20px; max-width: 1200px; margin: auto; }
        .titulo-contacto { text-align: center; font-size: 3em; letter-spacing: 10px; margin-bottom: 20px; font-weight: 400; }
        .subtitulo { text-align: center; text-transform: none; color: #666; margin-bottom: 60px; font-style: italic; }

        /* GRID PRINCIPAL: FORMULARIO E INFO */
        .grid-contacto { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: start; }

        /* FORMULARIO PROFESIONAL */
        .formulario-contenedor h2 { letter-spacing: 3px; margin-bottom: 30px; font-size: 1.2em; border-bottom: 1px solid #000; padding-bottom: 10px; }
        .campo { margin-bottom: 25px; }
        .campo label { display: block; font-size: 0.75em; letter-spacing: 2px; margin-bottom: 8px; font-weight: bold; }
        .campo input, .campo textarea { width: 100%; padding: 15px; border: 1px solid #eee; background: #f9f9f9; font-family: 'Times New Roman', serif; outline: none; transition: 0.3s; }
        .campo input:focus, .campo textarea:focus { border-color: #000; background: #fff; }
        .btn-enviar { background: #000; color: #fff; border: none; padding: 18px 40px; cursor: pointer; letter-spacing: 3px; font-weight: bold; width: 100%; transition: 0.4s; }
        .btn-enviar:hover { background: #444; }

        /* INFO DE SUCURSALES */
        .info-sucursales h2 { letter-spacing: 3px; margin-bottom: 30px; font-size: 1.2em; border-bottom: 1px solid #000; padding-bottom: 10px; }
        .sucursal-item { margin-bottom: 35px; }
        .sucursal-item h3 { font-size: 1em; letter-spacing: 2px; margin-bottom: 10px; display: flex; align-items: center; }
        .sucursal-item h3::before { content: '📍'; margin-right: 10px; }
        .sucursal-item p { text-transform: none; font-size: 0.9em; color: #444; margin-bottom: 5px; }
        .horario-tag { font-weight: bold; color: #000; display: block; margin-top: 5px; }

        /* REDES SOCIALES */
        .redes-sociales { margin-top: 50px; text-align: center; padding: 40px; background: #fdfaf8; }
        .redes-sociales h3 { letter-spacing: 5px; margin-bottom: 20px; font-size: 0.9em; }
        .iconos { display: flex; justify-content: center; gap: 30px; }
        .icono-link { text-decoration: none; color: #000; font-size: 0.8em; letter-spacing: 2px; font-weight: bold; border: 1px solid #000; padding: 10px 20px; transition: 0.3s; }
        .icono-link:hover { background: #000; color: #fff; }

        @media (max-width: 768px) {
            .grid-contacto { grid-template-columns: 1fr; gap: 40px; }
            header { padding: 10px 20px; }
        }
    </style>
</head>
<body>

<header>
    <a href="index.php"><img src="Imagenes/logo1.jpeg" alt="RAMI SHOP" class="logo-header"></a>
    <nav>
        <a href="index.php">INICIO</a>
        <a href="catalogo.php">CATÁLOGO</a>
        <a href="contacto.php" style="border-bottom: 1px solid #000;">CONTACTO</a>
    </nav>
</header>

<main class="seccion-contacto">
    <h1 class="titulo-contacto">ATENCIÓN AL CLIENTE</h1>
    <p class="subtitulo">Estamos para servirte en cualquiera de nuestras sucursales en Veracruz.</p>

    <div class="grid-contacto">
        <div class="formulario-contenedor">
            <h2>ENVÍANOS UN MENSAJE</h2>
            <form action="#">
                <div class="campo">
                    <label>NOMBRE COMPLETO</label>
                    <input type="text" placeholder="EJ. LEONARDO RAMÍREZ" required>
                </div>
                <div class="campo">
                    <label>CORREO ELECTRÓNICO</label>
                    <input type="email" placeholder="CORREO@EJEMPLO.COM" required>
                </div>
                <div class="campo">
                    <label>ASUNTO</label>
                    <input type="text" placeholder="EJ. CONSULTA DE MAYOREO">
                </div>
                <div class="campo">
                    <label>MENSAJE</label>
                    <textarea rows="6" placeholder="ESCRIBE TU MENSAJE AQUÍ..."></textarea>
                </div>
                <button type="submit" class="btn-enviar">ENVIAR MENSAJE</button>
            </form>
        </div>

        <div class="info-sucursales">
            <h2>NUESTRAS UBICACIONES</h2>
            
            <div class="sucursal-item">
                <h3>SUCURSAL CENTRO</h3>
                <p>Centro Histórico, Veracruz, Ver.</p>
                <span class="horario-tag">L-S: 8:00 AM - 8:00 PM | D: 9:00 AM - 6:00 PM</span>
            </div>

            <div class="sucursal-item">
                <h3>SUCURSAL NORTE</h3>
                <p>Zona Norte, Veracruz, Ver.</p>
                <span class="horario-tag">L-S: 8:00 AM - 9:00 PM | D: 9:00 AM - 6:00 PM</span>
            </div>

            <div class="sucursal-item">
                <h3>SUCURSAL TEJERÍA</h3>
                <p>Av. Principal Tejería, Veracruz.</p>
                <span class="horario-tag">L-S: 8:00 AM - 9:00 PM | D: 9:00 AM - 6:00 PM</span>
            </div>

            <div class="sucursal-item">
                <h3>SUCURSAL MATAMOROS</h3>
                <p>Fracc. Los Pinos / Matamoros, Veracruz.</p>
                <span class="horario-tag">L-S: 8:00 AM - 9:00 PM | D: 9:00 AM - 6:00 PM</span>
            </div>
        </div>
    </div>

    <div class="redes-sociales">
        <h3>SÍGUENOS EN NUESTRAS REDES</h3>
        <div class="iconos">
            <a href="#" class="icono-link">FACEBOOK</a>
            <a href="#" class="icono-link">INSTAGRAM</a>
            <a href="https://wa.me/522291234567" class="icono-link">WHATSAPP</a>
        </div>
    </div>
</main>

<footer style="text-align: center; padding: 40px; font-size: 0.7em; letter-spacing: 2px; color: #888; border-top: 1px solid #eee; margin-top: 50px;">
    © 2026 RAMI SHOP - TODOS LOS DERECHOS RESERVADOS.
</footer>

</body>
</html>