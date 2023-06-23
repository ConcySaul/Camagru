<?php
require_once ('models/userModel.php');

class PostPicture {
    private $_username;
    private $_email;
    private $_pdo;

    public function __construct($post) {
        $this->_pdo = $this->connectDb(); 
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['msg'] = 'You are not connected';
            require_once('views/index.php');
        }
        else {
            $stickerData = json_decode($post['stickerData'], true);
            $stickerData2 = json_decode($post['stickerData2'], true);
            $stickerData3 = json_decode($post['stickerData3'], true);

            
            $filename = $this->create_image(base64_decode(str_replace('data:'. $_POST['imageType'] .';base64,', '', $_POST['imageData'])),
            $stickerData, $stickerData2, $stickerData3);

            rename($filename, "public/".$filename);
            
            $directory = "public/" . $filename;
            $date = date('Y-m-d H:i:s');
            $query = $this->_pdo->prepare("INSERT into pictures (user_id, directory, timedate) VALUES (:user_id, :directory, :timedate)");
            $query->bindParam(":user_id", $_SESSION['user_id']);
            $query->bindParam(":directory", $directory);
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
                    'message' => 'failure with db'
                ));
                exit();
            }
        }
    }

    private function create_image($imageUrl, $stickerData, $stickerData2, $stickerData3) {

        $image = imagecreatefromstring($imageUrl);
        if (isset($stickerData['src'])){
            $overlayImg = imagecreatefrompng(ltrim($stickerData['src'], $stickerData['src'][0]));
            
            $overlayHeight = (substr($stickerData['height'], 0, -1) / 100) * imagesy($image);
            $overlayWidth = $overlayHeight * (imagesx($overlayImg) / imagesy($overlayImg));
            $overlayResized = imagecreatetruecolor($overlayWidth, $overlayHeight);
            imagealphablending($overlayResized, false);
            imagesavealpha($overlayResized, true);
        
            $overlayResizedLeft = (substr($stickerData['left'], 0, -1) / 100) * imagesx($image);
            $overlayResizedTop = (substr($stickerData['top'], 0, -1) / 100) * imagesy($image);
        
            imagecopyresampled($overlayResized, $overlayImg, 0, 0, 0, 0, $overlayWidth, $overlayHeight, imagesx($overlayImg), imagesy($overlayImg));
        
            imagecopy($image, $overlayResized, $overlayResizedLeft, $overlayResizedTop, 0, 0, $overlayWidth, $overlayHeight);
        }
        
        $tmp_filename = uniqid() . '.png';
    
        imagepng($image, $tmp_filename);
    
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
