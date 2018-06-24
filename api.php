<?php
    //include config, lib
    include_once('./config/data.php');
    include_once('./config/dbconfig.php');
    include_once('./lib/snoopy/Snoopy.class.php');

    //set variable
    $_APIKEY = $_GET['apikey'];

    //SQL query
    $Query = "SELECT * FROM `api` WHERE `apikey`='$_APIKEY'";
    $res = mysql_query($Query, $conn);
    $res = mysql_fetch_array($res);
    //print_r($res);
    $_SCname = $res['scname'];
    $_SCcode = $res['sccode'];
    $_SCloc = $res['scloc'];
    $_SCloc = $loc[$_SCloc];
    $_SCtype = $res['sctype'];
    if($_SCtype == "초") $_SCtype = 2;
    if($_SCtype == "중") $_SCtype = 3;
    if($_SCtype == "고") $_SCtype = 4;
    $_Mcode = $res['meal'];
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
    $cnt = $res[0][0];
    preg_match_all('/<td class="textC">(.*?)<\/td/', $cnt, $cnt);
    preg_match_all('/<td class="textC">(.*?)<\/td>/', $res[0][1], $fin);
    $cnt[0][1]=str_replace('<td class="textC">', '', $cnt[0][1]);
    $cnt[0][1]=str_replace('</td', '', $cnt[0][1]);
    $cnt = $cnt[0][1];
    $fin = $fin[1];
    $fin = $fin[date('w', strtotime($_Date))];
    $fin = preg_replace('/[0-9@.]*/', '', $fin);
    $fin = str_replace('<br />', ',', $fin);
    $fin = substr_replace($fin, '', -1);
    echo '<pre>{<br>';
    echo '  "학교명":"'.$_SCname.'",<br>';
    echo '  "일자":"'.$_Date.'",<br>';
    echo '  "식단":"'.$fin.'",<br>';
    echo '  "제공인원수":"'.$cnt.'"<br>';
    echo '}</pre>';
?>