<?php

require_once('./scripts/loger.php');
require_once('./config.php');

$type = $_REQUEST['type']; 
$login = $_REQUEST['login'];

if ($type == 'rates') {
    $rates = true;
} else {
    $rates = false;
}

$conn = new mysqli($config['bd']['host'], $config['bd']['user'], $config['bd']['password'], $config['bd']['name']);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$getUserQuery = "SELECT captchas FROM hdwcaptchasite WHERE username = ?";
$stmt = $conn->prepare($getUserQuery);
$stmt->bind_param("s", $login);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $captchas = $row["captchas"];
} else {
    echo "<script>alert('Пользователь с логином не найден');</script>";
	header('Location:' . $config['link'] . 'auth/login');
    exit();
}

$getTotalRowsQuery = "SELECT COUNT(*) AS total_rows FROM hdwcaptchalogs";
$result = $conn->query($getTotalRowsQuery);

$klients = 0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $klients = $row["total_rows"];
}

$getUserQuery = "SELECT pays FROM hdwcaptchasitebd";
$result = $conn->query($getUserQuery);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pays = $row["pays"];
}

$site_refer = "";
if (isset($_SERVER['HTTP_REFERER'])) {
    $site_refer = $_SERVER['HTTP_REFERER'];
}
if ($site_refer == "") {
    $site = "Прямое подключение";
} else {
    $site = $site_refer;
}

$allowed_prefixes = array(
    $config['link'] . 'auth/login',
    $config['link'] . 'auth/reg',
    $config['link'] . 'area',
);

$allowed = false;

foreach ($allowed_prefixes as $prefix) {
    if (strpos($site, $prefix) === 0) {
        $allowed = true;
        break;
    }
}

if ($allowed) {
    // Место для вашего дальнейшего кода, если сайт разрешен
} else {
    header('Location: ' . $config['link'] . 'auth/login');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./scripts/area.css">
	<link rel="icon" href="img/logo.png" type="image/x-icon">
    <title><?= $config['description'] ?></title>
</head>

<body>

    <div class="sidebar">
        <a href="<?= $config['link'] ?>index.php" class="logo">
            <i class='bx bx-code-alt'></i>
            <div class="logo-name"><span>HDW</span>captcha</div>
        </a>
        <ul class="side-menu">
            <li <?if ($rates == false) {echo 'class="active"';}?>><a href="<?= $config['link'] ?>area?login=<? echo $login?>"><i class='bx bxs-dashboard'></i>Главная</a></li>
			<li <?if ($rates == true) {echo 'class="active"';}?>><a href="<?= $config['link'] ?>area?type=rates&login=<? echo $login?>""><i class='bx bx-store-alt'></i>Тарифы</a></li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="<?= $config['link'] ?>" class="logout">
                    <i class='bx bx-log-out-circle'></i>
                    Выйти
                </a>
            </li>
        </ul>
    </div>

    <div class="content">
        <nav>
            <i class='bx bx-menu'></i>
            <form action="#">
                <div class="form-input">
                    <button class="" type="" style="border: none;"></button>
                </div>
            </form>
        </nav>

        <main>
		<div class="main">
            <div class="header">
                <div class="left">
                    <h1><?if ($rates == false) {echo 'Главная '.$login;} else {echo 'Тарифы';}?></h1>
                </div>
				<?php if (!$rates): ?>
				<a href="#" class="report">
                    <i class='bx bx-cloud-download'></i>
                    <div style="white-space: pre;"><?= $config['site'] ?> lib</div>
                </a>
				<?php endif; ?>
            </div>

            <?php if (!$rates): ?>
				<ul class="insights">
					<li>
						<i class='bx bx-calendar-check'></i>
						<span class="info">
							<h3><? echo $captchas?></h3>
							<p>Решено</p>
						</span>
					</li>
					<li>
						<i class='bx bx-show-alt'></i>
						<span class="info">
							<h3><? echo $klients?></h3>
							<p>Клиентов</p>
						</span>
					</li>
					<li>
						<i class='bx bx-line-chart'></i>
						<span class="info">
							<h3><? echo $pays?></h3>
							<p>Покупок</p>
						</span>
					</li>
				</ul>
			<?php else: ?>
				
				<div class="top-nft">
					
					<div class="nft-box">
						<p style="font-size: 25px;text-align: center;padding: 10px 0px;color: #fff;">Ключ API</p>
						<img src="./img/rate_1.jpg" class="nft-pic">
						<div class="nft-content">
							<div class="info">
								<div>
									<h2>На день</h2>
									<h4>1 устройство</h4>
								</div>
							</div>
							<div class="likes">
								<div class="icon-box">
									<a href="#rate-1" style="color: #fff; text-decoration: none;">Купить: 149₽</a>
								</div>
							</div>
						</div>
					</div>
					<div class="nft-box">
						<p style="font-size: 25px;text-align: center;padding: 10px 0px;color: #fff;">Ключ API</p>
						<img src="./img/rate_2.jpg" class="nft-pic">
						<div class="nft-content">
							<div class="info">
								<div>
									<h2>На месяц</h2>
									<h4>1 устройство</h4>
								</div>
							</div>
							<div class="likes">
								<div class="icon-box">
									<a href="#rate-2" style="color: #fff; text-decoration: none;" target="_blank">Купить: 2299₽</a>
								</div>
							</div>
						</div>
					</div>
					<div class="nft-box">
						<p style="font-size: 25px;text-align: center;padding: 10px 0px;color: #fff;">Ключ API</p>
						<img src="./img/rate_3.jpg" class="nft-pic">
						<div class="nft-content">
							<div class="info">
								<div>
									<h2>Навсегда</h2>
									<h4>1 устройство</h4>
								</div>
							</div>
							<div class="likes">
								<div class="icon-box">
									<a href="#rate-3" style="color: #fff; text-decoration: none;" target="_blank">Купить: 3299₽</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="top-nft">
					
					<div class="nft-box">
						<p style="font-size: 25px;text-align: center;padding: 10px 0px;color: #fff;">Подписка</p>
						<img src="./img/rate_4.jpg" class="nft-pic">
						<div class="nft-content">
							<div class="info">
								<div>
									<h2>Навсегда</h2>
									<h4>+ модуль eng</h4>
								</div>
							</div>
							<div class="likes">
								<div class="icon-box">
									<a href="#rate-4" style="color: #fff; text-decoration: none;" target="_blank">Купить: 149₽</a>
								</div>
							</div>
						</div>
					</div>
					<div class="nft-box">
						<p style="font-size: 25px;text-align: center;padding: 10px 0px;color: #fff;">Подписка</p>
						<img src="./img/rate_5.jpg" class="nft-pic">
						<div class="nft-content">
							<div class="info">
								<div>
									<h2>Навсегда</h2>
									<h4>+ модуль eng</h4>
									<h4>+ модуль rus</h4>
								</div>
							</div>
							<div class="likes">
								<div class="icon-box">
									<a href="#rate-5" style="color: #fff; text-decoration: none;" target="_blank">Купить: 249₽</a>
								</div>
							</div>
						</div>
					</div>
					<div class="nft-box">
						<p style="font-size: 25px;text-align: center;padding: 10px 0px;color: #fff;">Подписка</p>
						<img src="./img/rate_6.jpg" class="nft-pic">
						<div class="nft-content">
							<div class="info">
								<div>
									<h2>Навсегда</h2>
									<h4>+ модуль eng</h4>
									<h4>+ модуль rus</h4>
									<h4>+ модуль int</h4>
								</div>
							</div>
							<div class="likes">
								<div class="icon-box">
									<a href="#rate-6" style="color: #fff; text-decoration: none;" target="_blank">Купить: 359₽</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if (!$rates): ?>
				<div class="bottom-data">
					<div class="reminders">
						<div class="header">
							<i class='bx bx-note'></i>
							<h3>Ваши ключи</h3>
							<a href="<?= $config['link'] ?>area?type=rates&login=<?php echo $login?>" style="color: #fff;"><i class='bx bx-plus'></i></a>
						</div>
						<ul class="task-list">
							<?php
							// Получение всех ключей пользователя по логину
							$getKeysQuery = "SELECT * FROM hdwcaptchakeys WHERE username = ?";
							$stmt = $conn->prepare($getKeysQuery);
							$stmt->bind_param("s", $login);
							$stmt->execute();
							$result = $stmt->get_result();

							// Вывод ключей
							while ($row = $result->fetch_assoc()) {
								$keytype = $row["keytype"];
								$keystart = $row["keystart"];
								$keyName = $row["secret"];
								$completed = $row["active"];

								if ($completed == "true") {
									echo '<li class="completed">';
									echo '<div class="task-title">';
									echo '<i class="bx bx-check-circle"></i>';
									echo '<p>' . $keytype . " | " . $keystart . " | " . $keyName . '</p>';
									echo '</div>';
									echo '</li>';
								} else {
									echo '<li class="not-completed">';
									echo '<div class="task-title">';
									echo '<i class="bx bx-x-circle"></i>';
									echo '<p>' . $keytype . " | " . $keystart . " | " . $keyName . '</p>';
									echo '</div>';
									echo '</li>';
								}
							}

							?>
						</ul>
					</div>
				</div>
				
				<div class="bottom-data">
					<div class="reminders">
						<div class="header">
							<i class='bx bx-note'></i>
							<h3>Ваши подписки</h3>
							<a href="<?= $config['link'] ?>area?type=rates&login=<?php echo $login?>" style="color: #fff;"><i class='bx bx-plus'></i></a>
						</div>
						<ul class="task-list">
							<?php
							// Получение всех ключей пользователя по логину
							$getKeysQuery = "SELECT * FROM hdwcaptchasube WHERE username = ?";
							$stmt = $conn->prepare($getKeysQuery);
							$stmt->bind_param("s", $login);
							$stmt->execute();
							$result = $stmt->get_result();

							// Вывод ключей
							while ($row = $result->fetch_assoc()) {
								$subetype = $row["subetype"];
								
								echo '<li class="completed">';
								echo '<div class="task-title">';
								echo '<i class="bx bx-check-circle"></i>';
								echo '<p>' . $subetype . '</p>';
								echo '</div>';
								echo '</li>';
							}

							?>
						</ul>
					</div>
				</div>
			<?php endif; ?>
			
			<!-- Подвал -->
			<? include('./scripts/footer.php'); ?>

		</div>
        </main>

    </div>
	
	<?php
	$amount1 = 149;
	$amount2 = 2299;
	$amount3 = 3299;
	$amount4 = 149;
	$amount5 = 249;
	$amount6 = 359;
	
	$orderId1 = $login . " rate_1";
	$orderId2 = $login . " rate_2";
	$orderId3 = $login . " rate_3";
	$orderId4 = $login . " rate_4";
	$orderId5 = $login . " rate_5";
	$orderId6 = $login . " rate_6";
	?>

	<div id="rate-1">
		<div id="oknoo"><br>
			<a href="<?= $config['link'] ?>area?type=rates&login=<?php echo $login ?>" class="closeo">Закрыть окно</a>
			<p class="header" style="padding: 20px 0px 10px 0px;font-size: 25px;">Ключ API | На день</p>
			<?php
			$sign = md5($config['freekassa']['merchantId'] . ':' . $amount1 . ':' . $config['freekassa']['secretWordLink'] . ':' . $config['freekassa']['currency'] . ':' . $orderId1);
			$paymentUrl = "https://pay.freekassa.ru/?m={$config['freekassa']['merchantId']}&oa={$amount1}&o={$orderId1}&s={$sign}&currency={$config['freekassa']['currency']}&us_success={$successUrl}&us_fail={$config['freekassa']['failUrl']}&description={$description}";
			?>
			<form class="buy-form promo-form" method="post" action="area?type=rates&login=<?php echo $login ?>#rate-1" id="promoForm1">
				<input type="text" name="promo" id="promoInput1" placeholder="Промокод" data-price="<?php echo $amount1; ?>">
				<p style="padding: 10px 0px;">Вы получите ключ от API hdwcaptcha в личном кобинете!</p>
				<button type="submit" name="submit" class="buy-button">
					<a id="buyLink" href="<?php echo $paymentUrl; ?>" style="color: #fff;">Купить: <?php echo $amount1; ?>₽</a>
				</button>
			</form>
		</div>
	</div>

	<div id="rate-2">
		<div id="oknoo"><br>
			<a href="<?= $config['link'] ?>area?type=rates&login=<? echo $login ?>" class="closeo">Закрыть окно</a>
			<p class="header" style="padding: 20px 0px 10px 0px;font-size: 25px;">Ключ API | На месяц</p>
			<?php
			$sign = md5($config['freekassa']['merchantId'] . ':' . $amount2 . ':' . $config['freekassa']['secretWordLink'] . ':' . $config['freekassa']['currency'] . ':' . $orderId2);
			$paymentUrl = "https://pay.freekassa.ru/?m={$config['freekassa']['merchantId']}&oa={$amount2}&o={$orderId2}&s={$sign}&currency={$config['freekassa']['currency']}&us_success={$successUrl}&us_fail={$config['freekassa']['failUrl']}&description={$description}";
			?>
			<form class="buy-form promo-form" method="post" action="area?type=rates&login=<? echo $login ?>#rate-2" id="promoForm2">
				<input type="text" name="promo" id="promoInput2" placeholder="Промокод" data-price="<?php echo $amount2; ?>">
				<p style="padding: 10px 0px;">Вы получите ключ от API hdwcaptcha в личном кобинете!</p>
				<button type="submit" name="submit" class="buy-button">
					<a id="buyLink" href="<?php echo $paymentUrl; ?>" style="color: #fff;">Купить: <?php echo $amount2; ?>₽</a>
				</button>
			</form>
		</div>
	</div>

	<div id="rate-3">
		<div id="oknoo"><br>
			<a href="<?= $config['link'] ?>area?type=rates&login=<? echo $login ?>" class="closeo">Закрыть окно</a>
			<p class="header" style="padding: 20px 0px 10px 0px;font-size: 25px;">Ключ API | Навсегда</p>
			<?php
			$sign = md5($config['freekassa']['merchantId'] . ':' . $amount3 . ':' . $config['freekassa']['secretWordLink'] . ':' . $config['freekassa']['currency'] . ':' . $orderId3);
			$paymentUrl = "https://pay.freekassa.ru/?m={$config['freekassa']['merchantId']}&oa={$amount3}&o={$orderId3}&s={$sign}&currency={$config['freekassa']['currency']}&us_success={$successUrl}&us_fail={$config['freekassa']['failUrl']}&description={$description}";
			?>
			<form class="buy-form promo-form" method="post" action="area?type=rates&login=<? echo $login ?>#rate-3" id="promoForm3">
				<input type="text" name="promo" id="promoInput3" placeholder="Промокод" data-price="<?php echo $amount3; ?>">
				<p style="padding: 10px 0px;">Вы получите ключ от API hdwcaptcha в личном кобинете!</p>
				<button type="submit" name="submit" class="buy-button">
					<a id="buyLink" href="<?php echo $paymentUrl; ?>" style="color: #fff;">Купить: <?php echo $amount3; ?>₽</a>
				</button>
			</form>
		</div>
	</div>

	<div id="rate-4">
		<div id="oknoo"><br>
			<a href="<?= $config['link'] ?>area?type=rates&login=<? echo $login ?>" class="closeo">Закрыть окно</a>
			<p class="header" style="padding: 20px 0px 10px 0px;font-size: 25px;">Подписка | Навсегда</p>
			<?php
			$sign = md5($config['freekassa']['merchantId'] . ':' . $amount4 . ':' . $config['freekassa']['secretWordLink'] . ':' . $config['freekassa']['currency'] . ':' . $orderId4);
			$paymentUrl = "https://pay.freekassa.ru/?m={$config['freekassa']['merchantId']}&oa={$amount4}&o={$orderId4}&s={$sign}&currency={$config['freekassa']['currency']}&us_success={$successUrl}&us_fail={$config['freekassa']['failUrl']}&description={$description}";
			?>
			<form class="buy-form promo-form" method="post" action="area?type=rates&login=<? echo $login ?>#rate-4" id="promoForm4">
				<input type="text" name="promo" id="promoInput4" placeholder="Промокод" data-price="<?php echo $amount4; ?>">
				<p style="padding: 10px 0px;">Вы получите модуль eng!</p>
				<button type="submit" name="submit" class="buy-button">
					<a id="buyLink" href="<?php echo $paymentUrl; ?>" style="color: #fff;">Купить: <?php echo $amount4; ?>₽</a>
				</button>
			</form>
		</div>
	</div>

	<div id="rate-5">
		<div id="oknoo"><br>
			<a href="<?= $config['link'] ?>area?type=rates&login=<? echo $login ?>" class="closeo">Закрыть окно</a>
			<p class="header" style="padding: 20px 0px 10px 0px;font-size: 25px;">Подписка | Навсегда</p>
			<?php
			$sign = md5($config['freekassa']['merchantId'] . ':' . $amount5 . ':' . $config['freekassa']['secretWordLink'] . ':' . $config['freekassa']['currency'] . ':' . $orderId5);
			$paymentUrl = "https://pay.freekassa.ru/?m={$config['freekassa']['merchantId']}&oa={$amount5}&o={$orderId5}&s={$sign}&currency={$config['freekassa']['currency']}&us_success={$successUrl}&us_fail={$config['freekassa']['failUrl']}&description={$description}";
			?>
			<form class="buy-form promo-form" method="post" action="area?type=rates&login=<? echo $login ?>#rate-5" id="promoForm5">
				<input type="text" name="promo" id="promoInput5" placeholder="Промокод" data-price="<?php echo $amount5; ?>">
				<p style="padding: 10px 0px;">Вы получите модуль eng + модуль rus!</p>
				<button type="submit" name="submit" class="buy-button">
					<a id="buyLink" href="<?php echo $paymentUrl; ?>" style="color: #fff;">Купить: <?php echo $amount5; ?>₽</a>
				</button>
			</form>
		</div>
	</div>

	<div id="rate-6">
		<div id="oknoo"><br>
			<a href="<?= $config['link'] ?>area?type=rates&login=<? echo $login ?>" class="closeo">Закрыть окно</a>
			<p class="header" style="padding: 20px 0px 10px 0px;font-size: 25px;">Подписка | Навсегда</p>
			<?php
			$sign = md5($config['freekassa']['merchantId'] . ':' . $amount6 . ':' . $config['freekassa']['secretWordLink'] . ':' . $config['freekassa']['currency'] . ':' . $orderId6);
			$paymentUrl = "https://pay.freekassa.ru/?m={$config['freekassa']['merchantId']}&oa={$amount6}&o={$orderId6}&s={$sign}&currency={$config['freekassa']['currency']}&us_success={$successUrl}&us_fail={$config['freekassa']['failUrl']}&description={$description}";
			?>
			<form class="buy-form promo-form" method="post" action="area?type=rates&login=<? echo $login ?>#rate-6" id="promoForm6">
				<input type="text" name="promo" id="promoInput6" placeholder="Промокод" data-price="<?php echo $amount6; ?>">
				<p style="padding: 10px 0px;">Вы получите модуль eng + модуль rus + модуль int!</p>
				<button type="submit" name="submit" class="buy-button">
					<a id="buyLink" href="<?php echo $paymentUrl; ?>" style="color: #fff;">Купить: <?php echo $amount6; ?>₽</a>
				</button>
			</form>
		</div>
	</div>

    <script src="./scripts/area.js"></script>
	<script>
	
	function redirectTo(target) {
        window.location.href = target;
    }
	function handlePromoCodeChange(promoInput, buyLink, orderId) {
        promoInput.addEventListener("change", function () {
            var promoCode = this.value;

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);

                    if (response.success) {
                        var updatedAmount = response.discountedAmount;
                        var updatedPaymentUrl = response.paymentUrl;
                        buyLink.innerText = "Купить: " + updatedAmount + "₽";
                        buyLink.href = updatedPaymentUrl;
                    } else {
                        alert(response.message);
                    }
                }
            };
            var price = promoInput.dataset.price;

            xhr.open("POST", "./scripts/promo.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            var params = "promo=" + promoCode + "&price=" + price + "&login=" + orderId;
            xhr.send(params);
        });
    }

    handlePromoCodeChange(document.getElementById("promoInput1"), document.querySelector("#rate-1 .buy-button a"), "<? echo $orderId1; ?>");
    handlePromoCodeChange(document.getElementById("promoInput2"), document.querySelector("#rate-2 .buy-button a"), "<? echo $orderId2; ?>");
	handlePromoCodeChange(document.getElementById("promoInput3"), document.querySelector("#rate-3 .buy-button a"), "<? echo $orderId3; ?>");
	handlePromoCodeChange(document.getElementById("promoInput4"), document.querySelector("#rate-4 .buy-button a"), "<? echo $orderId4; ?>");
	handlePromoCodeChange(document.getElementById("promoInput5"), document.querySelector("#rate-5 .buy-button a"), "<? echo $orderId5; ?>");
	handlePromoCodeChange(document.getElementById("promoInput6"), document.querySelector("#rate-6 .buy-button a"), "<? echo $orderId6; ?>");
	
	const sidebarElem = document.querySelector('.sidebar');
    if (window.innerWidth < 768) {
        sidebarElem.classList.add('close');
    }
	</script>
</body>
</html>