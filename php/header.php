<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetShop</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="header">
        <button onclick="window.location.href='../bienvenida_cliente.php'" class="back-to-menu">◁ HOME</button>
        <button onclick="window.location.href='carrito.php'" class="cart-button">🛒 Carrito (<?php echo count($_SESSION['cart']); ?>)</button>
    </div>
