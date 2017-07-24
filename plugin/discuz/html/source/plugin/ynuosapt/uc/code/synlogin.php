<?php
/**
 * Created by PhpStorm.
 * User: strrl
 * Date: 17-4-7
 * Time: 下午3:16
 */
define('XBTIT_ALL_USR_PASSWD', 'here is a random password');
function xbtit_syncuser($username, $uid)
{
    $db = mysqli_connect("172.17.0.2", "root", "123456", "xbtit");
//    require_once '../../conn.php';
    $sql = "SELECT username FROM `xbtit_users` WHERE id = " . $uid . ";";
    $result = mysqli_fetch_all(mysqli_query($db, $sql), MYSQLI_ASSOC);
//    if (count($result) == 0)
    if (true) {
        //init
        $passwd = XBTIT_ALL_USR_PASSWD;
        $multipass = hash_generate($uid, $passwd, $username);
        $i = 1;
        $floor = 100000;
        $ceiling = 999999;
        srand((double)microtime() * 1000000);
        $password = mysqli_real_escape_string($db, $multipass[$i]["rehash"]);
        $salt = mysqli_real_escape_string($db, $multipass[$i]["salt"]);
        $passtype = $i;
        $dupe_hash = mysqli_real_escape_string($GLOBALS['conn'], $multipass[$i]["dupehash"]);
        $random = rand($floor, $ceiling);
        $pid = md5(uniqid(rand(), true));
        $time_offset = '0';
        $sql = "INSERT INTO `xbtit_users` (`id`,`username`, `password`, `salt`, `pass_type`, `dupe_hash`, `random`, `id_level`,`email`, `style`, `language`, `flag`, `joined`, `lastconnect`, `pid`, `time_offset`,`torrentsperpage`)VALUES(" . $uid . ",'" . $username . "', '" . $password . "', '', '1', '" . $dupe_hash . "', " . $random . ", 4, '" . $username . "@" . $username . ".com" . "', 1, 1, 0, NOW(), NOW(),'" . $pid . "', '0', 15)";
        $result = mysqli_query($db, $sql);
    }
    mysqli_close($db);
}

function hash_generate($row, $pwd, $user)
{
    global $btit_settings;

    $salt = pass_the_salt(20);
    $passtype = array();
    // Type 1 - Used in btit / xbtit / Torrent Trader / phpMyBitTorrent
    $passtype[1]["hash"] = md5($pwd);
    $passtype[1]["rehash"] = md5($pwd);
    $passtype[1]["salt"] = "";
    $passtype[1]["dupehash"] = substr(sha1(md5($pwd)), 30, 10) . substr(sha1(md5($pwd)), 0, 10);
//        // Type 2 - Used in TBDev / U-232 / SZ Edition / Invision Power Board
//        $passtype[2]["hash"]=md5(md5($row["salt"]).md5($pwd));
//        $passtype[2]["rehash"]=md5(md5($salt).md5($pwd));
//        $passtype[2]["salt"]=$salt;
//        $passtype[2]["dupehash"]=substr(sha1(md5($pwd)),30,10).substr(sha1(md5($pwd)),0,10);
//        // Type 3 - Used in Free Torrent Source /  Yuna Scatari / TorrentStrike / TSSE
//        $passtype[3]["hash"]=md5($row["salt"].$pwd.$row["salt"]);
//        $passtype[3]["rehash"]=md5($salt.$pwd.$salt);
//        $passtype[3]["salt"]=$salt;
//        $passtype[3]["dupehash"]=substr(sha1(md5($pwd)),30,10).substr(sha1(md5($pwd)),0,10);
//        // Type 4 - Used in Gazelle
//        $passtype[4]["hash"]=sha1(md5($row["salt"]).$pwd.sha1($row["salt"]).$btit_settings["secsui_ss"]);
//        $passtype[4]["rehash"]=sha1(md5($salt).$pwd.sha1($salt).$btit_settings["secsui_ss"]);
//        $passtype[4]["salt"]=$salt;
//        $passtype[4]["dupehash"]=substr(sha1(md5($pwd)),30,10).substr(sha1(md5($pwd)),0,10);
//        // Type 5 - Used in Simple Machines Forum
//        $passtype[5]["hash"]=sha1(strtolower($user).$pwd);
//        $passtype[5]["rehash"]=sha1(strtolower($user).$pwd);
//        $passtype[5]["salt"]="";
//        $passtype[5]["dupehash"]=substr(sha1(md5($pwd)),30,10).substr(sha1(md5($pwd)),0,10);
//        // Type 6 - New xbtit hashing style
//        $passtype[6]["hash"]=sha1(substr(md5($pwd),0,16)."-".md5($row["salt"])."-".substr(md5($pwd),16,16));
//        $passtype[6]["rehash"]=sha1(substr(md5($pwd),0,16)."-".md5($salt)."-".substr(md5($pwd),16,16));
//        $passtype[6]["salt"]=$salt;
//        $passtype[6]["dupehash"]=substr(sha1(md5($pwd)),30,10).substr(sha1(md5($pwd)),0,10);

    return $passtype;
}

function pass_the_salt($len = 5)
{
    $salt = '';
    srand((double)microtime() * 1000000);

    for ($i = 0; $i < $len; $i++) {
        $num = rand(33, 126);

        if ($num == '92') {
            $num = 93;
        }

        $salt .= chr($num);
    }
    return $salt;
}

function logToFile($msg)
{
    $logfile = fopen("sync.log", "a");
    fwrite($logfile, $msg);
}

?>
