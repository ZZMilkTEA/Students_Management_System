<?php
session_start();
require "DB_connect.php";
    if (isset($_SESSION['userinfo']) && !empty($_SESSION['userinfo'])) {
        $id=$_SESSION['userinfo'];
        if(mysqli_fetch_array(mysqli_query($conn , "select * from admin_account where A_id='$id'"))){
            echo "<script>window.location.href='query_page.php';</script>";
        }else{
            echo "<script>window.location.href='student_info.php';</script>";
        }
    }
    ?>

<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <title>学生信息管理系统</title>

    <?php include 'head.html' ?>

<script>
    function login() {
        var numberInput = document.forms["loginForm"]["number"].value;
        var pwdInput = document.forms["loginForm"]["pwd"].value;
        if (window.XMLHttpRequest) {
            // IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
            xmlhttp = new XMLHttpRequest();
        } else {
            // IE6, IE5 浏览器执行代码
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("error").innerHTML = xmlhttp.responseText;
                executeScript(xmlhttp.responseText);
            }
        }
        xmlhttp.open("GET", "login_verification.php?q1=" + numberInput + "&q2=" + pwdInput, false);
        xmlhttp.send();

        return false;
    }

    function executeScript(html)
    {
        var reg = /<script[^>]*>([^\x00]+)$/i;
        //对整段HTML片段按<\/script>拆分
        var htmlBlock = html.split("<\/script>");
        for (var i in htmlBlock)
        {
            var blocks;//匹配正则表达式的内容数组，blocks[1]就是真正的一段脚本内容，因为前面reg定义我们用了括号进行了捕获分组
            if (blocks = htmlBlock[i].match(reg))
            {
                //清除可能存在的注释标记，对于注释结尾-->可以忽略处理，eval一样能正常工作
                var code = blocks[1].replace(/<!--/, '');
                try
                {
                    eval(code) //执行脚本
                }
                catch (e)
                {
                }
            }
        }
    }
</script>
</head>
<body>

        <div class="forms">
            <h2 style="text-align:center;">登陆框</h2>
            <div class = "error" id = "error" ></div>
            <form style="margin: 0 auto;width: auto" name="loginForm" onsubmit="return login()">
                <table>
                    <tr>
                        <td>学号：</td>
                        <td><input name="number"></td>
                    </tr>
                    <tr>
                        <td>密码：</td>
                        <td><input type="password" name="pwd"></td>
                    </tr>
                </table>
                <div style="text-align:center;">
                    <input type="submit" value="登陆"  autofocus="autofocus">
                </div>
            </form>
        </div>

</body>
</html>