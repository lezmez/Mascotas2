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

$productosFilePath = '../json/productos.json';
$json_data = file_get_contents($productosFilePath);
$products = json_decode($json_data, true)['products'];

$filteredProducts = $products;

if (isset($_POST['category'])) {
    $category = $_POST['category'];
    if ($category !== 'todos') {
        $filteredProducts = array_filter($products, function ($product) use ($category) {
            return $product['category'] === $category;
        });
    }
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $product = array_filter($products, function ($product) use ($productId) {
        return $product['id'] == $productId;
    });
    $product = array_shift($product);

    if ($product) {
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity']++;
        } else {
            $_SESSION['cart'][$productId] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'discount' => $product['discount'],
                'image' => $product['image'],
                'quantity' => 1
            ];
        }
        echo '
            <script>
                alert("Producto ' . $product['name'] . ' añadido al carrito");
            </script>
        ';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos - PetShop</title>
    <link rel="stylesheet" href="../assets/css/catalogo.css">
</head>
<body>
    <button onclick="window.location.href='../bienvenida_cliente.php'" class="back-to-menu">◁ HOME</button>
    <button onclick="window.location.href='carrito.php'" class="cart-button">🛒 Carrito (<?php echo count($_SESSION['cart'] ?? []); ?>)</button>
    <div class="content">
        <h1>Catálogo de Productos</h1>
        <form method="post">
            <button type="submit" name="category" value="todos">Todos</button>
            <button type="submit" name="category" value="collares">Collares</button>
            <button type="submit" name="category" value="juguetes">Juguetes</button>
            <button type="submit" name="category" value="alimento">Alimento</button>
            <button type="submit" name="category" value="premios">Premios</button>
        </form>
        <div class="product-list">
            <?php foreach ($filteredProducts as $product): ?>
                <div class="product-item">
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    <h3><?php echo $product['name']; ?></h3>
                    <?php if ($product['discount'] > 0): ?>
                        <p class="price"><s>$<?php echo number_format($product['price'] / 100, 2); ?></s> $<?php echo number_format(($product['price'] - $product['discount']) / 100, 2); ?></p>
                    <?php else: ?>
                        <p class="price">$<?php echo number_format($product['price'] / 100, 2); ?></p>
                    <?php endif; ?>
                    <form method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit" name="add_to_cart">Añadir al carrito</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
