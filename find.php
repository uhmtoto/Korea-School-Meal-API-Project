<!DOCTYPE HTML>
<html>

<head>
    <title>API 검색 결과</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
</head>

<body class="is-preload">

    <section id="howto" class="wrapper">
        <div class="row gtr-uniform" style="padding: 0px 15% 0px 15%">
            <div class="col-12 col-12-xsmall">
                <h3>검색 결과입니다!</h3>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>API KEY</th>
                            <th>School</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include_once('config/dbconfig.php');
                            $mail = $_POST['mail'];
                            if(!preg_match('/^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i', $mail)) {
                                header('Location: http://uhmsh2018.iwinv.net/mealapi/alert.html?text=올바른 이메일 주소를 입력해주세요!');
                            }
                            $query = "select * from api where `usrmail` = '$mail'";
                            $res = mysql_query($query, $conn);
                            if(mysql_num_rows($res) == 0) {
                                header("Location: http://uhmsh2018.iwinv.net/mealapi/alert.html?text=검색 결과가 없습니다.");
                                exit();
                            }
                            else {
                                while($row = mysql_fetch_array($res)) {
                                    echo "<tr>";
                                    echo "<td>".$row['apikey']."</td>";
                                    echo "<td>".$row['scname']."</td>";
                                    echo "</tr>";
                                }
                            }
                        ?>  
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer id="footer">
        <p class="copyright">&copy; UHMTOTO, 2018 <br>TEMPLATE BY: <a href="http://html5up.net">HTML5 UP</a></p>
    </footer>


    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.scrolly.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>