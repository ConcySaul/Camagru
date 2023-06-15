<?php
require_once ('models/userModel.php');

class Logout {

    public function __construct($url) {
        
        if (isset($_SESSION['user_id'])){
            session_destroy();
            header('Location: /Index');
        }
    }
}
