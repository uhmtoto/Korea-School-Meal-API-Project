<?php
    //include config, lib
    include_once('./config/data.php');
    include_once('./config/dbconfig.php');
    include_once('./lib/snoopy/Snoopy.class.php');

    //set variable
    $_SCname = $_GET['scname'];
    $_SCcode = $_GET['sccode'];
    $_SCloc = $_GET['scloc'];
    $_SCloc = $loc[$_SCloc];
    $_SCtype = $_GET['SCtype'];
    if($_SCtype == "초") $_SCtype = 2;
    if($_SCtype == "중") $_SCtype = 3;
    if($_SCtype == "고") $_SCtype = 4;
    $_Mcode = $_GET['mcode'];
    if($_Mcode == "조") $_Mcode = 1;
    if($_Mcode == "중") $_Mcode = 2;
    if($_Mcode == "석") $_Mcode = 3;
    $_Date = $_GET['date'];

    //parse with Snoopy class
    $URL = "https://stu.$_SCloc.go.kr/sts_sci_md01_001.do?schulCode=$_SCcode&schulCrseScCode=$_SCtype&schMmealScCode=$_Mcode&schYmd=$_Date";
    $snoopy = new Snoopy;
    $snoopy->fetch($URL);

    //process
    preg_match('/<tbody>(.*?)<\/tbody>/s', $snoopy->results, $res);
    preg_match_all('/<tr>(.*?)<\/tr>/s', $res[0], $res);
    preg_match_all('/<td class="textC">(.*?)<\/td>/s', $res[0][1], $fin);
    $fin = $fin[1];
    $fin = $fin[date('w', strtotime($_Date))];
    $fin = preg_replace('/[0-9@.]*/', '', $fin);
    $json = json_encode(Array(
        '학교명'=>$_SCname,
        '일자'=>$_Date,
        '식단'=>$fin,
        '제공인원수'=>0
    ), JSON_UNESCAPED_UNICODE);
    
    //output
    echo ($json);
?>