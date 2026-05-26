<?php
// 1. CONEXIÓN A LA BASE DE DATOS (XAMPP)
$servidor = "localhost";
$usuario  = "root"; 
$password = ""; 
$base_datos = "tienda"; // Nombre exacto de tu base de datos en la captura

$conexion = new mysqli($servidor, $usuario, $password, $base_datos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Asegurar caracteres correctos (acentos, Ñ, etc.)
$conexion->set_charset("utf8mb4");

// 2. CONSULTAR LOS PRODUCTOS DE TU TABLA ACTUAL
$sql = "SELECT * FROM productos";
$resultado = $conexion->query($sql);

// Contenedores para agrupar dinámicamente tus categorías
$categorias = [
    'HOGAR Y COCINA' => [],
    'BELLEZA Y CUIDADO' => [],
    'VIAJE Y EXTERIORES' => [],
    'ENTRETENIMIENTO' => []
];

// 3. LECTURA DESDE LA BASE DE DATOS Y CLASIFICACIÓN
if ($resultado && $resultado->num_rows > 0) {
    while($prod = $resultado->fetch_assoc()) {
        $nombre = strtoupper($prod['nombre']);
        
        // 1. LEER LAS SUCURSALES REALES DE LA BASE DE DATOS
        // Si por alguna razón está vacío en la BD, le ponemos todas por defecto
        $lista_sucursales = !empty($prod['sucursales']) ? $prod['sucursales'] : 'CENTRO, NORTE, TEJERÍA, MATAMOROS';
        
        // Convertimos el texto "CENTRO, NORTE" en formato para JavaScript: "['CENTRO', 'NORTE']"
        $arreglo_sucursales = array_map('trim', explode(',', $lista_sucursales));
        $prod['sucursales_js'] = "['" . implode("', '", $arreglo_sucursales) . "']";
        $prod['sucursales_texto'] = strtoupper($lista_sucursales);
        
        // 2. CLASIFICACIÓN EN CATEGORÍAS POR NOMBRE
        if (strpos($nombre, 'MIST') !== false || strpos($nombre, 'PERFUME') !== false || 
            strpos($nombre, 'BROCHA') !== false || strpos($nombre, 'PEINES') !== false || 
            strpos($nombre, 'TINTE') !== false || strpos($nombre, 'FAJA') !== false || 
            strpos($nombre, 'GEL') !== false || strpos($nombre, 'ARGAN') !== false ||
            strpos($nombre, 'BODY') !== false || strpos($nombre, 'SPRAY') !== false) {
            
            $categorias['BELLEZA Y CUIDADO'][] = $prod;
            
        } elseif (strpos($nombre, 'MOCHILA') !== false || strpos($nombre, 'TERMO') !== false || 
                  strpos($nombre, 'STANLEY') !== false || strpos($nombre, 'BOLSA') !== false || 
                  strpos($nombre, 'LONA') !== false || strpos($nombre, 'MALLA') !== false || 
                  strpos($nombre, 'SOFÁ') !== false || strpos($nombre, 'BASTÓN') !== false || 
                  strpos($nombre, 'IMPERMEABLE') !== false || strpos($nombre, 'SOMBRILLA') !== false) {
            
            $categorias['VIAJE Y EXTERIORES'][] = $prod;
            
        } elseif (strpos($nombre, 'JUGUETE') !== false || strpos($nombre, 'PISTOLA') !== false || 
                  strpos($nombre, 'LEGO') !== false || strpos($nombre, 'FUNKO') !== false || 
                  strpos($nombre, 'SLIME') !== false || strpos($nombre, 'JENGA') !== false || 
                  strpos($nombre, 'LOTERIA') !== false || strpos($nombre, 'UNO') !== false || 
                  strpos($nombre, 'BARAJAS') !== false || strpos($nombre, 'LIBRO') !== false || 
                  strpos($nombre, 'CATARINA') !== false) {
            
            $categorias['ENTRETENIMIENTO'][] = $prod;
            
        } else {
            // Todo lo demás (Vajillas, Ventiladores, Cortinas, Alfombras, Vasos, Focos, Pasadores...) se va a Hogar
            $categorias['HOGAR Y COCINA'][] = $prod;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CATÁLOGO OFICIAL | RAMI SHOP</title>
    <style>
        * { box-sizing: border-box; text-transform: uppercase; margin: 0; padding: 0; }
        body { font-family: 'Times New Roman', serif; background-color: #fff; color: #000; overflow-x: hidden; }
        
        /* HEADER */
        header { background-color: #fff; padding: 10px 60px; position: sticky; top: 0; z-index: 1000; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #000; height: 90px; }
        .logo-header { height: 70px; }
        nav a { color: #000; text-decoration: none; margin-left: 30px; font-size: 0.85em; letter-spacing: 3px; font-weight: bold; cursor: pointer; }

        /* CONTENEDOR PRINCIPAL */
        .contenedor-catalogo { padding: 50px 20px; max-width: 1300px; margin: auto; }
        .titulo-principal { text-align: center; font-size: 3em; letter-spacing: 10px; margin-bottom: 60px; font-weight: 400;}
        
        /* ESTILOS DE CATEGORÍAS */
        .nombre-categoria { font-size: 1.8em; letter-spacing: 5px; border-bottom: 2px solid #F2E8DF; padding-bottom: 10px; margin: 50px 0 30px 0; font-weight: 400;}
        .grid-productos { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 40px; margin-bottom: 60px;}
        
        /* TARJETA DE PRODUCTO */
        .tarjeta-producto { text-align: center; padding: 20px; border: 1px solid #f9f9f9; transition: 0.3s; position: relative; display: flex; flex-direction: column; justify-content: space-between; height: 100%;}
        .tarjeta-producto:hover { transform: translateY(-10px); border-color: #eee; }
        .tarjeta-producto img { width: 100%; height: 220px; object-fit: contain; margin-bottom: 15px; }
        .tarjeta-producto h3 { font-size: 1em; letter-spacing: 1px; margin-bottom: 10px; height: 40px; display: flex; align-items: center; justify-content: center; font-weight: 400;}
        
        /* INFO DE STOCK */
        .stock-info { font-size: 0.65em; color: #666; margin-bottom: 15px; text-transform: none; background: #f9f9f9; padding: 5px; border-radius: 3px;}
        .sucursal-tag { color: #27ae60; font-weight: bold; }

        .precio { font-size: 1.2em; font-weight: bold; margin-bottom: 15px; display: block; color: #000;}
        .btn-comprar { width: 100%; padding: 12px; background-color: #000; color: #fff; border: none; cursor: pointer; font-weight: bold; letter-spacing: 2px; transition: 0.3s;}
        .btn-comprar:hover { background-color: #444; }

        /* CARRITO LATERAL */
        #carrito-lateral { position: fixed; right: -400px; top: 0; width: 400px; height: 100%; background: #fff; box-shadow: -5px 0 15px rgba(0,0,0,0.1); z-index: 2000; transition: 0.4s; display: flex; flex-direction: column; padding: 40px; }
        #carrito-lateral.activo { right: 0; }
        .lista-carrito { flex-grow: 1; overflow-y: auto; text-transform: none; list-style: none; margin-top: 20px; }
        .item-carrito { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .total-contenedor { border-top: 2px solid #000; padding-top: 20px; margin-top: 20px;}

        /* MODAL SUCURSALES */
        #modal-sucursales { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 3000; display: none; align-items: center; justify-content: center; }
        .sucursal-contenido { background: #fff; width: 90%; max-width: 500px; padding: 40px; text-align: center; border-radius: 2px;}
        .opcion-sucursal { border: 1px solid #eee; padding: 15px; margin-bottom: 10px; cursor: pointer; text-align: left; transition: 0.3s; }
        .opcion-sucursal:hover { background: #F2E8DF; border-color: #000; }
        .opcion-sucursal h4 { letter-spacing: 1px; margin-bottom: 5px;}
        .opcion-sucursal p { text-transform: none; font-size: 0.85em; color: #555;}
    </style>
</head>
<body>

<header>
    <a href="index.php"><img src="Imagenes/logo1.jpeg" alt="RAMI SHOP" class="logo-header"></a>
    <nav>
        <a href="index.php">INICIO</a>
        <a onclick="abrirCarrito()">CARRITO (<span id="cuenta-cart">0</span>)</a>
        <a href="contacto.php">CONTACTO</a>
    </nav>
</header>

<main class="contenedor-catalogo">
    <h1 class="titulo-principal">CATÁLOGO</h1>

    <?php 
    // Mostramos los productos dinámicamente según se agruparon
    foreach ($categorias as $nombre_cat => $lista_productos): 
        if (count($lista_productos) > 0): 
    ?>
        <h2 class="nombre-categoria"><?php echo $nombre_cat; ?></h2>
        <div class="grid-productos">
            
            <?php foreach ($lista_productos as $prod): 
                // Limpieza visual del texto de sucursales para la tarjeta
                $texto_tarjeta = (strpos($prod['sucursales_js'], 'CENTRO') !== false && strpos($prod['sucursales_js'], 'MATAMOROS') !== false && strpos($prod['sucursales_js'], 'TEJERÍA') !== false && strpos($prod['sucursales_js'], 'NORTE') !== false) 
                    ? "TODAS LAS SUCURSALES" 
                    : $prod['sucursales_texto'];
            ?>
                <div class="tarjeta-producto">
                    <img src="Imagenes/<?php echo $prod['imagen']; ?>" alt="<?php echo $prod['nombre']; ?>">
                    <h3><?php echo $prod['nombre']; ?></h3>
                    <p class="stock-info">DISPONIBLE EN: <span class="sucursal-tag"><?php echo $texto_tarjeta; ?></span></p>
                    <span class="precio">$<?php echo number_format($prod['precio'], 2); ?> MXN</span>
                    <button class="btn-comprar" onclick="agregarAlCarrito('<?php echo addslashes($prod['nombre']); ?>', <?php echo $prod['precio']; ?>, <?php echo $prod['sucursales_js']; ?>)">AÑADIR</button>
                </div>
            <?php endforeach; ?>

        </div>
    <?php 
        endif; 
    endforeach; 
    ?>
</main>

<div id="carrito-lateral">
    <div onclick="cerrarCarrito()" style="cursor:pointer; text-align:right; font-weight: bold;">✕ CERRAR</div>
    <h2 style="margin-top:20px; letter-spacing:3px;">MI LISTA</h2>
    <ul class="lista-carrito" id="items-lista"></ul>
    <div class="total-contenedor">
        <div style="display:flex; justify-content:space-between; font-weight:bold;">
            <span>TOTAL:</span>
            <span>$<span id="precio-total">0</span>.00</span>
        </div>
        <button onclick="abrirSucursales()" style="width:100%; padding:15px; background:#000; color:#fff; border:none; margin-top:20px; font-weight:bold; cursor:pointer; letter-spacing: 1px;">CONFIRMAR Y APARTAR</button>
    </div>
</div>

<div id="modal-sucursales">
    <div class="sucursal-contenido">
        <h2 style="letter-spacing:3px; margin-bottom:15px;">¿A QUÉ TIENDA IRÁS?</h2>
        <p style="text-transform:none; margin-bottom:20px; font-size:0.9em; color: #555;">Solo mostramos sucursales con STOCK COMPLETO de tu pedido.</p>
        <div id="contenedor-opciones-sucursal"></div>
        <button onclick="document.getElementById('modal-sucursales').style.display='none'" style="background:none; border:none; cursor:pointer; margin-top:20px; color: #888; font-size: 0.8em;">CANCELAR</button>
    </div>
</div>

<script>
    let carrito = [];
    let total = 0;

    const sucursalesInfo = [
        {id: 'CENTRO', nombre: 'SUCURSAL CENTRO', h: 'L-S: 8am-8pm | D: 9am-6pm'},
        {id: 'NORTE', nombre: 'SUCURSAL NORTE', h: 'L-S: 8am-9pm | D: 9am-6pm'},
        {id: 'TEJERÍA', nombre: 'SUCURSAL TEJERÍA', h: 'L-S: 8am-9pm | D: 9am-6pm'},
        {id: 'MATAMOROS', nombre: 'SUCURSAL MATAMOROS', h: 'L-S: 8am-9pm | D: 9am-6pm'}
    ];

    function agregarAlCarrito(nombre, precio, disponibles) {
        carrito.push({nombre, precio, disponibles});
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
                    <div style="text-transform: none; text-align: left;">
                        <p style="font-weight: bold; font-size: 0.9em;">${item.nombre}</p>
                        <p style="color: #666; font-size: 0.85em;">$${item.precio}.00</p>
                    </div>
                    <button onclick="eliminar(${index}, ${item.precio})" style="background:none; border:none; cursor:pointer; color: #cc0000; font-weight: bold; padding: 5px;">✕</button>
                </li>
            `;
        });
    }

    function eliminar(index, precio) {
        total -= precio;
        carrito.splice(index, 1);
        actualizarInterfaz();
        if(carrito.length === 0) cerrarCarrito();
    }

    function abrirCarrito() { document.getElementById('carrito-lateral').classList.add('activo'); }
    function cerrarCarrito() { document.getElementById('carrito-lateral').classList.remove('activo'); }

    function abrirSucursales() {
        if(carrito.length === 0) return;
        
        const contenedor = document.getElementById('contenedor-opciones-sucursal');
        contenedor.innerHTML = "";

        sucursalesInfo.forEach(suc => {
            const tieneTodoElPedido = carrito.every(prod => prod.disponibles.includes(suc.id));
            
            if(tieneTodoElPedido) {
                contenedor.innerHTML += `
                    <div class="opcion-sucursal" onclick="enviarPedido('${suc.id}')">
                        <h4>${suc.nombre}</h4>
                        <p>${suc.h}</p>
                        <p style="color: #27ae60; font-weight: bold; font-size: 0.75em; margin-top: 5px;">✅ PEDIDO COMPLETO DISPONIBLE</p>
                    </div>
                `;
            }
        });

        if(contenedor.innerHTML === "") {
            contenedor.innerHTML = `
                <div style="padding: 20px; background: #fff1f1; border: 1px solid #ffcccc; color: #cc0000; text-transform: none; border-radius: 2px;">
                    <p style="font-weight: bold; margin-bottom: 10px;">¡Lo sentimos!</p>
                    <p style="font-size: 0.9em;">Ninguna de nuestras sucursales tiene todos estos productos juntos actualmente. Prueba eliminando algún artículo para ver disponibilidad por separado.</p>
                </div>
            `;
        }
        
        cerrarCarrito();
        document.getElementById('modal-sucursales').style.display = 'flex';
    }

    function enviarPedido(sucursalElegida) {
        const telefonoOficial = "522291234567"; // <-- Pon aquí tu número de WhatsApp real
        
        let mensaje = `*NUEVO APARTADO - RAMI SHOP*%0A---%0A*TIENDA ELEGIDA:* SUCURSAL ${sucursalElegida}%0A%0A`;
        
        carrito.forEach(item => {
            mensaje += `• ${item.nombre} ($${item.precio}.00)%0A`;
        });
        
        mensaje += `%0A*TOTAL ESTIMADO: $${total}.00 MXN*%0A---%0A_He verificado stock en la web, voy para allá para confirmar y pagar._`;
        
        window.open(`https://wa.me/${telefonoOficial}?text=${mensaje}`, '_blank');
        document.getElementById('modal-sucursales').style.display = 'none';
    }
</script>

</body>
</html>