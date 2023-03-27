<?php
require_once ('models/userModel.php');

class Home {
    private $_username;
    private $_password;

    public function __construct($url) {
        $this->_username = $form_data['username'];
        $this->_password = $form_data['password'];

        $user = new User($this->_username, $this->_password);
        
        if (!$user->checkPassword()){
            $_SESSION['msg'] = 'Wrong password';
            header('Location: /Index.php');
        }
        else if ($user->checkUsername()){
            $_SESSION['msg'] = 'No such user';
            header('Location: /Index.php');
        }
        else {
            $user->login();
            header('Location: /Home.php');
        }
    }
}