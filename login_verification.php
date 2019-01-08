<?php
/**
 * Created by PhpStorm.
 * User: ZZMilkTEA
 * Date: 2018/12/29
 * Time: 3:10
 */

session_start();

$number = isset($_GET["q1"]) ? intval($_GET["q1"]) : '';
$pwd = isset($_GET["q2"]) ? (string)$_GET["q2"] : '';

require "DB_connect.php";

if($number==""){
    echo "<p>学号必填</p>";
}elseif (mysqli_fetch_array(mysqli_query($conn , "select * from STUDENTS where S_number=$number"))){
    $sql = "SELECT S_pwd FROM STUDENTS WHERE S_number=$number";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    if ($row["S_pwd"] != $pwd) {
        echo "<p>密码不正确</p>";
    } else {
        echo "<p>登陆成功！</p>";
        $_SESSION['userinfo']=$number;
        echo '<script>
        location.href="student_info.php";     //学生登陆成功跳转到学生页面
        </script>';
        exit;
    }
}elseif (!mysqli_fetch_array(mysqli_query($conn ,"select * from admin_account where A_id=$number"))) {
    echo "<p>该学号不存在</p>";
}else{
    $sql = "SELECT A_pwd FROM admin_account WHERE A_id=$number";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    if (strcmp($row["A_pwd"],$pwd)) {
        echo "<p>密码不正确</p>";
    } else {
        echo "<p>管理员登陆成功！</p>";
        $_SESSION['userinfo']=$number;
        echo '<script>
        location.href="query_page.php";         //管理员登陆成功登陆到管理员页面
        </script>';

        exit;
    }
}
mysqli_close($conn);
?>

