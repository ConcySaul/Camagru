<?php
require_once ('models/userModel.php');
require_once ('models/databaseModel.php'); 

class ConfirmPassword {

    private $_challengeId;

    public function __construct($post) {
        $db = new Database();
        $user = $db->getUserByChallenge($post['challengeId']);
        $db->changePassword($user['id'], $post['password']);
        $db->generateChallengeId($user['id']);
        $_SESSION['msg'] = 'Password changed';
    }
}
