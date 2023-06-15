<?php
require_once ('models/userModel.php');

class PostPicture {
    private $_username;
    private $_email;
    private $_pdo;

    public function __construct($image, $post) {
        $this->_pdo = $this->connectDb(); 
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['msg'] = 'You are not connected';
            require_once('views/index.php');
        }
        else {
            $stickerData = json_decode($post['stickerData'], true);

            $targetDir = 'public/';
            $targetFile = $targetDir.uniqid().'.'.pathinfo($image['name'], PATHINFO_EXTENSION);
            if (!move_uploaded_file($image['tmp_name'], $targetFile)) {
                http_response_code(500);
                echo json_encode(array(
                    'message' => 'failure'
                ));
                return; 
            }
            
            $tmp_filename = $this->create_image($targetFile, $stickerData);
            
            $date = date('Y-m-d H:i:s');
            $query = $this->_pdo->prepare("INSERT into pictures (user_id, directory, timedate) VALUES (:user_id, :directory, :timedate)");
            $query->bindParam(":user_id", $_SESSION['user_id']);
            $query->bindParam(":directory", $targetFile);
            $query->bindParam(":timedate", $date);
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

    private function create_image($imageUrl, $stickerData) {

        $image = imagecreatefrompng($imageUrl);
        $overlayImg = imagecreatefrompng(ltrim($stickerData['src'], $stickerData['src'][0]));

        
        $overlayHeight = (substr($stickerData['height'], 0, -1) / 100) * imagesy($image);
        $overlayWidth = $overlayHeight * (imagesx($overlayImg) / imagesy($overlayImg));
        $overlayResized = imagecreatetruecolor($overlayWidth, $overlayHeight);
        imagealphablending($overlayResized, false);
        imagesavealpha($overlayResized, true);
    
        $overlayResizedLeft = (substr($stickerData['left'], 0, -1) / 100) * imagesx($image);
        $overlayResizedTop = (substr($stickerData['top'], 0, -1) / 100) * imagesy($image);
    
        imagecopyresampled($overlayResized, $overlayImg, 0, 0, 0, 0, $overlayWidth, $overlayHeight, imagesx($overlayImg), imagesy($overlayImg));
    
        imagealphablending($image, true);
        imagesavealpha($image, true);
        imagecopy($image, $overlayResized, $overlayResizedLeft, $overlayResizedTop, 0, 0, $overlayWidth, $overlayHeight);
    
        imagepng($image, $imageUrl);
    
        return $tmp_filename;
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
