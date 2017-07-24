<?php


if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
include "include/BDecode.php";
include "include/BEncode.php";
include "include/curl_post.php";

class threadplugin_ynuosapt
{
    var $name = 'PT资源';
    var $iconfile = '';
    var $buttontext = '发布PT资源';
    static $info_hash;

    /**ma
     * 发主题时页面新增的表单项目
     * @param Integer $fid : 版块ID
     * @return string 通过 return 返回即可输出到发帖页面中
     */
    public function newthread($fid)
    {
        //TODO - Insert your code here
        include template("ynuosapt:newthread");
        return $return;
    }

    /**
     * 主题发布前的数据判断
     * @param Integer $fid : 版块ID
     */
    public function newthread_submit($fid)
    {
        //TODO - Insert your code here
        if ($_FILES["torrentfile"]['type'] == 'application/x-bittorrent') {
            if ($_FILES["torrentfile"]["error"] > 0) {
                showmessage("Error: " . $_FILES["torrentfile"]["error"] . "<br />");
            } else {
                $dst = dirname(__FILE__) . '/' . "temp/" . $_FILES["torrentfile"]["name"];
                move_uploaded_file($_FILES["torrentfile"]["tmp_name"], $dst);
                $torrentinfo = BDecode(file_get_contents($dst));
                if ($torrentinfo['info']['private'] != 1) {
                    showmessage("不是私有种,请重新做种并勾选私有种子!");
                }
                $this::$info_hash = sha1(BEncode($torrentinfo["info"]));
                $result = curl_post($_COOKIE['uid'], $_FILES["torrentfile"]["name"], $_POST['subject'], $dst);
                if (!strpos($result, "Upload successful! The torrent has been added."))
                    if (!strpos($result, "This torrent may already exist in our database. ")) {
                        echo($result);
                        var_dump($result);
                        showmessage("已有相同种子,请不要发布重复资源");
                    } else {
                        showmessage("系统错误!请联系管理员  str_ruiling@outlook.com");
                    }
            }
        } else
            showmessage("请上传正确的torrent文件!");
    }

    /**
     * 主题发布后的数据处理
     * @param Integer $fid : 版块ID
     * @param Integer $tid : 当前帖子ID
     */
    public function newthread_submit_end($fid, $tid)
    {
        //TODO - Insert your code here
        $data = array(
            'tid' => $tid,
            'downloadcount' => 0,
            'hash_info' => $this::$info_hash,
            'uploader' => $_COOKIE['uid']
        );
        $result = C::t("#ynuosapt#ynuosapt_tid_files")->insert($data);
    }

    /**
     * 编辑主题时页面新增的表单项目
     * @param Integer $fid : 版块ID
     * @param Integer $tid : 当前帖子ID
     * @return string 通过 return 返回即可输出到编辑主题页面中
     */
    public function editpost($fid, $tid)
    {
        //TODO - Insert your code here

        return '尚不能修改种子文件。敬请期待!';
    }

    /**
     * 主题编辑前的数据判断
     * @param Integer $fid : 版块ID
     * @param Integer $tid : 当前帖子ID
     */
    public function editpost_submit($fid, $tid)
    {
        //TODO - Insert your code here

    }

    /**
     * 主题编辑后的数据处理
     * @param Integer $fid : 版块ID
     * @param Integer $tid : 当前帖子ID
     */
    public function editpost_submit_end($fid, $tid)
    {
        //TODO - Insert your code here
    }

    /**
     * 回帖后的数据处理
     * @param Integer $fid : 版块ID
     * @param Integer $tid : 当前帖子ID
     */
    public function newreply_submit_end($fid, $tid)
    {
        //TODO - Insert your code here

        return "";
    }

    /**
     * 查看主题时页面新增的内容
     * @param Integer $tid : 当前帖子ID
     * @return string 通过 return 返回即可输出到主题首贴页面中
     */
    public function viewthread($tid)
    {
        require 'include/conn.php';
        global $_G;
        //TODO - Insert your code here
        $result = C::t("#ynuosapt#ynuosapt_tid_files")->fetch_with_tid($tid);
        $info_hash = $result[0]['hash_info'];
        $sql = "SELECT * FROM `xbtit`.`xbtit_files` WHERE info_hash='" . $info_hash . "';";
        $result = mysqli_fetch_all(mysqli_query($db, $sql), MYSQLI_ASSOC);
        $filename = $result[0]['filename'];
        $filehref = "/plugin.php?id=ynuosapt:downtorrent&info_hash=" . $info_hash . "&f=" . $filename;
        $filesize = makesize($result[0]['size']);
        $torrent_S = $result[0]['seeds'];
        $torrent_L = $result[0]['leechers'];
        $torrent_C = $result[0]['finished'];
        include template("ynuosapt:viewthread");
        return $return;
    }


}

function makesize($bytes)
{
    if (abs($bytes) < 1048576)
        return number_format($bytes / 1024, 2) . ' KB'; // (Kilobytes)
    if (abs($bytes) < 1073741824)
        return number_format($bytes / 1048576, 2) . ' MB'; // (Megabytes)
    if (abs($bytes) < 1099511627776)
        return number_format($bytes / 1073741824, 2) . ' GB'; // (Gigabytes)
    if (abs($bytes) < 1125899906842624)
        return number_format($bytes / 1099511627776, 2) . ' TB'; // (Terabytes)
    if (abs($bytes) < 1152921504606846976)
        return number_format($bytes / 1125899906842624, 2) . ' PB'; // (Petabytes)
    if (abs($bytes) < 1180591620717411303424)
        return number_format($bytes / 1152921504606846976, 2) . ' EB'; // (Exabytes)
    if (abs($bytes) < 1208925819614629174706176)
        return number_format($bytes / 1180591620717411303424, 2) . ' ZB'; // (Zettabytes)
    else
        return number_format($bytes / 1208925819614629174706176, 2) . ' YB'; // (Yottabytes)
}

?>