<?php
require_once ('models/userModel.php');
require_once ('models/pictureModel.php');

class Home {
    private $_username;

    public function __construct($url) {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['msg'] = 'You are not connected';
            require_once('views/index.php');
        }
        else {
            $_SESSION['msg'] = 'Welcome '.$_SESSION['username'];
            $pic = new Picture();
            
            $pictures = $pic->getPictures();
            require_once('views/home.php');
        }
    }
}