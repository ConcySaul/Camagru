<?php
require_once ('models/userModel.php');

class Login {
    private $_username;
    private $_password;

    public function __construct($form_data) {
        $this->_username = $form_data['username'];
        $this->_password = $form_data['password'];

        $user = new User($this->_username, $this->_password);
        
        if (!$user->checkPassword()){
            $_SESSION['msg'] = 'Wrong password';
            header('Location: /Index');
        }
        else if ($user->checkUsername()){
            $_SESSION['msg'] = 'No such user';
            header('Location: /Index');
        }
        else if (!$user->checkActive()){
            $_SESSION['msg'] = 'you have not validated your account';
            header('Location: /Index');
        }
        else {
            $user->login();
            $url = "/Home/1";
            header('Location: ' .$url);
        }
    }
}