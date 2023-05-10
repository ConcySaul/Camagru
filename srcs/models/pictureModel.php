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

    public function getPictures() {
        $query = $this->_pdo->prepare("SELECT * FROM pictures");
        $query->execute();
        $this->_pictures = $query->fetchAll();
        return $this->_pictures;
    }

    public function printPictures() {
        foreach ($this->_pictures as $picture) {
            echo '
                <div class="picture-element">
                    <!-- profile picture -->
                    <div class="picture-div neon-div-border">
                        <div class="profile-picture">
                        </div>
                        <p class="username">Username</p>
                        <div class="picture neon-div-border">
                            <img src="'.$picture['directory'].'" class="picture">
                        </div>
                        <div style="margin-top: 10px">
                        <div class="button-list">
                        <li>
                        <svg class="customSvg" fill="#6b1177" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M8.999 3.567c0.98 0 2.753 0.469 5.628 3.301l1.425 1.403 1.404-1.426c1.996-2.028 4.12-3.288 5.543-3.288 1.919 0 3.432 0.656 4.907 2.128 1.39 1.386 2.156 3.23 2.156 5.191 0.001 1.962-0.764 3.807-2.169 5.209-0.114 0.116-6.156 6.634-11.218 12.097-0.238 0.227-0.511 0.26-0.656 0.26-0.143 0-0.412-0.032-0.65-0.253-1.233-1.372-10.174-11.313-11.213-12.351-1.391-1.388-2.157-3.233-2.157-5.194s0.766-3.804 2.158-5.192c1.353-1.352 2.937-1.885 4.842-1.885zM8.999 1.567c-2.392 0-4.5 0.715-6.255 2.469-3.659 3.649-3.659 9.566 0 13.217 1.045 1.045 11.183 12.323 11.183 12.323 0.578 0.578 1.336 0.865 2.093 0.865s1.512-0.287 2.091-0.865c0 0 11.090-11.97 11.208-12.089 3.657-3.652 3.657-9.57 0-13.219-1.816-1.813-3.845-2.712-6.319-2.712-2.364 0-5 1.885-6.969 3.885-2.031-2-4.585-3.874-7.031-3.874v0z"></path></g></svg>
                        </li>
                        <li class="counters">50</li>
                        </div>
                        <div class="button-list">
                        <li>
                            <svg class="customSvg" version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.128"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" fill="none" d="M60,0H4C1.789,0,0,1.789,0,4v40c0,2.211,1.789,4,4,4h8v12 c0,1.617,0.973,3.078,2.469,3.695C14.965,63.902,15.484,64,16,64c1.039,0,2.062-0.406,2.828-1.172L33.656,48H60c2.211,0,4-1.789,4-4 V4C64,1.789,62.211,0,60,0z" stroke="#6b1177" stroke-width="10" stroke-linecap="round" stroke-linejoin="round" fill="none"></path> </g></svg>
                        </li>
                        <li class="counters">10</li>
                        </div>
                    </div>
                    </div>
                </div>
            ';
        }
    }
}
