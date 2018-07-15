<?php
    include_once('alert.php');
    $key = $_GET['key'];
    $date = $_GET['date'];
    $meal = $_GET['meal'];
    if(!preg_match('/[0-9]{8}/', $date)) alert("날짜가 올바르지 않습니다!");
    if(!preg_match('/[a-zA-z0-9]{10}/', $key)) alert("API 키가 올바르지 않습니다!");
    if($meal != "조" && $meal != "중" && $meal != "석") alert("식사 종류가 올바르지 않습니다!");

    /* 쿼리 폼 바꿔서 필요 없어짐 */
    //$date = str_replace('-', '', $meal);

    $URL = "https://www.uhmtoto.xyz/mealapi/api.php?apikey=$key&date=$date&meal=$meal";
    $URL = str_replace('&', '%26', $URL);

    $y = substr($date, 0, 4);
    $m = substr($date, 4, 2);
    $d = substr($date, 6, 2);
    alert($URL."<br>에 들어가시면 ".$y."년 ".$m."월 ".$d."일의 ".$meal."식을 JSON으로 받아보실 수 있습니다!");
?>