<?php
/**
 * Created by PhpStorm.
 * User: ZZMilkTEA
 * Date: 2018/12/29
 * Time: 3:10
 */

$number = isset($_GET["q1"]) ? intval($_GET["q1"]) : '';
$pwd = isset($_GET["q2"]) ? intval($_GET["q2"]) : '';

include "DB_connect.php";

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
        $_SESSION['userinfo']=[
            'uid' => $number
        ];
        exit;
    }
}elseif (!mysqli_fetch_array(mysqli_query($conn ,"select * from admin_account where A_id=$number"))) {
    echo "<p>该学号不存在</p>";
}else{
    $sql = "SELECT A_pwd FROM admin_account WHERE A_id=$number";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    if ($row["A_pwd"] != $pwd) {
        echo "<p>密码不正确</p>";
    } else {
        echo "<p>管理员登陆成功！</p>";
        $_SESSION['userinfo']=['uid' => $number];
        header('location:query_page.php');
        exit;
    }
}
mysqli_close($conn);
?>

