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

if (isset($_POST['remove_item'])) {
    $productId = $_POST['product_id'];
    unset($_SESSION['cart'][$productId]);
} elseif (isset($_POST['update_quantity'])) {
    $productId = $_POST['product_id'];
    $newQuantity = $_POST['quantity'];
    if ($newQuantity <= 0) {
        unset($_SESSION['cart'][$productId]);
    } else {
        $_SESSION['cart'][$productId]['quantity'] = $newQuantity;
    }
} elseif (isset($_POST['clear_cart'])) {
    $_SESSION['cart'] = [];
}

$cartItems = $_SESSION['cart'];
$total = 0;
foreach ($cartItems as $item) {
    $itemTotal = ($item['price'] - $item['discount']) * $item['quantity'];
    $total += $itemTotal;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - PetShop</title>
    <link rel="stylesheet" href="../assets/css/carrito.css">
</head>
<body>
    <button onclick="window.location.href='catalogo.php'" class="back-to-menu">◁ Catálogo</button>
    <div class="content">
        <h1>Carrito de Compras</h1>
        <?php if (empty($cartItems)): ?>
            <p>Tu carrito está vacío.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Descuento</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $id => $item): ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td>$<?php echo number_format($item['price'] / 100, 2); ?></td>
                            <td>$<?php echo number_format($item['discount'] / 100, 2); ?></td>
                            <td>
                                <form method="post">
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="0">
                                    <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                    <button type="submit" name="update_quantity" class="update-button">Actualizar</button>
                                </form>
                            </td>
                            <td>$<?php echo number_format(($item['price'] - $item['discount']) * $item['quantity'] / 100, 2); ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                    <button type="submit" name="remove_item">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p>Total a pagar: $<?php echo number_format($total / 100, 2); ?></p>
            <form method="post">
                <button type="submit" name="clear_cart">Vaciar Carrito</button>
            </form>
        <?php endif; ?>
    </div>
    <div class="cart-buttons">
        <?php if (!empty($_SESSION['cart'])): ?>
            <button onclick="window.location.href='pago.php'">Proceder al Pago</button>
        <?php endif; ?>
</body>
</html>
