<?php session_start();
include("conn.php");
error_reporting(0);
$username = $_SESSION['username'];
$sql = "select username from data";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
$time = date("Y:m:d H:i:s",time()+21600);
$account = $_SESSION['account'];
$_POST['account'] = $_SESSION['account'];
$address = $_POST[address];
$lat = $_POST[lat];
$lng = $_POST[lng];
if ($_SESSION['account'] != null) {
    if (isset($_POST['button'])) {
        if ("$_POST[account]" != "$account")
        {echo "<font color=\"#ff0000\">帳號錯誤</font>";}
        elseif ("$_POST[subject]" == null || "$_POST[content]" == null)
        {echo "<font color=\"#ff0000\">欄位不能空白</font>";}
        else {
            $subject = htmlspecialchars($_POST[subject], ENT_NOQUOTES);
            $content = htmlspecialchars($_POST[content], ENT_NOQUOTES);
            $sql = "insert into bbs (id,account,subject,content,time,address,lat,lng) value('','$account','$subject','$content','$time','$address','$lat','$lng')";
            mysql_query($sql);
            echo "發布成功";
            echo '<meta http-equiv=REFRESH CONTENT=2;url=bbsmap.php>';
        }
    }
}
else
{
    echo "<center><font color=\"#ff0000\" size=\"20\">尚未登入</font></center>";
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>我要留言</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/bbs.css">
    <link rel="stylesheet" href="assets/css/reset.css">
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script>
    <script src="http://maps.google.com/maps?file=api&v=3&key=AIzaSyBpJwO8jbJW5ZbVBaz_UxYLf2aAUurFR0w"
            type="text/javascript"></script>
</head>
<body style="background-image:url('assets/img/10-Flamingo.png');">

<div class="top">
    <div class="menu">
        <a href="bbsmap.php">愛心地圖</a>
        <a href="index.php">愛心資訊</a>
        <a href="bbs_add.php">發布訊息</a>
        <?php
        if($_SESSION['account'] == ""){
            echo "<a class=\" letter2\"         <a href=\"login.php\">會員登入</a>";
        }
        if($_SESSION['account'] != ""){
            echo "<a class=\" letter2\" <a href=\"logout.php\">會員登出</a>";
        }?>

        <a href="member.php">會員資料</a>

    </div>
    <div class="hello-name">
        <?php

        if ($_SESSION['account'] != null) {
            echo $username . " 你好";
        }
        else
        {
            echo "";
        }
        ?>
    </div>
</div>
<div>
    <h3 class="login10">填寫資訊</h3>
</div>
<div class="container">
    <div class="top-word">
    </div>
    <form id="form1" name="form1" method="post" onsubmit="return checkInput(this);" class="form-horizontal">
        <div class="form-group">
            <label for="account" class="col-sm-4 control-label"></label>
            <div class="col-sm-6">
                <input type="hidden" class="form-control" name="account" id="account" />
            </div>
        </div>
        <div class="form-group">
            <label for="subject" class="col-sm-4 control-label">主旨：</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="subject" id="subject"/>
            </div>
        </div>
        <div class="form-group">
            <label for="address" class="col-sm-4 control-label">所在地址：</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="address" id="address"/>
            </div>
        </div>
        <div class="form-group">
            <label for="content" class="col-sm-4 control-label">詳細內容：</label>
            <div class="col-sm-6">
                <textarea class="form-control" name="content" id="content" rows="5"></textarea>
            </div>
        </div>
        <div class="col-sm-6">
        <input type="hidden" name="lat" class="form-control">
        </div>
        <div class="col-sm-6">
        <input type="hidden" name="lng" class="form-control">
        </div>
        <div class="button">
            <input type="submit" name="button" id="button" value="送出" class="btn"/>
        </div>
    </form>

    <script type="text/javascript">
        $(document).ready(function() {
            var geocoder = new google.maps.Geocoder();
            $("input[name=address]").blur(function(){
                address = $("input[name=address]").val();
                if(address){
                    geocoder.geocode({'address': address}, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            $("input[name=lat]").val(results[0].geometry.location.lat());
                            $("input[name=lng]").val(results[0].geometry.location.lng());
                        }
                        else {alert("地址格式錯誤");}
                    })
                }

            });
        });

        function checkInput(form){
            //驗證標題是否為空
            if(form.subject.value == ''){
                alert('標題不能為空');
                form.subject.focus();
                return false;
            }

            //驗證輸入内容是否為空
            if(form.content.value == ''){
                alert('請說點什麼');
                form.content.focus();
                return false;
            }
            //驗證地址是否為空
            if(form.address.value == ''){
                alert('請輸入地址');
                form.address.focus();
                return false;
            }

            return true;
        }
    </script>
</body>
</html>