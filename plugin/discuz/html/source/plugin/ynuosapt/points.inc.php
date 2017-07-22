<?php

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
include 'conn.php';

$result = mysqli_query($db, "SELECT downloaded,uploaded FROM xbtit.xbtit_users WHERE id = '" . $_G['uid'] . "';");
mysqli_close($db);
$row = mysqli_fetch_all($result, MYSQLI_BOTH)[0];
$upload_data = makesize($row['downloaded']);
$download_data = makesize($row['uploaded']);

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