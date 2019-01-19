<?php   //用来返回已经存在的班级
require "DB_connect.php";

// 从 URL 中获取参数 q 的值
$q=$_GET["q"];

// 如果 q 参数存在则从数据库中查找数据
if(isset($q) && $q != '')
{
    if(!$conn)
    {
        die('Could not connect: ' .mysqli_error());
    }
    $sql = "select * from classes;";

    $result =mysqli_query($conn,$sql);

    $count = 0;
    while($row = mysqli_fetch_array($result))
    {
        //匹配判断
        if(stristr($row['C_number'],$q))
        {
            echo "<option value=\"".$row['C_number'] ."\">";
            $count += 1;
        }
    }
    mysqli_close($conn);
}

// 如果没找到则返回 "no suggestion"
if ($count == 0)
{
    echo "<option value=\"no suggestion\";>";
}
?>


