<?php
    include_once('../config/dbconfig.php');

    //POST data
    $scname = $_POST['scname'];
    $sccode = $_POST['sccode'];
    $sctype = $_POST['sctype'];
    $usrmail = $_POST['usrmail'];
    $rea = $_POST['rea'];
    $scloc = $_POST['scloc'];

    //generate random key  (http://blog.devez.net/285)
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 10; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    
    //sql query
    $Query = 'INSERT INTO `api`(`apikey`, `scname`, `scloc`, `sccode`, `sctype`, `usrmail`, `reason`) VALUES ("'.$randomString.'", "'.$scname.'", "'.$scloc.'", "'.$sccode.'", "'.$sctype.'", "'.$usrmail.'", "'.$rea.'")';

    if(!mysql_query($Query, $conn)) { //fail
        $redirect_URL = "등록을 실패했습니다.<br>다시 한번 시도해 주세요.";
    }
    else { //success
        $redirect_URL = "등록을 성공했습니다.<br>당신의 API 키는 ".$randomString."입니다.<br>자세한 사용방법은 메인 페이지를 참고 해주세요.";
    }
    Header("Location: http://uhmsh2018.iwinv.net/mealapi/alert.html?text=$redirect_URL");
?>