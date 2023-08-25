<?php

require_once('./config.php');

if (isset($_REQUEST['MERCHANT_ID']) && isset($_REQUEST['AMOUNT']) && isset($_REQUEST['MERCHANT_ORDER_ID']) && isset($_REQUEST['SIGN'])) {

    $receivedMerchantId = $_REQUEST['MERCHANT_ID'];
    $receivedAmount = $_REQUEST['AMOUNT'];
    $receivedOrderId = $_REQUEST['MERCHANT_ORDER_ID'];
    $receivedSign = $_REQUEST['SIGN'];
    
    list($login, $rate) = explode(' ', $receivedOrderId, 2);

    $expectedSign = md5($config['freekassa']['merchantId'] . ':' . $receivedAmount . ':' . $config['freekassa']['secretWordOplata'] . ':' . $receivedOrderId);

    if ($receivedSign === $expectedSign) {
        // Подпись совпадает, платеж прошел успешно

        $conn = new mysqli($config['bd']['host'], $config['bd']['user'], $config['bd']['password'], $config['bd']['name']);

        if ($conn->connect_error) {
            die("Ошибка подключения: " . $conn->connect_error);
        }

        function generateKey() {
            $blocks = array(
                strtoupper(substr(uniqid(), 0, 4)),
                strtoupper(substr(uniqid(), 4, 4)),
                strtoupper(substr(uniqid(), 8, 4))
            );

            return 'HDWcaptcha-' . implode('-', $blocks);
        }

        function addKey($username, $keytype, $keyExpiration, $conn) {
            $active = "true";
            $secret = generateKey();

            $insertKeyQuery = "INSERT INTO hdwcaptchakeys (username, keytype, keystart, active, secret) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertKeyQuery);
            $stmt->bind_param("sssss", $username, $keytype, $keyExpiration, $active, $secret);

            if ($stmt->execute()) {
                echo "Ключ успешно создан и добавлен в базу данных.";
            } else {
                echo "Ошибка при создании ключа: " . $stmt->error;
            }
        }

        function addSube($username, $subetype, $conn) {
            $insertKeyQuery = "INSERT INTO hdwcaptchasube (username, subetype) VALUES (?, ?)";
            $stmt = $conn->prepare($insertKeyQuery);
            $stmt->bind_param("ss", $username, $subetype);

            if ($stmt->execute()) {
                echo "Подписка успешно создана и добавлена в базу данных.";
            } else {
                echo "Ошибка при создании подписки: " . $stmt->error;
            }
        }

        if ($rate == "rate_1") {
            $keytype = "На день";
            $keyExpiration = date('Y-m-d H:i:s', strtotime('+1 day'));
            addKey($login, $keytype, $keyExpiration, $conn);
        } elseif ($rate == "rate_2") {
            $keytype = "На месяц";
            $keyExpiration = date('Y-m-d H:i:s', strtotime('+1 month'));
            addKey($login, $keytype, $keyExpiration, $conn);
        } elseif ($rate == "rate_3") {
            $keytype = "Навсегда";
            addKey($login, $keytype, $keytype, $conn);
        } elseif ($rate == "rate_4") {
            $subetype = "модуль eng";
            addSube($login, $subetype, $conn);
        } elseif ($rate == "rate_5") {
            $subetype = "модуль eng + модуль rus";
            addSube($login, $subetype, $conn);
        } elseif ($rate == "rate_6") {
            $subetype = "модуль eng + модуль rus + модуль int";
            addSube($login, $subetype, $conn);
        } else {
            echo "Неверный тариф: $rate";
        }

        $sql = "SELECT pays FROM hdwcaptchasitebd";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $currentKlients = (int)$row["pays"];
            $newKlients = $currentKlients + 1;

            $updateQuery = "UPDATE hdwcaptchasitebd SET pays = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("i", $newKlients);
            $stmt->execute();
        }

        // Закрытие соединения с базой данных
        $conn->close();

        echo 'Поздравляю! Оплата прошла успешно! Действие N выполнено для заказа ' . $receivedOrderId . ' на сумму ' . $receivedAmount . ' рублей.';
    } else {
        // Подпись не совпадает, платеж не прошел
        echo 'Что-то пошло не так. Платеж не был выполнен.';
    }
}
?>