<?php session_start();
include("conn.php");
error_reporting(0);
$username = $_SESSION['username'];
$account = $_SESSION['account'];
$sql = "select bbs.id, data.username, data.sex, bbs.subject, bbs.time, bbs.content from bbs LEFT JOIN data ON data.account=bbs.account order by bbs.id desc";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html>
<head>
    <title>地圖留言版</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bbs.css">
    <link rel="stylesheet" href="assets/css/reset.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <?php
    $array = array();
    while ($record = mysql_fetch_array($result)) {
        $array[] = $record;
    }
    $json = json_encode($array);
    ?>

</head>

<body>
<div class="top">
    <div class="menu">
        <a href="bbsmap.php">地圖留言板</a>
        <a href="index.php">留言板</a>
        <?php
        if ($_SESSION['account'] == "") {
            echo "<a class=\" letter2\"   <a href=\"login.php\">會員登入</a>";
        }
        if ($_SESSION['account'] != "") {
            echo "<a class=\" letter2\" <a href=\"bbs_add.php\">填寫留言<a href=\"logout.php\">會員登出 <a href=\"member.php\">會員資料</a>";
        } ?>
    </div>
    <div class="hello-name">
        <?php
        if ($_SESSION['account'] != null) {
            echo $username . " 你好";
        } else {
            echo "";
        }
        ?>
    </div>
</div>
<center>
    <script type="text/javascript">
        function initMap() {
            var URLs = "a.php";
            var geocoder = new google.maps.Geocoder();
            var latlng = new google.maps.LatLng(22.999900, 120.226876);
            var map = new google.maps.Map(document.getElementById('map'), {
                center: latlng,
                zoom: 14
            });
            $.ajax({
                url: URLs,
                type: "GET",
                dataType: 'json',
                success: function (json) {
                    var NumOfjson = json.length;
                    for (var i = 0; i < NumOfjson; i++) {
                        var username = json[i].username;
                        var time = json[i].time;
                        var subject = json[i].subject;
                        var content = json[i].content;
                        var address = json[i].address;
                        var infocontent = '留言者姓名：' + username + '<br>留言時間：' + time + '<br>留言主題：' + subject + '<br>留言內容：' + content + '<br>地址：' + address;
                        var lat = parseFloat(json[i].lat);
                        var lng = parseFloat(json[i].lng);
                        var myLatLng = {lat: lat, lng: lng};
                        console.log(myLatLng);
                        var marker = new google.maps.Marker({
                            map: map,
                            position: myLatLng,
                            icon: 'http://maps.gstatic.com/mapfiles/ridefinder-images/mm_20_red.png'
                        });
                        var infowindow = new google.maps.InfoWindow({
                            content: infocontent
                        });
                        google.maps.event.addListener(marker, 'click', (function (marker, infocontent, infowindow) {
                            return function () {
                                infowindow.setContent(infocontent);
                                infowindow.open(map, marker);
                            };
                        })(marker, infocontent, infowindow));

                    }
                }
            });
        }

    </script>
    <div id="map" style="width: 600px; height: 500px"></div> <!--此為地圖顯示大小-->
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8hRHdZEOVwpfzjh_Yo5Pu0Aw_RrsOsT8&callback=initMap">
    </script>
</body>
</html>