<?php
/**
 * Created by PhpStorm.
 * User: ZZMilkTEA
 * Date: 2019/1/8
 * Time: 1:43
 */
$number = isset($_GET["q1"]) ? intval($_GET["q1"]) : '';

require "DB_connect.php";

$sql = "delete FROM STUDENTS WHERE S_number=$number";
$conn->query($sql);
    ?>