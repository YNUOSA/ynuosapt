<?php
/**
 * Created by PhpStorm.
 * User: strrl
 * Date: 17-4-20
 * Time: 下午4:20
 */
function curl_post($uid, $filename, $info, $file_path, $category = 4, $anonymous = 'false')
{
    $data = array(
        'user_id' => $uid,
        'category' => $category,
        'anonymous' => $anonymous,
        'filename' => $filename,
        'info' => $info,
        "torrent" => new CURLFile(realpath($file_path))
    );
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_PORT => "80",
        CURLOPT_URL => "http://172.17.0.3/index.php?page=upload",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "utf8",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: multipart/form-data;",
        ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        return $response;
    }
}