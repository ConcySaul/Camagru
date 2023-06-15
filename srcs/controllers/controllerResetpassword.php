<?php
require_once ('models/userModel.php');
require_once ('models/databaseModel.php'); 

class Resetpassword {

    private $_challengeId;
    private $_user;

    public function __construct($url) {
        if ($url[1] != 'modifyPassword') {
            $this->_challengeId = $url[1];
            if (!$this->checkChallengeId()) {
                $_SESSION['msg'] = 'This link is not valid anymore';
                header ('Location: /Index');
            }
            else {
                require_once('views/resetPassword.php');
            }
        }
    }

    private function checkChallengeId() {
        $db = new Database();
        $this->_user = $db->getUserByChallenge($this->_challengeId);
        if (!$this->_user) {
            return false;
        }
        return true;
    }
}
