<?php
require_once('../config.php');

$promoCode = $_POST['promo'];
$price = $_POST['price'];
$login = $_POST['login'];

if ($price != 149 && $price != 2299 && $price != 3299 && $price != 249 && $price != 359) {
    $response = array(
        'success' => false,
        'message' => 'Чо самый умный?',
    );
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

$promoCodes = $config['promoCodes'];

if (array_key_exists($promoCode, $promoCodes)) {
    $discountPercentage = $promoCodes[$promoCode];
    $discountedAmount = $price - ($price * $discountPercentage) / 100; 

    $orderId = $login;
    $sign = md5($config['freekassa']['merchantId'] . ':' . $discountedAmount . ':' . $config['freekassa']['secretWordLink'] . ':' . $config['freekassa']['currency'] . ':' . $orderId);
    $paymentUrl = "https://pay.freekassa.ru/?m={$config['freekassa']['merchantId']}&oa={$discountedAmount}&o={$orderId}&s={$sign}&currency={$config['freekassa']['currency']}&us_success={$config['freekassa']['successUrl']}&us_fail={$config['freekassa']['failUrl']}&description={$config['freekassa']['description']}";

    $response = array(
        'success' => true,
        'discountedAmount' => $discountedAmount,
        'paymentUrl' => $paymentUrl,
    );
} else {
    $response = array(
        'success' => false,
        'message' => 'Промокод недействителен',
    );
}

header('Content-Type: application/json');
echo json_encode($response);
