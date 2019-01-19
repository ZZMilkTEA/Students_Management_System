<?php
/**
 * Created by PhpStorm.
 * User: ZZMilkTEA
 * Date: 2019/1/8
 * Time: 1:43
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

$number = $_GET["q1"];
$table = $_GET["q2"];

require "DB_connect.php";

switch ($table){
    case 1:$sql = "delete FROM students WHERE S_number=$number;";break;
    case 2:
        if(mysqli_fetch_array(mysqli_query($conn , "select * from students where S_class = '$number';"))){
            echo '<script>
                    alert("无法删除，因为有学生属于这个班级");
                  </script>';
            exit(0);
        }else{
            $sql = "delete FROM classes WHERE C_number=$number;";
        }
        break;
    case 3:
        if(mysqli_fetch_array(mysqli_query($conn , "select * from classes where C_teacherID = '$number';"))){
            echo '<script>
                    alert("无法删除，因为有班级由这位教师担任班主任");
                  </script>';
            exit(0);
        }else{
            $sql = "delete FROM teachers WHERE T_id=$number;";
        }
        break;
    default:
        echo '<script>
                    alert("没有匹配的表");
                  </script>';
        exit(0);
}

if ($conn->query($sql) === TRUE) {
    echo '<script>
        alert("删除成功");
        showData();
</script>';
} else {
    echo '<script>
        alert("删除失败，Error='.$conn->error.'");
</script>';
}
mysqli_close($conn);
?>