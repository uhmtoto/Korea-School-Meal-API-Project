<?php
    $key = $_GET['key'];
    $date = $_GET['date'];
    $meal = $_GET['meal'];
    $date = str_replace('-', '', $date);
    $URL = "http://uhmsh2018.iwinv.net/mealapi/api.php?apikey=$key&date=$date&meal=$meal";
	echo "$URL";
?>