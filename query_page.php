<?php
/**
 * Created by PhpStorm.
 * User: ZZMilkTEA
 * Date: 2018/12/29
 * Time: 22:57
 */
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

            function showData() {
                var column = document.forms["search_form"]["colunm"].value;
                var search_content = document.forms["search_form"]["search_content"].value;
               // window.alert(column + search_content);
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
                    }
                }
                xmlhttp.open("GET","get_data.php?q1="+ column + "&q2="+search_content,true);
                xmlhttp.send();
            }
        </script>
    </head>

    <body>
    <div class="search_form" >
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
    </div>

    <div id="txtHint"></div>

    </body>
</html>
