<?php
require_once ('models/userModel.php');

class Profile {
    private $_username;
    private $_password;

    public function __construct($url) {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['msg'] = 'You are not connected';
            require_once('views/index.php');
        }
        else {
            require_once('views/profile.php');
        }
    }
}