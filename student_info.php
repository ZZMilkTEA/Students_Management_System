<?php
/**
 * Created by PhpStorm.
 * User: ZZMilkTEA
 * Date: 2019/1/2
 * Time: 14:03
 */
session_start();
if (isset($_SESSION['userinfo']) && !empty($_SESSION['userinfo'])) {
    if($_SESSION['userinfo'] == 666666){
        echo "<script>window.location.href='index.php';</script>";
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

    <?php include "head.php";
    require "DB_connect.php";

    mysqli_set_charset($conn, "utf8");
    $number=$_SESSION['userinfo'];
    $sql = "SELECT * FROM students WHERE S_number = $number";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result)
    ?>

    <script>
        function jumpToLoginOut() {
            window.location.href="login_out.php";
        }
    </script>
</head>

<body>
    <div class="forms">
        <h2 style="text-align:center;">我的信息</h2>
        <table style=" margin: 0 auto;width: auto">
            <tr>
                <td>学号：</td>
                <td class="f_content"><?php echo $row['S_number'];?></td>
            </tr>
            <tr>
                <td>姓名：</td>
                <td class="f_content"><?php echo $row['S_name'];?></td>
            </tr>
            <tr>
                <td>年龄：</td>
                <td class="f_content"><?php echo $row['S_age'];?></td>
            </tr>
            <tr>
                <td>性别：</td>
                <td class="f_content"><?php  if($row['S_sex']==0)echo "女";else echo "男";?></td>
            </tr>
            <tr>
                <td>班级：</td>
                <td class="f_content"><?php echo $row['S_class'];?></td>
            </tr>
            <tr>
                <td>年级：</td>
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
    </script>

    <div id="changePwdForm" class="modal">
    <span onclick="document.getElementById('changePwdForm').style.display='none'" class="close" title="Close Modal">×</span>
    <form class="modal-content animate" action="/action_page.php">
        <div class="container">
            <label><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" required>

            <label><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" required>

            <label><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password" name="psw-repeat" required>
            <input type="checkbox" checked="checked"> Remember me
            <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

            <div class="clearfix">
                <button type="button" onclick="document.getElementById('changePwdForm').style.display='none'" class="cancelbtn">Cancel</button>
                <button type="submit" class="signupbtn">Sign Up</button>
            </div>
        </div>
    </form>
    </div>

</body>
</html>

