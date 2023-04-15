<?php
require_once ('models/databaseModel.php');

class Verify {
    private $_challengeId;
    private $_user;

    public function __construct($url) {
        $this->_challengeId = $url[1];
        if (!$this->checkChallengeId() || $this->_user['active'] == 1) {
            $_SESSION['msg'] = 'This link is not valid anymore';
            require_once ('views/index.php');
        }
        else {
            $db = new Database();
            $db->validateAccount($this->_user['id']);
            $_SESSION['msg'] = 'Your account has been validated';
            header('Location: /Index.php');
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