<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>注册页</title>

    <?php include 'head.php'?>
</head>


<body>
<?php include 'DB_connect.php'?>
<?php
// 定义变量并默认设置为空值
$nameErr = $numberErr = $ageErr = $classErr = $sexErr = $gradeErr =$pwdErr = $pwd_c_Err = "";
$name = $number = $age = $sex = $class = $grade = $pwd = $pwd_c = "";
$name_f = $number_f = $age_f = $sex_f = $class_f = $grade_f = $pwd_f = $pwd_c_f = false;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["number"]))
    {
        $numberErr = "学号是必需的";
    }
    else
    {
        $number = test_input($_POST["number"]);
        if ($number<100000 ||$number>999999)
        {
            $numberErr = "非法学号格式";
        }
        else if(mysqli_fetch_array(mysqli_query($conn ,"select * from STUDENTS where S_id='$number'"))){
            $numberErr = "学号已经存在";
        }
        else{
            $number_f = true;
        }
    }

    if (empty($_POST["name"]))
    {
        $nameErr = "姓名是必需的";
    }
    else{
        $name = test_input($_POST["name"]);
        if ( strlen($name)>20 ){
            $nameErr="名字过长";
        }else{
            $name_f = true;
        }
    }


    if (empty($_POST["class"]))
    {
        $classErr = "班级是必需的";
    }
    else
    {
        $class = test_input($_POST["class"]);
        if ($class<1000 || $class>9999)
        {
            $classErr = "非法班级格式";
        } else{
            $class_f = true;
        }
    }

    if (empty($_POST["age"]))
    {
        $ageErr = "年龄是必需的";
    }
    else
    {
        $age = test_input($_POST["age"]);
        if ($age<0 || $age>100)
        {
            $ageErr = "非法年龄格式";
        }
        else{
            $age_f = true;
        }
    }

    if (empty($_POST["grade"]))
    {
        $gradeErr = "年级是必需的";
    }
    else
    {
        $grade = test_input($_POST["grade"]);

        if ($grade<1 ||$grade>6)
        {
            $gradeErr = "非法年级格式";
        }
        else{
            $grade_f = true;
        }
    }

    if (empty($_POST["sex"]))
    {
        $sexErr = "性别是必需的";
    }
    else
    {
        $sex = test_input($_POST["sex"]);
        $sex_f = true;
    }

    if (empty($_POST["pwd"]))
    {
        $pwdErr = "密码是必须的";
    }
    else
    {
        $pwd = test_input($_POST["pwd"]);
        if (strlen($pwd)<6 || strlen($pwd)>16){
            $pwdErr = "密码格式不合法";
        }
        else{
            $pwd_f=true;
        }
    }

    $pwd_c=test_input($_POST["pwd_confirm"]);
    if($pwd!=$pwd_c){
        $pwd_c_Err = "与密码不一致";
    }
    else {
        $pwd_c_f=true;
    }

    if($name_f == true && $number_f == true && $age_f == true && $sex_f == true &&
        $class_f == true && $grade_f == true && $pwd_f == true && $pwd_c_f == true){
        include 'register_form_action.php';
    }
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
    <h2 style="text-align:center;">注册框</h2>

        <form style=" margin: 0 auto;width: auto"
        name="register_form"
        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
        method="post">
            <table>
                <tr>
                    <td class="f_description">学号：</td>
                    <td class="f_content"><input type="text" name="number" value="<?php echo $number;?>">
                        <span class="error">* <?php echo $numberErr;?></span></td>
                </tr>
                <tr>
                    <td class="f_description">姓名：</td>
                    <td class="f_content"><input type="text" name="name" value="<?php echo $name;?>">
                        <span class="error">* <?php echo $nameErr;?></span></td>
                </tr>
                <tr>
                    <td class="f_description">年龄：</td>
                    <td class="f_content"><input type="text" name="age" value="<?php echo $age;?>">
                        <span class="error">* <?php echo $ageErr;?></span></td>
                </tr>
                <tr>
                    <td class="f_description">性别： </td>
                    <td style="text-align: left">
                        <input type="radio" name="sex" <?php if (isset($sex) && $sex=="male") echo "checked";?> value="male">男
                        <input type="radio" name="sex" <?php if (isset($sex) && $sex=="female") echo "checked";?> value="female">女
                        <span class="error">* <?php echo $sexErr;?></span>
                    </td>
                </tr>
                <tr>
                    <td class="f_description">班级：</td>
                    <td class="f_content"><input type="text" name="class" value="<?php echo $class;?>">
                        <span class="error">* <?php echo $classErr;?></span></td>
                </tr>
                <tr>
                    <td class="f_description">年级：</td>
                    <td class="f_content"><input type="text" name="grade" value="<?php echo $grade;?>">
                        <span class="error">* <?php echo $gradeErr;?></span></td>
                </tr>
                <tr>
                    <td class="f_description">密码：</td>
                    <td class="f_content"><input type="password" name="pwd"value="<?php echo $pwd;?>">
                        <span class="error">* <?php echo $pwdErr;?></span></td>
                </tr>
                <tr>
                    <td class="f_description">确认密码：</td>
                    <td class="f_content"><input type="password" name="pwd_confirm" value="<?php echo $pwd_c;?>">
                        <span class="error">* <?php echo $pwd_c_Err;?></span></td>
                </tr>
            </table>
            <div style="text-align: center">
                <input type="submit" name="register" value="注册" >
            </div>
        </form>
</div>

</body>
</html>