<?php session_start();
include("conn.php");
error_reporting(0);
$account = $_SESSION['account'];
$username = $_SESSION['username'];
$sql = "select bbs.id, data.username, data.sex, bbs.subject, bbs.time, bbs.content from bbs LEFT JOIN data ON data.account=bbs.account order by bbs.id desc";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
?>
<html>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>留言</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bbs.css">
    <link rel="stylesheet" href="assets/css/reset.css">
</head>
<body style="background-image:url('assets/img/10-Flamingo.png');">
<div class="top">
    <div class="menu">
        <a href="bbsmap.php">愛心地圖</a>
        <a href="index.php">愛心資訊</a>
        <?php
        if($_SESSION['account'] == ""){
            echo "<a class=\" letter2\"   <a href=\"login.php\">會員登入</a>";
        }
        if($_SESSION['account'] != ""){
            echo "<a class=\" letter2\" <a href=\"logout.php\">會員登出 <a href=\"bbs_add.php\">填寫留言 <a href=\"member.php\">會員資料</a>";
        }?>

    </div>
    <div class="hello-name">
        <?php
        if ($_SESSION['account'] != null) {
            echo $username . " 你好";
        } else {
            echo "";
        }
        ?>
        <div class="comeback pull-right" id="_top">
            <a href="">top</a>
        </div>
    </div>
</div>
<div>
    <?php while ($row = mysql_fetch_row($result)): ?>
        <div class="well" >
        <br>第<?= $row[0] ?>位訪客
        <br>訪客姓名:<?= $row[1] ?>
        <br>性別:<?= $row[2] ?>生
            <br>留言時間:<?= nl2br($row[4]) ?>
            <div class="panel panel-danger">
            <div class="panel-heading">
                留言主題:<?= $row[3]?>
            </div>
                <div class="panel-body">
                    留言內容:<?= $row[5] ?>
             </div>
                </div>
            </div>

    <?php endwhile; ?>
</div>
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'></script>
<script type='text/javascript'>
    $(function () {
        $(window).load(function () {
            $(window).bind('scroll resize', function () {
                var $this = $(this);
                var $this_Top = $this.scrollTop();

                //當高度小於100時，關閉區塊
                if ($this_Top < 100) {
                    $(".top").removeClass("test");
                }
                if ($this_Top > 100) {
                    $(".top").addClass("test");
                }
            }).scroll();
        });
    });
</script>
<script type="text/javascript">
    //點擊top跑回頂端
    $(document).ready(function () {
        $('#_top').click(function () {
            $('html,body').animate({scrollTop: 0}, 'slow');
        });
    });
</script>
<script type="text/javascript">
    //隱藏top
    $(document).ready(function () {
        $("#_top").hide()
        $(function () {
            $(window).scroll(function () {
                if ($(this).scrollTop() > 1) {//當window的scrolltop距離>1，top淡出，反之淡入
                    $("#_top").fadeIn();
                } else {
                    $("#_top").fadeOut();
                }
            });
        });


    });
</script>
</body>
</html>
