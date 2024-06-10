<?php

    session_start();

    if(!isset($_SESSION['usuario'])){
        echo '
            <script>
                alert("Por favor debes iniciar sesión");
                window.location = "index.php";
            </script>
        ';
        session_destroy();
        die();
    }
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal - PetShop</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
    <button onclick="window.location.href='bienvenida_cliente.php'" class="back-to-menu">◁ HOME</button>
    <div class="content">
        <h1>Bienvenido a PetShop</h1>
        <p>Seleccione una opción del menú para continuar.</p>
    </div>
    <nav class="navbar">
        <ul> 
            <li><a href="php/catalogo.php">Catálogo</a></li>
            <li><a href="php/cerrar_sesion.php">Cerrar sesión</a></li>
        </ul>
    </nav>
    <footer>
        <p>&copy; 2024  - PetShop</p>
    </footer>
</body>
</html>