<?php
session_start();
$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'ratpack12',
        'db' => 'login'
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800 // time in seconds
    ),
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    )
);
spl_autoload_register(function($class) {
    require_once 'classes/' . $class . '.php';
});
require_once 'functions/sanitize.php';
if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
    // user asked to be remembered 
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $hashCheck = DB::getInstance()->get('users_sessions', array('hash', '=', $hash));
    if($hashCheck->count()) {
        // hash matches log user in
        // make sure the db field is large enough for hash - 64 charecters //
        $user = new User($hashCheck->first()->user_id);
        $user->login();
    }
}