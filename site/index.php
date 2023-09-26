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
	<link rel="stylesheet" href="./scripts/code.css">
	<link rel="icon" href="img/logo.png" type="image/x-icon">
	<meta name="keywords" content="<?= $config['keywords'] ?>">
    <title><?= $config['description'] ?></title>
	<meta property="og:description" content="Добро пожаловать! Наш сервис предоставляет множество возможностей для решения капчи. Забудьте о сложностях с капчей - мы поможем справиться с этой задачей легко и быстро. Попробуйте прямо сейчас и убедитесь в эффективности наших инструментов.">
	<meta data-rh="true" name="description" content="Добро пожаловать! Наш сервис предоставляет множество возможностей для решения капчи. Забудьте о сложностях с капчей - мы поможем справиться с этой задачей легко и быстро. Попробуйте прямо сейчас и убедитесь в эффективности наших инструментов.">
</head>
<body>
<div class="main">
    <!-- Верхнее меню -->
    <div class="navbar">
        <a href="<?= $config['link'] ?>index.php" class="logo"><?= $config['site'] ?></a>
        <div class="nav-buttons" id="navMenu">
			<button class="nav-btn selected"><a href="<?= $config['link'] ?>index.php" class="item" style="color: #ccc; text-decoration: none;">Главная</a></button>
            <button class="nav-btn"><a href="<?= $config['link'] ?>rates" class="item" style="color: #ccc; text-decoration: none;">Тарифы</a></button>
            <button class="nav-btn"><a href="<?= $config['link'] ?>auth/login" class="item" style="color: #ccc; text-decoration: none;">Войти</a></button>
        </div>

        <button class="toggler">
            <i class='bx bx-menu'></i>
        </button>
    </div>

    <div class="top-container">
        <div class="info-box">
            <p class="header">
                Решайте капчи через нашу Нейросеть с легкостью!
            </p>
            <p class="info-text">
                Подходит для ВКонтакте, Telegram и других платформ
            </p>
            <div class="info-buttons">
                <button class="info-btn selected"><a style="color: #fff; text-decoration: none;" href="<?= $config['link'] ?>auth/login">Начать</a></button>
                <button id="scroll" class="info-btn nav-btn">О нас</button>
            </div>
        </div>
		<div class="container-box" id="containerBox">
			<img src="./img/<?php echo $img ?>" class="container-pic">
			<div class="container-content">
				<div class="info">
					<div>
						<p>
							Ответ: <?php echo $answer ?>
						</p>
					</div>
				</div>
				<div class="likes">
					<div class="icon-box">
						Точность 99%
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="top-container">
		<div class="info-box">
			<h2 class="header">Основные преимущества:</h2>
			<p class="info-text">
				Наш сервис обеспечивает моментальное решение капчи благодаря использованию удаленных серверов и мощных нейронных сетей. Мы гарантируем быстрый и точный ответ!
			</p>
		</div>
		<div id="codeContainer" class="code-block">
			<div class="code-title">Скорость</div>
			<div class="pading-cod">
				<code id="codeBlock" class="code-content" style="white-space: normal;"><h2>Решение за мгновение</h2><br>
<h3>Одна капча решается<br> за 0.0453 секунды<br> это 45.3 миллисекунды!</h3>
				</code>
			</div>
			<button class="copy-button1" onclick="redirectTo('#pon')" style="height: 16%;"></button>
		</div>
	</div>


    <div class="get-started">
		<h2 class="header">О нашем сервисе</h2>
		<p class="info-text">Мы предоставляем простую и эффективную документацию, которая позволит легко начать использование нашего сервиса всего в 2 шага.</p>
		<div class="items-box">
			<div class="item-container">
				<div class="item">
					<i class='bx bx-check-shield'></i>
				</div>
				<p>Простота использования</p>
			</div>
			<div class="item-container">
				<div class="item">
					<i class='bx bx-wallet-alt'></i>
				</div>
				<p>Доступные цены</p>
			</div>
			<div class="item-container">
				<div class="item">
					<i class='bx bx-money'></i>
				</div>
				<p>Мощные нейронные сети</p>
			</div>
			<div class="item-container">
				<div class="item">
					<i class='bx bx-rocket'></i>
				</div>
				<p>Быстрые ответы от сервера</p>
			</div>
		</div>
	</div>

    <!-- Подвал -->
	<? include('./scripts/footer.php'); ?>

</div>

<div id="pon">
    <div id="oknoo"><br>
		<a href="" class="closeo">Закрыть окно</a>
		<p class="header" style="padding: 20px 0px 10px 0px;font-size: 25px;">0_0</p>
		<p style="padding: 10px 0px;">От _whaile_ | Я в шоках сижу<br>Если ты гений а если нет то только пидора ответ!</p>
       </div>
</div>

<script src="./scripts/index.js"></script>
<script>
    function updateBox() {
        var nftBox = document.getElementById("containerBox");
        nftBox.classList.add("updating");

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var response = this.responseText;
                nftBox.innerHTML = response;
                nftBox.classList.remove("updating");
            }
        };
        xhttp.open("GET", "<?= $config['link'] ?>/scripts/captcha.php", true);
        xhttp.send();
    }
	
	function redirectTo(target) {
        window.location.href = target;
    }

    window.onload = updateBox;

    setInterval(updateBox, Math.floor(Math.random() * (5000 - 3000 + 1)) + 3000);
</script>

<style> .container-box.updating { animation: updateAnimation 1s ease-in-out; } </style>
</body>
</html>