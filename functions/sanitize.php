<?php
/**
 * Created by Chris on 9/29/2014 3:59 PM.
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';

function escape($string) {
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}