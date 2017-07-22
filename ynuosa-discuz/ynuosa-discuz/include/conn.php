<?php
/**
 * Created by PhpStorm.
 * User: strrl
 * Date: 17-4-2
 * Time: 下午11:28
 */
//require 'config.php';
try {
    global $_G;
    $dbconfig = $_G['cache']['plugin']['ynuosapt'];
    $db = mysqli_connect($dbconfig['xbtit_dbhost'], $dbconfig['xbtit_dbuser'], $dbconfig['xbtit_dbpassword'], $dbconfig['xbtit_dbname'], $dbconfig['xbtit_dbport']);

} catch (Exception $e) {
    die('xbtit database error!');
}

?>