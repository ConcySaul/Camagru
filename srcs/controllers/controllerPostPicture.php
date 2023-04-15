<?php
require_once ('models/userModel.php');

class ModifyUser {
    private $_username;
    private $_email;
    private $_pdo;

    public function __construct($image) {
        $this->_pdo = $this->connectDb(); 
        echo($image['tmp_name']);
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['msg'] = 'You are not connected';
            require_once('views/index.php');
        }
        else {
            $targetDir = 'public/';
            $targetFile = $targetDir.uniqid().'.'.pathinfo($image['name'], PATHINFO_EXTENSION);
            if (!move_uploaded_file($image['tmp_name'], $targetFile)) {
                http_response_code(500);
                echo json_encode(array(
                    'message' => 'failure'
                ));
                return; 
            }
            $query = $this->_pdo->prepare("INSERT into pictures (user_id, path) VALUES (:user_id, :path)");
            $query->bindParam(":user_id", $_SESSION['user_id']);
            $query->bindParam(":path", $targetFile);
            if ($query->execute()) {
                http_response_code(201);
                echo json_encode(array(
                    'message' => "success"
                ));
            }          
            else {
                http_response_code(500);
                echo json_encode(array(
                    'message' => 'failure'
                ));
                exit();
            }
        }
    }

    private static function connectDb () {
		try {
            $pdo = new PDO(
                "mysql:host=database;dbname=camagru_database;charset=utf8mb4",
                "root",
				"root_password"
                );
			    return $pdo;
		}
        catch (Exception $err) {
            die('Erreur : ' . $err->getMessage());
        }
    }
}