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
$sql= "INSERT INTO STUDENTS (S_number,S_name,S_age,S_sex,S_class,S_grade,S_pwd) VALUES ($S_number,\"$S_name\",$S_age,$S_sex,$S_class,$S_grade,'$S_pwd');";
if ($conn->query($sql) === TRUE) {
    echo '<script>alert("录入成功！");
    location.href="query_page.php"</script>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
mysqli_close($conn);
?>