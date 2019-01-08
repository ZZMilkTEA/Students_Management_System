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

    include "DB_connect.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>学生信息管理系统</title>

        <?php include "head.php";?>


        <script>
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

    <div id="txtHint"></div>

    </body>
</html>
