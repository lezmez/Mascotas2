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

$products = [
    ['id' => 1, 'name' => 'Red Rose', 'category' => 'roses', 'price' => 19.999, 'image' => 'rosaroja.jpg'],
    ['id' => 2, 'name' => 'White Rose', 'category' => 'roses', 'price' => 19.999, 'image' => 'rosablanca.jpg'],
    ['id' => 3, 'name' => 'Sunflower', 'category' => 'sunflowers', 'price' => 15.999, 'image' => 'girasol.jpg'],
    ['id' => 4, 'name' => 'Tulip', 'category' => 'tulips', 'price' => 26.999, 'image' => 'tulipan.jpg'],
    ['id' => 5, 'name' => 'Orchid', 'category' => 'orchids', 'price' => 39.999, 'image' => 'orquidea.jpg'],
    ['id' => 6, 'name' => 'Lily', 'category' => 'lilies', 'price' => 30.999, 'image' => 'lirio.jpg'],
];

$filteredProducts = $products;

if (isset($_POST['category'])) {
    $category = $_POST['category'];
    if ($category !== 'todos') {
        $filteredProducts = array_filter($products, function ($product) use ($category) {
            return $product['category'] === $category;
        });
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - PetShop</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <button onclick="window.location.href='../bienvenida_cliente.php'" class="back-to-menu">◁ HOME</button>
    <div>
        <h2>Catálogo</h2>
        <div class="filter-buttons">
            <form method="post">
                <button type="submit" name="category" value="todos">Todos</button>
                <button type="submit" name="category" value="roses">Rosas</button>
                <button type="submit" name="category" value="sunflowers">Girasoles</button>
                <button type="submit" name="category" value="tulips">Tulipanes</button>
                <button type="submit" name="category" value="orchids">Orquídeas</button>
                <button type="submit" name="category" value="lilies">Lirios</button>
            </form>
        </div>

        <div class="products">
            <?php foreach ($filteredProducts as $product): ?>
                <div class="product">
                    <img src="../images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    <h3><?php echo $product['name']; ?></h3>
                    <p><?php echo $product['price']; ?> USD</p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 LEZMEZ - PetShop</p>
    </footer>
</body>
</html>
