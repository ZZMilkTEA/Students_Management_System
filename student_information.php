<?php
/**
 * Created by PhpStorm.
 * User: ZZMilkTEA
 * Date: 2019/1/2
 * Time: 14:03
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>学生信息管理系统</title>

    <?php include "head.php";
    include "DB_connect.php"?>

</head>

<body>
    <div class="forms">
        <h2 style="text-align:center;">我的信息</h2>
        <p>学号</p>
        <p>姓名</p>
        <p>年龄</p>
        <p>性别</p>
        <p>班级</p>
        <p>年级</p>
        <button type="button" onclick="login()">修改密码</button>
    </div>

<div id="txtHint"></div>

</body>
</html>

