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

// Leer productos desde el archivo JSON
$json_data = file_get_contents($productosFilePath);
$productos = json_decode($json_data, true)['products'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_product'])) {
        $id = $_POST['product_id'];
        foreach ($productos as &$producto) {
            if ($producto['id'] == $id) {
                $producto['name'] = $_POST['name'];
                $producto['price'] = intval($_POST['price'] * 100); // Convertir a centavos
                $producto['category'] = $_POST['category'];
                $producto['image'] = $_POST['image'];
                $producto['discount'] = intval($_POST['discount'] * 100); // Convertir a centavos
                break;
            }
        }
        // Guardar los cambios en el archivo JSON
        file_put_contents($productosFilePath, json_encode(['products' => $productos]));
    } elseif (isset($_POST['delete_product'])) {
        $id = $_POST['product_id'];
        $productos = array_filter($productos, function ($producto) use ($id) {
            return $producto['id'] != $id;
        });
        // Reindexar el array y guardar los cambios en el archivo JSON
        file_put_contents($productosFilePath, json_encode(['products' => array_values($productos)]));
    } elseif (isset($_POST['add_product'])) {
        $newProduct = [
            'id' => end($productos)['id'] + 1,
            'name' => $_POST['name'],
            'category' => $_POST['category'],
            'price' => intval($_POST['price'] * 100), // Convertir a centavos
            'image' => $_POST['image'],
            'discount' => intval($_POST['discount'] * 100) // Convertir a centavos
        ];
        $productos[] = $newProduct;
        // Guardar el nuevo producto en el archivo JSON
        file_put_contents($productosFilePath, json_encode(['products' => $productos]));
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Inventario - PetShop</title>
    <link rel="stylesheet" href="../assets/css/gestion_inventario.css">
</head>
<body>
    <button onclick="window.location.href='../bienvenida.php'" class="back-to-menu">◁ HOME</button>
    <div class="content">
        <h1>Gestión de Inventario</h1>
        
        <h2>Productos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio (USD)</th>
                    <th>Descuento (USD)</th>
                    <th>Categoría</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <form method="post">
                            <td><?php echo $producto['id']; ?></td>
                            <td><input type="text" name="name" value="<?php echo $producto['name']; ?>" required></td>
                            <td><input type="number" step="0.01" name="price" value="<?php echo number_format($producto['price'] / 100, 2); ?>" required></td>
                            <td><input type="number" step="0.01" name="discount" value="<?php echo number_format($producto['discount'] / 100, 2); ?>" required></td>
                            <td>
                                <select name="category" required>
                                    <option value="collares" <?php echo $producto['category'] == 'collares' ? 'selected' : ''; ?>>Collares</option>
                                    <option value="juguetes" <?php echo $producto['category'] == 'juguetes' ? 'selected' : ''; ?>>Juguetes</option>
                                    <option value="alimento" <?php echo $producto['category'] == 'alimento' ? 'selected' : ''; ?>>Alimento</option>
                                    <option value="premios" <?php echo $producto['category'] == 'premios' ? 'selected' : ''; ?>>Premios</option>
                                </select>
                            </td>
                            <td><input type="text" name="image" value="<?php echo $producto['image']; ?>" required></td>
                            <td>
                                <input type="hidden" name="product_id" value="<?php echo $producto['id']; ?>">
                                <button type="submit" name="update_product" class="update-button">Actualizar</button>
                                <button type="submit" name="delete_product" class="delete-button">Eliminar</button>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Agregar Producto Nuevo</h2>
        <form method="post">
            <table>
                <tr>
                    <td>Nombre:</td>
                    <td><input type="text" name="name" required></td>
                </tr>
                <tr>
                    <td>Precio (USD):</td>
                    <td><input type="number" step="0.01" name="price" required></td>
                </tr>
                <tr>
                    <td>Descuento (USD):</td>
                    <td><input type="number" step="0.01" name="discount" required></td>
                </tr>
                <tr>
                    <td>Categoría:</td>
                    <td>
                        <select name="category" required>
                            <option value="collares">Collares</option>
                            <option value="juguetes">Juguetes</option>
                            <option value="alimento">Alimento</option>
                            <option value="premios">Premios</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Imagen:</td>
                    <td><input type="text" name="image" required></td>
                </tr>
                <tr>
                    <td colspan="2"><button type="submit" name="add_product" class="add-button">Agregar Producto</button></td>
                </tr>
            </table>
        </form>
    </div>
    <footer class="footer">
        <p>&copy; 2024 LEZMEZ - PetShop</p>
    </footer>
</body>
</html>
