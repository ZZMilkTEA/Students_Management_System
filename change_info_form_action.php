<?php
/**
 * Created by PhpStorm.
 * User: ZZMilkTEA
 * Date: 2018/12/27
 * Time: 1:36
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
    $S_number = $_POST["number"];
    $S_name = $_POST["name"];
    $S_age = $_POST["age"];
    if ($_POST["sex"]=="male"){
        $S_sex = 1;
    }else{
        $S_sex = 0;
    }
    $S_class = $_POST["class"];
    $S_grade = $_POST["grade"];
    $S_pwd = $_POST["pwd"];
}
mysqli_select_db($conn,'stu_mngm_sys');
$sql= "update STUDENTS set S_name = '$S_name', S_birthdate = $S_age, S_sex = $S_sex, S_class = $S_class, S_grade = $S_grade, S_pwd='$S_pwd' where S_number=$S_number";
if ($conn->query($sql) === TRUE) {
    echo '<script>alert("修改成功！");
    window.close();
    </script>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
mysqli_close($conn);
?>