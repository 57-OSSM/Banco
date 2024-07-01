<?php
// Inicializar la sesión
session_start();

// Comprobar si el usuario está logueado, si no lo está redirigir a la página de login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: Login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #FF9C33;
            color: white;
            padding: 1em 0;
            text-align: center;
        }
        nav {
            display: flex;
            justify-content: center;
            padding: 1em;
        }
        nav a {
            color: white;
            margin: 0 1em;
            text-decoration: none;
        }
        section {
            padding: 2em;
            margin: 2em 0;
        }
        .services, .testimonials {
            display: flex;
            justify-content: space-around;
        }
        .service, .testimonial {
            width: 30%;
            padding: 1em;
            border: 1px solid #ccc;
            border-radius: 8px;
            text-align: center;
        }
        footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 1em 0;
        }
    </style>
</head>
<body>

<header>
    <div class="header-top">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION["telefono"]); ?>!</h1>
        <p>Proporcionamos los mejores servicios para ti</p>
    </div>
    <nav>
        <a href="#servicios">Servicios</a>
        <a href="#testimonios">Testimonios</a>
        <a href="#contacto">Contacto</a>
    </nav>
</header>

<section id="servicios">
    <h2>Servicios</h2>
    <div class="services">
        <div class="service">
           <a href="#clientes">
                <h3>Clientes</h3>
            </a>
            <p>Descripción del servicio 1.</p>
        </div>
        <div class="service">
        <a href="#premios">
                <h3>Premios</h3>
            </a>
            <p>Descripción del servicio 2.</p>
        </div>
        <div class="service">
                <a href="#beneficios">
                <h3>Beneficios</h3>
            </a>
            <p>Descripción del servicio 3.</p>
        </div>
    </div>
</section>

<section id="testimonios">
    <h2>Testimonios</h2>
    <div class="testimonials">
        <div class="testimonial">
            <h3>Cliente 1</h3>
            <p>"Comentario del cliente 1."</p>
        </div>
        <div class="testimonial">
            <h3>Cliente 2</h3>
            <p>"Comentario del cliente 2."</p>
        </div>
        <div class="testimonial">
            <h3>Cliente 3</h3>
            <p>"Comentario del cliente 3."</p>
        </div>
    </div>
</section>

<section id="contacto">
    <h2>Contacto</h2>
    <p>Dirección: Calle Falsa 123, Ciudad, País</p>
    <p>Teléfono: +123 456 789</p>
    <p>Email: contacto@empresa.com</p>
</section>

<footer>
    <p>© 2024 Nombre de la Empresa. Todos los derechos reservados.</p>
    <p>
            <a href="Login.php" class="btn btn-danger">Cerrar sesión</a>
        </p>
</footer>

</body>
</html>


