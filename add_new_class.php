<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>注册页</title>

    <?php include 'head.html' ?>

</head>


<body>
<?php require "DB_connect.php";
session_start();
if (isset($_SESSION['userinfo']) && !empty($_SESSION['userinfo'])) {
    $id=$_SESSION['userinfo'];
    if(!mysqli_fetch_array(mysqli_query($conn , "select * from admin_account where A_id='$id'")))
    {
        echo "<script>window.location.href='index.php';</script>";
    }
}else{
    echo "<script>window.location.href='index.php';</script>";
}?>

<?php
// 定义变量并默认设置为空值
$teacherErr = $numberErr  = "";
$teacher = $number = "";
$teacher_f = $number_f  = false;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["number"]))
    {
        $numberErr = "班号是必需的";
    }
    else
    {
        $number = test_input($_POST["number"]);
        if ($number<100000 ||$number>999999)
        {
            $numberErr = "非法班号格式";
        }
        else if(mysqli_fetch_array(mysqli_query($conn , "select * from CLASSES where C_number='$number'"))){
            $numberErr = "班号已经存在";
        }
        else{
            $number_f = true;
        }
    }

        $teacher = test_input($_POST["teacher"]);
        if ( strlen($teacher)>20 ){
            $teacherErr="名字过长";
        }else{
            $teacher_f = true;
        }
    }



    if($teacher_f == true && $number_f == true){
        require 'add_class_action.php';
    }

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<div class="forms">
    <h2 style="text-align:center;">加入新班级框</h2>

    <form style=" margin: 0 auto;width: auto"
          teacher="register_form"
          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
          method="post">
        <table>
            <tr>
                <td class="f_description">班号：</td>
                <td class="f_content"><input type="text" name="number" value="<?php echo $number;?>" placeholder="班号为6位整数">
                    <span class="error">* <?php echo $numberErr;?></span></td>
            </tr>
            <tr>
                <td class="f_description">班主任：</td>
                <td class="f_content"><input type="text" name="teacher" value="<?php echo $teacher;?>">
                    <span class="error"> <?php echo $teacherErr;?></span></td>
        </table>
        <div>
            <input type="submit" name="register" value="加入" >
        </div>
    </form>
</div>

</body>
</html>