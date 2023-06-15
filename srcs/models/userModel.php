<?php 
require_once ('models/databaseModel.php');
require_once ('models/mailModel.php');

class User {
    private $_id;
    private $_username;
    private $_email;
    private $_password;
    private $_challengeId;

    public function __construct() {
        $arguments = func_get_args();
        $numberOfArguments = func_num_args();

        if ($numberOfArguments == 3) {
            call_user_func_array(array($this, '__construct1'), $arguments);
        }
        else if ($numberOfArguments == 2) {
            call_user_func_array(array($this, '__construct2'), $arguments);
        }
        else if ($numberOfArguments == 1) {
            call_user_func_array(array($this, '__construct3'), $arguments);
        }
    }

    public function __construct1($username, $password, $email) {
        $this->_username = $username;
        $this->_email = $email;
        $this->_password = $password;
    }

    public function __construct2($username, $password) {
        $this->_username = $username;
        $this->_password = $password;
    }

    public function __construct3($id) {
        $db = new Database();
        $user = $db->getUserById($id);
        $this->_id = $user['id'];
        $this->_password = $user['pass'];
        $this->_username = $user['username'];
        $this->_email = $user['email'];
    }

    public function checkUsername () {
        $_db = new Database();
        $result = $_db->getUserByUsername($this->_username);
        if (!$result) {
            return true;
        }
        return false;
    }

    public function checkEmail () {
        $_db = new Database();
        $result = $_db->getUserByEmail($this->_email);
        if (!$result) {
            return true;
        }
        return false;
    }

    public function signup(){
        $_db = new Database();
        $challengeId = $_db->createUser($this->_username, $this->_email, $this->_password);
        $mail = new Mail($this->_email, $this->_username);
        $mail->sendSignUpEmail($challengeId);
    }

    public function resetPassword(){
        $db = new Database();
        $challengeId = $db->generateChallengeId($this->_id);
        $mail = new Mail($this->_email, $this->_username);
        $mail->sendPasswordMail($challengeId);
    }

    public function login(){
        $_db = new Database();
        $this->getUserId();
        $_SESSION['user_id'] = $this->_id;
        $_SESSION['username'] = $this->_username;
        $_SESSION['email'] = $this->_email;
    }

    public function checkPassword(){
        $_db = new Database();
        $user = $_db->getUserByUsername($this->_username);
        if (password_verify($this->_password, $user['pass'])) {
            return true;
        }
        return false;
    }

    public function checkActive(){
        $_db = new Database();
        $user = $_db->getUserByUsername($this->_username);
        if ($user['active'] == 1) {
            return true;
        }
        return false;
    }

    public function getUserId() {
        $_db = new Database();
        $user = $_db->getUserByUsername($this->_username);
        $this->_id = $user['id'];
        $this->_email = $user['email'];
    }

    public function returnId() {
        return $this->_id;
    }

    public function modifyUser($username, $email, $id) {
        $_db = new Database();
        if ($email) {
            $_db->changeEmail($id, $email);
        }
        if ($username) {
            $_db->changeUsername($id, $username);
        }
    }

    // public function printInfo(){
    //     echo($this->_username);
    //     echo($this->_email);
    //     echo($this->_password);
    // }
}
