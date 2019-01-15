<?php
/**
 * Created by PhpStorm.
 * User: ZZMilkTEA
 * Date: 2018/12/29
 * Time: 22:57
 */

session_start();
    if (isset($_SESSION['userinfo']) && !empty($_SESSION['userinfo'])) {
        if($_SESSION['userinfo'] !== 666666){
            echo "<script>window.location.href='index.php';</script>";
        }
    }else{
        echo "<script>window.location.href='index.php';</script>";
    }

    require "DB_connect.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>学生信息管理系统</title>

        <?php include "head.php";?>


        <script>
            // 获取模型
            var modal = document.getElementById('changePwdForm');

            // 鼠标点击模型外区域关闭登录框
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            function jumpToRegister() {
                window.location.href="register.php";
            }
            function jumpToLoginOut() {
                window.location.href="login_out.php";
            }

            function showData() {
                var column = document.forms["search_form"]["colunm"].value;
                var search_content = document.forms["search_form"]["search_content"].value;
                if (window.XMLHttpRequest) {
                    // IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
                    xmlhttp=new XMLHttpRequest();
                }
                else {
                    // IE6, IE5 浏览器执行代码
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange=function() {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                        document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
                        executeScript(xmlhttp.responseText);
                    }
                }
                xmlhttp.open("GET","get_data.php?q1="+ column + "&q2="+search_content,true);
                xmlhttp.send();
            }

            function showChangeInfoForm(number) {
                document.getElementById("number").innerHTML=number;
                document.getElementById('changePwdForm').style.display='block';
            }

            function changeInfo() {
                if (document.forms['changeInfoForm']['number'].value==null){

                }
                if (document.forms['changeInfoForm']['name'].value==null){

                }
                if (document.forms['changeInfoForm']['age'].value==null){

                }
                if (document.forms['changeInfoForm']['sex'].value==null){

                }
                if (document.forms['changeInfoForm']['class'].value==null){

                }
                if (document.forms['changeInfoForm']['grade'].value==null){

                }

            }

            function deleteInfo(S_number){
                var r = confirm("你确定要删除此条信息吗？");
                if (r==true){
                    if (window.XMLHttpRequest) {
                        // IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
                        xmlhttp=new XMLHttpRequest();
                    }
                    else {
                        // IE6, IE5 浏览器执行代码
                        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange=function() {
                        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                            alert("删除成功！");
                            showData();
                        }
                    }
                    xmlhttp.open("GET","delete_info.php?q1=" + S_number ,true);
                    xmlhttp.send();
                }
            }

            function executeScript(html)
            {
                var reg = /<script[^>]*>([^\x00]+)$/i;
                //对整段HTML片段按<\/script>拆分
                var htmlBlock = html.split("<\/script>");
                for (var i in htmlBlock)
                {
                    var blocks;//匹配正则表达式的内容数组，blocks[1]就是真正的一段脚本内容，因为前面reg定义我们用了括号进行了捕获分组
                    if (blocks = htmlBlock[i].match(reg))
                    {
                        //清除可能存在的注释标记，对于注释结尾-->可以忽略处理，eval一样能正常工作
                        var code = blocks[1].replace(/<!--/, '');
                        try
                        {
                            eval(code) //执行脚本
                        }
                        catch (e)
                        {
                        }
                    }
                }
            }
        </script>
        <div class="topnav" id="myTopnav">
            <a href="#home">主页</a>
            <a href="#about">网站介绍</a>
        </div>
    </head>

    <body>
    <div class="search_form" style="margin-top: 10px" >
        <form name="search_form" style="display:inline;">
            <select name="colunm" style="margin: auto">
                <option value="S_number">学号</option>
                <option value="S_name">姓名</option>
                <option value="S_age">年龄</option>
                <option value="S_sex">性别</option>
                <option value="S_class">班级</option>
                <option value="S_grade">年级</option>
            <input type="search" name="search_content" style="margin-left: 5px">
        </form>
        <button type="submit" form="search" onclick="showData()" style="margin-left: 10px">查询</button>
        <button type="button" onclick="jumpToRegister()" style="margin-left: 100px">录入新学生</button>
        <button type="button" onclick="jumpToLoginOut()" style="margin-left: 500px">退出登陆</button>
    </div>


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
            if ($number<100000000 ||$number>999999999)
            {
                $numberErr = "非法学号格式";
            }
            else if(mysqli_fetch_array(mysqli_query($conn , "select * from STUDENTS where S_number='$number'"))){
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

        $pwd_c=test_input($_POST["pwd_confirm"]);
        if($pwd!=$pwd_c){
            $pwd_c_Err = "与密码不一致";
        }
        else {
            $pwd_c_f=true;
        }

        if($name_f == true && $number_f == true && $age_f == true && $sex_f == true &&
            $class_f == true && $grade_f == true && $pwd_f == true && $pwd_c_f == true){
            require 'register_form_action.php';
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


    <div id="changePwdForm" class="modal">
        <span onclick="document.getElementById('changePwdForm').style.display='none'" class="close" title="Close Modal">×</span>
        <form name="changeInfoForm" class="modal-content animate" name="changePwdForm" onclick="changeInfo">
            <div class="container">
                <table>
                    <tr>
                        <td class="f_description">学号：</td>
                        <td class="f_content"><p id="number"></p></td>
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
                            <input type="radio" name="sex" <?php if (isset($sex) && $sex=="male") echo "checked";?> value="male">男
                            <input type="radio" name="sex" <?php if (isset($sex) && $sex=="female") echo "checked";?> value="female">女
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
                <div style="text-align: center">
                    <button type="submit" name="register" value="修改" >修改</button>
                    <button type="button" onclick="document.getElementById('changePwdForm').style.display='none'"
                            class="cancelbtn"
                            style="
                            padding: 14px 20px;
                            background-color: #f44336;">
                        取消</button>
                </div>
            </div>
        </form>
    </div>


    <div id="txtHint"></div>

    </body>
</html>
