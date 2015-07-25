<?php
// 修改用户名和密码
$conn = @mysql_connect('127.0.0.1','root','root');
if (!$conn) {
    die('Could not connect: ' . mysql_error());
}
// 修改数据库名称
mysql_select_db('mysql', $conn);

mysql_query("SET devices utf8");

