<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'assets/php/config.php';

$cart = [];
$userPhone = '';
$totalPrice = 0;
$orderPlaced = false;

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    $stmt = $pdo->prepare('SELECT t.*, c.quantity FROM `Корзина` c JOIN `Товары` t ON c.product_id = t.id WHERE c.user_id = ?');
    $stmt->execute([$userId]);
    $cart = $stmt->fetchAll();

    $stmt = $pdo->prepare('SELECT Телефон FROM `Пользователи` WHERE id = ?');
    $stmt->execute([$userId]);
    $userPhone = $stmt->fetchColumn();

    foreach ($cart as $item) {
        $totalPrice += $item['Цена'] * $item['quantity'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_order'])) {
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare('INSERT INTO `заказы` (`id_покупателя`, `Телефон`, `Адрес`) VALUES (?, ?, ?)');
        $stmt->execute([$userId, $phone, $address]);
        $orderId = $pdo->lastInsertId();

        foreach ($cart as $item) {
            $stmt = $pdo->prepare('INSERT INTO `Заказанные товары` (`order_id`, `product_id`, `quantity`, `price`) VALUES (?, ?, ?, ?)');
            $stmt->execute([$orderId, $item['id'], $item['quantity'], $item['Цена']]);
        }

        $stmt = $pdo->prepare('DELETE FROM `Корзина` WHERE user_id = ?');
        $stmt->execute([$userId]);

        $pdo->commit();
        $orderPlaced = true;
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/order.css">
    <title>Оформление заказа</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/pictures/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/pictures/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/pictures/favicon-16x16.png">
    <link rel="manifest" href="assets/pictures/site.webmanifest">
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="header_line">
                <div class="header_logo">
                    <img src="assets/pictures/logo.png" alt="Логотип магазина кормов">
                </div>
                <div class="nav">
                    <a class="nav_item" href="index.php">ГЛАВНАЯ</a>
                    <a class="nav_item" href="catalog.php">КАТАЛОГ</a>
                    <a class="cart_holder" href="cart.php">
                        <img class="cart_img" src="assets/pictures/cart.png" alt="Корзина">
                    </a>
                </div>
            </div>
        </div>
        <div class="order_container">
            <div class="order_title">Оформление заказа</div>
            <?php if ($orderPlaced): ?>
                <div class="thx">Спасибо за заказ!</div>
            <?php else: ?>
                <div class="order_forms">
                    <form action="order.php" method="post" class='order_form'>
                        <div class="form_top">
                            <div class="form_group">
                                <label for="phone" class='phone'>Номер телефона</label>
                                <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($userPhone) ?>" required class='phone_inp'>
                            </div>
                            <div class="form_group">
                                <label for="address" class='address'>Адрес доставки</label>
                                <input type="text" id="address" name="address" required class='address_inp'>
                            </div>
                        </div>
                        <div class="form_bottom">
                            <div class="order_suptitle">Ваши товары</div>
                            <ul class="order_list">
                                <?php foreach ($cart as $item): ?>
                                    <li class="order_item">
                                        <div class="product_title"><?= htmlspecialchars($item['Название']) ?></div>
                                        <div class="product_quantity">Количество: <?= htmlspecialchars($item['quantity']) ?></div>
                                        <div class="product_price">Цена: <?= htmlspecialchars($item['Цена']) ?> руб.</div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="total_price">
                                <strong>Итоговая цена: <?= htmlspecialchars($totalPrice) ?> руб.</strong>
                            </div>
                            <button type="submit" name="place_order" class="btn">Оформить заказ</button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
