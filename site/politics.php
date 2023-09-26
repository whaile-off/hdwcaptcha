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
    <link rel="stylesheet" href="./scripts/politics.css">
	<link rel="stylesheet" href="./scripts/style.css">
	<link rel="icon" href="img/logo.png" type="image/x-icon">
    <title><?= $config['description'] ?></title>
</head>
<body>
<div class="main">
    <!-- Верхнее меню -->
    <div class="navbar">
        <a href="<?= $config['link'] ?>index.php" class="logo"><?= $config['site'] ?></a>
        <div class="nav-buttons" id="navMenu">
			<button class="nav-btn"><a href="<?= $config['link'] ?>index.php" class="item" style="color: #ccc; text-decoration: none;">Главная</a></button>
            <button class="nav-btn"><a href="<?= $config['link'] ?>rates" class="item" style="color: #ccc; text-decoration: none;">Тарифы</a></button>
            <button class="nav-btn"><a href="<?= $config['link'] ?>auth/login" class="item" style="color: #ccc; text-decoration: none;">Войти</a></button>
        </div>

        <button class="toggler">
            <i class='bx bx-menu'></i>
        </button>
    </div>

	<div class="top">
		<p class="header">Политика</p>
	</div>

    <div class="top-container" style="justify-content: center;">
        <div class="info-box">
            <div id="codeContainer" class="code-block">
				<div class="code-title">Политика</div>
				<div class="pading-cod">
					<code id="codeBlock" class="code-content" style="white-space: normal;">
Дата вступления в силу: 29.07.2023<br><br>

Добро пожаловать на сайт <?= $config['site'] ?>! Мы уделяем особое внимание защите вашей конфиденциальности и безопасности данных. Наша политика конфиденциальности описывает, какие данные мы собираем, как мы их используем, и как мы обеспечиваем их защиту.<br><br>

Сбор и использование данных<br>
Мы собираем ограниченное количество персональной информации о посетителях нашего сайта. Когда вы используете наши сервисы, мы можем собирать следующую информацию:<br><br>

Имя и адрес электронной почты: мы можем запрашивать ваше имя и адрес электронной почты, чтобы обеспечить связь с вами и предоставить ответы на ваши запросы.<br><br>

Техническая информация: мы автоматически собираем некоторую техническую информацию, такую как IP-адрес, тип браузера, операционную систему и дату и время посещения сайта. Эта информация помогает нам оптимизировать работу сайта и улучшать пользовательский опыт.<br><br>

Использование файлов cookie<br>
Мы используем файлы cookie для улучшения функциональности нашего сайта и собираем анонимную информацию о вашем взаимодействии с ним. Файлы cookie - это небольшие текстовые файлы, которые сохраняются на вашем устройстве и позволяют анализировать, как вы используете сайт. Вы можете отключить файлы cookie в настройках вашего браузера, но это может повлиять на работу некоторых функций нашего сайта.<br><br>

Раскрытие информации третьим лицам<br>
Мы строго соблюдаем принцип конфиденциальности и не передаем вашу персональную информацию третьим лицам без вашего согласия, за исключением случаев, предусмотренных законодательством.<br><br>

Безопасность данных<br>
Мы принимаем все необходимые меры для защиты ваших данных от несанкционированного доступа, использования или раскрытия. Мы используем надежные методы хранения и обработки данных, чтобы обеспечить их безопасность.<br><br>

Внесение изменений в политику конфиденциальности<br>
Мы оставляем за собой право вносить изменения в нашу политику конфиденциальности. В случае внесения значительных изменений мы уведомим вас путем размещения обновленной версии политики на этой странице.<br><br>

Если у вас возникнут вопросы или предложения относительно нашей политики конфиденциальности, пожалуйста, свяжитесь с нами через наши контактные данные.<br><br>

Спасибо за использование нашего сервиса!<br><br>

Контактные данные:<br><br>

VK: <a style="color: #fff;" href="https://vk.com/hdwcaptcha">https://vk.com/hdwcaptcha</a>
					</code>
				</div>
				<button class="copy-button" onclick="copyCode()">Скопировать</button>
			</div>
        </div>
	</div>

    <!-- Подвал -->
	<? include('./scripts/footer.php'); ?>

</div>

<script src="./scripts/index.js"></script>
<script src="./scripts/politics.js"></script>

</body>
</html>