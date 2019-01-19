<?php
/**
 * Created by PhpStorm.
 * User: ZZMilkTEA
 * Date: 2018/12/30
 * Time: 17:32
 */

$colunm = isset($_GET["q1"])? $_GET["q1"]:"";
$searchContent = isset($_GET["q2"]) ? $_GET["q2"]:"";

require "DB_connect.php";

mysqli_set_charset($conn, "utf8");

if ($searchContent==null || $searchContent==""){
    $sql="SELECT C_number,C_teacherID,T_name FROM classes left JOIN teachers t ON classes.C_teacherID = T_id  ORDER BY $colunm;";
}else {
    $sql = "SELECT C_number,C_teacherID,T_name FROM classes left JOIN teachers t ON classes.C_teacherID = T_id  where $colunm = $searchContent;";
}
$result = mysqli_query($conn, $sql);

echo "
<table id='resultTable'>
<tr>
<th>班级</th>
<th>班主任工号</th>
<th>班主任姓名</th>
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

    echo "<td>" . $row['C_number'] . "</td>";
    echo "<td>" . $row['C_teacherID'] . "</td>";
    echo "<td>" . $row['T_name'] . "</td>";
    echo "<td> <button type='button' onclick='toChangeInfoForm(" . $row['C_number'] . ")'>修改</button>
  <button type='button' onclick='deleteInfo(" . $row['C_number'] . ",2)'>删除</button></td>";
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
?>