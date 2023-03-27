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
            `pass` VARCHAR(255) NOT NULL
		);");
	}

    public function createUser($username, $email, $password) {
        $query = $this->_pdo->prepare("INSERT INTO users (email, username, pass) VALUES (:email, :username, :pass);");
        $query->bindParam(":email", $email);
        $query->bindParam(":username", $username);

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $query->bindParam(":pass", $hash);
        $query->execute();

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
}