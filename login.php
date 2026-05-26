<?php
session_start();
require_once 'db.php';

$error_login = "";
$error_registro = "";
$registro_exitoso = false;
$nombre_registrado = "";

// Variable para controlar qué pestaña se queda activa al recargar
$tab_activa = "login"; 

// 2. LÓGICA DE PROCESAMIENTO DE FORMULARIOS
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // ACCIÓN: INICIAR SESIÓN
    if (isset($_POST['accion_login'])) {
        $tab_activa = "login";
        $correo = $conexion->real_escape_string($_POST['correo_login']);
        $pass = $_POST['password_login'];

        $sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
        $resultado = $conexion->query($sql);

        if ($resultado && $resultado->num_rows > 0) {
            $usuario_db = $resultado->fetch_assoc();
            if ($pass == $usuario_db['password']) {
                $_SESSION['usuario_nombre'] = $usuario_db['nombre'];
                header("Location: catalogo.php");
                exit();
            } else {
                $error_login = "CONTRASEÑA INCORRECTA";
            }
        } else {
            $error_login = "EL CORREO NO ESTÁ REGISTRADO";
        }
    }
    
    // ACCIÓN: REGISTRARSE
    if (isset($_POST['accion_registro'])) {
        $tab_activa = "registro";
        $nombre = $conexion->real_escape_string($_POST['nombre_reg']);
        $correo = $conexion->real_escape_string($_POST['correo_reg']);
        $pass = $_POST['password_reg'];
        $pass_conf = $_POST['password_reg_conf'];

        if ($pass !== $pass_conf) {
            $error_registro = "LAS CONTRASEÑAS NO COINCIDEN";
        } else {
            // Verificar si el correo ya existe
            $check_correo = $conexion->query("SELECT id FROM usuarios WHERE correo = '$correo'");
            if ($check_correo && $check_correo->num_rows > 0) {
                $error_registro = "EL CORREO YA ESTÁ REGISTRADO";
            } else {
                // Insertar usuario de forma real
                $sql_ins = "INSERT INTO usuarios (nombre, correo, password) VALUES ('$nombre', '$correo', '$pass')";
                if ($conexion->query($sql_ins)) {
                    $registro_exitoso = true;
                    $nombre_registrado = strtoupper($nombre);
                } else {
                    $error_registro = "ERROR AL GUARDAR EN LA BASE DE DATOS";
                }
            }
        }
    }
}
$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MI CUENTA | RAMI SHOP</title>
    <style>
        /* ESTILOS EXCLUSIVOS PARA ESTA PÁGINA */
        * { box-sizing: border-box; }

        body {
            font-family: 'Times New Roman', serif;
            background-color: #F2E8DF;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: #fff;
            padding: 10px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #000;
            height: 90px;
        }

        .logo-header { height: 70px; }

        nav a {
            color: #000;
            text-decoration: none;
            margin-left: 30px;
            font-size: 0.85em;
            letter-spacing: 3px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* CAJA DE LOGIN/REGISTRO */
        .contenedor-login {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .caja-auth {
            background: #fff;
            width: 100%;
            max-width: 450px;
            padding: 50px;
            border: 1px solid #000;
            box-shadow: 10px 10px 0px rgba(0,0,0,0.1);
        }

        .tabs { display: flex; margin-bottom: 30px; border-bottom: 1px solid #eee; }
        
        .tab {
            flex: 1;
            text-align: center;
            padding: 15px;
            cursor: pointer;
            letter-spacing: 2px;
            font-size: 0.8em;
            color: #888;
            text-transform: uppercase;
        }

        .tab.activa {
            color: #000;
            border-bottom: 2px solid #000;
            font-weight: bold;
        }

        .form-seccion { display: none; }
        .form-seccion.activo { display: block; }

        h2 { 
            font-size: 1.5em; 
            letter-spacing: 5px; 
            margin-bottom: 30px; 
            text-align: center; 
            text-transform: uppercase;
        }
        
        .campo { margin-bottom: 20px; }
        
        .campo label { 
            display: block; 
            font-size: 0.7em; 
            letter-spacing: 2px; 
            margin-bottom: 8px; 
            font-weight: bold; 
            text-transform: uppercase;
        }

        /* ALERTA DE ERROR ESTILIZADA */
        .msg-error {
            background: #fff1f1;
            border: 1px solid #cc0000;
            color: #cc0000;
            padding: 12px;
            margin-bottom: 25px;
            font-size: 0.8em;
            font-weight: bold;
            letter-spacing: 1px;
            text-align: center;
            text-transform: uppercase;
        }

        .campo input { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid #eee; 
            background: #f9f9f9; 
            font-family: Arial, sans-serif;
            text-transform: none; 
        }

        .btn-negro {
            width: 100%;
            padding: 15px;
            background: #000;
            color: #fff;
            border: none;
            cursor: pointer;
            letter-spacing: 3px;
            font-weight: bold;
            text-transform: uppercase;
            transition: 0.4s;
            text-align: center;
        }

        .btn-negro:hover { background: #444; }

        footer {
            background-color: #000;
            color: #F2E8DF;
            text-align: center;
            padding: 40px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        @keyframes aparecer {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<header>
    <a href="index.php"><img src="Imagenes/logo1.jpeg" alt="RAMI SHOP" class="logo-header"></a>
    <nav>
        <a href="index.php">INICIO</a>
        <a href="catalogo.php">CATÁLOGO</a>
        <a href="contacto.php">CONTACTO</a>
    </nav>
</header>

<main class="contenedor-login">
    <div class="caja-auth" id="cajaPrincipal">
        
        <?php if ($registro_exitoso): ?>
            <div style="text-align: center; animation: aparecer 0.8s ease;">
                <div style="font-size: 50px; margin-bottom: 20px;">👤</div>
                <h2 style="letter-spacing: 3px;">¡LISTO, <?php echo $nombre_registrado; ?>!</h2>
                <p style="margin-bottom: 30px; color: #555; text-transform: uppercase; font-size: 0.85em; letter-spacing: 1px;">Tu cuenta ha sido creada exitosamente. Bienvenido a la familia Rami Shop.</p>
                <a href="catalogo.php" class="btn-negro" style="text-decoration: none; display: block;">IR A COMPRAR</a>
            </div>
        <?php else: ?>
            
            <div class="tabs">
                <div class="tab <?php echo ($tab_activa == 'login') ? 'activa' : ''; ?>" onclick="cambiarSeccion('login', this)">Entrar</div>
                <div class="tab <?php echo ($tab_activa == 'registro') ? 'activa' : ''; ?>" onclick="cambiarSeccion('registro', this)">Registrarse</div>
            </div>

            <div id="seccion-login" class="form-seccion <?php echo ($tab_activa == 'login') ? 'activo' : ''; ?>">
                <h2>Bienvenido</h2>
                
                <?php if(!empty($error_login)): ?>
                    <div class="msg-error"><?php echo $error_login; ?></div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <input type="hidden" name="accion_login" value="1">
                    <div class="campo">
                        <label>Correo Electrónico</label>
                        <input type="email" name="correo_login" placeholder="usuario@gmail.com" required value="<?php echo isset($_POST['correo_login']) ? htmlspecialchars($_POST['correo_login']) : ''; ?>">
                    </div>
                    <div class="campo">
                        <label>Contraseña</label>
                        <input type="password" name="password_login" required>
                    </div>
                    <button type="submit" class="btn-negro">Iniciar Sesión</button>
                </form>
            </div>

            <div id="seccion-registro" class="form-seccion <?php echo ($tab_activa == 'registro') ? 'activo' : ''; ?>">
                <h2>Crear Cuenta</h2>

                <?php if(!empty($error_registro)): ?>
                    <div class="msg-error"><?php echo $error_registro; ?></div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <input type="hidden" name="accion_registro" value="1">
                    <div class="campo">
                        <label>Nombre Completo</label>
                        <input type="text" name="nombre_reg" placeholder="Tu nombre aquí" required value="<?php echo isset($_POST['nombre_reg']) ? htmlspecialchars($_POST['nombre_reg']) : ''; ?>">
                    </div>
                    <div class="campo">
                        <label>Correo Electrónico</label>
                        <input type="email" name="correo_reg" placeholder="usuario@gmail.com" required value="<?php echo isset($_POST['correo_reg']) ? htmlspecialchars($_POST['correo_reg']) : ''; ?>">
                    </div>
                    <div class="campo">
                        <label>Contraseña</label>
                        <input type="password" name="password_reg" required>
                    </div>
                    <div class="campo">
                        <label>Confirmar Contraseña</label>
                        <input type="password" name="password_reg_conf" required>
                    </div>
                    <button type="submit" class="btn-negro">Registrarme</button>
                </form>
            </div>

        <?php endif; ?>
    </div>
</main>

<footer>
    <p>© 2026 RAMI SHOP MX - EXCLUSIVIDAD Y CALIDAD</p>
</footer>

<script>
    function cambiarSeccion(tipo, elemento) {
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('activa'));
        document.querySelectorAll('.form-seccion').forEach(f => f.classList.remove('activo'));
        elemento.classList.add('activa');
        document.getElementById('seccion-' + tipo).classList.add('activo');
    }
</script>

</body>
</html>