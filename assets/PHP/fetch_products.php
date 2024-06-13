<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'config.php';

if (isset($_GET['productType']) && isset($_GET['page'])) {
    $productType = $_GET['productType'];
    $limit = 4;
    $page = (int)$_GET['page'];
    $offset = ($page - 1) * $limit;

    if ($productType == '') {
        $stmt = $pdo->prepare('SELECT * FROM `Товары` LIMIT :limit OFFSET :offset');
    } else {
        $stmt = $pdo->prepare('SELECT * FROM `Товары` WHERE `Тип продукции id` = :productType LIMIT :limit OFFSET :offset');
        $stmt->bindParam(':productType', $productType, PDO::PARAM_INT);
    }
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

    if ($productType == '') {
        $totalStmt = $pdo->query('SELECT COUNT(*) FROM `Товары`');
    } else {
        $totalStmt = $pdo->prepare('SELECT COUNT(*) FROM `Товары` WHERE `Тип продукции id` = :productType');
        $totalStmt->bindParam(':productType', $productType, PDO::PARAM_INT);
        $totalStmt->execute();
    }

    $totalItems = $totalStmt->fetchColumn();
    $totalPages = ceil($totalItems / $limit);

    echo "<div class='pagination'>";
    for ($i = 1; $i <= $totalPages; $i++) {
        echo "<a class='pagination_button' href='#' onclick='fetchProducts($i)'>$i</a> ";
    }
    echo "</div>";
}
?>
