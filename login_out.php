<?php
/**
 * Created by PhpStorm.
 * User: ZZMilkTEA
 * Date: 2019/1/3
 * Time: 13:27
 */
session_start();
if (isset($_SESSION['userinfo'])) {
    unset($_SESSION['userinfo']);
    echo '<script>
   alert("登出成功");
   location.href="index.php";
</script>';
}
?>