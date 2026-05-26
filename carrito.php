<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CATÁLOGO | RAMI SHOP</title>
    <style>
        * { box-sizing: border-box; text-transform: uppercase; margin: 0; padding: 0; }
        body { font-family: 'Times New Roman', serif; background-color: #fff; color: #000; overflow-x: hidden; }
        
        /* HEADER */
        header { background-color: #fff; padding: 10px 60px; position: sticky; top: 0; z-index: 1000; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #000; height: 90px; }
        .logo-header { height: 70px; }
        nav a { color: #000; text-decoration: none; margin-left: 30px; font-size: 0.85em; letter-spacing: 3px; font-weight: bold; cursor: pointer; }

        /* GRID PRODUCTOS */
        .contenedor-catalogo { padding: 50px 20px; max-width: 1300px; margin: auto; }
        .grid-productos { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 40px; margin-bottom: 60px; }
        .tarjeta-producto { text-align: center; padding: 20px; border: 1px solid #f9f9f9; transition: 0.3s; }
        .tarjeta-producto:hover { transform: translateY(-10px); border-color: #eee; }
        .tarjeta-producto img { width: 100%; height: 250px; object-fit: contain; margin-bottom: 20px; }
        .precio { font-size: 1.2em; font-weight: bold; margin-bottom: 15px; display: block; }
        .btn-comprar { width: 100%; padding: 12px; background-color: #000; color: #fff; border: none; cursor: pointer; font-weight: bold; letter-spacing: 2px; }

        /* CARRITO LATERAL PROFESIONAL */
        #carrito-lateral {
            position: fixed; right: -400px; top: 0; width: 400px; height: 100%;
            background: #fff; box-shadow: -5px 0 15px rgba(0,0,0,0.1);
            z-index: 2000; transition: 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            display: flex; flex-direction: column; padding: 40px;
        }
        #carrito-lateral.activo { right: 0; }
        .cerrar-cart { cursor: pointer; font-size: 1.5em; text-align: right; margin-bottom: 20px; }
        .lista-carrito { flex-grow: 1; overflow-y: auto; text-transform: none; list-style: none; }
        .item-carrito { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .total-contenedor { border-top: 2px solid #000; padding-top: 20px; margin-top: 20px; }
        .btn-pagar { width: 100%; padding: 15px; background: #000; color: #fff; border: none; font-weight: bold; margin-top: 20px; cursor: pointer; }
    </style>
</head>
<body>

<header>
    <a href="index.html"><img src="Imagenes/logo1.jpeg" alt="RAMI SHOP" class="logo-header"></a>
    <nav>
        <a href="index.php">INICIO</a>
        <a onclick="abrirCarrito()">CARRITO (<span id="cuenta-cart">0</span>)</a>
        <a href="contacto.php">CONTACTO</a>
    </nav>
</header>

<main class="contenedor-catalogo">
    <h1 style="text-align: center; letter-spacing: 10px; margin-bottom: 50px;">CATÁLOGO</h1>
    
    <div class="grid-productos">
        <div class="tarjeta-producto">
            <img src="Imagenes/producto12.png" alt="Vajilla">
            <h3>JUEGO DE VAJILLA</h3>
            <span class="precio">$105.00</span>
            <button class="btn-comprar" onclick="agregarAlCarrito('JUEGO DE VAJILLA', 105)">AÑADIR</button>
        </div>
        <div class="tarjeta-producto">
            <img src="Imagenes/producto1.png" alt="Sofa">
            <h3>SOFÁ INFLABLE</h3>
            <span class="precio">$245.00</span>
            <button class="btn-comprar" onclick="agregarAlCarrito('SOFÁ INFLABLE', 245)">AÑADIR</button>
        </div>
        </div>
</main>

<div id="carrito-lateral">
    <div class="cerrar-cart" onclick="cerrarCarrito()">✕</div>
    <h2 style="letter-spacing: 3px; margin-bottom: 30px;">TU BOLSA</h2>
    <ul class="lista-carrito" id="items-lista">
        </ul>
    <div class="total-contenedor">
        <div style="display: flex; justify-content: space-between; font-weight: bold;">
            <span>TOTAL:</span>
            <span>$<span id="precio-total">0</span>.00</span>
        </div>
        <button class="btn-pagar">FINALIZAR COMPRA</button>
    </div>
</div>

<script>
    let carrito = [];
    let total = 0;

    function agregarAlCarrito(nombre, precio) {
        carrito.push({nombre, precio});
        total += precio;
        actualizarInterfaz();
        abrirCarrito();
    }

    function actualizarInterfaz() {
        document.getElementById('cuenta-cart').innerText = carrito.length;
        document.getElementById('precio-total').innerText = total;
        
        const lista = document.getElementById('items-lista');
        lista.innerHTML = "";
        carrito.forEach((item, index) => {
            lista.innerHTML += `
                <li class="item-carrito">
                    <div>
                        <p style="font-weight: bold;">${item.nombre}</p>
                        <p style="font-size: 0.8em; color: #666;">$${item.precio}.00</p>
                    </div>
                    <button onclick="eliminar(${index}, ${item.precio})" style="background: none; border: none; cursor: pointer;">✕</button>
                </li>
            `;
        });
    }

    function eliminar(index, precio) {
        total -= precio;
        carrito.splice(index, 1);
        actualizarInterfaz();
    }

    function abrirCarrito() { document.getElementById('carrito-lateral').classList.add('activo'); }
    function cerrarCarrito() { document.getElementById('carrito-lateral').classList.remove('activo'); }
</script>

</body>
</html>