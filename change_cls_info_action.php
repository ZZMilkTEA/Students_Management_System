<?php
/**
 * Created by PhpStorm.
 * User: ZZMilkTEA
 * Date: 2019/1/19
 * Time: 19:36
 */

require "DB_connect.php";

session_start();
if (isset($_SESSION['userinfo']) && !empty($_SESSION['userinfo'])) {
    $id=$_SESSION['userinfo'];
    if(!mysqli_fetch_array(mysqli_query($conn , "select * from admin_account where A_id='$id'")))
    {
        echo "<script>window.location.href='index.php';</script>";
    }
}else{
    echo "<script>window.location.href='index.php';</script>";
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $C_number = $_POST["number"];
    $C_teacherID = $_POST["teacherID"];

}
mysqli_select_db($conn,'stu_mngm_sys');
$sql= "update classes set C_teacherID = $C_teacherID where C_number=$C_number";
if ($conn->query($sql) === TRUE) {
    echo '<script>alert("修改成功！");
    window.close();
    </script>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
mysqli_close($conn);
?>