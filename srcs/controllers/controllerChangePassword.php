<?php
require_once ('models/userModel.php');
require_once ('models/mailModel.php');

class ChangePassword {
    private $_pdo;

    public function __construct() {
        $user = new User($_SESSION['user_id']);
        $user->resetPassword();
        session_destroy();
        header('Location: /Index');
    }

}
