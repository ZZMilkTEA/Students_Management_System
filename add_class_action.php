<?php
/**
 * Created by PhpStorm.
 * User: ZZMilkTEA
 * Date: 2018/12/27
 * Time: 1:36
 */

require "DB_connect.php";

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
    $C_teacher = $_POST["teacher"];

}
mysqli_select_db($conn,'stu_mngm_sys');
$sql= "INSERT INTO CLASSES (C_number,C_teacher) VALUES ($C_number,\"$C_teacher\");";
if ($conn->query($sql) === TRUE) {
    echo '<script>alert("录入成功！");
    location.href="query_class_info.php"</script>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
mysqli_close($conn);
?>