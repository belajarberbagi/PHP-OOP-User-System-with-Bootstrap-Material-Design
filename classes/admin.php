<?php
/**
 * Created by Chris on 10/11/2014 11:31 PM.
 */

class Admin {

    private $_db;

    public function __construct() {
        $this->_db = DB::getInstance();
    }

    //Insert News
    public function insertNews($fields = array()) {
        if(!$this->_db->insert('news', $fields)) {
            throw new Exception('Sorry, there was a problem creating the news.');
        }
    }

}