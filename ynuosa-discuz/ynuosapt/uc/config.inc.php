<?php

define('UC_CONNECT', 'mysql');
define('UC_DBHOST', '172.17.0.2');
define('UC_DBUSER', 'root');
define('UC_DBPW', '123456');
define('UC_DBNAME', 'ultrax');
define('UC_DBCHARSET', 'utf8');
define('UC_DBTABLEPRE', '`ultrax`.pre_ucenter_');
define('UC_DBCONNECT', '0');
define('UC_KEY', '6f58XchualZ15mPU9mq7nJAArbe9HuXTeTFNRkY');
define('UC_API', 'http://localhost/uc_server');
define('UC_CHARSET', 'utf-8');
define('UC_IP', '');
define('UC_APPID', '2');
define('UC_PPP', '20');
$dbhost = '172.17.0.2';            // 数据库服务器
$dbuser = 'root';            // 数据库用户名
$dbpw = '123456';                // 数据库密码
$dbname = 'ultrax';            // 数据库名
$pconnect = 0;                // 数据库持久连接 0=关闭, 1=打开
$tablepre = 'pre_ucenter_';        // 表名前缀, 同一数据库安装多个论坛请修改此处
$dbcharset = 'utf8';            // MySQL 字符集, 可选 'gbk', 'big5', 'utf8', 'latin1', 留空为按照论坛字符集设定

//同步登录 Cookie 设置
$cookiedomain = '';            // cookie 作用域
$cookiepath = '/';            // cookie 作用路径