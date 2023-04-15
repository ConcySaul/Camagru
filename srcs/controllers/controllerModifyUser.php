<?php
require_once ('models/userModel.php');

class ModifyUser {
    private $_username;
    private $_email;
    private $_pdo;

    public function __construct($form_data) {
        $this->_pdo = $this->connectDb(); 
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['msg'] = 'You are not connected';
            require_once('views/index.php');
        }
        else {
            $user = new User($_SESSION['user_id']);
            $username = $form_data->username;
            $email = $form_data->email;

            if ($username) {
                $query = $this->_pdo->prepare("UPDATE users SET username = :username WHERE id = :id");
                $query->bindParam(":id", $_SESSION['user_id']);
                $query->bindParam(":username", $username);
                if ($query->execute()) {
                    $_SESSION['username'] = $username;
                }          
                else {
                    http_response_code(500);
                    echo json_encode(array(
                        'message' => 'failure'
                    ));
                    exit();
                }
            }

            if ($email) {
                $query = $this->_pdo->prepare("UPDATE users SET email = :email WHERE id = :id");
                $query->bindParam(":id", $_SESSION['user_id']);
                $query->bindParam(":email", $email);
                if ($query->execute()) {
                    $_SESSION['email'] = $email;
                }          
                else {
                    http_response_code(500);
                    echo json_encode(array(
                        'message' => 'failure'
                    ));
                    exit();
                }
            }

            http_response_code(201);
            echo json_encode(array(
                'message' => "success"
            ));
            // else {
            //     http_response_code(500);
            //     echo json_encode(array(
            //         'message' => $user->modifyUser($data->username, $data->email)
            //     ));
            // }
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