<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'register':
                $phoneNumber = $_POST['Телефон'];
                $password = password_hash($_POST['Пароль'], PASSWORD_BCRYPT);

                try {
                    $stmt = $pdo->prepare('INSERT INTO Пользователи (Телефон, Пароль) VALUES (?, ?)');
                    $stmt->execute([$phoneNumber, $password]);
                    echo 'Регистрация прошла успешно';
                } catch (PDOException $e) {
                    if ($e->getCode() === '23000') {
                        echo 'Пользователь уже существует';
                    } else {
                        echo 'Ошибка регистрации: ' . $e->getMessage();
                    }
                }
                break;

            case 'login':
                $phoneNumber = $_POST['Телефон'];
                $password = $_POST['Пароль'];

                $stmt = $pdo->prepare('SELECT * FROM Пользователи WHERE Телефон = ?');
                $stmt->execute([$phoneNumber]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['Пароль'])) {
                    $_SESSION['user_id'] = $user['id'];
                    echo 'Вход выполнен успешно';
                } else {
                    echo 'Неверный номер телефона или пароль';
                }
                break;

            case 'logout':
                session_destroy();
                echo 'Выход выполнен успешно';
                break;
        }
    }
}
?>
