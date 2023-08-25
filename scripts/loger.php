<?
$user_agent = $_SERVER['HTTP_USER_AGENT'];

function getOS() {
    global $user_agent;

    $os_platform = "Неизвестная операционная система";

    $os_array = array(
        '/windows nt 10.0|windows nt 6.4/i' => 'Windows 11',
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile',
        '/windows phone/i' => 'Windows Phone',
        '/windows mobile/i' => 'Windows Mobile',
        '/bada/i' => 'Bada',
        '/tizen/i' => 'Tizen',
        '/maemo/i' => 'Maemo',
        '/meego/i' => 'MeeGo',
        '/webtv/i' => 'WebTV',
        '/palm/i' => 'Palm',
        '/symbian|symbos/i' => 'Symbian'
    );

    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }

    return $os_platform;
}

function getBrowser() {
    global $user_agent;

    $browser = "Неизвестный браузер";

    $browser_array = array(
        '/msie/i' => 'Internet Explorer',
        '/trident/i' => 'Internet Explorer',
        '/edg/i' => 'Microsoft Edge',
        '/edge/i' => 'Edge',
        '/firefox/i' => 'Firefox',
        '/Mozilla/i' => 'Mozila',
        '/Mozilla/5.0/i' => 'Mozila',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/opera|opr/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/Bot/i' => 'BOT Browser',
        '/Valve Steam GameOverlay/i' => 'Steam',
        '/mobile|mobile/i' => 'Mobile',
        '/playstation 4/i' => 'PlayStation 4',
        '/xbox/i' => 'Xbox',
        '/nintendo/i' => 'Nintendo',
        '/kindle/i' => 'Kindle',
        '/playbook/i' => 'BlackBerry PlayBook',
        '/rim tablet os/i' => 'BlackBerry Tablet OS',
        '/wii/i' => 'Wii',
        '/psp|playstation portable/i' => 'PlayStation Portable',
        '/psvita|playstation vita/i' => 'PlayStation Vita'
    );

    foreach ($browser_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }
    }

    return $browser;
}

$site_refer = "";
if(isset($_SERVER['HTTP_REFERER'])) {
    $site_refer = $_SERVER['HTTP_REFERER'];
}
if($site_refer == ""){
    $site = "Прямое подключение";
} else {
    if($site_refer == $config['site_url']) {
        $site = "Прямое подключение";
    } else {
        $site = $site_refer;
    }
}
if ($site == '') {
    $site = 'Прямое подключение';
}

$ip = $_SERVER['REMOTE_ADDR'];

$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip.'?fields=status,message,continent,continentCode,country,countryCode,region,regionName,city,district,zip,lat,lon,timezone,offset,currency,isp,org,as,asname,reverse,mobile,proxy,hosting,query&lang=ru')); // Делаем запрос в базу

$index = $query['zip'];

if ($query['zip'] == '') {
    $index = 'Невозможно определить';
}

$cord_sh = $query['lat'];
$cord_dol = $query['lon'];
$country = $query['country'];
$sity = $query['city'];
$proxy = $query['proxy'];
if ($query['proxy'] == '1') {
    $proxy_1 = 'Да';
} else {
    $proxy_1 = 'Нет';
}

$hosting = $query['hosting'];
if ($query['hosting'] == '1') {
    $hosting_1 = 'Да';
} else {
    $hosting_1 = 'Нет';
}

$user_os = getOS();
$user_browser = getBrowser();
$date_today = date("m.d.y");
$today = date("H:i:s");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$sql = "SELECT pays FROM hdwcaptchasitebd";
$result = $conn->query($sql);

if ($result->num_rows === 1) {} else {
    $insertQuery = "INSERT INTO hdwcaptchasitebd (pays) VALUES (?)";
    $pays = "0";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("s", $pays);
    $stmt->execute();
}

$checkQuery = "SELECT COUNT(*) as count FROM hdwcaptchalogs WHERE ip = ?";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param("s", $ip);
$stmt->execute();
$result = $stmt->get_result();

$row = $result->fetch_assoc();
if ($row["count"] == 0) {
    $insertQuery = "INSERT INTO hdwcaptchalogs (ip, browser, os, site, country, sity, hosting, proxy) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
	$stmt = $conn->prepare($insertQuery);
	$stmt->bind_param("ssssssss", $ip, $user_browser, $user_os, $site, $country, $sity, $hosting_1, $proxy_1);
	$stmt->execute();
}
$conn->close();

?>