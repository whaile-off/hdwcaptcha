<?php

require_once('../config.php');

$conn = new mysqli($config['bd']['host'], $config['bd']['user'], $config['bd']['password'], $config['bd']['name']);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = $_POST["login"];
    $password = $_POST["password"];

    $checkUserQuery = "SELECT * FROM hdwcaptchasite WHERE username = ?";
    $stmt = $conn->prepare($checkUserQuery);
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Пользователь с таким логином уже существует');</script>";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Хешируем пароль
        $insertUserQuery = "INSERT INTO hdwcaptchasite (username, password, captchas) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertUserQuery);
        $captchas = "0"; // Присваиваем значение captchas
        $stmt->bind_param("sss", $login, $hashedPassword, $captchas);

        if ($stmt->execute()) {
            header("Location: " . $config['link'] . "area?login=$login");
            exit;
        } else {
            echo "<script>alert('Ошибка при регистрации');</script>";
        }
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
			<p class="header" style="padding: 20px 0px 20px 10px;">Создать аккаунт</p>
			<form class="login-form" method="post" action="reg">
				<input type="text" name="login" placeholder="Логин">
				<input type="password" name="password" placeholder="Пароль">
				<button type="submit">Создать аккаунт</button>
				<button><a href="<?= $config['link'] ?>auth/login" style="color: #ccc; text-decoration: none;">Войти</a></button>
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