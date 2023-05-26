<?php
require_once ('models/userModel.php');
require_once ('models/pictureModel.php');

class LikePicture {
    private $_username;

    public function __construct($formData) {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['msg'] = 'You are not connected';
            require_once('views/index.php');
        }
        else {
            $picture = new Picture();
            $check = $picture->checkLike($formData['id'], $_SESSION['user_id']);
            if ($check == 0) {
                $picture->addLike($formData['id'], $_SESSION['user_id']);
                http_response_code(201);
                echo json_encode(array(
                    'message' => "liked"
                ));
            } 
            else if ($check != 0) {
                $picture->removeLike($formData['id'], $_SESSION['user_id']);
                http_response_code(201);
                echo json_encode(array(
                    'message' => "unliked"
                ));
            }
            else {
                http_response_code(500);
                echo json_encode(array(
                    'message' => "failed"
                ));
            }
        }
    }
}