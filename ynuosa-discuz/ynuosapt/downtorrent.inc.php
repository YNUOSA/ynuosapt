<?php
/**
 * Created by PhpStorm.
 * User: strrl
 * Date: 17-4-20
 * Time: 下午10:38
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
global $_G;
$path = $_G['cache']['plugin']['ynuosapt']['xbtit_URL'] . '/download.php?id=' . $_GET['info_hash'] . '&uid=' . $_G['uid'] . '&f=' . $_GET['f'];
header("location:$path")
?>