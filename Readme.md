#云南大学PT站
##介绍
Discuz + Discuz插件 + xbtit(tracker)

均运行在docker中

Discuz映射到主机的80端口上

xbtit映射到主机的880端口上

##安装手册
1. make start (如果是重新安装请运行 make rebuild)
2. 使用向导安装Discuz与xbtit(注:数据库IP为docker容器的IP)
3. 修改如下文件:  
a. 在`uc_server\model\admin.php`中
将  
`$this->cookie_status = 0;`  
修改为：  
`$this->cookie_status = isset($_COOKIE['sid']) ? 1 : 0;`  
(修复ucenter进不去)   
b. 在`source/class/discuz/discuz_application.php`中    
将369－371这三行
```php
if (strpos ($temp, $str) !== false) {
          system_error ('request_tainting');
   }
```
注释掉 
 (修复同步登陆不成功)  
 c.在`template/default/forum/post.html`中  
为`<form>`加入属性`enctype="multipart/form-data"`  
(修复无法上传文件)
 
4. 在discuz数据库中建立如下表
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
5. 进入ucenter,添加一个应用,并配置插件目录下uc目录的config.inc.php    
http://your.domain.name/source/plugin/ynuosapt/uc  
(1. 先不要开启同步登陆 2. 关闭discuz的同步登陆 3.开启ynuosapt的同步登陆 4. 开启discuz的同步登陆)
5. 开启插件
6. 修改版面权限以支持特殊主题:PT资源(具体操作请查阅discuz使用手册)
6. 