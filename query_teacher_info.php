<?php
/**
 * Created by PhpStorm.
 * User: ZZMilkTEA
 * Date: 2019/1/19
 * Time: 21:03
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


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>学生信息管理系统</title>

    <?php include "head.html";?>

    <script src="paging.js"></script>

    <script src="delete_info.js"></script>

    <script>
        // 获取模型
        var modal = document.getElementById('changePwdForm');

        // 鼠标点击模型外区域关闭登录框
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        function jumpToAddNewClass() {
            window.location.href="add_new_class.php";
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
                    document.getElementById("queryFormShow").innerHTML=xmlhttp.responseText;
                    executeScript(xmlhttp.responseText);
                }
            }
            xmlhttp.open("GET","get_teacher_data.php?q1="+ column + "&q2="+search_content,true);
            xmlhttp.send();
        }

        function toChangeInfoForm(number){
            window.open("change_tc_info.php?q1="+number,"","width=800,height=400")
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
        <a href="query_page.php">学生基本信息查询</a>
        <a href="query_class_info.php" >班级信息查询</a>
        <a href="query_teacher_info.php" class="active">教师管辖班级查询</a>
    </div>

</head>

<body>
<div class="search_form" style="margin-top: 10px" >
    <form id="search_form" name="search_form" style="display:inline;">
        <select name="colunm" style="margin: auto" >
            <option value="T_id">工号</option>
            <option value="T_name">教师姓名</option>
            <option value="C_number">班号</option>

            <input type="search" name="search_content" id="searchBox" style="margin-left: 5px">
    </form>
    <button type="submit" form="search" onclick="showData()" style="margin-left: 10px">查询</button>
    <button type="button" onclick="jumpToAddNewTeacger()" style="margin-left: 100px">录入新教师</button>
    <button type="button" onclick="jumpToLoginOut()" style="margin-left: 500px">退出登陆</button>
</div>


<div id="queryFormShow"></div>
<div id="txtHint"></div>

</body>
</html>
