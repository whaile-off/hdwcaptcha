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
		<p class="header">Документация</p>
	</div>

    <div class="top-container">
        <div class="info-box">
            <div id="codeContainer" class="code-block">
				<div class="code-title">Java</div>
				<div class="pading-cod">
					<code id="codeBlock" class="code-content">public class HelloWorld {
	public static void main(String[] args) {
		System.out.println("Hello, World!");
	}
}

//TODO DOCS
					</code>
				</div>
				<button class="copy-button" onclick="copyCode()">Скопировать код</button>
			</div>
        </div>
		<div class="container-box" style="border: none;background: none;">
            <div class="container-content">
                <div class="info">
                    <div>
                        <h1 style="color: #fff;">Поключение <?= $config['site'] ?> библиотеки на Java</h1>
                    </div>
                </div>
            </div>
        </div>
	</div>
	
	<div class="top-container">
        <div class="info-box">
            <div id="codeContainer" class="code-block">
				<div class="code-title">Java</div>
				<div class="pading-cod">
					<code id="codeBlock" class="code-content">public class HelloWorld {
	public static void main(String[] args) {
		System.out.println("Hello, World!");
	}
}

//TODO DOCS
					</code>
				</div>
				<button class="copy-button" onclick="copyCode()">Скопировать код</button>
			</div>
        </div>
		<div class="container-box" style="border: none;background: none;">
            <div class="container-content">
                <div class="info">
                    <div>
                        <h1 style="color: #fff;">Поключение <?= $config['site'] ?> библиотеки на Java</h1>
                    </div>
                </div>
            </div>
        </div>
	</div>

    <!-- Подвал -->
	<? include('./scripts/footer.php'); ?>

</div>

<script src="./scripts/index.js"></script>
<script src="./scripts/code.js"></script>

</body>
</html>