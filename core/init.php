<?php
/**
 * Created by Chris on 9/29/2014 3:58 PM.
 */

session_start();

$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'db' => 'db'
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800
    ),
    'sessions' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    )
);

date_default_timezone_set('America/Los_Angeles');


define('SITE_ROOT', 'http://localhost:63342/PHP-OOP-User-System-with-Bootstrap-Material-Design'); //Don't add trailing / at the end

define('ROOT', dirname(dirname(__FILE__)));
$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));

spl_autoload_register(function($class) {
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/' . strtolower($class) . '.php');
});

require_once ($_SERVER['DOCUMENT_ROOT'] . '/functions/sanitize.php');

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('sessions/session_name'))) {
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));

    if($hashCheck->count()) {
        $user = new User($hashCheck->first()->user_id);
        $user->login();
    }
}