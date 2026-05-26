let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

// CONTADOR
function actualizarContador() {
    let contador = document.getElementById("contador");
    if (contador) {
        contador.innerText = carrito.length;
    }
}

// AGREGAR
function agregarCarrito(nombre, precio) {
    carrito.push({nombre, precio});
    localStorage.setItem("carrito", JSON.stringify(carrito));
    actualizarContador();
    alert("Producto agregado 🛒");
}

// MOSTRAR CARRITO
function mostrarCarrito() {
    let contenedor = document.getElementById("lista-carrito");
    let total = 0;

    if (!contenedor) return;

    contenedor.innerHTML = "";

    carrito.forEach((item, index) => {
        total += item.precio;

        contenedor.innerHTML += `
            <div style="background:white; padding:10px; margin:10px; border-radius:10px;">
                <h3>${item.nombre}</h3>
                <p>$${item.precio}</p>
                <button onclick="eliminar(${index})">Eliminar</button>
            </div>
        `;
    });

    document.getElementById("total").innerText = "Total: $" + total;
}

// ELIMINAR
function eliminar(index) {
    carrito.splice(index, 1);
    localStorage.setItem("carrito", JSON.stringify(carrito));
    mostrarCarrito();
    actualizarContador();
}

// COMPRAR
function comprar() {
    window.location.href = "ticket.html";
}

// TICKET
function mostrarTicket() {
    let contenedor = document.getElementById("ticket");
    let total = 0;

    if (!contenedor) return;

    contenedor.innerHTML = "<h2>Gracias por tu compra 🙌</h2>";

    carrito.forEach(item => {
        total += item.precio;
        contenedor.innerHTML += `<p>${item.nombre} - $${item.precio}</p>`;
    });

    contenedor.innerHTML += `<h3>Total pagado: $${total}</h3>`;

    localStorage.removeItem("carrito");
}

// AUTO
actualizarContador();
mostrarCarrito();
mostrarTicket();