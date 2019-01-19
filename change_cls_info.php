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
$teacherErr = $numberErr  = "";
$teacherID = $number = "";
$teacher_f = $number_f  = false;


if(isset($_GET["q1"])) {
    $number = $_GET["q1"];

    $sql = "SELECT * FROM classes WHERE C_number = $number";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $teacherID = $row['C_teacherID'];
}

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
        else if(!mysqli_fetch_array(mysqli_query($conn , "select * from CLASSES where C_number='$number'"))){
            $numberErr = "班号不存在";
        }
        else{
            $number_f = true;
        }
    }

    $teacherID = test_input($_POST["teacherID"]);
    if(!mysqli_fetch_array(mysqli_query($conn , "select * from teachers where T_id='$teacherID'"))){
        $teacherErr="该工号不存在";
    }else{
        $teacher_f = true;
    }
}



if($teacher_f == true && $number_f == true){
    require 'change_cls_info_action.php';
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
<script>
    function showResult(str)
    {
        if (str.length==0)
        {
            document.getElementById("txtHint").innerHTML="";
            return;
        }
        if (window.XMLHttpRequest)
        {// IE7+, Firefox, Chrome, Opera, Safari 浏览器执行
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// IE6, IE5 浏览器执行
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("E_classes").innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","get_exist_class.php?q="+str,true);
        xmlhttp.send();
    }
</script>

<div id="changeClsForm" class="modal" style="display: block">
    <form name="changeInfoForm"
          class="modal-content animate"
          name="changeClsForm"
          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
          method="post">
        <div class="container">
            <h>修改信息框</h>
            <table>
                <tr>
                    <td class="f_description">班号：</td>
                    <td class="f_content"><input type="text" name="number" value="<?php echo $number;?>" placeholder="班号为6位整数">
                        <span class="error"> <?php echo $numberErr;?></span></td>
                </tr>
                <tr>
                    <td class="f_description">班主任工号：</td>
                    <td class="f_content"><input type="search" name="teacherID" value="<?php echo $teacherID;?>"
                                                 onkeyup="showResult(this.value)" placeholder="可为空" list="E_teacherID">
                        <span class="error"> <?php echo $teacherErr;?></span></td>
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

<datalist id="E_teacherID"></datalist>
