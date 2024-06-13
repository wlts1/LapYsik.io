<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>ЛапУсик</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/pictures/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/pictures/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/pictures/favicon-16x16.png">
    <link rel="manifest" href="./assets/pictures/site.webmanifest">
</head>
<body>
    <div class="page">
        <!-- Header -->
        <div class="header">
            <div class="container">
                <!-- Header_line -->
                <div class="header_line">
                    <div class="header_logo">
                        <img src="assets/pictures/logo.png" alt="Логотип магазина кормов">
                    </div>
                    <div class="nav">
                        <a class="nav_item" href="index.php">ГЛАВНАЯ</a>
                        <a class="nav_item" href="catalog.php">КАТАЛОГ КОРМОВ</a>
                        <a class="nav_item" id="aboutShopButton" href="#history">О МАГАЗИНЕ</a>
                        <script src="assets/js/scroll_into.js"></script>
                        <a class="cart_holder" href="cart.php">
                            <img class="cart_img" src="assets/pictures/cart.png" alt="Корзина">
                        </a>
                    </div>

                    <div class="phone">
                        <div class="phone_holder">
                            <div class="phone_img"><img src="assets/pictures/phone.png" alt=""></div>
                            <div class="number"><a class="num" href="#">+7 (XXX) XXX-XX-XX</a></div>
                        </div>
                        <div class="phone_txt">Позвоните, чтобы заказать корм</div>
                    </div>

                    <div class="btn">
                        <a class="new-button" href="order.php">ОФОРМИТЬ ЗАКАЗ</a>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a class="new-button" id="logoutButton" href="#" onclick="logout()">ВЫЙТИ</a>
                        <?php else: ?>
                            <a class="new-button" href="#" onclick="openLoginModal()">ВОЙТИ</a>
                        <?php endif; ?>
                    </div>

                    <div id="loginModal" class="new-modal">
                        <div class="new-modal-content">
                            <span class="new-close" onclick="closeLoginModal()">&times;</span>
                            <div class="modal_title">Войти</div>
                            <form class="form" id="loginForm" onsubmit="submitLoginForm(event)">
                                <input class="phone_number" type="text" placeholder="Мобильный телефон" id="loginPhoneNumber" name="Телефон" required>
                                <input class="pass" type="password" placeholder="Пароль" id="loginPassword" name="Пароль" required>
                                <button class="new-modal-button" type="submit">Войти</button>
                            </form>
                            <div class="text_btn_holder">
                                <div class="form_text">Нет аккаунта?</div>
                                <div class="form_btn">
                                    <a href="#" class="new-modal-btn" onclick="openRegisterModal()">Зарегистрируйтесь</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="registerModal" class="new-modal">
                        <div class="new-modal-content">
                            <span class="new-close" onclick="closeRegisterModal()">&times;</span>
                            <div class="modal_title">Регистрация</div>
                            <form class="form" id="registerForm" onsubmit="submitRegisterForm(event)">
                                <input class="phone_number" type="text" placeholder="Мобильный телефон" id="registerPhoneNumber" name="Телефон" required>
                                <input class="pass" type="password" placeholder="Пароль" id="registerPassword" name="Пароль" required>
                                <button class="new-modal-button" type="submit">Зарегистрироваться</button>
                            </form>
                        </div>
                    </div>
                </div>
    <script src="assets/js/modal.js"></script>

                <!-- Header_down -->
                <div class="header_down">
                    <div class="header_title">
                        <div class="header_text">
                            Добро пожаловать в <br> наш магазин кормов

                            <div class="header_suptitle">
                                ЛУЧШИЕ КОРМА ДЛЯ <br> ВАШИХ ПИТОМЦЕВ
                            </div>
                        </div>
                        <div class="header_btn">
                            <a class="header_button" href="./catalog.php">ПОСМОТРЕТЬ КАТАЛОГ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cards -->
        <div class="cards">
            <div class="container">
                <div class="cards_holder">
                    <div class="card">
                        <div class="card_img"><img src="./assets/pictures/card1.png" alt=""></div>
                        <div class="card_title">Корм для собак <br> <span>Высшее качество</span></div>
                        <div class="card_desc">
                            Только лучшие и проверенные корма для вашего питомца.
                        </div>
                    </div>

                    <div class="card">
                        <div class="card_img"><img src="./assets/pictures/card2.png" alt=""></div>
                        <div class="card_title">Корм для кошек <br> <span>Натуральные ингредиенты</span></div>
                        <div class="card_desc">
                            Идеальный выбор для здоровья и долголетия вашей кошки.
                        </div>
                    </div>

                    <div class="card">
                        <div class="card_img"><img src="./assets/pictures/card3.png" alt=""></div>
                        <div class="card_title">Игрушки для питомцев <br> <span>Большой выбор</span></div>
                        <div class="card_desc">
                            Разнообразные игрушки для ваших питомцев, чтобы развлечь и радовать их.
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- History -->
        <div class="history" id="history">
            <div class="container">

                <div class="history_holder">

                    <div class="history_info">
                        <div class="history_title">Наша миссия <br> — <br> <span>Забота о питомцах</span></div>
                        <div class="history_desc">
                            Наш магазин был создан из любви к животным. Мы стремимся предоставить только лучшие и наиболее питательные корма для домашних питомцев, чтобы способствовать их здоровью и благополучию.
                        </div>

                        <div class="history_num">
                            <div class="num_item">
                                500 <span>Видов корма</span>
                            </div>
                            <div class="num_item">
                                12000 <span>Порций еды</span>
                            </div>
                            <div class="num_item">
                                250 <span>Популярных закусок</span>
                            </div>
                        </div>
                    </div>

                    <div class="history_imgs">
                        <img class="imgages_1" src="./assets/pictures/1.png" alt="">
                        <img class="imgages_2" src="./assets/pictures/2.png" alt="">
                        <img class="imgages_3" src="./assets/pictures/3.png" alt="">
                    </div>
                </div>

            </div>
        </div>

        <!-- Block -->
        <div class="black_block">
            <div class="container">

                <div class="block_holder">
                    <div class="left">
                        <div class="left_title">
                            Заботьтесь о своем питомце <br> с лучшим кормом
                        </div>
                        <div class="left_txt">
                            Только у нас широкий выбор качественных кормов для всех видов животных
                        </div>
                    </div>
                    <div class="right">
                        <div class="right_button" href="catalog.php"><a class="right_btn" href="catalog.php">КАТАЛОГ</a></div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Dishes -->
        <div class="dishes">
            <div class="container">

                <div class="dishes_title">Наши продукты <br> <span>Качественный корм</span></div>

                <div class="burgers">
                    <div class="burgers_img">
                        <img class="pizza" src="./assets/pictures/storage.jpg" alt="">
                    </div>
                    <div class="burgers_items">
                        <div class="burger_item">
                            <img class="burger" src="./assets/pictures/pets1.png" alt="">
                            <div class="burger_txt">
                                <h3>Корм для собак премиум класса</h3>
                                <div class="order_price">
                                    <p>Цена: 1500 руб.</p>
                                    <a class="order_button" href="./catalog.php">КАТАЛОГ</a>
                                </div>
                            </div>
                        </div>
                        <div class="burger_item">
                            <img class="burger" src="./assets/pictures/pets2.png" alt="">
                            <div class="burger_txt">
                                <h3>Корм для кошек с натуральным мясом</h3>
                                <div class="order_price">
                                    <p>Цена: 1300 руб.</p>
                                    <a class="order_button" href="./catalog.php">КАТАЛОГ</a>
                                </div>
                            </div>
                        </div>
                        <div class="burger_item">
                            <img class="burger" src="./assets/pictures/pets3.png" alt="">
                            <div class="burger_txt">
                                <h3>Лакомства для грызунов</h3>
                                <div class="order_price">
                                    <p>Цена: 300 руб.</p>
                                    <a class="order_button" href="./catalog.php">КАТАЛОГ</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Menu -->
        <div class="menu">
            <div class="container">

                <div class="menu_top">
                    <div class="menu_title">
                        Наш Ассортимент
                    </div>
                </div>
                <div class="menu_items">
                    <div class="menu_item">
                        <div class="menu_image">
                            <img src="./assets/pictures/menu-item1.jpg" class="menu_img" alt="">
                            <div class="price">
                                <img src="./assets/pictures/price.png" class="price_img" alt="">
                                <div class="price420">850</div>
                            </div>
                        </div>
                        <div class="menu_text">Корм "Мясное удовольствие"</div>
                        <div class="menu_subtext">Сбалансированное питание для вашего питомца</div>
                        <div class="menu_button" href="./order.php">
                            <a href="./order.php" class="menu_btn">КАТАЛОГ</a>
                        </div>
                    </div>
                    <div class="menu_item">
                        <div class="menu_image">
                            <img src="./assets/pictures/menu-item2.jpg" class="menu_img" alt="">
                            <div class="price">
                                <img src="./assets/pictures/price.png" class="price_img" alt="">
                                <div class="price420">750</div>
                            </div>
                        </div>
                        <div class="menu_text">Корм "Рыбные вкусности"</div>
                        <div class="menu_subtext">Богатый источник омега-3 для здоровья вашего питомца</div>
                        <div class="menu_button" href="./order.php">
                            <a href="./order.php" class="menu_btn">КАТАЛОГ</a>
                        </div>
                    </div>
                    <div class="menu_item">
                        <div class="menu_image">
                            <img src="./assets/pictures/menu-item3.jpg" class="menu_img" alt="">
                            <div class="price">
                                <img src="./assets/pictures/price.png" class="price_img" alt="">
                                <div class="price420">600</div>
                            </div>
                        </div>
                        <div class="menu_text">Корм "Зерновой баланс"</div>
                        <div class="menu_subtext">Натуральные ингредиенты для энергии и здоровья вашего питомца</div>
                        <div class="menu_button" href="./order.php">
                            <a href="./order.php" class="menu_btn">КАТАЛОГ</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Comment -->
        <div class="comments">
            <div class="container">

                <div class="comment_text">"Я полностью доволен вашим магазином! Заказывал здесь корм для своих питомцев несколько раз и всегда остался доволен качеством услуг. Доставка всегда точна, качество продукции высокое, а ассортимент широкий и разнообразный. Мои питомцы тоже довольны, им нравится каждый корм, который я здесь покупаю. Очень рекомендую ваш магазин всем владельцам домашних животных!"</div>

                <div class="comment_image">
                    <img src="./assets/pictures/face.png" class="comment_img" alt="">
                </div>

                <div class="comment_type">Покупатель</div>
                <div class="comment_name">Николай</div>

            </div>
        </div>

        <!-- Gallery -->
        <div class="gallery">
            <div class="container">

                <div class="gallery_title">Счастливые <span>Лапки</span></div>

                <div class="gallery_content">
                    <div class="gallery_left">
                        <div class="gallery_up">
                            <img src="./assets/pictures/25_picture_261ab0f2.jpg" class="img_gal" alt="">
                        </div>
                        <div class="gallery_down">
                            <img src="./assets/pictures/3bda4b7d061c20f3b7e1bcda904b5a08.jpg" class="img_gal" alt="">
                            <img src="./assets/pictures/44369.jpg" class="img_gal" alt="">
                        </div>
                    </div>

                    <div class="gallery_right">
                        <div class="gallery_up">
                            <img src="./assets/pictures/1675256200_ornella-club-p-ulibay.jpg" class="img_gal" alt="">
                            <img src="./assets/pictures/1679421415_celes-club-p-dovolnay.jpg" class="img_gal" alt="">
                        </div>
                        <div class="gallery_down">
                            <img src="./assets/pictures/9PRVCXLNctY.jpg" class="img_gal" alt="">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Shopkeepers -->
        <div class="shopkeepers">
            <div class="container">

                <div class="shopkeepers_title">
                    Ваши <span>Помощники</span>
                </div>

                <div class="shopkeepers_content">
                    <img class="shopkeepers_img" src="./assets/pictures/1c.jpg" alt="">
                    <img class="shopkeepers_img" src="./assets/pictures/2c.jpg" alt="">
                    <img class="shopkeepers_img" src="./assets/pictures/3c.jpg" alt="">
                </div>

            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            Copyright 2024
        </div>

        <div class="backToTop" id="backToTop">
            ↑
            <a style="display: none;">↑</a>
        </div>
    </div>
    <script src="./assets/JS/button_sroll.js"></script>        
</body>
</html>
