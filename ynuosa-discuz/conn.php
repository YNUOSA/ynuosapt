<?php
/**
 * Created by PhpStorm.
 * User: strrl
 * Date: 17-4-2
 * Time: 下午11:28
 */
loadcache('ynuosapt');
try {
//    $db = mysqli_connect($_G['cache']['plugin']['dbhost'], $_G['cache']['dbusername'], $_G['cache']['dbpassword'], $_G['cache']['dbname'], $_G['cache']['plugin']['dbport']);
    $db = mysqli_connect("172.17.0.2", "root", "123456", "xbtit", 3306);
} catch (Exception $e) {

}

?>