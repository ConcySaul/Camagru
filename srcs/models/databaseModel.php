<?php 

class Database {
    private static $_pdo;

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

    public function initDatabase()
	{
		$this->_pdo->query("CREATE DATABASE IF NOT EXISTS camagru_database;");

		$this->_pdo->query("CREATE TABLE IF NOT EXISTS users (
			`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`email` VARCHAR(255) NOT NULL,
			`username` VARCHAR(32) NOT NULL,
            `pass` VARCHAR(255) NOT NULL,
            `challengeId` VARCHAR(255),
            `active` INT NOT NULL DEFAULT 0
		);");

        $this->_pdo->query("CREATE TABLE IF NOT EXISTS pictures (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `user_id` INT NOT NULL,
            `directory` VARCHAR(32) NOT NULL,
            `caption` VARCHAR(250),
            `like` INT NOT NULL DEFAULT 0,
            `comment` INT NOT NULL DEFAULT 0,
            `timedate` DATETIME NOT NULL
        );");


        $this->_pdo->query("CREATE TABLE IF NOT EXISTS likes (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `id_user` INT NOT NULL,
            `id_pic` INT NOT NULL
        );");
	}

    public function createUser($username, $email, $password) {
        $query = $this->_pdo->prepare("INSERT INTO users (email, username, pass, challengeId) VALUES (:email, :username, :pass, :challengeId);");
        $query->bindParam(":email", $email);
        $query->bindParam(":username", $username);

        $challengeId = uniqid();

        $query->bindParam(":challengeId", $challengeId);
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $query->bindParam(":pass", $hash);
        $query->execute();
        return ($challengeId);
    }

    public function getUserByUsername($username) {
        $query = $this->_pdo->prepare("SELECT * FROM users WHERE username = :username");                     
        $query->bindParam(":username", $username);
        $query->execute();
        $result = $query->fetch();
        return ($result);
    }

    public function getUserByEmail($email) {
        $query = $this->_pdo->prepare("SELECT * FROM users WHERE email = :email");                     
        $query->bindParam(":email", $email);
        $query->execute();
        $result = $query->fetch();
        return ($result);
    }

    public function getUserByChallenge($challengeId) {
        $query = $this->_pdo->prepare("SELECT * FROM users WHERE challengeId = :challengeId");                     
        $query->bindParam(":challengeId", $challengeId);
        $query->execute();
        $result = $query->fetch();
        return ($result);
    }

    public function validateAccount($id) {
        $query = $this->_pdo->prepare("UPDATE users SET  active = 1 WHERE id = :id");
        $query->bindParam(":id", $id);
        $query->execute();               
    }

    public function changeUsername($id, $username) {
        $query = $this->_pdo->prepare("UPDATE users SET username = :username WHERE id = :id");
        $query->bindParam(":id", $id);
        $query->bindParam(":username", $username);
        if (!$query->execute()) {
            $error = $query->errorInfo();
            var_dump ($error);
        }          
    }

    public function changeEmail($id, $email) {
        $query = $this->_pdo->prepare("UPDATE users SET email = :email WHERE id = :id");
        $query->bindParam(":id", $id);
        $query->bindParam(":email", $email);
        if (!$query->execute()) {
            $error = $query->errorInfo();
            var_dump ($error);
        }
    }
}
