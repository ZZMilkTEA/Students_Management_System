<?php
/**
 * Created by PhpStorm.
 * User: ZZMilkTEA
 * Date: 2019/1/2
 * Time: 14:03
 */
require "DB_connect.php";
session_start();

if (isset($_SESSION['userinfo']) && !empty($_SESSION['userinfo'])) {
    $id=$_SESSION['userinfo'];
    if(mysqli_fetch_array(mysqli_query($conn , "select * from admin_account where A_id='$id'"))){
        echo "<script>window.location.href='query_page.php';</script>";
    }
}else{
    echo "<script>window.location.href='index.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>学生信息管理系统</title>

    <?php include "head.html";
    require "DB_connect.php";

    mysqli_set_charset($conn, "utf8");
    $number=$_SESSION['userinfo'];
    $sql = "SELECT * FROM students left JOIN classes ON (students.S_class = classes.C_number) left join teachers on classes.C_teacherID = teachers.T_id where S_number = $number;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    ?>

    <script>
        function jumpToLoginOut() {
            window.location.href="login_out.php";
        }
    </script>

    <style>
        /* Full-width input fields */
        .modal input[type=text],.modal input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <div class="forms">
        <h2 style="text-align:center;">我的信息</h2>
        <table style=" margin: 0 auto;width: auto">
            <tr>
                <td class="f_description">学号：</td>
                <td class="f_content"><?php echo $row['S_number'];?></td>
            </tr>
            <tr>
                <td class="f_description">姓名：</td>
                <td class="f_content"><?php echo $row['S_name'];?></td>
            </tr>
            <tr>
                <td class="f_description">出生日期：</td>
                <td class="f_content"><?php echo $row['S_birthdate'];?></td>
            </tr>
            <tr>
                <td class="f_description">入学日期：</td>
                <td class="f_content"><?php echo $row['S_studydate'];?></td>
            </tr>
            <tr>
                <td class="f_description">性别：</td>
                <td class="f_content"><?php  if($row['S_sex']==0)echo "女";else echo "男";?></td>
            </tr>
            <tr>
                <td class="f_description">班级：</td>
                <td class="f_content"><?php echo $row['S_class'];?></td>
            </tr>
            <tr>
                <td class="f_description">班主任：</td>
                <td class="f_content"><?php
                    if($row['T_name'] == null || $row['T_name'] == ""){
                        echo "无";
                    }else {
                        echo $row['T_name'];
                    }
                    ?></td>
            </tr>
            <tr>
                <td class="f_description">年级：</td>
                <td class="f_content"><?php echo $row['S_grade'];?></td>
            </tr>
        </table>
        <button type="button" onclick="document.getElementById('changePwdForm').style.display='block'" style="width:auto;"">修改密码</button>
        <button type="button" onclick="jumpToLoginOut()">退出登陆</button>
    </div>

    <script>
        // 获取模型
        var modal = document.getElementById('changePwdForm');

        // 鼠标点击模型外区域关闭登录框
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        function pwdChange(){
            var oldPwd = document.forms["changePwdForm"]["oldPwd"].value;
            var newPwd = document.forms["changePwdForm"]["newPwd"].value;
            var newPwd_confirm = document.forms["changePwdForm"]["newPwd_confirm"].value;
            if (newPwd.length > 6 && newPwd.length < 16) {
                if (newPwd === newPwd_confirm) {
                    if (window.XMLHttpRequest) {
                        // IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        // IE6, IE5 浏览器执行代码
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                } else {
                    alert("重复新密码与新密码不一致！");
                    return false;
                }
            } else {
                alert("密码格式不合法！");
                return false;
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("hintTXT").innerHTML = xmlhttp.responseText;
                    executeScript(xmlhttp.responseText);
                }
            }
            xmlhttp.open("GET", "change_pwd.php?q1=" + <?php echo $row['S_number']; ?> + "&q2=" + oldPwd + "&q3=" + newPwd, false);
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

    <div id="changePwdForm" class="modal">
        <span onclick="document.getElementById('changePwdForm').style.display='none'" class="close" title="Close Modal">×</span>
        <form class="modal-content animate" name="changePwdForm" onsubmit="return pwdChange()">
            <div class="container">
                <label><b>旧密码</b></label>
                <input type="password" name="oldPwd" required>

                <label><b>新密码</b></label>
                <input type="password" name="newPwd" required>

                <label><b>重复新密码</b></label>
                <input type="password" name="newPwd_confirm" required>

                <div style="text-align: center;width: auto">
                    <button type="submit" value="修改"  autofocus="autofocus">修改</button>
                    <button type="button" onclick="document.getElementById('changePwdForm').style.display='none'"
                            class="cancelbtn"
                            style="
                            background-color: #f44336;">取消</button>
                </div>
            </div>
        </form>
    </div>

<div id="hintTXT"></div>
</body>
</html>

