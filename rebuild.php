<?php
/**
 * Created by PhpStorm.
 * User: strrl
 * Date: 17-3-31
 * Time: 下午9:17
 */
$con = mysqli_connect("172.17.0.2", "root", "123456");
if (mysqli_connect_errno($con)) {
    echo "连接 MySQL 失败: " . mysqli_connect_error();
}

// 执行查询
//mysqli_query($con, "drop database discuz");
mysqli_query($con, "drop database ultrax");
mysqli_query($con, "drop database xbtit");
//mysqli_query($con, "create database discuz");
mysqli_query($con, "create database ultrax");
mysqli_query($con, "create database xbtit");

mysqli_close($con);

?>