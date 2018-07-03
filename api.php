<?php
    //config, library
    include_once('./config/data.php');
    include_once('./config/dbconfig.php');
    include_once('./lib/snoopy/Snoopy.class.php');

    //set API key from GET method
    $_APIKEY = $_GET['apikey'];

    //SQL query
    $Query = "SELECT * FROM `api` WHERE `apikey`='$_APIKEY'";
    $res = mysql_query($Query, $conn);
    $res = mysql_fetch_array($res);

    //set vars from $res
    $_SCname = $res['scname'];
    $_SCcode = $res['sccode'];
    $_SCloc = $res['scloc'];
    $_SCloc = $loc[$_SCloc];
    $_SCtype = $res['sctype'];
    $_Mcode = $_GET['meal'];
    $_Date = $_GET['date'];
    if($_SCtype == "초") $_SCtype = 2;
    if($_SCtype == "중") $_SCtype = 3;
    if($_SCtype == "고") $_SCtype = 4;
    if($_Mcode == "조식") $_Mcode = 1;
    if($_Mcode == "중식") $_Mcode = 2;
    if($_Mcode == "석식") $_Mcode = 3;

    //parse with Snoopy class
    $URL = "https://stu.$_SCloc.go.kr/sts_sci_md01_001.do?schulCode=$_SCcode&schulCrseScCode=$_SCtype&schMmealScCode=$_Mcode&schYmd=$_Date";
    $snoopy = new Snoopy;
    $snoopy->fetch($URL);

    //process
    preg_match('/<tbody>(.*?)<\/tbody>/s', $snoopy->results, $res);
    preg_match_all('/<tr>(.*?)<\/tr>/s', $res[0], $res);
    $cnt = $res[0][0];
    preg_match_all('/<td class="textC">(.*?)<\/td/', $cnt, $cnt);
    preg_match_all('/<td class="textC">(.*?)<\/td>/', $res[0][1], $fin);
    $cnt[0][1]=str_replace('<td class="textC">', '', $cnt[0][1]);
    $cnt[0][1]=str_replace('</td', '', $cnt[0][1]);
    $cnt = $cnt[0][1];
    $fin = $fin[1][date('w', strtotime($_Date))];
    $fin = preg_replace('/[0-9@.]*/', '', $fin);
    $fin = str_replace('<br />', ',', $fin);
    $fin = substr_replace($fin, '', -1);
    if($fin=="") $fin = "오늘의 식단이 없습니다.";

    //output with JSON
    $json = json_encode(Array(
        '학교명'=>$_SCname,
        '일자'=>$_Date,
        '식단'=>$fin,
        '제공인원수'=>$cnt
    ), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    echo($json);
?>