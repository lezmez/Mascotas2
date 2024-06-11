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
    ['id' => 1, 'name' => 'Collar para Gato', 'category' => 'collares', 'price' => 19.999, 'image' => '../assets/images/collargato.jpeg'],
    ['id' => 2, 'name' => 'Collar para Perro', 'category' => 'collares', 'price' => 19.999, 'image' => '../assets/images/collarperro.jpg'],
    ['id' => 3, 'name' => 'Combo de Juguetes', 'category' => 'juguetes', 'price' => 15.999, 'image' => '../assets/images/combojuguetes.jpg'],
    ['id' => 4, 'name' => 'Dog Chow', 'category' => 'alimento', 'price' => 26.999, 'image' => '../assets/images/dogchow.jpg'],
    ['id' => 5, 'name' => 'Dog Chow', 'category' => 'alimento', 'price' => 39.999, 'image' => '../assets/images/dogchowadultos.jpg'],
    ['id' => 6, 'name' => 'Dog Gourmet Adultos', 'category' => 'alimento', 'price' => 30.999, 'image' => '../assets/images/dogourmetadulto.jpg'],
    ['id' => 7, 'name' => 'Don Kat', 'category' => 'alimento', 'price' => 30.999, 'image' => '../assets/images/DONKAT.jpg'],
    ['id' => 8, 'name' => 'Hueso Argos', 'category' => 'premios', 'price' => 30.999, 'image' => '../assets/images/huesoargos.jpeg'],
    ['id' => 9, 'name' => 'Croquetas Premio', 'category' => 'premios', 'price' => 30.999, 'image' => '../assets/images/huesopremio.jpg'],
    ['id' => 10, 'name' => 'Juguete Goma', 'category' => 'juguetes', 'price' => 30.999, 'image' => '../assets/images/juguete1.jpeg'],
    ['id' => 11, 'name' => 'Jueguete Hueso', 'category' => 'juguetes', 'price' => 30.999, 'image' => '../assets/images/juguetehueso.jpg'],
    ['id' => 12, 'name' => 'Jueguete Hueso Real', 'category' => 'juguetes', 'price' => 30.999, 'image' => '../assets/images/juguetehuesoreal.jpg'],
    ['id' => 13, 'name' => 'Max', 'category' => 'alimento', 'price' => 30.999, 'image' => '../assets/images/max.jpg'],
    ['id' => 14, 'name' => 'Meow Mix', 'category' => 'alimento', 'price' => 30.999, 'image' => '../assets/images/meowmix.jpg'],
    ['id' => 15, 'name' => 'Monello', 'category' => 'alimento', 'price' => 30.999, 'image' => '../assets/images/Monello.jpg'],
    ['id' => 16, 'name' => 'Pedigree Cachorro', 'category' => 'alimento', 'price' => 30.999, 'image' => '../assets/images/pedigreecachorro.jpg'],
    ['id' => 17, 'name' => 'Whiskas', 'category' => 'alimento', 'price' => 30.999, 'image' => '../assets/images/whiskas.png'],
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

if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    echo '
        <script>
            alert("Producto ' . $productId . ' añadido al carrito");
        </script>
    ';
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
                <button type="submit" name="category" value="collares">Collares</button>
                <button type="submit" name="category" value="juguetes">Juguetes</button>
                <button type="submit" name="category" value="alimento">Alimento</button>
                <button type="submit" name="category" value="premios">Premios</button>
            </form>
        </div>

        <div class="products">
            <?php foreach ($filteredProducts as $product): ?>
                <div class="product">
                    <img src="../images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    <h3><?php echo $product['name']; ?></h3>
                    <p>$ <?php echo $product['price']; ?> USD</p>
                    <form method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit" name="add_to_cart">Add to Cart</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
</body>
</html>
