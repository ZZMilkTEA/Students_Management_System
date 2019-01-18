<?php
/**
 * Created by PhpStorm.
 * User: ZZMilkTEA
 * Date: 2018/12/30
 * Time: 17:32
 */

$colunm = isset($_GET["q1"])? $_GET["q1"]:"";
$search_content = isset($_GET["q2"]) ? $_GET["q2"]:"";

require "DB_connect.php";

mysqli_set_charset($conn, "utf8");

if ($search_content==null || $search_content==""){
    $sql="SELECT * FROM students ORDER BY $colunm";
    $result = mysqli_query($conn,$sql);
}else {
    $sql = "SELECT * FROM students WHERE $colunm = $search_content";
    $result = mysqli_query($conn, $sql);
}

echo "
<table id='students'>
<tr>
<th>学号</th>
<th>姓名</th>
<th>年龄</th>
<th>性别</th>
<th>班级</th>
<th>年级</th>
<th>操作</th>
</tr>";

$counter=0;
while($row = mysqli_fetch_array($result))
{
    if($counter%2==0){
        echo "<tr>";
    }else{
        echo "<tr class='alt'>";
    }

    echo "<td>" . $row['S_number'] . "</td>";
    echo "<td>" . $row['S_name'] . "</td>";
    echo "<td>" . $row['S_age'] . "</td>";
    echo "<td>" . sexShowTrsfmt($row['S_sex']) . "</td>";
    echo "<td>" . $row['S_class'] . "</td>";
    echo "<td>" . $row['S_grade'] . "</td>";
    echo "<td> <button type='button' onclick='toChangeInfoForm(" . $row['S_number'] . ")'>修改</button>
  <button type='button' onclick='deleteInfo(" . $row['S_number'] . ")'>删除</button></td>";
    echo "</tr>";
    $counter++;
}

echo "
</table>
";



function sexShowTrsfmt($input){
    if($input==0)return "女";
    if($input==1)return "男";
}
?>