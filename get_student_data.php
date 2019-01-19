<?php
/**
 * Created by PhpStorm.
 * User: ZZMilkTEA
 * Date: 2018/12/30
 * Time: 17:32
 */

$colunm = isset($_GET["q1"])? $_GET["q1"]:"";
$searchContent = isset($_GET["q2"]) ? $_GET["q2"]:"";
$graduation = isset($_GET["q3"]) ? $_GET["q3"]:0;

require "DB_connect.php";

mysqli_set_charset($conn, "utf8");

if ($searchContent==null || $searchContent==""){
    $sql="SELECT *,TIMESTAMPDIFF(month ,S_birthdate,curdate())/12 as S_age FROM students ORDER BY $colunm";
}else {
    $sql = "select *,TIMESTAMPDIFF(month ,S_birthdate,curdate())/12 as S_age from students where $colunm = $searchContent;";
}
$result = mysqli_query($conn,$sql);

echo "
<table id='resultTable'>
<tr>
<th>学号</th>
<th>姓名</th>
<th>出生日期</th>
<th>年龄</th>
<th>性别</th>
<th>入学日期</th>
<th>班级</th>
<th>年级</th>
<th>操作</th>
</tr>";

$counter=0;
while($row = mysqli_fetch_array($result))
{
    if($graduation == 0){
        if((ceil(strtotime (date("Y-m-d"))-strtotime ($row['S_studydate']))/3600/24)>=1461){
            continue;
        }
    }
    if($counter%2==0){
        echo "<tr>";
    }else{
        echo "<tr class='alt'>";
    }

    echo "<td>" . $row['S_number'] . "</td>";
    echo "<td>" . $row['S_name'] . "</td>";
    echo "<td>" . $row['S_birthdate'] . "</td>";
    echo "<td>" . floor($row['S_age']) . "</td>";
    echo "<td>" . sexShowTrsfmt($row['S_sex']) . "</td>";
    echo "<td>" . $row['S_studydate'] . "</td>";
    echo "<td>" . $row['S_class'] . "</td>";
    echo "<td>" . $row['S_grade'] . "</td>";
    echo "<td> <button type='button' onclick='toChangeInfoForm(" . $row['S_number'] . ")'>修改</button>
  <button type='button' onclick='deleteInfo(" . $row['S_number'] . ",1)'>删除</button></td>";
    echo "</tr>";
    $counter++;
}

echo "
</table>
<table width=\"60%\" align=\"right\">
        <tr><td><div id=\"barcon\" name=\"barcon\"></div></td></tr>
    </table>
    <script>
    goPage(1,10);
</script>
";



function sexShowTrsfmt($input){
    if($input==0)return "女";
    if($input==1)return "男";
}
?>