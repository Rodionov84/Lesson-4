<?php
$a = file_get_contents('http://openweathermap.org/data/2.5/weather?id=524901&appid=b6907d289e10d714a6e88b30761fae22');

$api = json_decode($a, true);

//var_dump($api); exit;

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
		<tr><td>Город:</td><td colspan="2"><span><?php echo $api ['name']; ?></span></td></tr>
		<tr><td>Погодные условия:</td><td> <span><?php echo $api ['weather'] ['0'] ['main']; ?><span></td><td>
		<tr><td>Температура:</td><td><span><?php echo $api ['main'] ['temp']; ?></span>°C</td><td>
		<tr><td>Влажность:</td><td><span> <?php echo $api ['main'] ['humidity']; ?></span>%</td><td>
		<tr><td>Давление:</td><td><span><?php echo $api ['main'] ['pressure']; ?></span> hpa</td><td>		
    </table>
  </body>
</html>

