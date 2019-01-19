<?php
/**
 * Created by PhpStorm.
 * User: ZZMilkTEA
 * Date: 2018/12/29
 * Time: 22:57
 */
require "DB_connect.php";

session_start();
if (isset($_SESSION['userinfo']) && !empty($_SESSION['userinfo'])) {
    $id=$_SESSION['userinfo'];
    if(!mysqli_fetch_array(mysqli_query($conn , "select * from admin_account where A_id='$id';")))
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

        <!-- 加载分页函数 -->
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

            function jumpToRegister() {
                window.location.href="register_new_student.php";
            }
            function jumpToLoginOut() {
                window.location.href="login_out.php";
            }

            function showData() {
                var column = document.forms["search_form"]["colunm"].value;
                var search_content = document.forms["search_form"]["search_content"].value;
                var graduation =0;
                var obj=document.getElementsByName("graduation");
                if (obj[0].checked) {
                    graduation = 1;
                }
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
                xmlhttp.open("GET","get_student_data.php?q1="+ column + "&q2="+search_content + "&q3=" + graduation,true);
                xmlhttp.send();
            }

             function toChangeInfoForm(number){
                window.open("change_stu_info.php?q1="+number,"","width=800,height=400")
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

           function  check(value) {     //根据属性栏提供不同搜索框
               if (value === "S_sex"){
                   var sexDiv = document.createElement("div");
                   sexDiv.id = "sexDiv";
                   sexDiv.style.display="inline";
                   var sexBoxMale = document.createElement("input");
                   var sexBoxFemale = document.createElement("input");
                   sexBoxMale.type = sexBoxFemale.type = "radio";
                   sexBoxMale.name = sexBoxFemale.name = "search_content";
                   sexBoxMale.value = 1;
                   sexBoxFemale.value = 0;

                   var maleTXTtag = document.createElement("label");
                   var femaleTXTtag = document.createElement("label");

                   var maleTXT=document.createTextNode("男");
                   var femaleTXT= document.createTextNode("女");

                   maleTXTtag.appendChild(maleTXT);
                   femaleTXTtag.appendChild(femaleTXT);

                   var searchForm = document.getElementById("search_form");
                   var searchBox = document.getElementById("searchBox");
                   searchForm.removeChild(searchBox);
                   sexDiv.appendChild(sexBoxMale);
                   sexDiv.appendChild(maleTXTtag);
                   sexDiv.appendChild(sexBoxFemale);
                   sexDiv.appendChild(femaleTXTtag);
                   searchForm.appendChild(sexDiv)
               }
               else {
                   if (document.getElementById("sexDiv")) {
                        var inputBox = document.createElement("input");
                        inputBox.type  = "search";
                        inputBox.name = "search_content";
                        inputBox.style.marginLeft = "5px";
                        inputBox.id = "searchBox";

                        var searchForm = document.getElementById("search_form");
                        searchForm.removeChild(document.getElementById("sexDiv"));
                        searchForm.appendChild(inputBox);
                   }
                   var searchBox = document.getElementById("searchBox");
                       searchBox.type="search";
               }

               if (value === "S_birthdate" || value === "S_studydate"){
                   var searchBox = document.getElementById("searchBox");
                   searchBox.type="date";
               }
           }

        </script>

        <div class="topnav" id="myTopnav">
            <a href="query_page.php" class="active">学生基本信息查询</a>
            <a href="query_class_info.php">班级信息查询</a>
            <a href="query_teacher_info.php">教师管辖班级查询</a>
        </div>

    </head>

    <body>
    <div class="search_form" style="margin-top: 10px" >
        <form id="search_form" name="search_form" style="display:inline;">
            <select name="colunm" style="margin: auto" onchange="check(this.value)">
                <option value="S_number">学号</option>
                <option value="S_name">姓名</option>
                <option value="S_birthdate">出生日期</option>
                <option value="S_studydate">入学日期</option>
                <option value="S_sex">性别</option>
                <option value="S_class">班级</option>
                <option value="S_grade">年级</option>
                <option value="S_age">年龄</option>
            <input type="search" name="search_content" id="searchBox" style="margin-left: 5px">
        </form>
        <input type="checkbox" name="graduation" value="1">显示已毕业学生
        <button type="submit" form="search" onclick="showData()" style="margin-left: 10px">查询</button>
        <button type="button" onclick="jumpToRegister()" style="margin-left: 100px">录入新学生</button>
        <button type="button" onclick="jumpToLoginOut()" style="margin-left: 500px">退出登陆</button>
    </div>


    <div id="queryFormShow"></div>
    <div id="txtHint"></div>

    </body>
</html>
