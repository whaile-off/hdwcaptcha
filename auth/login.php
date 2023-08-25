<?php

require_once('../config.php');

$conn = new mysqli($config['bd']['host'], $config['bd']['user'], $config['bd']['password'], $config['bd']['name']);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = $_POST["login"];
    $password = $_POST["password"];

    $sql = "SELECT password FROM hdwcaptchasite WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];
        if (password_verify($password, $hashedPassword)) { // Проверяем хеш пароля
            header("Location: " . $config['link'] . "area?login=$login");
            exit;
        } else {
            echo "<script>alert('Неверный логин или пароль');</script>";
        }
    } else {
        echo "<script>alert('Неверный логин или пароль');</script>";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../scripts/style.css">
	<link rel="icon" href="../img/logo.png" type="image/x-icon">
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
            <button class="nav-btn selected"><a href="<?= $config['link'] ?>auth/login" class="item" style="color: #ccc; text-decoration: none;">Войти</a></button>
        </div>

        <button class="toggler">
            <i class='bx bx-menu'></i>
        </button>
    </div>
	
    <div class="top-container">
		<div class="nft-nobox"></div>

		<div class="auth-box">
			<p class="header" style="padding: 20px 0px 20px 10px;">Войти</p>
			<form class="login-form" method="post" action="login">
				<input type="text" name="login" placeholder="Логин">
				<input type="password" name="password" placeholder="Пароль">
				<a href="https://vk.com/hdwcaptcha">Забыли свой пароль?</a>
				<button type="submit">Войти</button>
				<button><a href="<?= $config['link'] ?>auth/reg" style="color: #ccc; text-decoration: none;">Создать аккаунт</a></button>
			</form>
		</div>
			
		<div class="nft-nobox"></div>
	</div>



    <!-- Подвал -->
	<? include('../scripts/footer.php'); ?>

</div>


<script src="../scripts/index.js"></script>
</body>
</html>