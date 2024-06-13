<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $productId = $_POST['productId'];

    if ($_POST['action'] === 'add') {
        $stmt = $pdo->prepare('SELECT * FROM `Корзина` WHERE `user_id` = ? AND `product_id` = ?');
        $stmt->execute([$userId, $productId]);
        $item = $stmt->fetch();

        if ($item) {
            $stmt = $pdo->prepare('UPDATE `Корзина` SET `quantity` = `quantity` + 1 WHERE `user_id` = ? AND `product_id` = ?');
            $stmt->execute([$userId, $productId]);
        } else {
            $stmt = $pdo->prepare('INSERT INTO `Корзина` (`user_id`, `product_id`, `quantity`) VALUES (?, ?, 1)');
            $stmt->execute([$userId, $productId]);
        }

        echo 'Товар добавлен в корзину';
    }
}
?>
