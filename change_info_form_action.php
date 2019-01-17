<?php
/**
 * Created by PhpStorm.
 * User: ZZMilkTEA
 * Date: 2018/12/27
 * Time: 1:36
 */
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $S_number = $_POST["number"];
    $S_name = $_POST["name"];
    $S_age = $_POST["age"];
    $S_sex =$_POST["sex"];
    $S_class = $_POST["class"];
    $S_grade = $_POST["grade"];
    $S_pwd = $_POST["pwd"];
}
mysqli_select_db($conn,'stu_mngm_sys');
$sql= "update STUDENTS set S_name = '$S_name', S_age = $S_age, S_sex = $S_sex, S_class = $S_class, S_grade = $S_grade, S_pwd='$S_pwd' where S_number=$S_number";
if ($conn->query($sql) === TRUE) {
    echo '<script>alert("修改成功！");
    window.close();
    </script>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
mysqli_close($conn);
?>