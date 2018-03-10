<?php
$cache_file = dirname(__FILE__) . '/api-cache.json'; // Specify the path to the cache file and its name
$expires = time() - 1 * 60 * 60;
$api_url="http://openweathermap.org/data/2.5/weather?id=524901&appid=b6907d289e10d714a6e88b30761fae22";

if (!file_exists($cache_file)) {
    $create_file = fopen($cache_file, "w");
    $create_file = file_get_contents($api_url);
}
// Check that the file is older than the expire time and that it's not empty
if (filectime($cache_file) < $expires || file_get_contents($cache_file) == '') {
    // File is too old, refresh cache
    $api_results = file_get_contents($api_url);
    $json_results = json_encode($api_results);
    // Remove cache file on error to avoid writing wrong xml
    if ($api_results && $json_results) {
        file_put_contents($cache_file, $json_results);
    }
    else
        unlink($cache_file);
}
$json_results = file_get_contents($cache_file);

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

