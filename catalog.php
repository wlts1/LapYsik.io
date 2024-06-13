<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'assets/php/config.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./assets/css/catalog.css">
    <title>Каталог</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/pictures/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/pictures/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/pictures/favicon-16x16.png">
    <link rel="manifest" href="assets/pictures/site.webmanifest">
</head>
<body>
    <div class="page">
        <div class="header">
            <div class="container">
                <div class="header_line">
                    <div class="header_logo">
                        <img src="assets/pictures/logo.png" alt="Логотип магазина кормов">
                    </div>
                    <div class="nav">
                        <a class="nav_item" href="index.php">ГЛАВНАЯ</a>
                        <a class="cart_holder" href="cart.php">
                            <img class="cart_img" src="assets/pictures/cart.png" alt="Корзина">
                        </a>
                    </div>
                </div>
            </div>
    
            <div class="catalog">
                <div class="catalog_title">Каталог</div>
                <form id="productTypeForm" class="productTypeForm">
                    <div for="productType" class="productType">Выберите тип товара:</div>
                    <select id="productType" name="productType" onchange="fetchProducts()">
                        <option value="" class='productOption'>Все типы</option>
                        <?php
                        $stmt = $pdo->query('SELECT * FROM `Типы продукции`');
                        while ($row = $stmt->fetch()) {
                            echo "<option value=\"" . $row['id'] . "\" class='productOption'>" . $row['Название'] . "</option>";
                        }
                        ?>
                    </select>
                </form>
    
                <div id="products">
                    <?php
                    $limit = 4;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;
    
                    $stmt = $pdo->prepare('SELECT * FROM `Товары` LIMIT :limit OFFSET :offset');
                    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                    $stmt->execute();
    
                    while ($row = $stmt->fetch()) {
                        echo "<div class='product'>";
                        echo "<div class='product_holder'>";
                        echo "<div class='product_title'>" . $row['Название'] . "</div>";
                        echo "<div class='product_desc'>Описание: " . $row['Описание'] . "</div>";
                        echo "<div class='product_price'>Цена: " . $row['Цена'] . " руб.</div>";
                        echo "</div>";
                        echo "<div class='product_buttons'>";
                        echo "<div class='product_button'>";
                        echo "<a onclick='addToCart(" . $row['id'] . ")' class='product_btn'>Добавить в корзину</a>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
    
                    $totalStmt = $pdo->query('SELECT COUNT(*) FROM `Товары`');
                    $totalItems = $totalStmt->fetchColumn();
                    $totalPages = ceil($totalItems / $limit);
    
                    echo "<div class='pagination'>";
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<a class='pagination_button' href='#' onclick='fetchProducts($i)'>$i</a> ";
                    }
                    echo "</div>";
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/catalog.js"></script>
</body>
</html>
