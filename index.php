<?php
$cache_file=""; $expires=""; $purge_cache=""; $request_limit=""; $_SESSION['views']=true;

if (!$cache_file) $cache_file = dirname(__FILE__) . '/api-cache.json';
if (!$expires) $expires = time() - 1 * 60 * 60;
if (!file_exists($cache_file)) die("Cache file is missing: $cache_file");
// Check that the file is older than the expire time and that it's not empty
if (filectime($cache_file) < $expires || file_get_contents($cache_file) == '' || $purge_cache && intval($_SESSION['views']) <= $request_limit) {
    // File is too old, refresh cache
    $api_results = file_get_contents('http://openweathermap.org/data/2.5/weather?id=524901&appid=b6907d289e10d714a6e88b30761fae22');
    $json_results = json_encode($api_results);
    // Remove cache file on error to avoid writing wrong xml
    if ($api_results && $json_results)
        file_put_contents($cache_file, $json_results);
    else
        unlink($cache_file);
} else {
    // Check for the number of purge cache requests to avoid abuse
    if (intval($_SESSION['views']) >= $request_limit)
        $limit_reached = " <span class='error'>Request limit reached ($request_limit). Please try purging the cache later.</span>";
    // Fetch cache
    $json_results = file_get_contents($cache_file);
    $request_type = 'JSON';
}

$a = json_decode($json_results);
$api = json_decode($a, true);

$city = $api ['name'];
$weather_conditions = $api ['weather'] ['0'] ['main'];
$temp = $api ['main'] ['temp'];
$humidity = $api ['main'] ['humidity'];
$pressure = $api ['main'] ['pressure'];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <style type="text/css">
        .weather {
            background-color: yellow;
            color: black;
        }

        span {
            font-weight: 900;
        }

        .error {
            color: red;
        }
    </style>
    <title>Lesson-4</title>
</head>
<body>
<table class="weather">
    <tr>
        <td>Город:</td>
        <td colspan="2"><span><?php echo $city; ?></span></td>
    </tr>
    <tr>
        <td>Погодные условия:</td>
        <td><span><?php echo $weather_conditions; ?><span></td>
        <td>
    <tr>
        <td>Температура:</td>
        <td><span><?php echo $temp; ?></span>°C</td>
        <td>
    <tr>
        <td>Влажность:</td>
        <td><span> <?php echo $humidity; ?></span>%</td>
        <td>
    <tr>
        <td>Давление:</td>
        <td><span><?php echo $pressure; ?></span> hpa</td>
        <td>
</table>
</body>
</html>

