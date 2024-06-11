<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_from_cart'])) {
        $productId = $_POST['product_id'];
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
    }
}

include 'header.php';
?>

<div>
    <h2>Carrito de Compras</h2>
    <div class="cart">
        <?php if (empty($_SESSION['cart'])): ?>
            <p class="cart-empty">El carrito está vacío</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    foreach ($_SESSION['cart'] as $id => $product): 
                        $subtotal = $product['price'] * $product['quantity'];
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>"></td>
                            <td><?php echo $product['name']; ?></td>
                            <td>$ <?php echo number_format($product['price'], 2); ?> USD</td>
                            <td><?php echo $product['quantity']; ?></td>
                            <td>$ <?php echo number_format($subtotal, 2); ?> USD</td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                    <button type="submit" name="remove_from_cart">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" style="text-align:right;">Total</td>
                        <td>$ <?php echo number_format($total, 2); ?> USD</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <div class="cart-buttons">
        <button onclick="window.location.href='catalogo.php'">Volver al Catálogo</button>
        <?php if (!empty($_SESSION['cart'])): ?>
            <button onclick="window.location.href='pago.php'">Proceder al Pago</button>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
