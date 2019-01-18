<?php
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

mysqli_set_charset($conn, "utf8");

// 定义变量并默认设置为空值
$nameErr = $numberErr = $ageErr = $classErr = $sexErr = $gradeErr =$pwdErr = "";
$name = $number = $age = $sex = $class = $grade = $pwd = "";
$name_f = $number_f = $age_f = $sex_f = $class_f = $grade_f = $pwd_f = false;


if(isset($_GET["q1"])) {
    $number = $_GET["q1"];

    $sql = "SELECT * FROM students WHERE S_number = $number";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $name = $row['S_name'];
    $age = $row['S_age'];
    $sex = $row['S_sex'];
    $class = $row['S_class'];
    $grade = $row['S_grade'];
    $pwd = $row['S_pwd'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["number"]))
    {
        $numberErr = "学号是必需的";
    }
    else
    {
        $number = test_input($_POST["number"]);
        if ($number<100000000 ||$number>999999999)
        {
            $numberErr = "非法学号格式";
        }
        else if(!mysqli_fetch_array(mysqli_query($conn , "select * from STUDENTS where S_number='$number'"))){
            $numberErr = "该学号不存在";
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
        if ($class<100000 || $class>999999)
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


    if($name_f == true &&  $age_f == true && $sex_f == true &&
        $class_f == true && $grade_f == true && $pwd_f == true ){
        require 'change_info_form_action.php';
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



function sexShowTrsfmt($input){
    if($input==0)return "女";
    if($input==1)return "男";
}
?>
    <link rel="stylesheet" type="text/css" href="style.css">
    <div id="changePwdForm" class="modal" style="display: block">
        <form name="changeInfoForm"
              class="modal-content animate"
              name="changePwdForm"
              action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
              method="post">
        <div class="container">
            <h>修改信息框</h>
            <table>
                <tr>
                    <td class="f_description">学号：</td>
                    <td class="f_content"><input type="text" name="number" value="<?php echo $number;?>" placeholder="学号为9位整数">
                        <span class="error"> <?php echo $numberErr;?></span></td>
                </tr>
                <tr>
                    <td class="f_description">姓名：</td>
                    <td class="f_content"><input type="text" name="name" value="<?php echo $name;?>">
                        <span class="error"> <?php echo $nameErr;?></span></td>
                </tr>
                <tr>
                    <td class="f_description">年龄：</td>
                    <td class="f_content"><input type="text" name="age" value="<?php echo $age;?>" placeholder="0~100">
                        <span class="error"><?php echo $ageErr;?></span></td>
                </tr>
                <tr>
                    <td class="f_description">性别： </td>
                    <td style="text-align: left">
                        <input type="radio" name="sex" <?php if (isset($sex) && $sex=="1") echo "checked";?> value="male">男
                        <input type="radio" name="sex" <?php if (isset($sex) && $sex=="0") echo "checked";?> value='female'>女
                            <span class="error"><?php echo $sexErr;?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="f_description">班级：</td>
                        <td class="f_content"><input type="text" name="class" value="<?php echo $class;?>" placeholder="班级为6位整数">
                            <span class="error"> <?php echo $classErr;?></span></td>
                    </tr>
                    <tr>
                        <td class="f_description">年级：</td>
                        <td class="f_content"><select name="grade"<?php echo $grade;?> >
                                <option value="1" <?php if ($grade == 1) echo "selected";?> >1</option>
                                <option value="2" <?php if ($grade == 2) echo "selected";?> >2</option>
                                <option value="3" <?php if ($grade == 3) echo "selected";?> >3</option>
                                <option value="4" <?php if ($grade == 4) echo "selected";?> >4</option>
                                <option value="5" <?php if ($grade == 5) echo "selected";?> >5</option>
                                <option value="6" <?php if ($grade == 6) echo "selected";?> >6</option>
                            </select>
                            <span class="error"> <?php echo $gradeErr;?></span></td>
                    </tr>
                    <tr>
                        <td class="f_description">密码：</td>
                        <td class="f_content"><input type="text" name="pwd"value="<?php echo $pwd;?>"placeholder="请输入6~16位的密码">
                            <span class="error"> <?php echo $pwdErr;?></span></td>
                    </tr>
                </table>
                <div style="text-align: center;width: auto">
                    <button type="submit" name="register" value="修改" >修改</button>
                    <button type="button" onclick="window.close()"
                            class="cancelbtn"
                            style="
                            background-color: #f44336;">
                        取消</button>
                </div>
            </div>
        </form>
    </div>
