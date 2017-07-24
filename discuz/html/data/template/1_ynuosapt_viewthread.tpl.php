<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); $return = '
<div class="quote">
    <dl class="  tattl">
        <dt>
            <img src="static/image/filetype/torrent.gif" border="0" class="vm" alt="">
        </dt>
        <dd>
            <p class="attnm">

                <a href='.$filehref.' id="aid1"
                   target="_blank" initialized="true">'.$filename.'</a>

            </p>
            <p>文件大小:'.$filesize.' <br>实时数据: S:'.$torrent_S.' L:'.$torrent_L.' C:'.$torrent_C.' </p>
            <p>

            </p>
        </dd>
    </dl>
</div>
'?>