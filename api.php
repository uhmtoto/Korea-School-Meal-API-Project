<?php
    $_SCname = $_GET['scname'];
    $_SCcode = $_GET['sccode'];
    $_SCloc = $_GET['scloc'];
    $_SCkin = $_GET['sckin'];
    $_Mcode = $_GET['mcode'];
    $_Date = $_GET['date'];
    $URL = "https://stu.goe.go.kr/sts_sci_md01_001.do?schulCode=$_SCcode&&schulCrseScCode=$_SCkin&schMmealScCode=$_Mcode&schYmd=$_Date";
    echo $URL;
?>