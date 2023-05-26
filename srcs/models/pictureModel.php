<?php 

class Picture {
    private static $_pdo;
    private static $_pictures;

    public function __construct() {
        $this->_pdo = $this->connectDb();
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

    public function getAllPictures() {
        $query = $this->_pdo->prepare("SELECT * FROM pictures");
        $query->execute();
        $this->count = $query->fetchAll();
        return $this->_pictures;
    }

    public function getPictures($offset) {
        $limit = 5;

        $query = $this->_pdo->prepare("SELECT * FROM pictures ORDER BY timedate DESC LIMIT :limit OFFSET :offset");
        $query->bindParam(':limit', $limit, PDO::PARAM_INT);
        $query->bindParam(':offset', $offset, PDO::PARAM_INT);
        $query->execute();
        $this->_pictures = $query->fetchAll();
        return $this->_pictures;
    }

    public function countPictures() {
        $query = $this->_pdo->prepare("SELECT COUNT(*) as counter FROM pictures");
        $query->execute();
        $count = $query->fetchColumn();
        return $count;
    }

    public function countLike($pictureId) {
        $query = $this->_pdo->prepare("SELECT COUNT(*) as counter FROM likes where id_pic = :pictureId");
        $query->bindParam(':pictureId', $pictureId);
        $query->execute();
        $count = $query->fetchColumn();
        return $count;
    }

    public function checkLike($pictureId, $userId) {
        $query = $this->_pdo->prepare("SELECT * FROM likes where id_pic = :pictureId AND id_user = :userId ;");
        $query->bindParam(':userId', $userId, PDO::PARAM_INT);
        $query->bindParam(':pictureId', $pictureId, PDO::PARAM_INT);
        $query->execute();
        $check = $query->fetch();
        if ($check != null) {
            return 1;
        }
        return 0;
    }

    public function addLike($pictureId, $userId) {
        $query = $this->_pdo->prepare("INSERT INTO likes (id_user, id_pic) values (:userId, :pictureId)");
        $query->bindParam(':userId', $userId);
        $query->bindParam(':pictureId', $pictureId);
        $query->execute();
    }

    public function removeLike($pictureId, $userId) {
        $query = $this->_pdo->prepare("DELETE FROM likes where id_pic = :pictureId AND id_user = :userId");
        $query->bindParam(':userId', $userId, PDO::PARAM_INT);
        $query->bindParam(':pictureId', $pictureId, PDO::PARAM_INT);
        $query->execute();
    }

    public function printStickers() {
        $dir = $_SERVER['DOCUMENT_ROOT'] . "/public/stickers/";
        $files = scandir($dir);
        foreach ($files as $file) {
            if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'png') {
                echo '<img src="' . "/public/stickers/" . $file . '" onclick="addSticker(\''. "/public/stickers/" . $file .'\')" />';
            }
        }
    }

    public function printPictures() {
        foreach ($this->_pictures as $picture) {
            $check = $this->checkLike($picture['id'], $_SESSION['user_id']);
            $likeCounter = $this->countLike($picture['id']);
            echo '
                <div class="picture-element">
                    <!-- profile picture -->
                    <div class="picture-div neon-div-border">
                        <div class="profile-picture">
                        </div>
                        <p class="username">Username</p>
                        <div class="picture neon-div-border">
                            <a href="/Picture/'.$picture['id'].'">
                                <img src="/'.$picture['directory'].'" class="picture">
                            </a>
                        </div>
                        <div style="margin-top: 10px">
                            <div class="button-list">
                                <li id="likeLi">
                                    '.
                                    ($check ? '
                                    <svg id="svg'.$picture['id'].'" class="customSvg" onclick="likePicture('.$picture['id'].')" fill="#6b1177" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>heart</title> <path d="M0.256 12.16q0.544 2.080 2.080 3.616l13.664 14.144 13.664-14.144q1.536-1.536 2.080-3.616t0-4.128-2.080-3.584-3.584-2.080-4.16 0-3.584 2.080l-2.336 2.816-2.336-2.816q-1.536-1.536-3.584-2.080t-4.128 0-3.616 2.080-2.080 3.584 0 4.128z"></path> </g></svg>
                                    ' : '
                                    <svg id="svg'.$picture['id'].'" class="customSvg" onclick="likePicture('.$picture['id'].')" fill="#6b1177" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M8.999 3.567c0.98 0 2.753 0.469 5.628 3.301l1.425 1.403 1.404-1.426c1.996-2.028 4.12-3.288 5.543-3.288 1.919 0 3.432 0.656 4.907 2.128 1.39 1.386 2.156 3.23 2.156 5.191 0.001 1.962-0.764 3.807-2.169 5.209-0.114 0.116-6.156 6.634-11.218 12.097-0.238 0.227-0.511 0.26-0.656 0.26-0.143 0-0.412-0.032-0.65-0.253-1.233-1.372-10.174-11.313-11.213-12.351-1.391-1.388-2.157-3.233-2.157-5.194s0.766-3.804 2.158-5.192c1.353-1.352 2.937-1.885 4.842-1.885zM8.999 1.567c-2.392 0-4.5 0.715-6.255 2.469-3.659 3.649-3.659 9.566 0 13.217 1.045 1.045 11.183 12.323 11.183 12.323 0.578 0.578 1.336 0.865 2.093 0.865s1.512-0.287 2.091-0.865c0 0 11.090-11.97 11.208-12.089 3.657-3.652 3.657-9.57 0-13.219-1.816-1.813-3.845-2.712-6.319-2.712-2.364 0-5 1.885-6.969 3.885-2.031-2-4.585-3.874-7.031-3.874v0z"></path></g></svg>
                                    ') .'
                                    </li>
                                <li id="'.$picture['id'].'" class="counters">'.$likeCounter.'</li>
                            </div>
                            <div class="button-list">
                                <li>
                                    <a href="">
                                        <svg class="customSvg" version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.128"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" fill="none" d="M60,0H4C1.789,0,0,1.789,0,4v40c0,2.211,1.789,4,4,4h8v12 c0,1.617,0.973,3.078,2.469,3.695C14.965,63.902,15.484,64,16,64c1.039,0,2.062-0.406,2.828-1.172L33.656,48H60c2.211,0,4-1.789,4-4 V4C64,1.789,62.211,0,60,0z" stroke="#6b1177" stroke-width="10" stroke-linecap="round" stroke-linejoin="round" fill="none"></path> </g></svg>
                                    </a>
                                </li>
                                <li class="counters">'.$picture['comment'].'</li>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }
    }
}
