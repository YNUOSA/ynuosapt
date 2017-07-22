<?php
/**
 * Created by PhpStorm.
 * User: strrl
 * Date: 17-4-18
 * Time: 下午11:36
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_ynuosapt_tid_files extends discuz_table
{

    public function __construct()
    {
        $this->_table = 'ynuosapt_tid_files';
        $this->_pk = 'lid';
        parent::__construct();
    }

    public function fetch_with_tid($tid, $force_from_db = false)
    {
        $data = array();
        if (!empty($tid)) {
            if (($force_from_db || $data = $this->fetch_cache($tid)) === false) {
                $data = DB::fetch_all('SELECT * FROM ' . DB::table($this->_table) . " WHERE" . DB::field("tid", $tid));
                if (!empty($data)) $this->store_cache($tid, $data);
            }
        }
        return $data;
    }
}
