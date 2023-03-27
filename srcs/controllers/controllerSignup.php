<?php
require_once ('models/userModel.php');

class Signup {
    private $_username;
    private $_password;
    private $_email;

    public function __construct($form_data) {
        $this->_username = $form_data['username'];
        $this->_email = $form_data['email'];
        $this->_password = $form_data['password'];
        
        $user = new User($this->_username, $this->_password, $this->_email);

        if (!$user->checkUsername()) {
            $_SESSION['msg'] = 'Username already used';
            header('Location: /Index.php');
        }
        else if (!$user->checkEmail()){
            $_SESSION['msg'] = 'Email already used';
            header('Location: /Index.php');
        }
        else {
            $user->signup();
            $_SESSION['msg'] = 'Account created';
            header('Location: /Verify.php');
        }
    }
}