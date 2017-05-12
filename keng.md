#已修改的文件：
config/config_global.php  
```php 
./config/config_global.php
$_config['plugindeveloper'] = 1//2;
```
source/class/class_member.php  
source/class/class_mylog.php
uc_server/model/admin.php


#2017年04月05日

如果UC进不去  
打开  
`uc_server\model\admin.php`  
搜索：  
`$this->cookie_status = 0;`  
修改为：  
`$this->cookie_status = isset($_COOKIE['sid']) ? 1 : 0;`  
覆盖同名文件，再使用uc密码就能登录了
1. 在class_member.php中发现注册时的钩子
2. 将插件注册为ucserver的应用可以减少对源文件的改动

#2017年04月06日
在discuz中 new 一个类会自动去source/class/去找 include或require其他的php文件再写入类都不行。
必须在class中新建class_类名.php  
关于GD库的安装：  
依赖`libpng-dev`  

<pre>
症状1：会员在dz修改会员信息后不通知其他 应用同步更改；

症状2：在uc后台“应用管理”里编辑任何应用，唯独就通知DZx主程序失败，其他应用通知成功。这点在uc后台 -->数据列表-->通知列表  内 能查看出错误记录；

症状3：其他在应用中 会员 登录或注销 都能全站同步，唯独在dzx中 登录或注销，不能同步到其他应用。

以上说明这可能是dzx3.x的bug，此为临时解决方案。bug 好像已有人提交，但是官方好像没有反应。
）

/**************以下为临时解决********************/

在ucenter中修改了一个邮箱可注册多个帐号后显示修改成功，但是通知失败

经过反复对比和测试，找到是这个文件造成的问题/source/class/discuz/discuz_application.php
删除或注销 369－371这三行代码即可！改后暂时没有发现什么问题，但不知道会不会有什么隐患。
                             
/*将以下代码注释掉，以作零时解决方案*/
if (strpos ($temp, $str) !== false) {
       system_error ('request_tainting');
}
</pre>

#2017年04月07日01:16:48 
rebuild后  
discuz内synlogin synlogout 成功


#2017年04月07日01:41:16
xbtit注册规则

```sql
INSERT INTO `xbtit_users` 
(`username`, `password`, `salt`, `pass_type`, `dupe_hash`, `random`, `id_level`, 
`email`, `style`, `language`, `flag`, `joined`, `lastconnect`, `pid`, `time_offset`, 
`torrentsperpage`) 
VALUES 
('test02', 'f6d28b83df2f9854baaf1c12b0357b60', '', '1', 'cde4ac77222d3219fc81', 298770, 2, 
'b@b.com', 1, 1, 0, NOW(), NOW(),'41f04f98e920af6758825bb0d426d608', '0', 
15)

```
其中
```php
$i = $btit_settings["secsui_pass_type"]; 常为  1
$multipass = 
function hash_generate($row, $pwd, $user)
{
    global $btit_settings;

    $salt=pass_the_salt(20);
    $passtype=array();
    // Type 1 - Used in btit / xbtit / Torrent Trader / phpMyBitTorrent
    $passtype[1]["hash"]=md5($pwd);
    $passtype[1]["rehash"]=md5($pwd);
    $passtype[1]["salt"]="";
    $passtype[1]["dupehash"]=substr(sha1(md5($pwd)),30,10).substr(sha1(md5($pwd)),0,10);
    // Type 2 - Used in TBDev / U-232 / SZ Edition / Invision Power Board
    $passtype[2]["hash"]=md5(md5($row["salt"]).md5($pwd));
    $passtype[2]["rehash"]=md5(md5($salt).md5($pwd));
    $passtype[2]["salt"]=$salt;
    $passtype[2]["dupehash"]=substr(sha1(md5($pwd)),30,10).substr(sha1(md5($pwd)),0,10);
    // Type 3 - Used in Free Torrent Source /  Yuna Scatari / TorrentStrike / TSSE
    $passtype[3]["hash"]=md5($row["salt"].$pwd.$row["salt"]);
    $passtype[3]["rehash"]=md5($salt.$pwd.$salt);
    $passtype[3]["salt"]=$salt;
    $passtype[3]["dupehash"]=substr(sha1(md5($pwd)),30,10).substr(sha1(md5($pwd)),0,10);
    // Type 4 - Used in Gazelle
    $passtype[4]["hash"]=sha1(md5($row["salt"]).$pwd.sha1($row["salt"]).$btit_settings["secsui_ss"]);
    $passtype[4]["rehash"]=sha1(md5($salt).$pwd.sha1($salt).$btit_settings["secsui_ss"]);
    $passtype[4]["salt"]=$salt;
    $passtype[4]["dupehash"]=substr(sha1(md5($pwd)),30,10).substr(sha1(md5($pwd)),0,10);
    // Type 5 - Used in Simple Machines Forum
    $passtype[5]["hash"]=sha1(strtolower($user).$pwd);
    $passtype[5]["rehash"]=sha1(strtolower($user).$pwd);
    $passtype[5]["salt"]="";
    $passtype[5]["dupehash"]=substr(sha1(md5($pwd)),30,10).substr(sha1(md5($pwd)),0,10);
    // Type 6 - New xbtit hashing style
    $passtype[6]["hash"]=sha1(substr(md5($pwd),0,16)."-".md5($row["salt"])."-".substr(md5($pwd),16,16));
    $passtype[6]["rehash"]=sha1(substr(md5($pwd),0,16)."-".md5($salt)."-".substr(md5($pwd),16,16));
    $passtype[6]["salt"]=$salt;
    $passtype[6]["dupehash"]=substr(sha1(md5($pwd)),30,10).substr(sha1(md5($pwd)),0,10);

    return $passtype;
}

password = mysqli_real_escape_string($GLOBALS['conn'], $multipass[$i]["rehash"])
salt = mysqli_real_escape_string($GLOBALS['conn'], $multipass[$i]["salt"])  ''
pass_type = $i 1
dupe_hash = mysqli_real_escape_string($GLOBALS['conn'], $multipass[$i]["dupehash"])
random = $random
……
pid = $pid = md5(uniqid(rand(), true));
time_offset = $timezone
```
#2017年04月07日
完成用户同步
#2017年04月11日15:43:24
```
Request URL:http://localhost:880/index.php?page=upload
Request Method:POST
Status Code:200 OK
Remote Address:[::1]:880
Referrer Policy:no-referrer-when-downgrade
Response Headers
view source
Cache-Control:no-store, no-cache, must-revalidate, post-check=0, pre-check=0
Connection:Keep-Alive
Content-Encoding:gzip
Content-Length:3055
Content-Type:text/html; charset=UTF-8
Date:Tue, 11 Apr 2017 07:41:10 GMT
Expires:Thu, 19 Nov 1981 08:52:00 GMT
Keep-Alive:timeout=5, max=100
Pragma:no-cache
Server:Apache/2.4.10 (Debian)
Vary:Accept-Encoding
X-Powered-By:PHP/5.6.30
Request Headers
view source
Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8
Accept-Encoding:gzip, deflate, br
Accept-Language:zh-CN,zh;q=0.8,en;q=0.6
Cache-Control:max-age=0
Connection:keep-alive
Content-Length:11472
Content-Type:multipart/form-data; boundary=----WebKitFormBoundary8YMQUjxyuHBevnS9
Cookie:XDEBUG_SESSION=phpStorm; gwHY_2132_saltkey=n3l67u6B; gwHY_2132_lastvisit=1491892797; gwHY_2132_onlineusernum=1; gwHY_2132_sid=LT2KNn; gwHY_2132_lastact=1491896398%09home.php%09misc; gwHY_2132_sendmail=1; uid=2; pass=940f121c0237258b867332c949131b9f; xbtit=ff4570df74275df3e02eb0a3e8a16cea
Host:localhost:880
Origin:http://localhost:880
Referer:http://localhost:880/index.php?page=upload
Upgrade-Insecure-Requests:1
User-Agent:Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/57.0.2987.98 Chrome/57.0.2987.98 Safari/537.36
Query String Parameters
view source
view URL encoded
page:upload
Request Payload
------WebKitFormBoundary8YMQUjxyuHBevnS9
Content-Disposition: form-data; name="user_id"


------WebKitFormBoundary8YMQUjxyuHBevnS9
Content-Disposition: form-data; name="torrent"; filename="cn_windows_10_multiple_editions_x64_dvd_6848463.iso.torrent"
Content-Type: application/x-bittorrent


------WebKitFormBoundary8YMQUjxyuHBevnS9
Content-Disposition: form-data; name="category"

7
------WebKitFormBoundary8YMQUjxyuHBevnS9
Content-Disposition: form-data; name="filename"

cn win 10
------WebKitFormBoundary8YMQUjxyuHBevnS9
Content-Disposition: form-data; name="fontchange"


------WebKitFormBoundary8YMQUjxyuHBevnS9
Content-Disposition: form-data; name="fontchange"


------WebKitFormBoundary8YMQUjxyuHBevnS9
Content-Disposition: form-data; name="info"

cn win 10:D:D:D
------WebKitFormBoundary8YMQUjxyuHBevnS9
Content-Disposition: form-data; name="anonymous"

false
------WebKitFormBoundary8YMQUjxyuHBevnS9--
```

#2017年04月18日11:07:40
更改了download.php与upload.php  
使其可以通过发包来上传与下载
##剩下的任务就是全力写discuz插件了  

思路:
新建一张表 discuz_pt_log
修改xtbt的代码 在发包时返回torrent的hash

上传torrent文件时讲hash与帖子的froumid存到discuz_pt_log中

显示帖子时去查询这张表
#2017年04月18日18:11:02
为了解决上传文件的问题 不得不修改discuz文件
修改了:template/default/forum/post.html
为其中的form加入了enctype="multipart/form-data"属性
#2017年04月18日23:39:57
在discuz中新建了一张表 
```sql
CREATE TABLE `ultrax`.`pre_ynuosapt_tid_files` (
  `lid` INT NOT NULL AUTO_INCREMENT,
  `tid` INT NULL,
  `downloadcount` INT NULL DEFAULT 0,
  `hash_info` VARCHAR(40) NULL,
  `uploadtime` DATETIME NULL DEFAULT NOW(),
  `uploader` VARCHAR(20) NULL,
  PRIMARY KEY (`lid`));
```
表名:mytablename  
目录:source/plugin/mypluginid/table/table_mytablename.php  
类名:table_mytablename  
用法:C::t('#mypluginid#mytablename')->method();  