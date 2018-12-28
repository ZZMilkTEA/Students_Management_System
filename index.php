<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <title>学生信息管理系统</title>

    <?php include 'head.php'?>


    <script>
        var numberInput=document.forms["loginForm"]["number"].value;
        var pwdInput=document.forms["loginForm"]["pwd"].value;
        function jumpToRegister() {
            window.location.href="register.php";
        }
    </script>

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
            }
        }
        xmlhttp.open("GET", "login_verification.php?q1=" + numberInput + "&q2=" + pwdInput, true);
        xmlhttp.send();
    }
</script>
</head>
<body>

        <div class="forms">
            <h2 style="text-align:center;">登陆框</h2>
            <div class = "error" id = "error" ></div>
            <form style="margin: 0 auto;width: auto" name="loginForm"">
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
            </form>
                <div style="text-align:center;">
                    <button type="button" onclick="login()">登陆</button>
                    <button type="button" onclick="jumpToRegister()">注册</button>
                </div>
        </div>
    </div>


</body>
</html>