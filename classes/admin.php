<?php
/**
 * Created by Chris on 10/11/2014 11:31 PM.
 */

class Admin {

    private $_db,
            $_data;

    public function __construct() {
        $this->_db = DB::getInstance();
    }

    //Get News by ID
    public function getNews($id) {
        $tableInfo = $this->_db->query('SELECT * FROM news WHERE id = ' . $id);
            return $tableInfo->results();

    }

    public function updateNews($fields = array(), $id = null) {
        if(!$this->_db->update('news', $id, $fields)) {
            throw new Exception('There was a problem updating');
        }
    }

    //Insert News
    public function insertNews($fields = array()) {
        if(!$this->_db->insert('news', $fields)) {
            throw new Exception('Sorry, there was a problem creating the news.');
        }
    }

    //Delete News
    public function deleteNews($id) {
        $this->_db->delete('news', array('id', '=', $id));
    }

    public function data(){
        return $this->_data;
    }

}