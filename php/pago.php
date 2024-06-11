<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo '
        <script>
            alert("Por favor debes iniciar sesión");
            window.location = "index.php";
        </script>
    ';
    session_destroy();
    die();
}

// Procesar el pago aquí. Este es un ejemplo básico de cómo podría ser una página de pago.
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago - PetShop</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <button onclick="window.location.href='carrito.php'" class="back-to-menu">◁ Volver al Carrito</button>
    <div class="payment-form">
        <h2>Proceso de Pago</h2>
        <p>Aquí puedes implementar el formulario de pago y la integración con tu sistema de pagos.</p>
        <form action="procesar_pago.php" method="post">
            <table>
                <tr>
                    <th><label for="nombre">Nombre Completo:</label></th>
                    <td><input type="text" id="nombre" name="nombre" required></td>
                </tr>
                <tr>
                    <th><label for="direccion">Dirección:</label></th>
                    <td><input type="text" id="direccion" name="direccion" required></td>
                </tr>
                <tr>
                    <th><label for="tarjeta">Número de Tarjeta:</label></th>
                    <td><input type="text" id="tarjeta" name="tarjeta" required></td>
                </tr>
                <tr>
                    <th><label for="fecha_expiracion">Fecha de Expiración:</label></th>
                    <td><input type="text" id="fecha_expiracion" name="fecha_expiracion" required></td>
                </tr>
                <tr>
                    <th><label for="cvv">CVV:</label></th>
                    <td><input type="text" id="cvv" name="cvv" required></td>
                </tr>
            </table>
            <button type="submit" class="cart-button">Pagar</button>
        </form>
    </div>
</body>
</html>
