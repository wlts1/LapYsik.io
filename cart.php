<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'assets/php/config.php';

$cart = [];
$userPhone = '';
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $stmt = $pdo->prepare('SELECT t.*, c.quantity FROM `Корзина` c JOIN `Товары` t ON c.product_id = t.id WHERE c.user_id = ?');
    $stmt->execute([$userId]);
    $cart = $stmt->fetchAll();
    $stmt = $pdo->prepare('SELECT Телефон FROM `Пользователи` WHERE id = ?');
    $stmt->execute([$userId]);
    $userPhone = $stmt->fetchColumn();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['clear_cart'])) {
    $stmt = $pdo->prepare('DELETE FROM `Корзина` WHERE user_id = ?');
    $stmt->execute([$userId]);
    $cart = [];
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./assets/css/cart.css">
    <title>Корзина</title>
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
                        <a class="nav_item" href="catalog.php">КАТАЛОГ</a>
                    </div>
                </div>
            </div>
            <div class="cart_container">
                <div class="cart_title">Ваша корзина</div>
                <?php if (empty($cart)): ?>
                    <div class="cart_text">Ваша корзина пуста.</div>
                    <a class="btn" href="catalog.php">Добавить товары</a>
                <?php else: ?>
                    <div class="cart_list">
                        <?php foreach ($cart as $item): ?>
                            <li class="cart_item">
                                <div class="product_title"><?= htmlspecialchars($item['Название']) ?></div>
                                <div class="product_desc"><?= htmlspecialchars($item['Описание']) ?></div>
                                <div class="product_price">Цена: <?= htmlspecialchars($item['Цена']) ?> руб.</div>
                                <div class="product_quantity">Количество: <?= htmlspecialchars($item['quantity']) ?></div>
                            </li>
                        <?php endforeach; ?>
                    </div>
                    <div class="cart_forms">
                        <div class="cart_form">
                            <form action="order.php" method="post">
                                <button type="submit" class="btn">Оформить заказ</button>
                            </form>
                        </div>
                        <div class="cart_form">
                            <form action="cart.php" method="post">
                                <button type="submit" name="clear_cart" class="btn">Очистить корзину</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
