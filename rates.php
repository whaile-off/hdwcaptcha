<?php

require_once('./scripts/loger.php');
require_once('./config.php');

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./scripts/style.css">
	<link rel="icon" href="img/logo.png" type="image/x-icon">
    <title><?= $config['site'] ?> | _whaile_</title>
</head>
<body>
<div class="main">
    <!-- Верхнее меню -->
    <div class="navbar">
        <a href="<?= $config['link'] ?>index.php" class="logo"><?= $config['site'] ?></a>
        <div class="nav-buttons" id="navMenu">
			<button class="nav-btn"><a href="<?= $config['link'] ?>index.php" class="item" style="color: #ccc; text-decoration: none;">Главная</a></button>
            <button class="nav-btn selected"><a href="<?= $config['link'] ?>rates" class="item" style="color: #ccc; text-decoration: none;">Тарифы</a></button>
            <button class="nav-btn"><a href="<?= $config['link'] ?>auth/login" class="item" style="color: #ccc; text-decoration: none;">Войти</a></button>
        </div>

        <button class="toggler">
            <i class='bx bx-menu'></i>
        </button>
    </div>
	
	<div class="top">
		<p class="header">Наши тарифы</p>
	</div>
	
    <div class="top-container">
        <div class="container-box">
			<p style="font-size: 25px;text-align: center;padding: 10px 0px;color: #fff;">Ключ API</p>
            <img src="./img/rate_1.jpg" class="container-pic">
            <div class="container-content">
                <div class="info">
                    <div>
                        <h2>На день</h2>
						<h4>1 устройство</h4>
                    </div>
                </div>
                <div class="likes">
					<div class="icon-box" style="border: 1px solid #ccc;border-radius: 8px;padding: 7px;">
                        <a href="<?= $config['link'] ?>auth/login" style="color: #fff; text-decoration: none;">Цена: 149₽</a>
                    </div>
                </div>
            </div>
        </div>
		<div class="container-box">
			<p style="font-size: 25px;text-align: center;padding: 10px 0px;color: #fff;">Ключ API</p>
            <img src="./img/rate_2.jpg" class="container-pic">
            <div class="container-content">
                <div class="info">
                    <div>
                        <h2>На месяц</h2>
						<h4>1 устройство</h4>
                    </div>
                </div>
                <div class="likes">
                    <div class="icon-box" style="border: 1px solid #ccc;border-radius: 8px;padding: 7px;">
                        <a href="<?= $config['link'] ?>auth/login" style="color: #fff; text-decoration: none;">Цена: 2299₽</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-box">
			<p style="font-size: 25px;text-align: center;padding: 10px 0px;color: #fff;">Ключ API</p>
            <img src="./img/rate_3.jpg" class="container-pic">
            <div class="container-content">
                <div class="info">
                    <div>
                        <h2>Навсегда</h2>
						<h4>1 устройство</h4>
                    </div>
                </div>
                <div class="likes">
                    <div class="icon-box" style="border: 1px solid #ccc;border-radius: 8px;padding: 7px;">
                        <a href="<?= $config['link'] ?>auth/login" style="color: #fff; text-decoration: none;">Цена: 3299₽</a>
                    </div>
                </div>
            </div>
        </div>
	</div>
	<div class="top-container">
		<div class="container-box">
			<p style="font-size: 25px;text-align: center;padding: 10px 0px;color: #fff;">Подписка</p>
            <img src="./img/rate_4.jpg" class="container-pic">
            <div class="container-content">
                <div class="info">
                    <div>
                        <h2>Навсегда</h2>
						<h4>+ модуль eng</h4>
                    </div>
                </div>
                <div class="likes">
					<div class="icon-box" style="border: 1px solid #ccc;border-radius: 8px;padding: 7px;">
                        <a href="<?= $config['link'] ?>auth/login" style="color: #fff; text-decoration: none;">Цена: 149₽</a>
                    </div>
                </div>
            </div>
        </div>
		<div class="container-box">
			<p style="font-size: 25px;text-align: center;padding: 10px 0px;color: #fff;">Подписка</p>
            <img src="./img/rate_5.jpg" class="container-pic">
            <div class="container-content">
                <div class="info">
                    <div>
                        <h2>Навсегда</h2>
						<h4>+ модуль eng</h4>
						<h4>+ модуль rus</h4>
                    </div>
                </div>
                <div class="likes">
                    <div class="icon-box" style="border: 1px solid #ccc;border-radius: 8px;padding: 7px;">
                        <a href="<?= $config['link'] ?>auth/login" style="color: #fff; text-decoration: none;">Цена: 249₽</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-box">
			<p style="font-size: 25px;text-align: center;padding: 10px 0px;color: #fff;">Подписка</p>
            <img src="./img/rate_6.jpg" class="container-pic">
            <div class="container-content">
                <div class="info">
                    <div>
                        <h2>Навсегда</h2>
						<h4>+ модуль eng</h4>
						<h4>+ модуль rus</h4>
						<h4>+ модуль int</h4>
                    </div>
                </div>
                <div class="likes">
                    <div class="icon-box" style="border: 1px solid #ccc;border-radius: 8px;padding: 7px;">
                        <a href="<?= $config['link'] ?>auth/login" style="color: #fff; text-decoration: none;">Цена: 359₽</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Подвал -->
	<? include('./scripts/footer.php'); ?>

</div>


<script src="./scripts/index.js"></script>
</body>
</html>