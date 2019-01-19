<?php
/**
 * Created by PhpStorm.
 * User: ZZMilkTEA
 * Date: 2019/1/9
 * Time: 11:16
 */

$number = $_GET["q1"];
$oldPwd = $_GET["q2"];
$newPwd = $_GET["q3"];

require "DB_connect.php";

$sql = "select S_pwd from STUDENTS where S_number = $number;";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if($row['S_pwd']!== $oldPwd){
    echo "<script>alert('旧密码不正确！')</script>";
    exit;
}

$sql = "update STUDENTS set S_pwd = '$newPwd' where S_number = $number;";
if ($conn->query($sql) === TRUE) {
    echo "
    <script>
        alert('密码修改成功！');
        document.getElementById('changePwdForm').style.display='none';
    </script>
";
}
?>