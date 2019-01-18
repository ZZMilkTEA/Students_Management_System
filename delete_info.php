<?php
/**
 * Created by PhpStorm.
 * User: ZZMilkTEA
 * Date: 2019/1/8
 * Time: 1:43
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

$number = isset($_GET["q1"]) ? intval($_GET["q1"]) : '';

require "DB_connect.php";

$sql = "delete FROM STUDENTS WHERE S_number=$number";
$conn->query($sql);
    ?>